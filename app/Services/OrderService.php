<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plan;
use App\Models\SupportPackage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OrderService
{
    /**
     * تبدیل یک سبد خرید در وضعیت pending به سفارش
     */
    public function createOrderFromCart(Cart $cart): Order
    {
        return DB::transaction(function () use ($cart) {
            $user = $cart->user;

            // استخراج اطلاعات قیمت و آیتم خرید
            $itemData = $this->resolveCartItemData($cart);

            $subtotalAmount = $itemData['unit_price'];
            $discountAmount = $itemData['discount_amount'];
            $payableAmount  = $itemData['final_amount'];

            // ایجاد شماره سفارش یکتا و خوانا (مثال: ORD-20261006-A1B2C)
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            //  ثبت سفارش اصلی
            $order = Order::create([
                'user_id'         => $user->id,
                'order_number'    => $orderNumber,
                'subtotal_amount' => $subtotalAmount,
                'discount_amount' => $discountAmount,
                'payable_amount'  => $payableAmount,
                'currency'        => 'IRT', // تومان
                'status'          => 'pending',
            ]);

            //  ثبت آیتم سفارش به صورت Polymorphic
            $order->items()->create([
                'purchasable_type' => $itemData['purchasable_type'],
                'purchasable_id'   => $itemData['purchasable_id'],
                'title'            => $itemData['title'],
                'unit_price'       => $itemData['unit_price'],
                'discount_amount'  => $itemData['discount_amount'],
                'final_amount'     => $itemData['final_amount'],
                'quantity'         => 1,
                'metadata'         => $itemData['metadata'],
            ]);

            return $order;
        });
    }

    /**
     * استخراج عنوان، قیمت و متادیتا بر اساس نوع آیتم در سبد خرید
     */
    protected function resolveCartItemData(Cart $cart): array
    {
        if ($cart->plan_id) {
            $plan = $cart->plan ?? Plan::findOrFail($cart->plan_id);

            // قیمت مستقیماً از خود پلن خوانده می‌شود (بعد از ریفکتور حذف plan_prices)
            $unitPrice = (int) ($plan->original_price ?: $plan->price);
            $finalAmount = (int) $plan->price;
            $discountAmount = max(0, $unitPrice - $finalAmount);

            if ($finalAmount <= 0) {
                throw new InvalidArgumentException('قیمت معتبری برای این پلن یافت نشد.');
            }

            return [
                'purchasable_type' => Plan::class,
                'purchasable_id'   => $plan->id,
                'title'            => $plan->title,
                'unit_price'       => $unitPrice,
                'discount_amount'  => $discountAmount,
                'final_amount'     => $finalAmount,
                'metadata'         => [
                    'plan_id'     => $plan->id,
                    'action_type' => $cart->type,
                ],
            ];
        }

        if ($cart->support_package_id) {
            $supportPackage = $cart->supportPackage ?? SupportPackage::findOrFail($cart->support_package_id);

            $unitPrice = (int) ($supportPackage->original_price ?: $supportPackage->price);
            $finalAmount = (int) $supportPackage->price;
            $discountAmount = max(0, $unitPrice - $finalAmount);

            return [
                'purchasable_type' => SupportPackage::class,
                'purchasable_id'   => $supportPackage->id,
                'title'            => $supportPackage->title,
                'unit_price'       => $unitPrice,
                'discount_amount'  => $discountAmount,
                'final_amount'     => $finalAmount,
                'metadata'         => [
                    'support_package_id' => $supportPackage->id,
                    'duration_months'    => $supportPackage->duration_months,
                    'action_type'        => 'support',
                ],
            ];
        }

        throw new InvalidArgumentException('سبد خرید حاوی آیتم معتبری نیست.');
    }
}

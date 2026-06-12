<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $plans = Plan::with(['prices' => function ($q) {
            $q->where('is_active', true)
              ->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        return view('shop.index', compact('plans'));
    }
}

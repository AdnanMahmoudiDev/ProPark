<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where('id', '!=', auth()->id())
            ->latest()
            ->paginate(20);
    
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,user'],
        ]);

        $user->update([
            'role' => $data['role'],
        ]);

        return back()->with('success', 'نقش کاربر با موفقیت به‌روزرسانی شد.');
    }
}

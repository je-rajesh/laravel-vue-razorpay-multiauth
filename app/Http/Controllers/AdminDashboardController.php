<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        return inertia('Admin/Dashboard', [
            'user' => auth()->user(),
        ]);
    }
}

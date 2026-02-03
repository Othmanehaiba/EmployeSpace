<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('recruteur')) {
            return view('dashboard.recruteur', compact('user'));
        }

        return view('dashboard.chercheur', compact('user'));
    }
}

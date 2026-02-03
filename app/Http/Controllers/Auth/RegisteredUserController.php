<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'bio' => ['required'],
            'speciallity' => ['required'],
            'photo' => ['required'],
            'role' => ['required', 'in:chercheur,recruteur'],
            'company_name' => ['required_if:role,recruteur'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bio' => $request->bio,
            'photo' => $request->photo,
            'speciallity' => $request->speciallity,
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'recruteur') {
            \App\Models\Recruteur::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
            ]);
        } else {
            \App\Models\Candidate::create([
                'user_id' => $user->id,
                'speciallity' => $request->speciallity,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);
        
        return redirect()->route('dashboard');

    }
}

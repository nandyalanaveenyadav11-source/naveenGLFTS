<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    // Simple demo logic: finding the user by email
    $user = \App\Models\User::where('email', $request->email)->first();
    
    if ($user) {
        // In a real app we'd check password and use Auth::login($user)
        return redirect('/')->with('success', "Logged in as {$user->name}");
    }
    
    return back()->with('error', 'Invalid credentials');
});

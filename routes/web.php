<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\MitraController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi', [DestinationController::class, 'index'])->name('destinasi.index');
Route::get('/destinasi/{slug}', [DestinationController::class, 'show'])->name('destinasi.show');
Route::get('/gabung-mitra', [MitraController::class, 'register'])->name('mitra.register');
Route::get('/mitra/dashboard', [MitraController::class, 'dashboard'])->name('mitra.dashboard');

// Endpoint Aksi & Integrasi Dashboard Mitra
Route::post('/mitra/destination/update', [MitraController::class, 'updateDestination'])->name('mitra.destination.update');
Route::post('/mitra/tickets/validate', [MitraController::class, 'validateTicket'])->name('mitra.tickets.validate');
Route::post('/mitra/status/update', [MitraController::class, 'updateStatus'])->name('mitra.status.update');
Route::post('/mitra/capacity/update', [MitraController::class, 'updateCapacity'])->name('mitra.capacity.update');
Route::post('/mitra/announcement/publish', [MitraController::class, 'publishAnnouncement'])->name('mitra.announcement.publish');

// Autentikasi Pengguna (Masuk & Keluar)
Route::get('/auth/google', function () {
    // Jika Socialite terinstall dan terkonfigurasi di env
    if (class_exists(\Laravel\Socialite\Facades\Socialite::class) && config('services.google.client_id')) {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    // Simulasi Login Cepat dengan Akun Google untuk Development
    $user = User::firstOrCreate(
        ['email' => 'wisatawan.google@gmail.com'],
        [
            'name' => 'Wisatawan Google (Banyumas)',
            'password' => bcrypt('google_auth_demo_secret'),
        ]
    );
    Auth::login($user, true);
    request()->session()->regenerate();

    return redirect()->intended('/')->with('success', 'Berhasil masuk dengan akun Google!');
})->name('login.google');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return back()->with('success', 'Berhasil masuk!');
    }

    $user = User::firstOrCreate(
        ['email' => $credentials['email']],
        [
            'name' => $request->input('name') ?: (ucwords(str_replace(['.', '_'], ' ', explode('@', $credentials['email'])[0])) ?: 'Wisatawan Banyumas'),
            'password' => bcrypt($credentials['password']),
        ]
    );
    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();
    return back()->with('success', 'Berhasil masuk!');
})->name('login');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return back()->with('success', 'Berhasil keluar.');
})->name('logout');

// Update Profil Pengguna
Route::post('/profile/update', function (\Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return back()->with('login_required', 'Silakan masuk terlebih dahulu.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
    ]);

    $user = Auth::user();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->save();

    return back()->with('success', 'Profil akun Anda berhasil diperbarui!');
})->name('profile.update');

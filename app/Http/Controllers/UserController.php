<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users_create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:pegawai,admin',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        // Assign role
        if (method_exists($user, 'assignRole')) {
            $user->assignRole($request->input('role'));
        }
        Session::flash('success', 'User created successfully!');
        return Redirect::route('users.index');
    }

    /**api */
     public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'secret' => 'required|string|max:10000',
            'one_time' => 'required|in:0,1',
            'expiry' => 'required_if:one_time,0|integer|in:5,60,1440',
        ]);
        try {
            $isOneTime = $request->input('one_time') == 1;
            $expiresAt = $isOneTime ? null : now()->addMinutes($request->input('expiry'));
            $secret = Secret::create([
                'text' => $request->input('secret'),
                'slug' => $this->generateUniqueSlug(),
                'expires_at' => $expiresAt,
                'user_id' => $request->user() ? $request->user()->id : null,
                'used' => false,
                'one_time' => $isOneTime,
            ]);
            $signedUrl = URL::temporarySignedRoute(
                'ots.show',
                $isOneTime ? now()->addYears(10) : $expiresAt,
                ['slug' => $secret->slug]
            );
            return response()->json([
                'success' => true,
                'message' => 'Secret created successfully',
                'signed_url' => $signedUrl,
                'secret_id' => $secret->id,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create secret',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * REST API: Show a secret by slug (JSON response)
     */
    public function apiShow(Request $request, $slug)
    {
        $secret = Secret::where('slug', $slug)->first();
        if (!$secret) {
            return response()->json([
                'success' => false,
                'message' => 'Secret not found',
            ], 404);
        }
        if ($secret->one_time && $secret->used) {
            return response()->json([
                'success' => false,
                'message' => 'Secret already viewed',
            ], 410);
        }
        if (!$secret->one_time && $secret->expires_at && Carbon::parse($secret->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Secret expired',
            ], 410);
        }
        // Mark as used if one_time
        if ($secret->one_time && !$secret->used) {
            $secret->update([
                'used' => true,
                'viewed_at' => now()
            ]);
        }
        return response()->json([
            'success' => true,
            'secret' => $secret->text,
            'expires_at' => $secret->expires_at,
            'one_time' => $secret->one_time,
        ]);
    }



}

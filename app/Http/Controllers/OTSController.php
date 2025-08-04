<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Secret;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class OTSController extends Controller
{
    /**
     * Show the form for creating a new secret.
     */
    public function form(): View
    {
        return view('OTS_input');
    }

    /**
     * Store a newly created secret and generate signed URL.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'secret' => 'required|string|max:10000',
            'expiry' => 'required|integer|in:5,60,1440',
            'one_time' => 'required|in:0,1',
        ]);

        try {
            $expiresAt = now()->addMinutes($request->input('expiry'));
            $secret = Secret::create([
                'text' => $request->input('secret'),
                'slug' => $this->generateUniqueSlug(),
                'expires_at' => $expiresAt,
                'user_id' => auth()->id(),
                'used' => false,
                'one_time' => $request->input('one_time'),
            ]);
            $signedUrl = URL::temporarySignedRoute(
                'ots.show',
                $expiresAt,
                ['slug' => $secret->slug]
            );
            return redirect()->route('ots.form')->with([
                'success' => 'Secret link generated successfully!',
                'signedUrl' => $signedUrl
            ]);
        } catch (\Exception $e) {
            return redirect()->route('ots.form')->withInput()->with('error', 'Failed to create secret. Please try again.');
        }
    }

    /**
     * Display the specified secret (one-time use, public, OTS_display view).
     */
    public function show(Request $request, string $slug): View
    {
        if (!$request->hasValidSignature()) {
            return view('OTS_display', [
                'expired' => true
            ]);
        }
        $secret = Secret::where('slug', $slug)->first();
        if (!$secret) {
            return view('OTS_display', [
                'expired' => true
            ]);
        }
        if ($secret->one_time && $secret->used) {
            return view('OTS_display', [
                'expired' => true
            ]);
        }
        if ($secret->expires_at && Carbon::parse($secret->expires_at)->isPast()) {
            return view('OTS_display', [
                'expired' => true
            ]);
        }
        // Jika one_time, set used=true setelah dibuka. Jika tidak, biarkan used=false agar bisa dibuka berkali-kali.
        if ($secret->one_time) {
            $secret->update([
                'used' => true,
                'viewed_at' => now()
            ]);
        }
        return view('OTS_display', [
            'secret' => $secret->text,
            'expires_at' => $secret->expires_at,
            'one_time' => $secret->one_time,
        ]);
    }

    /**
     * Display user's secrets (for admin/management).
     */
    public function index(Request $request): View
    {
        $query = Secret::where('user_id', auth()->id());
        if ($request->has('status')) {
            switch ($request->input('status')) {
                case 'active':
                    $query->where('used', false)
                          ->where(function($q) {
                              $q->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                          });
                    break;
                case 'expired':
                    $query->where(function($q) {
                        $q->where('expires_at', '<=', now())
                          ->orWhere('used', true);
                    });
                    break;
                case 'used':
                    $query->where('used', true);
                    break;
            }
        }
        $secrets = $query->select(['id', 'slug', 'expires_at', 'used', 'viewed_at', 'created_at'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        return view('OTS', compact('secrets'));
    }

    /**
     * Delete a specific secret.
     */
    public function destroy(Secret $secret): RedirectResponse
    {
        if ($secret->user_id !== auth()->id()) {
            return redirect()->route('ots.form')->with('error', 'Unauthorized access.');
        }
        $secret->delete();
        return redirect()->route('ots.form')->with('success', 'Secret deleted successfully.');
    }

    /**
     * Clean up expired and used secrets.
     */
    public function cleanup(): RedirectResponse
    {
        $deleted = Secret::where('user_id', auth()->id())
                        ->where(function($query) {
                            $query->where('expires_at', '<=', now())
                                  ->orWhere('used', true);
                        })
                        ->delete();
        return redirect()->route('ots.form')->with('success', "Successfully deleted {$deleted} expired/used secrets.");
    }

    /**
     * Show statistics for user's secrets.
     */
    public function stats(): View
    {
        $userId = auth()->id();
        $stats = [
            'total' => Secret::where('user_id', $userId)->count(),
            'active' => Secret::where('user_id', $userId)
                            ->where('used', false)
                            ->where(function($q) {
                                $q->whereNull('expires_at')
                                  ->orWhere('expires_at', '>', now());
                            })->count(),
            'used' => Secret::where('user_id', $userId)->where('used', true)->count(),
            'expired' => Secret::where('user_id', $userId)
                              ->where('expires_at', '<=', now())
                              ->where('used', false)
                              ->count(),
        ];
        return view('OTS', compact('stats'));
    }

    /**
     * Generate unique slug for secret.
     */
    private function generateUniqueSlug(): string
    {
        do {
            $slug = Str::random(32);
        } while (Secret::where('slug', $slug)->exists());

        return $slug;
    }

    /**
     * Check if secret exists and get basic info (without revealing content).
     */
    public function info(string $slug): View
    {
        $secret = Secret::where('slug', $slug)
                       ->select('slug', 'expires_at', 'used', 'viewed_at', 'created_at')
                       ->first();
        if (!$secret) {
            return view('OTS', [
                'error' => 'Secret not found.'
            ]);
        }
        $status = 'active';
        if ($secret->used) {
            $status = 'used';
        } elseif ($secret->expires_at && Carbon::parse($secret->expires_at)->isPast()) {
            $status = 'expired';
        }
        return view('OTS', [
            'secret' => $secret,
            'status' => $status
        ]);
    }
}

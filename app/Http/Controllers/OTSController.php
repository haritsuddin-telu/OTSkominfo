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
     * Grafik jumlah pesan rahasia yang dikirim sesuai batasan waktu.
     */
    public function chart()
    {
        // Ambil data jumlah pesan rahasia berdasarkan batas waktu (expiry)
        $labels = ['Sekali lihat', '5 Menit', '1 Jam', '1 Hari'];
        $data = [
            Secret::where('one_time', true)->count(),
            Secret::where('one_time', false)->where('expires_at', '!=', null)->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, expires_at) = 5')->count(),
            Secret::where('one_time', false)->where('expires_at', '!=', null)->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, expires_at) = 60')->count(),
            Secret::where('one_time', false)->where('expires_at', '!=', null)->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, expires_at) = 1440')->count(),
        ];
        return view('secret_chart', compact('labels', 'data'));
    }
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
                'user_id' => auth()->id(),
                'used' => false,
                'one_time' => $isOneTime,
            ]);
            // Untuk sekali lihat, link tetap valid sangat lama (10 tahun), expired hanya jika sudah dibuka
            $signedUrl = URL::temporarySignedRoute(
                'ots.show',
                $isOneTime ? now()->addYears(10) : $expiresAt,
                ['slug' => $secret->slug]
            );
            return redirect()->route('ots.form')->with([
                'success' => 'Link pesan rahasia telah ter-generate !',
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
        // Jika sekali lihat, expired hanya jika sudah dibuka (used==true), abaikan waktu
        if ($secret->one_time) {
            if ($secret->used) {
                return view('OTS_display', [ 'expired' => true ]);
            }
            // Set used=true setelah dibuka
            $secret->update([
                'used' => true,
                'viewed_at' => now()
            ]);
        } else {
            // Jika bukan sekali lihat, expired jika waktu habis
            if ($secret->expires_at && Carbon::parse($secret->expires_at)->isPast()) {
                return view('OTS_display', [ 'expired' => true ]);
            }
        }
        // Pastikan waktu yang dikirim ke view sudah diubah ke Asia/Jakarta
        $expires_at = $secret->expires_at ? Carbon::parse($secret->expires_at)->setTimezone('Asia/Jakarta') : null;
        return view('OTS_display', [
            'secret' => $secret->text,
            'expires_at' => $expires_at,
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
                        ->get()
                        ->map(function($secret) {
                            $secret->expires_at = $secret->expires_at ? Carbon::parse($secret->expires_at)->setTimezone('Asia/Jakarta') : null;
                            $secret->created_at = $secret->created_at ? Carbon::parse($secret->created_at)->setTimezone('Asia/Jakarta') : null;
                            $secret->viewed_at = $secret->viewed_at ? Carbon::parse($secret->viewed_at)->setTimezone('Asia/Jakarta') : null;
                            return $secret;
                        });
        return view('OTS', ['secrets' => $secrets]);
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
        return redirect()->route('ots.form')->with('sukses', 'Pesan rahasia telah dihapus.');
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
        return redirect()->route('ots.form')->with('success', "Sukses Dihapus {$deleted} Pesan Rahasia Expired/Terpakai.");
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
                'error' => 'Pesan rahasia tidak ditemukan.'
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

    /**api */
     public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'secret' => 'required|string|max:10000',
            'one_time' => 'required|boolean',
            'expiry' => 'required_if:one_time,false|integer|in:5,60,1440',
        ]);
        try {
            $isOneTime = (bool) $request->input('one_time');
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

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Models\Secret;

class OTSController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:pegawai']);
    }

    public function form() {
        return view('OTS');
    }

    public function store(Request $request) {
        $request->validate([
            'secret' => 'required|string',
            'expiry' => 'required|integer',
        ]);
        $slug = Str::random(32);
        $expires_at = now()->addMinutes($request->input('expiry'));
        try {
            $secret = Secret::create([
                'text' => $request->input('secret'),
                'slug' => $slug,
                'expires_at' => $expires_at,
                'used' => false,
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('ots.form')->with('error', 'Failed to save secret: ' . $e->getMessage());
        }
        $signedUrl = URL::signedRoute('ots.show', ['slug' => $slug]);
        return redirect()->route('ots.form')->with('signedUrl', $signedUrl);
    }

    public function show(Request $request, $slug) {
        $secret = Secret::where('slug', $slug)->firstOrFail();
        $expired = $secret->expires_at && \Carbon\Carbon::now()->gt($secret->expires_at);
        if ($secret->used || $expired) {
            // Do NOT delete expired secrets, just show expired message
            return view('OTS', ['expired' => true]);
        }
        // Mark as used, but do not delete
        $secret->used = true;
        $secret->save();
        return view('OTS', [
            'secret' => $secret->text,
            'expires_at' => $secret->expires_at,
            'expired' => false
        ]);
    }
}

@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg py-8">
    <h2 class="text-2xl font-bold mb-4">Buat Secret Baru</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @if(session('signedUrl'))
            <div class="bg-gray-100 p-2 mb-4 rounded">
                <strong>Link:</strong> <a href="{{ session('signedUrl') }}" class="text-blue-600 underline">{{ session('signedUrl') }}</a>
            </div>
        @endif
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">{{ session('error') }}</div>
    @endif

    @if(isset($error))
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">{{ $error }}</div>
    @endif

    @if(isset($expired) && $expired)
        <div class="bg-yellow-100 text-yellow-800 p-2 mb-4 rounded">Link sudah digunakan atau expired.</div>
    @endif

    @if(isset($secret))
        <div class="bg-blue-100 text-blue-800 p-2 mb-4 rounded">
            <strong>Secret:</strong>
            <span id="maskedSecret">
                {{ substr($secret,0,1) . str_repeat('*', max(0, strlen($secret)-1)) }}
            </span>
            <button type="button" onclick="copySecret()" class="ml-2 bg-green-600 text-white px-2 py-1 rounded">Copy</button>
            <br>
            <strong>Expired at:</strong> {{ $expires_at }}
        </div>
        <script>
        function copySecret() {
            const secret = @json($secret);
            navigator.clipboard.writeText(secret).then(function() {
                const btn = event.target;
                const original = btn.textContent;
                btn.textContent = 'Copied!';
                setTimeout(() => { btn.textContent = original; }, 1500);
            });
        }
        </script>
    @endif

    <form method="POST" action="{{ route('ots.store') }}" class="bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="secret" class="block font-semibold mb-1">Secret</label>
            <textarea name="secret" id="secret" rows="4" class="w-full border rounded p-2" required>{{ old('secret') }}</textarea>
            @error('secret')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="expiry" class="block font-semibold mb-1">Masa Berlaku</label>
            <select name="expiry" id="expiry" class="w-full border rounded p-2" required>
                <option value="5" {{ old('expiry') == 5 ? 'selected' : '' }}>5 Menit</option>
                <option value="60" {{ old('expiry') == 60 ? 'selected' : '' }}>1 Jam</option>
                <option value="1440" {{ old('expiry') == 1440 ? 'selected' : '' }}>1 Hari</option>
            </select>
            @error('expiry')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Buat Secret</button>
    </form>
</div>
@endsection

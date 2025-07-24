<x-app-layout>
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-500">One Time Secret (OTS)</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        @role('pegawai')
        <form method="POST" action="{{ route('ots.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="secret" class="block text-sm font-medium text-gray-700 dark:text-white">Secret Text</label>
                <input type="text" name="secret" id="secret" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" placeholder="Enter your secret..." value="{{ old('secret') }}">
                @error('secret')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700 dark:text-white">Expiry</label>
                <select name="expiry" id="expiry" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                    <option value="5" {{ old('expiry') == 5 ? 'selected' : '' }}>5 Minutes</option>
                    <option value="60" {{ old('expiry') == 60 ? 'selected' : '' }}>1 Hour</option>
                    <option value="1440" {{ old('expiry') == 1440 ? 'selected' : '' }}>1 Day</option>
                </select>
                @error('expiry')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">Generate Secret Link</button>
        </form>
        @if(session('signedUrl'))
        <div class="mt-8 flex flex-col items-center justify-center">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-lg w-full max-w-lg">
                <h3 class="text-lg font-bold text-blue-600 mb-2">Your One Time Secret Link</h3>
                <div class="flex items-center mb-2">
                    <input type="text" readonly value="{{ session('signedUrl') }}" class="flex-1 rounded-lg border-blue-300 bg-white text-blue-700 px-2 py-2 mr-2 font-mono text-sm shadow focus:outline-none">
                    <button onclick="navigator.clipboard.writeText('{{ session('signedUrl') }}')" class="py-2 px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold shadow">Copy</button>
                </div>
                <a href="{{ session('signedUrl') }}" target="_blank" class="block text-blue-500 hover:underline text-xs">Open Secret Link</a>
            </div>
        </div>
        @endif
        @else
        <div class="p-4 bg-yellow-100 text-yellow-700 rounded">Only pegawai can create secrets.</div>
        @endrole

        {{-- Remove duplicate link display --}}
    </div>

    @if(isset($secret))
    <div class="max-w-xl mx-auto mt-8 bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <h3 class="text-xl font-bold mb-4 text-blue-500">Reveal Secret</h3>
        @if($expired)
            <div class="p-4 bg-red-100 text-red-700 rounded">This secret has expired or already been viewed.</div>
        @else
            <div class="mb-4">
                <span id="masked" class="text-lg font-mono tracking-widest bg-gray-100 dark:bg-slate-800 px-4 py-2 rounded">••••••••••••••••••••••••</span>
                <span id="revealed" class="hidden text-lg font-mono tracking-widest bg-gray-100 dark:bg-slate-800 px-4 py-2 rounded">{{ $secret }}</span>
            </div>
            <button onclick="document.getElementById('masked').classList.add('hidden');document.getElementById('revealed').classList.remove('hidden');" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg mr-2">Reveal</button>
            <button onclick="navigator.clipboard.writeText('{{ $secret }}')" class="py-2 px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg">Copy</button>
            <div class="mt-4 text-sm text-gray-500">Expires: {{ $expires_at }}</div>
        @endif
    </div>
    @endif
</div>
</x-app-layout>

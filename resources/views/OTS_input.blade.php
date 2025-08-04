<x-app-layout>
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-500">One Time Secret (OTS)</h2>
        {{-- Display success messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        {{-- Display error messages --}}
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        {{-- Display error from controller --}}
        @if(isset($error))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ $error }}</div>
        @endif
        @role('pegawai')
        <form method="POST" action="{{ route('ots.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="secret" class="block text-sm font-medium text-gray-700 dark:text-white">Secret Text</label>
                <textarea name="secret" id="secret" required rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" placeholder="Enter your secret...">{{ old('secret') }}</textarea>
                @error('secret')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700 dark:text-white">Expiry</label>
                <select name="expiry" id="expiry" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                    <option value="5" {{ old('expiry') == '5' ? 'selected' : '' }}>5 Minutes</option>
                    <option value="60" {{ old('expiry') == '60' ? 'selected' : '' }}>1 Hour</option>
                    <option value="1440" {{ old('expiry') == '1440' ? 'selected' : '' }}>1 Day</option>
                </select>
                @error('expiry')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">Generate Secret Link</button>
        </form>
        @else
        <div class="p-4 bg-yellow-100 text-yellow-700 rounded">Only pegawai can create secrets.</div>
        @endrole
    </div>
</div>
</x-app-layout>

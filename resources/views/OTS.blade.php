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
        {{-- Only show form if not displaying a secret --}}
        @if(!isset($secret) && !isset($expired))
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

        {{-- Display generated link --}}
        @if(session('signedUrl'))
        <div class="mt-8 flex flex-col items-center justify-center">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-lg w-full max-w-lg">
                <h3 class="text-lg font-bold text-blue-600 mb-2">Your One Time Secret Link</h3>
                <div class="flex items-center mb-2">
                    <input type="text" readonly value="{{ session('signedUrl') }}" id="secretUrl" class="flex-1 rounded-lg border-blue-300 bg-white text-blue-700 px-2 py-2 mr-2 font-mono text-sm shadow focus:outline-none">
                    <button onclick="copyToClipboard()" class="py-2 px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold shadow">Copy</button>
                </div>
                <a href="{{ session('signedUrl') }}" target="_blank" class="block text-blue-500 hover:underline text-xs">Open Secret Link</a>
                <div class="mt-2 text-xs text-gray-600">
                    <strong>Warning:</strong> This link can only be opened once and will expire automatically.
                </div>
            </div>
        </div>
        @endif
        @endif
        @else
        <div class="p-4 bg-yellow-100 text-yellow-700 rounded">Only pegawai can create secrets.</div>
        @endrole
    </div>

    {{-- Display secret content or expired message --}}
    @if(isset($secret) || (isset($expired) && $expired))
    <div class="max-w-xl mx-auto mt-8 bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <h3 class="text-xl font-bold mb-4 text-blue-500">Secret Content</h3>
        
        @if(isset($expired) && $expired)
            <div class="p-4 bg-red-100 text-red-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    This secret has expired or has already been viewed.
                </div>
            </div>
        @elseif(isset($secret))
            <div class="mb-6">
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4 border text-center shadow-lg transition-all duration-300">
                    <div class="flex justify-center items-center mb-4">
                        <span class="text-4xl animate-bounce">🔒</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Secret (masked):</p>
                    <span class="font-mono text-lg tracking-widest select-none" id="maskedSecret">
                        {{ substr($secret,0,3) . str_repeat('*', max(0, strlen($secret)-3)) }}
                    </span>
                    <button type="button" onclick="copyMaskedSecret()" id="copyBtn" class="ml-2 bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-400 text-white px-4 py-2 rounded-lg font-semibold shadow transition-all duration-200 flex items-center gap-2">
                        <svg id="copyIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6" /></svg>
                        <span id="copyText">Copy</span>
                    </button>
                    <div id="copyFeedback" class="mt-2 text-green-600 font-semibold opacity-0 transition-opacity duration-300">Copied to clipboard!</div>
                </div>
            </div>
            
            @if(isset($expires_at))
            <div class="text-sm text-gray-500 text-center">
                <div class="flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Expires: {{ \Carbon\Carbon::parse($expires_at)->format('M j, Y g:i A') }}
                </div>
            </div>
            @endif
        @endif
        
        <div class="mt-6 text-center">
            <a href="{{ route('ots.form') }}" class="inline-flex items-center py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Secret
            </a>
        </div>
    </div>
    @endif
</div>

<script>
function copyToClipboard() {
    const urlInput = document.getElementById('secretUrl');
    urlInput.select();
    urlInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(urlInput.value).then(function() {
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.remove('bg-green-500', 'hover:bg-green-600');
        button.classList.add('bg-green-600');
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            button.classList.remove('bg-green-600');
        }, 2000);
    });
}

function copyMaskedSecret() {
    @if(isset($secret))
        const secret = @json($secret);
        navigator.clipboard.writeText(secret).then(function() {
            // Button animation & feedback
            const btn = document.getElementById('copyBtn');
            const icon = document.getElementById('copyIcon');
            const text = document.getElementById('copyText');
            const feedback = document.getElementById('copyFeedback');
            btn.classList.remove('bg-green-600');
            btn.classList.add('bg-green-700');
            icon.classList.add('animate-spin');
            text.textContent = 'Copied!';
            feedback.classList.remove('opacity-0');
            feedback.classList.add('opacity-100');
            setTimeout(() => {
                btn.classList.remove('bg-green-700');
                btn.classList.add('bg-green-600');
                icon.classList.remove('animate-spin');
                text.textContent = 'Copy';
                feedback.classList.remove('opacity-100');
                feedback.classList.add('opacity-0');
            }, 1500);
        });
    @else
        // Do nothing if secret is not set
    @endif
}


function copySecret() {
    const secretContent = document.getElementById('secretContent').textContent;
    navigator.clipboard.writeText(secretContent).then(function() {
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.remove('bg-green-500', 'hover:bg-green-600');
        button.classList.add('bg-green-600');
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            button.classList.remove('bg-green-600');
        }, 2000);
    });
}
</script>
</x-app-layout>
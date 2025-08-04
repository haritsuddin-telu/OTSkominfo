<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Time Secret</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-500">One Time Secret (OTS)</h2>
        {{-- Display secret content or expired message --}}
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
                        @php
                            $maxLength = 20;
                            $displaySecret = mb_substr($secret, 0, $maxLength);
                            $masked = mb_substr($displaySecret, 0, 3) . str_repeat('*', max(0, mb_strlen($displaySecret)-3));
                        @endphp
                        {{ $masked }}
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
        {{-- Tombol Create New Secret dihilangkan agar halaman display benar-benar publik --}}
    </div>
</div>
<script>
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
</script>
</body>
</html>

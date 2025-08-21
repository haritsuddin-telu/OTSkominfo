
<x-app-layout>
<link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
<title>OTS Kominfo Jatim</title>
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <div class="flex justify-center">
            <h2 class="text-2xl font-bold mb-6 text-blue-500 text-center">One Time Secret (OTS)</h2>
        </div>
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
    @can('access ots')
        <form method="POST" action="{{ route('ots.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="secret" class="block text-sm font-medium text-gray-700 dark:text-white">Masukkan Pesan Rahasia</label>
                <textarea name="secret" id="secret" required rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" placeholder="Tuliskan pesan rahasia anda disini...">{{ old('secret') }}</textarea>
                @error('secret')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Pilih Durasi</label>
                <div class="flex gap-4">
                    <label>
                        <input type="radio" name="one_time" value="1" {{ old('one_time', '1') == '1' ? 'checked' : '' }} onclick="toggleExpiry(this.value)">
                        Sekali Lihat
                    </label>
                    <label>
                        <input type="radio" name="one_time" value="0" {{ old('one_time') == '0' ? 'checked' : '' }} onclick="toggleExpiry(this.value)">
                        Dilihat Dengan Batasan Waktu                  </label>
                </div>
            </div>
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih Batasan Waktu </label>
                <select name="expiry" id="expiry" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                    <option value="5" {{ old('expiry') == '5' ? 'selected' : '' }}>5 Menit</option>
                    <option value="60" {{ old('expiry') == '60' ? 'selected' : '' }}>1 Jam</option>
                    <option value="1440" {{ old('expiry') == '1440' ? 'selected' : '' }}>1 Hari</option>
                </select>
                @error('expiry')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
<script>
function toggleExpiry(val) {
    const expiry = document.getElementById('expiry');
    if (val == '1') {
        expiry.disabled = true;
        expiry.classList.add('bg-gray-200', 'cursor-not-allowed');
    } else {
        expiry.disabled = false;
        expiry.classList.remove('bg-gray-200', 'cursor-not-allowed');
    }
}
// Inisialisasi saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    const checked = document.querySelector('input[name="one_time"]:checked');
    if (checked) toggleExpiry(checked.value);
});
</script>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">Buat Link Rahasia</button>
        </form>

        {{-- Display generated link --}}
        @if(session('signedUrl'))
        <div class="mt-8 flex flex-col items-center justify-center">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-lg w-full max-w-lg">
                <h3 class="text-lg font-bold text-blue-600 mb-2">Link Rahasia Anda</h3>
                <div class="flex items-center mb-2">
                    <input type="text" readonly value="{{ session('signedUrl') }}" id="secretUrl" class="flex-1 rounded-lg border-blue-300 bg-white text-blue-700 px-2 py-2 mr-2 font-mono text-sm shadow focus:outline-none">
                    <button onclick="copyToClipboard()" class="py-2 px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold shadow">Salin Link</button>
                </div>
                <a href="{{ session('signedUrl') }}" target="_blank" class="block text-blue-500 hover:underline text-xs">Buka Link Rahasia</a>
                <div class="mt-2 text-xs text-gray-600">
                    <strong>Perhatian:</strong> Link ini hanya dapat dibuka sesuai jenis yang dipilih dan akan kedaluwarsa secara otomatis.
                </div>
            </div>
        </div>
        @endif
        @else
        <div class="p-4 bg-yellow-100 text-yellow-700 rounded">Hanya pegawai yang dapat membuat Link Rahasia.</div>
        @endrole
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
</script>
    </div>
</div>
</x-app-layout>

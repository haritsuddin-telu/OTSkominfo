<x-app-layout>
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-500">Create User</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                @error('password')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-white">Role</label>
                <select name="role" id="role" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                    <option value="pegawai">Pegawai</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">Create User</button>
        </form>
    </div>
</div>
</x-app-layout>

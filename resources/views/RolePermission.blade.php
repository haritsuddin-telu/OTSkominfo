<x-app-layout>
<link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
<title>Role Management</title>
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Role & Permission Management</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Roles List -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Roles</h3>
            <ul>
                @foreach($roles as $role)
                    <li class="mb-2 flex justify-between items-center">
                        <span>{{ $role->name }}</span>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Hapus role ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <form action="{{ route('roles.store') }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="name" placeholder="Role name" class="border rounded px-2 py-1" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Add Role</button>
            </form>
        </div>
        <!-- Permissions List -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Permissions</h3>
            <ul>
                @foreach($permissions as $permission)
                    <li class="mb-2 flex justify-between items-center">
                        <span>{{ $permission->name }}</span>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Hapus permission ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <form action="{{ route('permissions.store') }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="name" placeholder="Permission name" class="border rounded px-2 py-1" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Add Permission</button>
            </form>
        </div>
    </div>
    <!-- Tabel Role dan Permission -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4">Role & Permission Table</h3>
        <table class="min-w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Permissions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="border px-4 py-2 font-semibold">{{ $role->name }}</td>
                        <td class="border px-4 py-2">
                            @php $perms = $role->permissions->pluck('name')->toArray(); @endphp
                            @if(count($perms))
                                <ul>
                                    @foreach($perms as $perm)
                                        <li>{{ $perm }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-400 italic">No permissions</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Assign Permission to Role -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4">Assign Permission to Role</h3>
        <form action="{{ route('roles.assign_permission') }}" method="POST" class="flex gap-2">
            @csrf
            <select name="role" class="border rounded px-2 py-1" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <select name="permission" class="border rounded px-2 py-1" required>
                <option value="">Pilih Permission</option>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Assign</button>
        </form>
    </div>
    <!-- Assign Role to User -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4">Assign Role to User</h3>
        <form action="{{ route('users.assign_role') }}" method="POST" class="flex gap-2">
            @csrf
            <select name="user_id" class="border rounded px-2 py-1" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <select name="role" class="border rounded px-2 py-1" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Assign</button>
        </form>
    </div>
</div>
</x-app-layout>


<!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>

<div class="min-h-screen bg-gray-100">
    <!-- Background biru atas -->
    <div class="fixed top-0 left-0 w-full bg-blue-500 h-20 z-50"></div>
    <!-- Sidebar -->
    <x-aside />
    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl" style="font-family: Arial, sans-serif;">
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm leading-normal">
                    <a class="text-white opacity-50" href="/dashboard">Dashboard</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Role Permission</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Role Permission</h6>
          </nav>
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
              <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">

                </div>
            </div>
    <!-- Main Content -->
    <div class="xl:ml-72">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
        <title>Role Management</title>
        <div class="py-8 pl-0 xl:pl-8 pr-4">
    <h2 class="text-2xl font-bold mb-6 text-center">Role & Permission Management</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Roles List -->
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h3 class="text-lg font-semibold mb-4 text-center">Roles</h3>
            <div class="flex-1 flex flex-col justify-between">
                <ul class="overflow-y-auto max-h-64 mb-4 pr-2">
                    @foreach($roles as $role)
                        <li class="mb-2 flex justify-between items-center">
                            <span class="flex-1">{{ $role->name }}</span>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Hapus role ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ route('roles.store') }}" method="POST" class="flex gap-2 items-end mt-auto">
                    @csrf
                    <input type="text" name="name" placeholder="Role name" class="border rounded px-2 py-1 w-full" required>
                    <button type="submit" class="bg-blue-500 text-white px-10 py-2 min-w-[90px] text-base rounded whitespace-nowrap flex justify-center items-center">Add Role</button>
                </form>
            </div>
        </div>
        <!-- Permissions List -->
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h3 class="text-lg font-semibold mb-4 text-center">Permissions</h3>
            <div class="flex-1 flex flex-col justify-between">
                <ul class="overflow-y-auto max-h-64 mb-4 pr-2">
                    @foreach($permissions as $permission)
                        <li class="mb-2 flex justify-between items-center">
                            <span class="flex-1">{{ $permission->name }}</span>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Hapus permission ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ route('permissions.store') }}" method="POST" class="flex gap-2 items-end mt-auto">
                    @csrf
                    <input type="text" name="name" placeholder="Permission name" class="border rounded px-2 py-1 w-full" required>
                    <button type="submit" class="bg-blue-500 text-white px-10 py-2 min-w-[90px] text-base rounded whitespace-nowrap flex justify-center items-center">Add Permission</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Tabel Role dan Permission -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4 text-center">Role & Permission Table</h3>
        <table class="min-w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-left">Permissions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="border px-4 py-2 font-semibold text-left">{{ $role->name }}</td>
                        <td class="border px-4 py-2 text-left">
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
        <h3 class="text-lg font-semibold mb-4 text-center">Assign Permission to Role</h3>
        <form action="{{ route('roles.assign_permission') }}" method="POST" class="flex gap-2 items-center">
            @csrf
            <div class="flex-1">
                <select name="role" class="border rounded px-2 py-2 w-full" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <select name="permission" class="border rounded px-2 py-2 w-full" required>
                    <option value="">Pilih Permission</option>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded shadow-lg">Assign</button>
        </form>
    </div>
    <!-- Assign Role to User -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4 text-center">Assign Role to User</h3>
        <form action="{{ route('users.assign_role') }}" method="POST" class="flex gap-2 items-center">
            @csrf
            <div class="flex-1">
                <select name="user_id" class="border rounded px-2 py-1 w-full" required>
                    <option value="">Pilih User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <select name="role" class="border rounded px-2 py-1 w-full" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded shadow-lg">Assign</button>
        </form>
    </div>

        </div>
    </div>
</div>


    <!-- Nucleo Icons -->
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- Main Styling -->
<link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
<!-- Popper.js -->
<script src="https://unpkg.com/@popperjs/core@2"></script>

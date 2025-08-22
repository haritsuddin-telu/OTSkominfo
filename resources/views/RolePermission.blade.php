<head>
    <title>Role Permission</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Icons & Scripts -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <div class="min-h-screen bg-gray-100 font-sans">
        <!-- Header biru atas -->
        <div class="w-full bg-[#5a74ea] h-80 flex flex-col justify-start shadow-lg rounded-b-xl px-8">
            <div class="flex items-start mt-2">
                <div class="xl:ml-72">
    
                     <ol class="flex flex-wrap pt-1  bg-transparent rounded-lg ">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Role Permission</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Role & Permission Management</h6>
          
       
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <x-aside />

        <!-- Main Content -->
        <main class="relative xl:ml-72 transition-all duration-200 ease-in-out rounded-xl">
        <div class=" xl:px-2 flex flex-col gap-8 -mt-60">

                <!-- Breadcrumb & subjudul dipindahkan ke header biru atas -->
                

                <!-- Roles & Permissions Grid -->
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
                            <div class="w-full flex gap-2 items-end mt-auto">
                                <form action="{{ route('roles.store') }}" method="POST" class="flex w-full gap-2">
                                    @csrf
                                    <input type="text" name="name" placeholder="Role name" class="border rounded px-2 py-1 w-full" required>
                                    <button type="submit" class="bg-blue-500 text-white px-10 py-2 min-w-[90px] text-base rounded flex justify-center items-center whitespace-nowrap">Add Role</button>
                                </form>
                            </div>
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
                            <div class="w-full flex gap-2 items-end mt-auto">
                                <form action="{{ route('permissions.store') }}" method="POST" class="flex w-full gap-2">
                                    @csrf
                                    <input type="text" name="name" placeholder="Permission name" class="border rounded px-2 py-1 w-full" required>
                                    <button type="submit" class="bg-blue-500 text-white px-10 py-2 min-w-[90px] text-base rounded flex justify-center items-center whitespace-nowrap">Add Permission</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role & Permission Table -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-lg font-semibold mb-6 text-center">Role & Permission Table</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-6 py-3 text-center font-semibold">Role</th>
                                    <th class="border px-6 py-3 text-center font-semibold">Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td class="border px-6 py-3 text-center font-semibold">{{ $role->name }}</td>
                                        <td class="border px-6 py-3 text-center">
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
                </div>

                <!-- Assign Permission to Role -->
                <div class="bg-white rounded-lg shadow p-6">
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
                <div class="bg-white rounded-lg shadow p-6">
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
        </main>
    </div>

    @livewireScripts
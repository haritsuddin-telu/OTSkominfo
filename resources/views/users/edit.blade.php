<!--
=========================================================
* Edit User - Argon Dashboard Tailwind Style
=========================================================
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit User</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
  
</head>
<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
  <x-aside />
  <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
    <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
      <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
          <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-sm leading-normal">
              <a class="text-white opacity-50" href="{{ route('table') }}">Users</a>
            </li>
            <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Edit User</li>
          </ol>
          <h6 class="mb-0 font-bold text-white capitalize">Edit User</h6>
        </nav>
      </div>
    </nav>
    <div class="w-full px-6 py-6 mx-auto flex justify-center items-center min-h-[80vh]">
      <div class="w-full  max-w-xl mx-auto md:mx-16 lg:mx-32 xl:mx-64">
        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-8 ">
          <h4 class=" mb-8 font-bold text-xl text-blue-500 text-center">Edit User</h4>
          
          @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" style="border-left-width: 30px;border-right-width: 30px;border-bottom-width: 30px;border-color:white;">
            @csrf
            @method('PUT')
            <div>
              <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-white" for="name">Name</label>
              <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" required />
            </div>
            <div>
              <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-white" for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" required />
            </div>
            <div>
              <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-white" for="role">Role</label>
              <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-white">
                @foreach($roles as $role)
                  <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-white" for="profile_photo">Profile Photo</label>
              <input type="file" name="profile_photo" id="profile_photo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-white" />
              @if($user->profile_photo_url)
                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="mt-4 h-20 w-20 rounded-xl object-cover mx-auto border border-gray-200" />
              @endif
            </div>
            <div class="flex justify-between items-center mt-8 gap-4">
              <a href="{{ route('table') }}" 
  class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white 
         rounded-lg shadow hover:scale-105 hover:shadow-lg 
         transition-all duration-200 ease-in-out focus:outline-none"
  style="background-image: linear-gradient(to top right, #ff0000, #ea1515);">
  
  <span>Cancel</span>
</a>
               <button type="submit" 
                class="inline-flex items-center px-6 py-2 text-xs font-semibold text-white 
                rounded-lg shadow hover:scale-105 hover:shadow-lg 
                transition-all duration-200 ease-in-out focus:outline-none"
               style="background-image: linear-gradient(to top right, #3b82f6, #295293, #3a44f1);">
              
              <span>Save Changes</span>
            </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
  <script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>
</body>
</html>

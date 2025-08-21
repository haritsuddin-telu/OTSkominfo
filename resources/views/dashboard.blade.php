
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
    <title>Dashboard</title>
    {{-- sticky background blue on top --}}
    <div class="fixed top-0 left-0 w-full bg-blue-500 dark:hidden min-h-75 "></div>
    <!-- sidenav  -->
    <x-aside />

    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl" style="font-family: Arial, sans-serif;">
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false" style="font-family: Arial, sans-serif;">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
          </nav>
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
              <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">

                </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">

              <li class="flex items-center">
                @auth
                <a href="{{ route('dashboard') }}" class="block px-0 py-2 text-sm font-semibold text-white transition-all ease-nav-brand">
                  <i class="fa fa-user sm:mr-1"></i>
                  <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                </a>
                @endauth
              </li>
              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                  </div>
                </a>
              </li>
              <li class="flex items-center px-4">
                <a href="javascript:;" class="p-0 text-sm text-white transition-all ease-nav-brand">
                  <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                  <!-- fixed-plugin-button-nav  -->
                </a>

            </ul>
          </div>
        </div>
      </nav>

      <!-- end Navbar -->

      <!-- cards -->
      <div class="w-full flex gap-6 px-6 py-6 mx-auto" style="font-family: Arial, sans-serif;">
        <!-- row 1 -->
        <!-- Card Jumlah User -->
        <div class="flex-1">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                      <div>
                        <p class="mb-0 text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Jumlah User</p>
                        <h5 class="mb-2 font-bold dark:text-white">{{ $jumlahUser }}</h5>
                      </div>
                      <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                        <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        <!-- Card Jumlah OTS -->
        <div class="flex-1">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                      <div>
                        <p class="mb-0 text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Jumlah OTS yang Dikirim</p>
                        <h5 class="mb-2 font-bold dark:text-white">{{ $jumlahOts }}</h5>
                      </div>
                      <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                        <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
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
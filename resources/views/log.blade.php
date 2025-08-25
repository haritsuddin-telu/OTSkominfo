<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
     <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
    <title>History </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>


    <!-- sidenav  -->
    <x-aside />

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Secret Log</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Secret Log</h6>
          </nav>
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <!-- Semua elemen nama user dan search bar di navbar dihapus sesuai permintaan -->
          </div>
        </div>
      </nav>
  <div class="w-full px-6 md:px-12 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
          <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border px-4 md:px-8" style="margin-left:16px; margin-right:16px;">
              <div class="p-4 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="dark:text-white">Secret Log</h6>
              </div>
              <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                  <!-- DataTable: Secret Log -->
                  <div style="max-width: 100%; width: 100%; overflow-x: auto;">
                  <table id="logTable" class="display items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500" style="min-width: 650px;">
                    <thead class="align-bottom">
                      <tr>
                        <th class="px-6 py-3 font-semibold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-L border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">ID</th>
                        <th class="px-6 py-3 font-semibold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-L border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">User Name</th>
                        <th class="px-6 py-3 font-semibold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-L border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Expires At</th>
                        <th class="px-6 py-3 font-semibold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-L border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($secrets as $secret)
                      <tr>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <div class="flex px-2 py-1">
                            <div class="w-7 h-7 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                              {{ substr($secret->id, -2) }}
                            </div>
                            <span class="ml-2 font-medium text-gray-900">{{ $secret->id }}</span>
                          </div>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <div class="flex items-center">
                            @if($secret->user && $secret->user->name !== '-')
                              <div class="w-7 h-7 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                {{ strtoupper(substr($secret->user->name, 0, 1)) }}
                              </div>
                              <span class="font-medium text-gray-900">{{ $secret->user->name }}</span>
                            @else
                              <div class="w-7 h-7 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                              </div>
                              <span class="text-gray-400 italic">No user assigned</span>
                            @endif
                          </div>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($secret->expires_at)->format('M d, Y H:i') }}</span>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($secret->created_at)->format('M d, Y H:i') }}</span>
                        </td>
                <style>
                  #logTable {
                    font-size: 1rem;
                    font-family: 'Open Sans', Arial, sans-serif;
                    color: #334155;
                    width: 100%;
                    max-width: 100%;
                    border-collapse: separate;
                    border-spacing: 0;
                  }
                  #logTable th, #logTable td {
                    vertical-align: middle;
                    padding: 14px 16px;
                    white-space: nowrap;
                  }
                  #logTable th {
                    font-weight: 700;
                    color: #64748b;
                    background: #f8fafc;
                    border-bottom: 2px solid #e5e7eb;
                    font-size: 0.95rem;
                  }
                  #logTable td {
                    background: #fff;
                    border-bottom: 1px solid #e5e7eb;
                  }
                  #logTable tbody tr {
                    transition: background 0.2s;
                  }
                  #logTable tbody tr:nth-child(even) td {
                    background: #f9fafb;
                  }
                  #logTable tbody tr:hover td {
                    background: #f1f5f9;
                  }
                  #logTable_wrapper .dt-top-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 0.5rem;
                    flex-wrap: nowrap;
                    gap: 1rem;
                  }
                  @media (max-width: 700px) {
                    #logTable_wrapper .dt-top-row {
                      flex-wrap: wrap;
                    }
                  }
                  #logTable_wrapper .dataTables_length, #logTable_wrapper .dataTables_filter {
                    float: none !important;
                    margin-bottom: 0;
                    margin-top: 0.5rem;
                  }
                  #logTable_wrapper .dataTables_filter {
                    text-align: right;
                  }
                  #logTable_wrapper .dataTables_filter input[type="search"] {
                    width: 140px;
                    border-radius: 6px;
                    border: 1px solid #e5e7eb;
                    padding: 5px 8px;
                    font-size: 0.95rem;
                    margin-left: 8px;
                  }
                  #logTable_wrapper .dataTables_length label, #logTable_wrapper .dataTables_filter label {
                    font-size: 0.98rem;
                    color: #4b6891;
                  }
                  #logTable_wrapper .dataTables_length select {
                    border-radius: 6px;
                    border: 1px solid #e5e7eb;
                    padding: 3px 8px;
                    font-size: 0.95rem;
                    margin: 0 6px;
                  }
                  #logTable_wrapper .dataTables_info {
                    clear: both;
                    padding-top: 0.5rem;
                    font-size: 0.97rem;
                    color: #64748b;
                  }
                  #logTable_wrapper .dataTables_paginate {
                    margin-top: 0.5rem;
                  }
                  #logTable_wrapper .dataTables_paginate .paginate_button {
                    padding: 0.2rem 0.7rem;
                    font-size: 13px;
                  }
                  @media (max-width: 900px) {
                    #logTable {
                      font-size: 0.95rem;
                    }
                    #logTable th {
                      font-size: 0.9rem;
                    }
                  }
                </style>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4" class="text-center py-8">
                          <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                          <h3 class="mt-2 text-xs font-medium text-gray-900">No secrets found</h3>
                          <p class="mt-1 text-xs text-gray-500">Get started by creating a new secret entry.</p>
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- DataTables JS & CSS (CDN) -->
                <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" />
                <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
                <!-- Style duplikat dihapus, font-size besar hanya dari style utama di atas -->
                <script>
                  $(document).ready(function() {
                    $('#logTable').DataTable({
                      responsive: false,
                      autoWidth: false,
                      scrollX: true,
                      pageLength: 10,
                      lengthMenu: [5, 10, 25, 50],
                      order: [[0, 'desc']],
                      language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ entri',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                        infoEmpty: 'Tidak ada data',
                        paginate: {
                          previous: 'Sebelumnya',
                          next: 'Berikutnya'
                        }
                      },
                      columnDefs: [
                        { width: '50px', targets: 0 },
                        { width: '120px', targets: 1 },
                        { width: '120px', targets: 2 },
                        { width: '120px', targets: 3 }
                      ],
                      initComplete: function() {
                        // Bungkus length & filter dalam flex agar sebaris
                        $('#logTable_wrapper .dataTables_length, #logTable_wrapper .dataTables_filter').wrapAll('<div class="dt-top-row"></div>');
                      }
                    });
                  });
                </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

  <div fixed-plugin>
      <a fixed-plugin-button class="fixed px-4 py-2 text-xl bg-white shadow-lg cursor-pointer bottom-8 right-8 z-990 rounded-circle text-slate-700">
        <i class="py-2 pointer-events-none fa fa-cog"> </i>
      </a>
      <!-- -right-90 in loc de 0-->
      <div fixed-plugin-card class="z-sticky backdrop-blur-2xl backdrop-saturate-200 dark:bg-slate-850/80 shadow-3xl w-90 ease -right-90 fixed top-0 left-auto flex h-full min-w-0 flex-col break-words rounded-none border-0 bg-white/80 bg-clip-border px-2.5 duration-200">
        <div class="px-6 pt-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
          <div class="float-left">
            <h5 class="mt-4 mb-0 dark:text-white">Argon Configurator</h5>
            <p class="dark:text-white dark:opacity-80">See our dashboard options.</p>
          </div>
          <div class="float-right mt-6">
            <button fixed-plugin-close-button class="inline-block p-0 mb-4 text-sm font-bold leading-normal text-center uppercase align-middle transition-all ease-in bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:-translate-y-px tracking-tight-rem bg-150 bg-x-25 active:opacity-85 dark:text-white text-slate-700">
              <i class="fa fa-close"></i>
            </button>
          </div>
          <!-- End Toggle Button -->
        </div>
        <hr class="h-px mx-0 my-1 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
        <div class="flex-auto p-6 pt-0 overflow-auto sm:pt-4">
          <!-- Sidebar Backgrounds -->
          <div>
            <h6 class="mb-0 dark:text-white">Sidebar Colors</h6>
          </div>
          <a href="javascript:void(0)">
            <div class="my-2 text-left" sidenav-colors>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-blue-500 to-violet-500 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-slate-700 text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" active-color data-color="blue" onclick="sidebarColor(this)"></span>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-white text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" data-color="gray" onclick="sidebarColor(this)"></span>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-blue-700 to-cyan-500 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-white text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" data-color="cyan" onclick="sidebarColor(this)"></span>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-emerald-500 to-teal-400 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-white text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" data-color="emerald" onclick="sidebarColor(this)"></span>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-orange-500 to-yellow-500 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-white text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" data-color="orange" onclick="sidebarColor(this)"></span>
              <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 ease-in-out bg-gradient-to-tl from-red-600 to-orange-600 relative inline-block cursor-pointer whitespace-nowrap border border-solid border-white text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700" data-color="red" onclick="sidebarColor(this)"></span>
            </div>
          </a>
          <!-- Sidenav Type -->
          <div class="mt-4">
            <h6 class="mb-0 dark:text-white">Sidenav Type</h6>
            <p class="text-sm leading-normal dark:text-white dark:opacity-80">Choose between 2 different sidenav types.</p>
          </div>
          <div class="flex">
            <button transparent-style-btn class="inline-block w-full px-4 py-2.5 mb-2 font-bold leading-normal text-center text-white capitalize align-middle transition-all bg-blue-500 border border-transparent border-solid rounded-lg cursor-pointer text-sm xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-blue-500 xl-max:to-violet-500 xl-max:text-white xl-max:border-0 hover:-translate-y-px dark:cursor-not-allowed dark:opacity-65 dark:pointer-events-none dark:bg-gradient-to-tl dark:from-blue-500 dark:to-violet-500 dark:text-white dark:border-0 hover:shadow-xs active:opacity-85 ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-blue-500 to-violet-500 hover:border-blue-500" data-class="bg-transparent" active-style>White</button>
            <button white-style-btn class="inline-block w-full px-4 py-2.5 mb-2 ml-2 font-bold leading-normal text-center text-blue-500 capitalize align-middle transition-all bg-transparent border border-blue-500 border-solid rounded-lg cursor-pointer text-sm xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-blue-500 xl-max:to-violet-500 xl-max:text-white xl-max:border-0 hover:-translate-y-px dark:cursor-not-allowed dark:opacity-65 dark:pointer-events-none dark:bg-gradient-to-tl dark:from-blue-500 dark:to-violet-500 dark:text-white dark:border-0 hover:shadow-xs active:opacity-85 ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-none hover:border-blue-500" data-class="bg-white">Dark</button>
          </div>
          <p class="block mt-2 text-sm leading-normal dark:text-white dark:opacity-80 xl:hidden">You can change the sidenav type just on desktop view.</p>
          <!-- Navbar Fixed -->
          <div class="flex my-4">
            <h6 class="mb-0 dark:text-white">Navbar Fixed</h6>
            <div class="block pl-0 ml-auto min-h-6">
              <input navbarFixed class="rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left mt-1 ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
            </div>
          </div>
          <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent " />
          <div class="flex mt-2 mb-12">
            <h6 class="mb-0 dark:text-white">Light / Dark</h6>
            <div class="block pl-0 ml-auto min-h-6">
              <input dark-toggle class="rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left mt-1 ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
            </div>
          </div>
          <a target="_blank" class="dark:border dark:border-solid dark:border-white inline-block w-full px-6 py-2.5 mb-4 font-bold leading-normal text-center text-white align-middle transition-all bg-transparent border border-solid border-transparent rounded-lg cursor-pointer text-sm ease-in hover:shadow-xs hover:-translate-y-px active:opacity-85 tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850" href="https://www.creative-tim.com/product/argon-dashboard-tailwind" >Free Download</a>
          <a target="_blank" class="dark:border dark:border-solid dark:border-white dark:text-white inline-block w-full px-6 py-2.5 mb-4 font-bold leading-normal text-center align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer active:shadow-xs hover:-translate-y-px active:opacity-85 text-sm ease-in tracking-tight-rem bg-150 bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700 active:hover:shadow-none" href="https://www.creative-tim.com/learning-lab/tailwind/html/quick-start/argon-dashboard/">View documentation</a>
          <div class="w-full text-center">
            <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard-tailwind" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
            <h6 class="mt-4 dark:text-white">Thank you for sharing!</h6>
            <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23tailwindcss&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard-tailwind" class="inline-block px-5 py-2.5 mb-0 mr-2 font-bold text-center text-white align-middle transition-all border-0  rounded-lg cursor-pointer hover:shadow-xs hover:-translate-y-px active:opacity-85 leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 me-2 border-slate-700 bg-slate-700" target="_blank"> <i class="mr-1 fab fa-twitter"></i> Tweet </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard-tailwind" class="inline-block px-5 py-2.5 mb-0 mr-2 font-bold text-center text-white align-middle transition-all border-0  rounded-lg cursor-pointer hover:shadow-xs hover:-translate-y-px active:opacity-85 leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 me-2 border-slate-700 bg-slate-700" target="_blank"> <i class="mr-1 fab fa-facebook-square"></i> Share </a>
          </div>
        </div>
      </div>
    </div>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
  <!-- main script file  -->
  <script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>
</html>

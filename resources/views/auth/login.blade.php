<x-guest-layout>
    <div class="bg-white dark:bg-gray-900">
        <div class="flex justify-center h-screen">
            {{-- Kiri: Gambar Background --}}
            <div class="hidden bg-cover lg:block lg:w-2/3"
                style="background-image: url('https://images.unsplash.com/photo-1616763355603-9755a640a287?ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80')">
                <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                    <div>
                        <h2 class="text-2xl font-bold text-white sm:text-3xl">One Time Secret</h2>
                        <p class="max-w-xl mt-3 text-gray-300">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. In autem ipsa, nulla laboriosam
                            dolores.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Login --}}
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1">
                    {{-- Logo --}}
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <img src="{{ asset('assets/img/logo-kominfo.png') }}" alt="Logo" class="h-10">
                        </div>
                        <p class="mt-3 text-gray-500 dark:text-gray-300">Sign in to access your account</p>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    <x-validation-errors class="mt-4 mb-4" />

                    {{-- Form Login --}}
                    <div class="mt-8">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div>
                                <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email
                                    Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    autofocus
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            <div class="mt-6">
                                <div class="flex justify-between mb-2">
                                    <label for="password"
                                        class="text-sm text-gray-600 dark:text-gray-200">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-sm text-gray-400 focus:text-blue-500 hover:text-blue-500 hover:underline">Forgot
                                            password?</a>
                                    @endif
                                </div>

                                <input type="password" name="password" id="password" required
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            {{-- Remember Me --}}
                            <div class="flex items-center mt-4">
                                <input type="checkbox" name="remember" id="remember_me"
                                    class="text-blue-500 border-gray-300 rounded focus:ring-blue-400">
                                <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-300">Remember
                                    me</label>
                            </div>

                            {{-- Submit --}}
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-blue-500 rounded-lg
                                           hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                    Sign in
                                </button>
                            </div>
                        </form>

                        {{-- Register Link --}}
                        @if (Route::has('register'))
                            <p class="mt-6 text-sm text-center text-gray-400">
                                Don’t have an account yet?
                                <a href="{{ route('register') }}"
                                    class="text-blue-500 focus:outline-none focus:underline hover:underline">Sign up</a>.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
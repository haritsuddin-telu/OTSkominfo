<x-guest-layout>
    <div class="bg-white dark:bg-gray-900">
        <div class="flex justify-center h-screen">
            {{-- Kiri: Background Image --}}
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

            {{-- Kanan: Form Register --}}
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            {{-- Logo --}}
                            <div class="text-center">
                                <div class="flex justify-center mx-auto">
                                    <img src="{{ asset('assets/img/logo-kominfo.png') }}" alt="Logo" class="h-10">
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 text-gray-500 dark:text-gray-300">Create a new account</p>
                    </div>

                    {{-- Validation Errors --}}
                    <x-validation-errors class="mt-4 mb-4" />

                    <div class="mt-8">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Full
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            {{-- Email --}}
                            <div class="mt-4">
                                <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email
                                    Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            {{-- Password --}}
                            <div class="mt-4">
                                <label for="password"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Password</label>
                                <input type="password" name="password" id="password" required
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mt-4">
                                <label for="password_confirmation"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg
                                           dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                                           focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            {{-- Submit --}}
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-blue-500 rounded-lg
                                           hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                    Register
                                </button>
                            </div>
                        </form>

                        {{-- Link to login --}}
                        <p class="mt-6 text-sm text-center text-gray-400">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-blue-500 focus:outline-none focus:underline hover:underline">Log in</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
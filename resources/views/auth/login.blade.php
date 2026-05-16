<x-guest-layout>
    <div class="mb-5">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-[#0098f0] transition-colors group">
            <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" class="block w-full bg-white border-gray-300 text-gray-800 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" class="block w-full bg-white border-gray-300 text-gray-800 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0]" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-between items-center mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0098f0] shadow-sm focus:ring-[#0098f0]" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-[#0098f0] hover:underline" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-[#0098f0] hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-md shadow-sm transition-colors text-sm">
                Log in
            </button>
        </div>

        @if (Route::has('register'))
            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#0098f0] font-medium hover:underline">
                    Sign Up
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UTReminder</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        tab: '{{ $errors->hasAny(['nim', 'name', 'password_confirmation', 'profile_photo']) ? 'register' : 'login' }}',
        photoName: null,
        photoPreview: null,
        updatePhotoPreview(event) {
            const photo = event.target.files[0];
            if (!photo) return;
            this.photoName = photo.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };
            reader.readAsDataURL(photo);
        }
    }"
    class="bg-slate-100 dark:bg-[#0a0a0a] text-[#1b1b18] flex p-4 lg:p-8 items-center justify-center min-h-screen flex-col"
>
    <header class="w-full max-w-4xl text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
               
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-4xl transition-opacity opacity-100 duration-750 ease-in-out starting:opacity-0">
        {{-- DESKTOP VIEW --}}
        <div class="hidden lg:block relative w-full h-[600px]">
            <div class="absolute inset-0 bg-white dark:bg-slate-900 rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-2 h-full">
                    {{-- Register Form Column --}}
                    <div class="p-12 flex flex-col justify-center">
                        @guest
                            <form x-show="tab === 'register'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-6">Create a New Account</h2>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                                    {{-- Left side inputs --}}
                                    <div class="space-y-4">
                                        <div>
                                            <label for="nim" class="text-sm font-medium text-slate-600 dark:text-slate-400">NIM</label>
                                            <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            @if($errors->has('nim'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('nim') }}</p>@endif
                                        </div>
                                        <div>
                                            <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">Name</label>
                                            <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            @if($errors->has('name'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('name') }}</p>@endif
                                        </div>
                                        <div>
                                            <label for="email_reg" class="text-sm font-medium text-slate-600 dark:text-slate-400">Email</label>
                                            <input id="email_reg" type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            @if($errors->has('email'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('email') }}</p>@endif
                                        </div>
                                    </div>
                                    {{-- Right side inputs --}}
                                    <div class="space-y-4">
                                        <div>
                                            <label for="password_reg" class="text-sm font-medium text-slate-600 dark:text-slate-400">Password</label>
                                            <input id="password_reg" type="password" name="password" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            @if($errors->has('password'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('password') }}</p>@endif
                                        </div>
                                        <div>
                                            <label for="password_confirmation" class="text-sm font-medium text-slate-600 dark:text-slate-400">Confirm Password</label>
                                            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Profile Photo</label>
                                            <div class="mt-1 flex justify-center items-center w-full">
                                                <label for="profile_photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-lg cursor-pointer bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!photoPreview">
                                                        <svg class="w-8 h-8 mb-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                                        <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">Click to upload</span></p>
                                                    </div>
                                                    <img :src="photoPreview" x-show="photoPreview" class="object-cover w-full h-full rounded-lg">
                                                    <input id="profile_photo" type="file" name="profile_photo" @change="updatePhotoPreview($event)" class="hidden" accept="image/*">
                                                </label>
                                            </div>
                                            @if($errors->has('profile_photo'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('profile_photo') }}</p>@endif
                                        </div>
                                    </div>
                                    {{-- Submit and switch button --}}
                                    <div class="col-span-2">
                                        <button type="submit" class="w-full mt-4 px-4 py-3 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create Account</button>
                                        <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-4">
                                            Already have an account?
                                            <button type="button" @click.prevent="tab = 'login'" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sign in</button>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        @endguest
                    </div>

                    {{-- Login Form Column --}}
                    <div class="p-12 flex flex-col justify-center">
                         @guest
                            <form x-show="tab === 'login'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf
                                <h2 class="text-2xl font-semibold text-slate-800 dark:text-white">Sign In to Your Account</h2>
                                <div>
                                    <label for="login" class="text-sm font-medium text-slate-600 dark:text-slate-400">Email or NIM</label>
                                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus class="w-full px-4 py-2 mt-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="your.email@ecampus.ut.ac.id">
                                    @if($errors->has('login'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('login') }}</p>@endif
                                </div>
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="password" class="text-sm font-medium text-slate-600 dark:text-slate-400">Password</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Forgot password?</a>
                                        @endif
                                    </div>
                                    <input id="password" type="password" name="password" required class="w-full px-4 py-2 mt-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••">
                                    @if($errors->has('password'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('password') }}</p>@endif
                                </div>
                                <div class="block">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" name="remember" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="w-full px-4 py-3 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign In</button>
                                </div>
                                <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                                    Don't have an account?
                                    <button type="button" @click.prevent="tab = 'register'" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sign up</button>
                                </p>
                            </form>
                        @else
                            <div class="text-slate-800 dark:text-white">
                                <p class="mb-2">Anda sudah masuk sebagai <strong>{{ Auth::user()->name }}</strong>.</p>
                                <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-indigo-600 rounded-md text-white">Buka Dashboard</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>

            {{-- Sliding Panel --}}
            <div
                class="absolute inset-y-0 left-0 w-1/2 bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-900 rounded-lg shadow-2xl p-12 text-white flex flex-col justify-center transform transition-transform duration-700 ease-in-out"
                :class="{ 'translate-x-full': tab === 'register', 'translate-x-0': tab === 'login' }"
            >
                {{-- Content for LOGIN tab --}}
                <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="w-full">
                    <div class="mb-6">
                        <img src="{{ asset('images/image.png') }}" alt="logo" class="h-10 w-auto">
                    </div>
                    <h1 class="text-4xl font-bold">UT Reminder</h1>
                    <p class="mt-4 text-slate-300">Your smart companion for success at Universitas Terbuka. Never miss a deadline again.</p>
                </div>
                {{-- Content for REGISTER tab --}}
                <div x-show="tab === 'register'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak class="w-full">
                    <div class="mb-6">
                        <img src="{{ asset('images/image.png') }}" alt="logo" class="h-10 w-auto">
                    </div>
                    <h1 class="text-4xl font-bold">Welcome!</h1>
                    <p class="mt-4 text-slate-300">Just a few details to get you started on your academic journey with UT Reminder.</p>
                </div>
            </div>
        </div>

        {{-- MOBILE VIEW --}}
        <div class="lg:hidden w-full bg-white dark:bg-slate-900 rounded-lg shadow-lg p-8">
            @guest
                {{-- Register Form --}}
                <form x-show="tab === 'register'" x-transition x-cloak method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('images/image.png') }}" alt="logo" class="h-8 w-auto">
                    </div>
                    <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-6 text-center">Create a New Account</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="nim_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">NIM</label>
                            <input id="nim_mobile" type="text" name="nim" value="{{ old('nim') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if($errors->has('nim'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('nim') }}</p>@endif
                        </div>
                        <div>
                            <label for="name_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Name</label>
                            <input id="name_mobile" type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if($errors->has('name'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('name') }}</p>@endif
                        </div>
                        <div>
                            <label for="email_reg_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Email</label>
                            <input id="email_reg_mobile" type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if($errors->has('email'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('email') }}</p>@endif
                        </div>
                        <div>
                            <label for="password_reg_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Password</label>
                            <input id="password_reg_mobile" type="password" name="password" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if($errors->has('password'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('password') }}</p>@endif
                        </div>
                        <div>
                            <label for="password_confirmation_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Confirm Password</label>
                            <input id="password_confirmation_mobile" type="password" name="password_confirmation" required class="w-full px-4 py-2 mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Profile Photo</label>
                            <div class="mt-1 flex justify-center items-center w-full">
                                <label for="profile_photo_mobile" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-lg cursor-pointer bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!photoPreview">
                                        <svg class="w-8 h-8 mb-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                        <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">Click to upload</span></p>
                                    </div>
                                    <img :src="photoPreview" x-show="photoPreview" class="object-cover w-full h-full rounded-lg">
                                    <input id="profile_photo_mobile" type="file" name="profile_photo" @change="updatePhotoPreview($event)" class="hidden" accept="image/*">
                                </label>
                            </div>
                            @if($errors->has('profile_photo'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('profile_photo') }}</p>@endif
                        </div>
                        <div>
                            <button type="submit" class="w-full mt-4 px-4 py-3 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create Account</button>
                            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-4">
                                Already have an account?
                                <button type="button" @click.prevent="tab = 'login'" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sign in</button>
                            </p>
                        </div>
                    </div>
                </form>

                {{-- Login Form --}}
                <form x-show="tab === 'login'" x-transition x-cloak method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('images/image.png') }}" alt="logo" class="h-8 w-auto">
                    </div>
                    <h2 class="text-2xl font-semibold text-slate-800 dark:text-white text-center">Sign In</h2>
                    <div>
                        <label for="login_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Email or NIM</label>
                        <input id="login_mobile" type="text" name="login" value="{{ old('login') }}" required autofocus class="w-full px-4 py-2 mt-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="your.email@ecampus.ut.ac.id">
                        @if($errors->has('login'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('login') }}</p>@endif
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password_mobile" class="text-sm font-medium text-slate-600 dark:text-slate-400">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Forgot password?</a>
                            @endif
                        </div>
                        <input id="password_mobile" type="password" name="password" required class="w-full px-4 py-2 mt-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••">
                        @if($errors->has('password'))<p class="text-red-600 text-sm mt-1">{{ $errors->first('password') }}</p>@endif
                    </div>
                    <div class="block">
                        <label for="remember_me_mobile" class="inline-flex items-center">
                            <input id="remember_me_mobile" type="checkbox" name="remember" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-3 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign In</button>
                    </div>
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                        Don't have an account?
                        <button type="button" @click.prevent="tab = 'register'" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Sign up</button>
                    </p>
                </form>
            @else
                <div class="text-slate-800 dark:text-white">
                    <p class="mb-2">Anda sudah masuk sebagai <strong>{{ Auth::user()->name }}</strong>.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-indigo-600 rounded-md text-white">Buka Dashboard</a>
                </div>
            @endguest
        </div>
    </main>
</body>
</html>

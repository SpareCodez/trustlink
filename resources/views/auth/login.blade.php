@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
    {{-- Error banner --}}
    @if ($errors->any())
        <div class="absolute top-0 left-0 w-full animate-in fade-in slide-in-from-top duration-500">
            <div class="bg-[#FF4D00] text-white flex items-center justify-center py-3 px-6 gap-3">
                <span class="material-symbols-outlined text-[20px]">warning</span>
                <span class="font-body-md text-body-md font-medium">Wrong email or password. Check your details and try again.</span>
            </div>
        </div>
    @endif

    <div class="w-full max-w-[440px] flex flex-col {{ $errors->any() ? 'mt-12' : '' }}">
        <div class="mb-stack-lg">
            <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-1">Sign in</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Sign in to access your account</p>
        </div>

        <form class="space-y-stack-md" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('email') ? 'text-error' : 'text-outline' }}">alternate_email</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('email') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        name="email" placeholder="Email address" type="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus/>
                </div>
            </div>

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('password') ? 'text-error' : 'text-outline' }}">lock</span>
                    <input class="w-full pl-10 pr-10 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('password') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        id="password-input" name="password" placeholder="Password" type="password"
                        required autocomplete="current-password"/>
                    <button class="absolute right-3 text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
                    </button>
                </div>
                <div class="flex justify-end">
                    @if (Route::has('password.request'))
                        <a class="font-label-caps text-label-caps text-primary hover:text-primary-container transition-colors" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer group w-fit">
                <div class="relative flex items-center">
                    <input name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="peer sr-only" type="checkbox"/>
                    <div class="w-5 h-5 hairline-border rounded-lg bg-surface peer-checked:bg-primary peer-checked:border-primary transition-all"></div>
                    <span class="material-symbols-outlined absolute inset-0 text-white text-[16px] opacity-0 peer-checked:opacity-100 flex items-center justify-center pointer-events-none">check</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface transition-colors">Keep me signed in for 30 days</span>
            </label>

            <button class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group mt-stack-lg" type="submit">
                Sign in
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

        <div class="mt-stack-lg flex flex-col items-center gap-6">
            <div class="flex items-center w-full gap-4">
                <div class="h-[0.5px] bg-outline-variant flex-1"></div>
                <span class="font-label-caps text-label-caps text-outline uppercase">Or register</span>
                <div class="h-[0.5px] bg-outline-variant flex-1"></div>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center">
                Need an account? <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Apply for merchant access</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password-input');
        const icon  = document.getElementById('password-toggle-icon');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    }
</script>
@endpush

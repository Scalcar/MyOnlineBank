<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container-fluid py-2 mx-2">
    <a class="navbar-brand d-flex align-items-start" href="/user">
    <x-application-logo width="42" />
    <span class="ms-2">{{ config('app.name', 'Laravel') }}</span>         
    </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-auto ps-5">
                <x-nav-link href="{{ route('user.home') }}" :active="request()->routeIs('user.home')" class="me-3">
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="me-3">
                    {{ __('First') }}
                </x-nav-link>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('First') }}
                </x-nav-link>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <div class="me-4">
                    <a href="{{ route('user.login') }}" class="text-light font-weight-bold"><i class="bi bi-person-plus-fill icon" style="font-size: 24px;" title="Login"></i></a>
                </div>
                         
            </ul>
        </div>
    </div>
</nav>        
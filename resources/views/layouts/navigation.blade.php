<nav class="navbar navbar-expand-md navbar-dark bg-dark border-bottom sticky-top">
    <div class="container-fluid py-2">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center mx-2" href="/user/home">
            <x-application-logo width="42" />
            <span class="ms-2">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <x-nav-link href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </ul>

            <ul class="navbar-nav ms-auto ps-5">
                    <x-nav-link href="{{ route('user.home') }}" :active="request()->routeIs('user.home')" class="me-3">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('user.news') }}" :active="request()->routeIs('user.news')" class="me-3">
                        {{ __('News') }}
                    </x-nav-link>
                    <!-- <x-nav-link href="{{ route('user.contact') }}" :active="request()->routeIs('user.contact')">
                        {{ __('Contact') }}
                    </x-nav-link> -->
                </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mx-3">

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown id="settingsDropdown">
                        <x-slot name="trigger">
                            {{ Auth::user()->username }}
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('user.logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('user.logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-danger">
                                                <i class="bi bi-power text-danger"> </i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </ul>
        </div>
    </div>
</nav>
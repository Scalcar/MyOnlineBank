<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container-fluid px-3">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/admin/home">
            <x-application-logo width="42" />
            <span class="ms-1">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto ms-2">
                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </ul>

            <ul class="navbar-nav ms-auto">
                <x-nav-link href="{{ route('admin.home') }}" :active="request()->routeIs('admin.home')">
                    {{ __('Home') }}
                </x-nav-link>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto me-3">
                

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown id="settingsDropdown">
                        <x-slot name="trigger">
                            {{ Auth::guard('admin')->user()->name }}
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('admin.logout')"
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
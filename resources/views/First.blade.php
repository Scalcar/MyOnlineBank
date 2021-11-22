<x-guest-layout>  
    <div class="container-fluid p-0 mb-0 h-auto">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid py-2 mx-2">
            <a class="navbar-brand d-flex align-items-start" href="/">
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
                        <x-nav-link href="{{ route('user.publicNews') }}" :active="request()->routeIs('user.publicNews')" class="me-3">
                            {{ __('News') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('user.publicContact') }}" :active="request()->routeIs('user.publicContact')">
                            {{ __('Contact') }}
                        </x-nav-link>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
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
                                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <div class="me-4">
                                <a href="{{ route('user.login') }}" class="text-light font-weight-bold"><i class="bi bi-person-plus-fill icon" style="font-size: 24px;" title="Login"></i></a>
                            </div>
                        @endauth     
                    </ul>
                </div>
            </div>
        </nav>        

        <div class="d-flex  pt-2 bg-white shadow-sm border-bottom">
            <div class="container">
                <h2 class="h4 font-weight-bold text-center my-3 text-secondary">
                    Your Bank at Your Fingertips.
                </h2>
            </div>
        </div>
                     
        <x-footer></x-footer>
    </div>
</x-guest-layout>
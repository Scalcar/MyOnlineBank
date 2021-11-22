<x-guest-layout>
    
    <div class="container-fluid p-0 mb-0 h-auto">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid py-2">
                <a class="navbar-brand d-flex align-items-start" href="/">
                    <x-application-logo width="42" />
                    <span class="ms-2">{{ config('app.name', 'Laravel') }}</span>         
                </a>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto ps-5">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        
                                                
                    </ul>
                </div>
            </div>
        </nav>        

        <div class="container-fluid" style="margin-top: 10%;">
            <div class="row">
                <div class="col-md-4 m-auto py-5">
                    <div class="card shadow-sm p-3 border border-secondary">
                        <div class="card-body mb-2">
                            <h4 class="text-center mb-3">My Online Bank - Login</h4>
                            <form action="{{ route('user.check') }}" method="POST" autocomplete="off">
                                @if(Session::get('fail'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif

                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                                    <span class="text-danger">@error('email') {{ $message }}  @enderror</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter password" value="{{ old('password') }}">
                                    <span class="text-danger">@error('password') {{ $message }}  @enderror</span>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <x-checkbox id="remember_me" name="remember" />

                                        <label class="form-check-label" for="remember_me">
                                            {{ __('Remember Me') }}
                                        </label>
                                        <span class="float-end">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                        </span>
                                    </div>                        
                                </div>
                            
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-outline-dark w-50">Login</button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        <x-footer></x-footer>
    </div>

</x-guest-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: #c8d9e8 !important;">
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
        <div class="container-fluid py-2 mx-2">
            <a class="navbar-brand d-flex align-items-start" href="/">
                <x-application-logo width="42" />
                <span class="ms-2">{{ config('app.name', 'Laravel') }}</span>         
            </a>          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <div class="text-danger p-2 border border-danger rounded mx-2">Restricted Area</div>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 120px;">
        <div class="row">
            <div class="col-md-4 m-auto py-5">
                <div class="card shadow-sm p-3 border border-secondary">
                    <div class="card-body mb-2">
                        <h4 class="text-center mb-3">My Online Bank - Admin Login</h4>
                        <form action="{{ route('admin.check') }}" method="POST" autocomplete="off">
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
                                    <!-- <span class="float-end">
                                    @if (Route::has('password.request'))
                                        <a class="text-muted" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                    </span> -->
                                </div>                        
                            </div>
                        
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-outline-primary w-50">Login</button>
                            </div>
                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</body>
</html>
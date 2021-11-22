<x-admin-layout>
    <x-slot name="header">
        <div class="col-3">
            <h2 class="h4 font-weight-bold">
            ~ {{ __('Welcome!') }}  <span class="ms-2 text-secondary">{{Auth::user()->name}}</span> ~
            </h2>
        </div>
        <div class="col-8">
            <nav class="nav nav-pills nav-justified justify-content-end">
                <a class="nav-link active" aria-current="page" href="#"> Admin <i class="bi bi-person-plus" style="font-size: 16px;"> </i></a>
                <a class="nav-link" href="{{ route('admin.manage_admins') }}">Manage Admins</a>
                <a class="nav-link" href="{{ route('admin.add_customer') }}"> Customer <i class="bi bi-person-plus" style="font-size: 16px;"> </i></a>
                <a class="nav-link" href="{{ route('admin.manage_customers') }}">Manage Customers</a>
                <a class="nav-link" href="{{ route('admin.manage_messages') }}">Manage Messages</a>
                <a class="nav-link" href="#">Post News</a>
            </nav>
        </div>    
    </x-slot>

    <div class="row" style="margin-top: 8%;">
        <div class="col-md-9 m-auto py-5">
            <div class="card shadow-sm p-3 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center mb-3 text-primary"> ~ Create New Admin ~ </h4>
                    <form action="{{ route('admin.create') }}" method="POST" autocomplete="off" class="p-2">
                        @if(Session::get('success'))
                        <div class="alert alert-success col-9 m-auto alert-dismissible fade show mb-3 text-center" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(Session::get('fail'))
                            <div class="alert alert-danger col-9 m-auto alert-dismissible fade show mb-3 text-center" role="alert">
                                {{ Session::get('fail') }}
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @csrf
                        <div class="row mb-2">
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Name" id="name" name="name" value="{{ old('name') }}" />
                                <label for="name" class="text-muted ps-4">Name :</label>
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Email" id="email" name="email" value="{{ old('email') }}" />
                                <label for="email" class="text-muted ps-4">Email :</label>
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4 mt-5">
                            <div class="col form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Password" id="password" name="password" value="{{ old('password') }}" />
                                <label for="password" class="text-muted ps-4">Password :</label>
                                <span class="text-danger ps-1">@error('password') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Confirm Password" id="cpassword" name="cpassword" value="{{ old('cpassword') }}" />
                                <label for="cpassword" class="text-muted ps-4">Confirm Password</label>
                                <span class="text-danger ps-1">@error('cpassword') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5 mb-3">
                            <button type="submit" class="btn btn-lg btn-outline-primary w-50"> Create </button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
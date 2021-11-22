<x-admin-layout>
    <x-slot name="header">
        <div class="col-3">
            <h2 class="h4 font-weight-bold">
            ~ {{ __('Welcome!') }}  <span class="ms-2 text-secondary">{{Auth::user()->name}}</span> ~
            </h2>
        </div>
        <div class="col-8">
            <nav class="nav nav-pills nav-justified justify-content-end">
                <a class="nav-link" href="{{ route('admin.add_admin') }}"> Admin <i class="bi bi-person-plus" style="font-size: 16px;"> </i></a>
                <a class="nav-link" href="{{ route('admin.manage_admins') }}">Manage Admins</a>
                <a class="nav-link" href="{{ route('admin.add_customer') }}"> Customer <i class="bi bi-person-plus" style="font-size: 16px;"> </i></a>
                <a class="nav-link" href="{{ route('admin.manage_customers') }}">Manage Customers</a>
                <a class="nav-link" href="{{ route('admin.manage_messages') }}">Manage Messages</a>
                <a class="nav-link" href="#">Post News</a>
            </nav>
        </div>    
    </x-slot>

    <div class="row" style="margin-top: 8%;">
        <div class="col-md-6 m-auto py-5">
            <div class="card shadow-sm p-4 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center mb-3 text-primary"> ~ Edit Admin ~ </h4>
                    <form action="{{ route('admin.edit') }}" method="POST" autocomplete="off" class="p-2">                  
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="modelId" value="{{$admin->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Name" id="name" name="name" value="{{ $admin->name }}" />
                                <label for="name" class="text-muted ps-4">Name :</label>
                                <span class="text-danger ps-1">@error('name') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4 mt-5">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Email" id="email" name="email" value="{{ $admin->email }}" />
                                <label for="email" class="text-muted ps-4">Email :</label>
                                <span class="text-danger ps-1">@error('email') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-evenly mt-5 mb-2">
                            <a class="btn btn-lg btn-outline-secondary w-25" href="{{ route('admin.manage_admins') }}">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Edit</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
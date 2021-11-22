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
    <!--  remember $admin->users  si $user->admin->name -->
    
    <div class="row">
        <div class="col-md-9 m-auto py-5">
            <div class="card shadow-sm p-3 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center mb-3 text-primary"> ~ Edit Customer ~ </h4>
                    <form action="{{ route('admin.edit_customer') }}" method="POST" autocomplete="off" class="p-2">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="modelId" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="First name" id="fname" name="fname" value="{{ $user->fname }}" />
                                <label for="fname" class="text-muted ps-4">First Name</label>
                                <span class="text-danger">@error('fname') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Last name" id="lname" name="lname" value="{{ $user->lname }}" />
                                <label for="lname" class="text-muted ps-4">Last Name</label>
                                <span class="text-danger">@error('lname') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4 mt-5">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Username" id="username" name="username" value="{{ $user->username }}" />
                                <label for="username" class="text-muted ps-4">Username</label>
                                <span class="text-danger ps-1">@error('username') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="phone" class="form-control text-primary" placeholder="CNP" id="cnp" name="cnp" value="{{ $user->cnp }}" pattern="[0-9]{13}"/>
                                <label for="cnp" class="text-muted ps-4">CNP</label>
                                <span class="text-danger ps-1">@error('cnp') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="email" class="form-control text-primary" placeholder="Email" name="email" id="email" value="{{ $user->email }}" />
                                <label for="email" class="text-muted ps-4">Email address</label>
                                <span class="text-danger ps-1">@error('email') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="phone" class="form-control text-primary" placeholder="Phone" id="phone" name="phone" value="{{ $user->phone }}" pattern="[0-9]{9,14}" />
                                <label for="phone" class="text-muted ps-4">Phone</label>
                                <span class="text-danger ps-1">@error('phone') {{ $message }} @enderror</span>
                            </div>
                        </div>                                             
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Address" id="address" name="address" value="{{ $user->address }}" />
                                <label for="address" class="text-muted ps-4">Address</label>
                                <span class="text-danger ps-1">@error('address') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="gender" id="gender">
                                    <option>Choose gender</option>
                                    @foreach(App\General\Concretes\Enums\UserGenders::$enum as $key => $value)
                                        <option value="{{$value}}" @if ($user->gender == $value) selected @endif >{{$key}}</option>
                                    @endforeach
                                </select>
                                <label for="gender" class="text-muted ps-4">Gender</label>
                                <span class="text-danger">@error('gender') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="date" class="form-control text-primary" placeholder="Date of Birth" id="dob" name="dob" value="{{ $user->dob }}" max="2003-12-31" min="1950-01-01" />
                                <label for="dob" class="text-muted ps-4">Date of Birth</label>
                                <span class="text-danger">@error('dob') {{ $message }} @enderror</span>
                            </div>
                        </div>                                              
                        <div class="d-flex justify-content-evenly mt-5 mb-3">
                            <a class="btn btn-lg btn-outline-secondary w-25" href="{{ route('admin.manage_customers') }}">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Edit</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
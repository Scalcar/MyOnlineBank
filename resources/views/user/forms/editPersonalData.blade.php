<x-app-layout>
    <x-slot name="header">       
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>         
    </x-slot>

    <div class="row">           
        <div class="col-6 m-auto mt-5">
            <div class="card shadow-sm border border-2 border-primary">
                <div class="card-body mb-2">
                    <h4 class="text-center my-3 text-primary"> ~ Edit Personal Settings ~ </h4>
                    <form action="{{ route('user.edit_personal_data') }}" method="POST" autocomplete="off" class="p-2">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="modelId" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="First name" id="fname" name="fname" value="{{ $user->fname }}" />
                                <label for="fname" class="text-muted ps-4">First Name</label>
                                <span class="text-danger ps-1">@error('fname') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Username" id="username" name="username" value="{{ $user->username }}" />
                                <label for="username" class="text-muted ps-4">Username</label>
                                <span class="text-danger ps-1">@error('username') {{ $message }} @enderror</span>
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
                        <div class="row">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Address" id="address" name="address" value="{{ $user->address }}" />
                                <label for="address" class="text-muted ps-4">Address</label>
                                <span class="text-danger ps-1">@error('address') {{ $message }} @enderror</span>
                            </div>
                        </div>    
                        <div class="text-danger text-center">Note: For other changes or if you have incorrect data please contact admin at <span class="badge bg-info">{{$user->admin->email}}</span></div>                       
                        <div class="d-flex justify-content-center mt-5 mb-3">                        
                            <button type="submit" class="btn btn-lg btn-outline-primary w-50">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
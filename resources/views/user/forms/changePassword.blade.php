<x-app-layout>
    <x-slot name="header">       
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>         
    </x-slot>

    <div class="row">           
        <div class="col-4 m-auto mt-5">
            <div class="card shadow-sm border border-2 border-primary">
                <div class="card-body mb-2">
                    <h4 class="text-center my-3 text-primary"> ~ Change Password Setting ~ </h4>
                    <form action="{{ route('user.change_password') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="modelId" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-2">
                            <div class="col-8 m-auto form-floating">
                            <input type="password" class="form-control text-primary" placeholder="Old password" id="opassword" name="opassword" value="{{ old('opassword') }}" />
                                <label for="opassword" class="text-muted ps-4">Old Password</label>
                                <span class="text-danger ps-1">@error('opassword') {{ $message }} @enderror</span>
                            </div>                          
                        </div>
                        <div class="row mb-2">
                            <div class="col-8 m-auto form-floating">
                            <input type="password" class="form-control text-primary" placeholder="New password" id="password" name="password" value="{{ old('password') }}" />
                                <label for="password" class="text-success ps-4">New password</label>
                                <span class="text-danger ps-1">@error('password') {{ $message }} @enderror</span>
                            </div>                          
                        </div>
                        <div class="row mb-2">
                            <div class="col-8 m-auto form-floating">
                            <input type="password" class="form-control text-primary" placeholder="Confirm password" id="cpassword" name="cpassword" value="{{ old('cpassword') }}" />
                                <label for="cpassword" class="text-danger ps-4">Confirm password</label>
                                <span class="text-danger ps-1">@error('cpassword') {{ $message }} @enderror</span>
                            </div>                          
                        </div>
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="submit" class="btn btn-lg btn-outline-primary w-50">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
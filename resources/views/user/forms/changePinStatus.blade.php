<x-app-layout>
    <x-slot name="header">       
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>         
    </x-slot>

    <div class="row">           
        <div class="col-md-4 m-auto mb-5 mt-4">
            <div class="card shadow-sm border border-2 border-primary">
                <div class="card-body mb-2">
                    <h3 class="text-center my-4 text-primary"> ~ Change Pin Setting ~ </h3>
                    <div class="text-center text-primary mt-5 mb-3">
                        <h4>Pin Status: <span class="badge @if($account->pinStatus === 0) bg-danger @else bg-success @endif">{{$account->statusPin}}</span><h4>
                        @if($account->pinStatus === 0)         
                            <h5 class="text-dark py-3 fw-bold"><i class="bi bi-exclamation-circle text-danger me-2"></i>Admin Notification - Pin is: {{$account->pin}}. Please change it! <i class="bi bi-exclamation-circle text-danger ms-2"></i></h5>
                        @endif
                    </div>
                    <form action="{{ route('user.change_pin') }}" method="POST" autocomplete="off" class="p-2 mt-3">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="account_id" value="{{$account->id}}" />
                        </div>
                        <div class="row mb-2">
                            <div class="col-7 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Old Pin" name="pin" id="pin" />
                                <label for="pin" class="text-muted ps-4">Old PIN :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>                      
                        </div>
                        <div class="row">
                            <div class="col-7 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="New Pin" name="npin" id="npin" />
                                <label for="npin" class="text-muted ps-4">New PIN :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('npin') {{ $message }} @enderror</span>
                            </div>                                                                                                                                                                                                                                                                                                          
                        </div> 
                        <div class="row">
                            <div class="col-7 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Confirm pin" name="cpin" id="cpin" />
                                <label for="cpin" class="text-muted ps-4">Confirm pin :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('cpin') {{ $message }} @enderror</span>
                            </div>                                                                                                                                                                                                                                                                                                          
                        </div> 
                        <div class="row mb-4">
                            <div class="col-7 m-auto">
                                @if($account->pinStatus === 1)
                                    <span class="float-end"><a class="text-muted" href="#">{{ __('Forgot your pin?') }} </a></span>
                                @endif
                            </div>
                        </div>                      
                        <div class="text-danger text-center">Note: For your protection change the pin as often as possible.</div>
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
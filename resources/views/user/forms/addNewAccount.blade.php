<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    <div class="row">      
        <div class="col-md-5 m-auto py-5">
            <div class="card shadow-sm p-3 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center my-3 text-primary"> ~ @if(count($user->accounts) === 0 || $user->accounts->first()->status->status === 0) Do you need an account? @else Do you need a secondary account? @endif ~ </h4>
                    <form action="{{ route('user.request_account') }}" method="POST" autocomplete="off" class="p-2">                      
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="admin_id" value="{{$user->admin->id}}" />
                            <input type="hidden" name="user_id" value="{{$user->id}}" />
                            <input type="hidden" name="accNo" value="{{$random}}" />
                            <input type="hidden" name="pin" value="{{rand(1000,9999)}}" />
                            @if(count($user->accounts) !== 0)
                                <input type="hidden" name="branch" value="{{$user->accounts->first()->branch}}" />
                            @endif
                        </div>
                        @if(count($user->accounts) === 0 || $user->accounts->first()->status->status === 0)
                            <div class="row mb-4">
                                <div class="col-7 m-auto form-floating">
                                    <select class="form-select text-primary" aria-label="Default select example" name="branch" id="branch">
                                        <option>Choose branch</option>
                                        @foreach(App\General\Concretes\Enums\AccountBranches::$enum as $key => $value)
                                            <option value="{{$value}}">{{$key}}</option>
                                        @endforeach                                                                      
                                    </select>
                                    <label for="branch" class="text-muted ps-4">Account branch :</label>
                                    <span class="text-danger">@error('branch') {{ $message }} @enderror</span>
                                </div>                          
                            </div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-7 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="type" id="type">
                                    <option>Choose type</option>
                                    @foreach(App\General\Concretes\Enums\AccountType::$enum as $key => $value)
                                        <option value="{{$value}}">{{ucfirst($key)}}</option>
                                    @endforeach                                                                      
                                </select>
                                <label for="type" class="text-muted ps-4">Account type :</label>
                                <span class="text-danger">@error('type') {{ $message }} @enderror</span>
                            </div>                          
                        </div>
                        <div class="row mb-4">                        
                            <div class="col-7 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="currency" id="currency">
                                    <option>Choose currency</option>
                                    @foreach(App\General\Concretes\Enums\AccountCurrency::$enum as $key => $value)
                                        <option value="{{$value}}">{{$key}}</option>
                                    @endforeach                                  
                                </select>
                                <label for="currency" class="text-muted ps-4">Currency :</label>
                                <span class="text-danger">@error('currency') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-7 m-auto form-floating">
                                <input type="number" class="form-control text-primary" placeholder="Balance" name="balance" id="balance" value="{{ old('balance') }}" min="0"/>
                                <label for="balance" class="text-muted ps-4">Balance :<span class="ms-2"><i class="bi bi-piggy-bank h5"></i></span></label>
                                <span class="text-danger ps-1">@error('balance') {{ $message }} @enderror</span>
                            </div>
                        </div>                       
                        <div class="text-danger text-center">Note: The account request will be verified by an admin who can approve it or not.</div>
                        <div class="d-flex justify-content-center mt-5 mb-3">
                            <a href="{{ route('user.home') }}" class="btn btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-outline-primary w-25 ms-4">Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
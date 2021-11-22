<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$account->user->fname}} {{$account->user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    @if(Session::get('fail'))
        <div class="alert alert-danger col-5 mt-4 text-center m-auto alert-dismissible fade show" role="alert">
            {{ Session::get('fail') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif 

    <div class="row">           
        <div class="col-md-4 m-auto py-5">          
            <div class="card shadow-sm p-3 border border-secondary my-4">               
                <div class="card-body mb-2">
                    <h3 class="text-center my-4 text-danger"> Are you sure you want to close this account? </h3>
                    <div class="text-center text-primary my-5">
                        <h4>Details:<h4> 
                        <h5>Account: {{$account->accNo}} / Type: {{$account->AccountType}} / Balance: {{$account->balance}} {{$account->AccountCurrency}}</h5>
                    </div>
                    <form action="{{ route('user.request_close') }}" method="POST" autocomplete="off" class="p-2">                      
                        @csrf
                        <div class="row mb-2">                                                      
                            <input type="hidden" name="modelId" value="{{$account->status->id}}" />
                            <input type="hidden" name="account_id" value="{{$account->id}}" />                                             
                        </div>                      
                        <div class="row mb-4">
                            <div class="col-7 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Pin" name="pin" id="pin" />
                                <label for="pin" class="text-muted ps-4">PIN :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>                      
                        </div>
                        <div class="text-danger text-center">Note: Each customer must have at least one bank account.</div>
                        <div class="text-danger text-center">To close the account you must come to our offices.</div>
                        <div class="d-flex justify-content-center mt-5 mb-3">
                            <a href="{{ route('user.close_account_form') }}" class="btn btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-outline-danger w-25 ms-4">Request</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
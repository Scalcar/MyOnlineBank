<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    @if(Session::get('success'))
        <div class="alert alert-success col-6 mt-4 text-center m-auto alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
   
    <div class="row">           
        <div class="col-md-6 m-auto py-5">          
            <div class="card shadow-sm border border-2 border-primary">              
                <div class="card-body mb-2">
                    <h4 class="text-center my-4 text-primary"> ~ External Transfer ~ </h4>                
                    <form action="{{ route('user.external_transfer') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="user_id" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="from_account" id="from_account">
                                    <option>Choose account :</option>
                                    @foreach($accounts as $key => $account)
                                        <option value="{{$account->id}}" >{{$loop->iteration}}) Account Number: {{$account->accNo}} / Type: {{$account->accountType}} / Balance: {{$account->balance}} {{$account->accountCurrency}}</option>
                                    @endforeach
                                </select>
                                <label for="from_account" class="text-muted ps-4">Account to transfer From :</label>
                                <span class="text-danger">@error('from_account') {{ $message }} @enderror</span>
                            </div>
                        </div> 
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Account to transfer to" id="to_account" name="to_account" value="{{old('to_account')}}" />
                                <label for="to_account" class="text-muted ps-4">Account Number to transfer To : </label>
                                <span class="text-danger">@error('to_account') {{ $message }} @enderror</span>
                            </div>
                        </div>                                          
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Amount to transfer" id="amount" name="amount" value="{{old('amount')}}" />
                                <label for="amount" class="text-muted ps-4">Amount : </label>
                                <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Details for transfer" id="details" name="details" value="{{old('details')}}" />
                                <label for="details" class="text-muted ps-4">Transfer Details : </label>
                                <span class="text-danger">@error('details') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Pin" name="pin" id="pin" />
                                <label for="pin" class="text-muted ps-4"> PIN :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>                      
                        </div>                                             
                        <div class="text-danger text-center my-3">Note: Check twice before you make the transfer. </div>                                                                        
                        <div class="d-flex justify-content-evenly mt-5 mb-3">
                            <a href="{{ route('user.home') }}" class="btn btn-lg btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Submit</button>
                        </div>
                    </form>                  
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
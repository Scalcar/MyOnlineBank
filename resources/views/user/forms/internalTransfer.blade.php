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
                    <h4 class="text-center my-4 text-primary"> ~ Internal Transfer with your contacts ~ </h4>
                    <form action="{{ route('user.internal_transfer') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="user_id" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="from_account" id="from_account">
                                    <option>Choose account :</option>
                                    @if(count($accounts) !== 0)
                                        @foreach($accounts as $key => $account)
                                            <option value="{{$account->id}}" >{{$loop->iteration}}) Account Number: {{$account->accNo}} / Balance: {{$account->balance}} {{$account->accountCurrency}}</option>
                                        @endforeach
                                    @else
                                        <option>You have no accounts.</option>    
                                    @endif
                                </select>
                                <label for="from_account" class="text-muted ps-4">Account to transfer From :</label>
                                <span class="text-danger">@error('from_account') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="to_account" id="to_account">
                                    <option>Choose contact :</option>
                                    @if(count($contacts) !== 0)
                                        @foreach($contacts as $key => $contact)
                                            @if(!empty($contact->account))
                                                <option value="{{$contact->account_id}}" >{{$loop->iteration}}) {{$contact->nickname}} - Account Number : {{$contact->account->accNo}} / Currency : {{$contact->account->accountCurrency}}</option>
                                            @else
                                                <option class="text-danger">{{$loop->iteration}}) {{$contact->nickname}} is invalid - closed account</span></option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option>You have no contacts.</option>
                                    @endif
                                </select>
                                <label for="to_account" class="text-muted ps-4">Contact to transfer To :</label>
                                <span class="text-danger">@error('to_account') {{ $message }} @enderror</span>
                            </div>                        
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Amount to transfer" id="amount" name="amount" value="{{old('amount')}}" />
                                <label for="amount" class="text-muted ps-4">Amount : <i class="bi bi-cash" style="font-size: 16px;"></i> <i class="bi bi-cash" style="font-size: 16px;"></i> <i class="bi bi-cash" style="font-size: 16px;"></i></label>
                                <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8 m-auto form-floating">
                                <input type="password" class="form-control text-primary" placeholder="Pin" name="pin" id="pin" />
                                <label for="pin" class="text-muted ps-4"> PIN :<span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>                      
                        </div>                         
                        <div class="text-danger text-center my-4">Note: If the accounts have different currency the transfer will be made at this 
                            <a class="list-group-item list-group-item-action list-group-item-success my-2 rounded text-center w-25 m-auto" data-bs-toggle="collapse" href="#exchange" role="button" aria-expanded="false" aria-controls="exchange"><i class="bi bi-currency-exchange"></i> exchange rate <i class="bi bi-currency-exchange"></i></a>
                        </div>
                        <div class="collapse my-2 col-8 m-auto" id="exchange">
                            <div class="card card-body border border-primary">
                                <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                                    @foreach(App\General\Concretes\Enums\AccountCurrency::$enum as $key => $value)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if($value === 0) active @endif" id="pills-{{$value}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$value}}" type="button" role="tab" aria-controls="pills-{{$value}}" aria-selected="@if($value === 0) true @else false @endif">{{$key}}</button>
                                        </li>
                                    @endforeach
                                </ul>                               
                                <div class="tab-content" id="pills-tabContent">                                   
                                    <div class="tab-pane fade show active" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">1 USD = 4 RON </li>
                                            <li class="list-group-item">1 EUR = 4,5 RON</li>
                                            <li class="list-group-item">1 GBP = 5 RON</li>
                                            <li class="list-group-item border-top border-top-3 border-primary">Ex: If you exchange 50 USD you get 200 RON and for 50 EUR 225 RON.</li>                                          
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">1 RON = 0,25 USD </li>
                                            <li class="list-group-item">1 EUR = 1,125 USD</li>
                                            <li class="list-group-item">1 GBP = 1,25 USD</li>
                                            <li class="list-group-item border-top border-top-3 border-primary">Ex: If you exchange 50 RON you get 12,5 USD and for 50 EUR 56,25 USD.</li>                                          
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">1 RON = 0,22 EUR </li>
                                            <li class="list-group-item">1 USD = 0,88 EUR</li>
                                            <li class="list-group-item">1 GBP = 1,11 EUR</li>
                                            <li class="list-group-item border-top border-top-3 border-primary">Ex: If you exchange 50 RON you get 11 EUR and for 50 USD 44 EUR.</li>                                          
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">1 RON = 0,20 GBP </li>
                                            <li class="list-group-item">1 USD = 0,80 GBP</li>
                                            <li class="list-group-item">1 EUR = 0,90 GBP</li>
                                            <li class="list-group-item border-top border-top-3 border-primary">Ex: If you exchange 50 RON you get 10 GBP and for 50 EUR 45 GBP.</li>                                          
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
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
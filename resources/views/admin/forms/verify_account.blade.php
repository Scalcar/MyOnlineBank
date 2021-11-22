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

    <div class="row">
        <div class="col-md-9 m-auto py-5">
            <div class="card shadow-sm p-3 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center mb-3 text-primary">
                        <a class="link-secondary me-3 float-end" href="{{route('admin.home')}}" title="Go Back! "><i class="bi bi-x-square"></i></a> 
                        ~ Verify Secondary Account for {{$account->user->fname}} {{$account->user->lname}} ~ </h4>
                    <form action="{{ route('admin.verify_account') }}" method="POST" autocomplete="off" class="p-2">                        
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}" />
                            <input type="hidden" name="user_id" value="{{$account->user_id}}" />
                            <input type="hidden" name="modelId" value="{{$account->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Account Number" id="accNo" name="accNo" value="{{$account->accNo}}" readonly />
                                <label for="accNo" class="text-muted ps-4">Account Number :</label>
                                <span class="text-danger">@error('accNo') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="branch" id="branch">
                                    <option>Choose branch</option>
                                    @foreach(App\General\Concretes\Enums\AccountBranches::$enum as $key => $value)
                                        <option value="{{$value}}" @if ($account->branch == $value) selected @endif >{{$key}}</option>
                                    @endforeach                                   
                                </select>
                                <label for="branch" class="text-muted ps-4">Branch :</label>
                                <span class="text-danger">@error('branch') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="number" class="form-control text-primary" placeholder="Balance" name="balance" id="balance" value="{{$account->balance}}" min="0"/>
                                <label for="balance" class="text-muted ps-4">Balance :<span class="ms-2"><i class="bi bi-piggy-bank h5"></i></span></label>
                                <span class="text-danger ps-1">@error('balance') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="type" id="type">
                                    <option>Choose type</option>
                                    @foreach(App\General\Concretes\Enums\AccountType::$enum as $key => $value)
                                        <option value="{{$value}}" @if ($account->type == $value) selected @endif >{{ucfirst($key)}}</option>
                                    @endforeach                                  
                                </select>
                                <label for="type" class="text-muted ps-4">Account type :</label>
                                <span class="text-danger">@error('type') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="number" class="form-control text-primary" placeholder="Pin" name="pin" id="pin" value="{{$account->pin}}" readonly />
                                <label for="pin" class="text-muted ps-4">Pin : <span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="currency" id="currency">
                                    <option>Choose currency</option>
                                    @foreach(App\General\Concretes\Enums\AccountCurrency::$enum as $key => $value)
                                        <option value="{{$value}}" @if ($account->currency == $value) selected @endif >{{$key}}</option>
                                    @endforeach                                  
                                </select>
                                <label for="currency" class="text-muted ps-4">Currency :</label>
                                <span class="text-danger">@error('currency') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5 mb-3">
                            @if($account->status->status === 2)
                                <button type="submit" name="action" value="delete" class="btn btn-outline-danger w-50">Close Account</button>
                            @else
                            <button type="submit" name="action" value="save" class="btn btn-outline-success w-25 me-4">Approve <i class="bi bi-hand-thumbs-up"></i></button>
                            <button type="submit" name="action" value="delete" class="btn btn-outline-danger w-25 ms-4">Reject <i class="bi bi-hand-thumbs-down"></i></button>
                            @endif
                        </div>
                    </form>                   
                </div>
            </div>
        </div>    
    </div>
    <x-footer></x-footer>
</x-admin-layout>
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
                    <h4 class="text-center mb-3 text-primary"> ~ Add Account to <span class="text-decoration-underline ms-2">{{$customer->fname}} {{$customer->lname}}</span> ~ </h4>
                    <form action="{{ route('admin.admin_add_account') }}" method="POST" autocomplete="off" class="p-2">
                        @if(Session::get('success'))
                        <div class="alert alert-success col-9 mb-3 text-center m-auto alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(Session::get('fail'))
                            <div class="alert alert-danger col-9 mb-3 text-center m-auto alert-dismissible fade show" role="alert">
                                {{ Session::get('fail') }}
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}" />
                            <input type="hidden" name="user_id" value="{{$customer->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Account Number" id="accNo" name="accNo" value="{{$random}}" readonly />
                                <label for="accNo" class="text-muted ps-4">Account Number :</label>
                                <span class="text-danger">@error('accNo') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="branch" id="branch">
                                    <option>Choose branch</option>
                                    @foreach(App\General\Concretes\Enums\AccountBranches::$enum as $key => $value)
                                        <option value="{{$value}}" @if (count($customer->accounts) !== 0 && $customer->accounts->first()->branch == $value) selected @endif >{{$key}}</option>
                                    @endforeach
                                </select>
                                <label for="branch" class="text-muted ps-4">Branch :</label>
                                <span class="text-danger">@error('branch') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col form-floating">
                                <input type="number" class="form-control text-primary" placeholder="Balance" name="balance" id="balance" value="{{ old('balance') }}" min="0"/>
                                <label for="balance" class="text-muted ps-4">Balance :<span class="ms-2"><i class="bi bi-piggy-bank h5"></i></span></label>
                                <span class="text-danger ps-1">@error('balance') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
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
                            <div class="col form-floating">
                                <input type="number" class="form-control text-primary" placeholder="Pin" name="pin" id="pin" value="{{rand(1000,9999)}}" readonly />
                                <label for="pin" class="text-muted ps-4">Pin : <span class="ms-2"><i class="bi bi-key h5"></i></span></label>
                                <span class="text-danger ps-1">@error('pin') {{ $message }} @enderror</span>
                            </div>
                            <div class="col form-floating">
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
                        <div class="d-flex justify-content-evenly mt-5 mb-3">
                            <a class="btn btn-lg btn-outline-secondary w-25" href="{{ route('admin.show_customer',['customer' => $customer->id]) }}">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
    <x-footer></x-footer>
</x-admin-layout>
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

    <div class="row mt-5 mb-5">
        @if(Session::get('success'))
            <div class="alert alert-success col-6 mb-3 text-center m-auto alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card col-md-7 m-auto shadow-sm p-4 mb-5">
            <div class="dropdown mx-5 mt-4">
                <button class="btn btn-outline-primary dropdown-toggle px-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-book h5"></i><span class="ms-2">Accounts</span> 
                </button>
                @if(count($customer->accounts) === 0)
                    <ul class="dropdown-menu w-100 mt-2" aria-labelledby="dropdownMenuButton1">
                        <li class="dropdown-item text-primary">You have no accounts</li>
                    </ul> 
                @else
                    <ul class="dropdown-menu w-100 mt-2" aria-labelledby="dropdownMenuButton1">
                        @foreach($customer->accounts as $key => $account)                                             
                                <li><a class="dropdown-item text-primary" href="{{ route('admin.show_account',['account' => $account->id]) }}">{{$key + 1}}) Account Number: {{$account->accNo}} / Balance: {{$account->balance}} / Currency: {{$account->accountCurrency}} 
                                    <span class="badge @if ($account->status->status == 1) bg-success @elseif($account->status->status === 2) bg-secondary @else bg-danger @endif ms-2">{{$account->status->statusName}}</span></a>
                                </li>                                                                                                    
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="card-header text-white bg-info mx-5 mt-3 text-center py-3 h4">Customer : <span class="ms-2">{{$customer->fname}}  {{$customer->lname}}</span> 
                <span class="float-end"><a href="{{route('admin.add_account_form',['customer' => $customer->id]) }}" class="p-2 rounded text-secondary btn-outline-light" title="Click to add a new account"><i class="bi bi-plus-circle"></i></a></span>
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> First Name : </div>
                <div class="card-text"> {{$customer->fname}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Last Name : </div>
                <div class="card-text"> {{$customer->lname}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Username : </div>
                <div class="card-text"> {{$customer->username}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Gender : </div>
                <div class="card-text"> {{$customer->genderName}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Date of Birth : </div>
                <div class="card-text"> {{ date("d/m/Y", strtotime($customer->dob)) }} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> CNP : </div>
                <div class="card-text"> {{$customer->cnp}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Email : </div>
                <div class="card-text"> {{$customer->email}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Phone : </div>
                <div class="card-text"> {{$customer->phone}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Address : </div>
                <div class="card-text"> {{$customer->address}} </div>                 
            </div>
            <div class="card-body text-primary bg-white mx-5 d-flex justify-content-between px-4 fs-5">
                <div class="card-text"> Made by : </div>
                <div class="card-text"> <span class="badge bg-info px-4 py-2"> {{$customer->admin->name}} </span></div>                 
            </div>
            <div class="d-flex justify-content-center mt-5 mb-3">
                <a href="{{route('admin.manage_customers') }}" class="btn btn-outline-primary w-50 px-3 link-secondary">Go Back</a>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
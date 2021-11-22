<x-admin-layout class="mx-0">
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

    
        <div class="row my-5 d-flex flex-nowrap">
            @if(Session::get('success'))
                <div class="alert alert-success col-6 mb-3 text-center m-auto alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-4 me-3">
                <div class="card border border-2 border-primary">
                    <div class="card-body">
                        <div class="h4 text-center my-3 d-flex align-items-baseline justify-content-between">
                            <a class="link-secondary ms-2" href="{{route('admin.show_customer',['customer' => $account->user->id])}}" title="Back to customer"><i class="bi bi-arrow-left-square"></i></a>
                            Account Details
                            @if($account->status->status == 0)
                                <a class="link-danger me-2" href="{{ route('admin.verify_account_form',['account' => $account->id]) }}" title="Click to verify account"><i class="bi bi-exclamation-square"></i></a>
                            @else
                            <form action="{{ route('admin.delete_account') }}" method="POST" class="me-2">
                                @csrf
                                <input type="hidden" name="modelId" value="{{$account->id}}" />
                                <button type="submit" class="btn btn-link link-danger p-0" title="Delete the account"><i class="bi bi-dash-square" style="font-size: 21px;"></i></button>
                            </form>
                            @endif                           
                        </div>
                        <div class="d-grid gap-3">
                            <div class="p-2 border border-primary rounded ps-3">Account Number : {{$account->accNo}}</div>
                            <div class="p-2 border border-primary rounded ps-3">Account Branch : {{$account->accountBranch}}</div>
                            <div class="p-2 border border-primary rounded ps-3">Account Name : {{$account->user->fname}} {{$account->user->lname}}</div>
                            <div class="p-2 border border-primary rounded ps-3">Account Type : {{$account->accountType}}</div>
                            <div class="p-2 border border-primary rounded ps-3">Available Balance : {{$account->balance}} {{$account->accountCurrency}}</div>
                            <div class="p-2 border border-primary rounded ps-3">Account Status : <span class="badge @if ($account->status->status == 1) bg-success @elseif($account->status->status === 2) bg-secondary @else bg-danger @endif ms-2">{{$account->status->statusName}}</span></div>
                            <div class="p-2 border border-primary rounded ps-3 mb-3">Created By : <span class="badge bg-info ms-2">{{$account->admin->name}}</span></div>
                        </div>  


                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card border border-2 border-primary">
                    <div class="card-body">
                        <div class="h4 text-center my-2">Transactions Details for Account <span class="ms-2">#{{$account->accNo}}</span>
                            @if(count($account->transactions) > 6)
                                <span class="float-end me-4"><a href="{{ route('admin.show_transactions',['account' => $account->id]) }}" class="link-dark" title="View All Transactions"><i class="bi bi-card-list"></i></a></span>
                            @endif
                        </div>
                        <table class="table table-hover align-middle">
                            <thead style="height: 50px;">
                                <tr>
                                    <th scope="col"> # </th>
                                    <th scope="col"> Number </th>
                                    <th scope="col"> Date & Time </th>
                                    <th scope="col"> Remarks </th>
                                    <th scope="col"> Debit ({{$account->accountCurrency}}) </th>
                                    <th scope="col"> Credit ({{$account->accountCurrency}}) </th>                     
                                    <th scope="col"> Balance </th>                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($account->transactions) === 0)
                                    <tr style="height: 70px;">
                                        <td class="text-center h4" colspan="7">You have no transactions</td>
                                    </tr>
                                @else
                                    @foreach($account->transactions->sortDesc()->forPage(1,6) as $key => $transaction)
                                        <tr style="height: 60px;">
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$transaction->trans_no}}</td>
                                            <td>{{\Carbon\Carbon::parse($transaction->created_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i')}}</td>
                                            <td>{{$transaction->description}}</td>
                                            <td class="text-danger"> - {{$transaction->debit}}</td>
                                            <td class="text-success"> + {{$transaction->credit}}</td>
                                            <td>{{$account->balance}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>

        </div>
    
    <x-footer></x-footer>
</x-admin-layout>

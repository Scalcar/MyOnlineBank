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
   
    <div class="row my-5">
        <div class="card shadow-sm p-4 pb-0 col-10 m-auto my-5 border border-2 border-primary">                                                                           
            <table class="table table-hover align-middle mb-0">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="row" colspan="7" class="h4 text-center fw-bold pb-3">
                            <span class="float-start ms-2"><a href="{{ route('admin.show_account',['account' => $account->id]) }}" class="link-dark"><i class="bi bi-x-square"></i></a></span>
                            All Transactions of Account Number #{{$account->accNo}}</th>                                              
                    </tr>
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> Number </th>
                        <th scope="col"> Date & Time </th>
                        <th scope="col"> Remarks </th>                                           
                        <th scope="col"> Debit ({{$account->accountCurrency}}) </th>
                        <th scope="col"> Credit ({{$account->accountCurrency}}) </th>
                        <th scope="col"> Balance ({{$account->accountCurrency}}) </th>
                    </tr>
                </thead>
                <tbody>                                               
                    @foreach($transactions as $key => $transaction)
                    <tr style="height: 60px;">
                        <th scope="row">{{$key + $transactions->firstItem()}}</th>
                        <td>{{$transaction->trans_no}}</td>
                        <td>{{$transaction->updated_at}}</td>
                        <td>{{$transaction->description}}</td>
                        <td class="text-danger"> - {{$transaction->debit}}</td>
                        <td class="text-success"> + {{$transaction->credit}}</td>
                        <td>{{$transaction->balance}}</td>                                                                       
                    </tr>                
                    @endforeach
                    <caption>
                        <div class="d-flex justify-content-center mt-3">{{$transactions->appends(['account' => $account->id])->links()}}</div>
                    </caption>            
                </tbody>                              
            </table>           
        </div>
    </div>

    <x-footer></x-footer>
</x-admin-layout>
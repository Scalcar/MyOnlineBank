<x-admin-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
           ~ {{ __('Admin Dashboard') }} ~
        </h2>
        <div class="m-auto h5 py-2">Bank Balance: 
            <span class="badge bg-primary me-4"> + {{number_format(900000 - $bankBalance)}} RON </span>
            Bank Deposits:
            <span class="badge bg-success"> + {{number_format($bankBalance)}} RON</span>
        </div>
    </x-slot>
    <!--  remember $admin->users  si $user->admin->name -->
    
        @if(Session::get('success'))
            <div class="alert alert-success col-9 my-3 text-center m-auto alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif   
    <div class="row justify-content-evenly">
        <div class="col-3">
            <div class="card my-4 bg-primary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Accounts <small>Created</small> : <span class="badge bg-success rounded-pill">{{count($accounts)}}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card my-4 bg-primary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Users <small>Created</small> : <span class="badge bg-success rounded-pill">{{count($users)}}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card my-4 bg-primary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Admins <small>Working</small> : <span class="badge bg-success rounded-pill">{{count($admins)}}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card my-4 bg-primary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Transactions : <span class="badge bg-success rounded-pill">{{count($transactions)}}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
            <div class="card my-4 border border-primary">
                <div class="card-header bg-primary text-light">
                    <h3>Latest Transactions</h3>
                </div>
                <div class="card-body pt-0 px-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Transaction Number</th>
                                <th>Date & Time</th>
                                <th>Remarks</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="mt-3 d-flex justify-content-center">{{$lastTransactions->links()}}</div>
                            @foreach($lastTransactions as $key => $value)
                                <tr>
                                    <th scope="row">{{$key + $lastTransactions->firstItem()}}</th>
                                    <th >{{$value->account->user->fname}} {{$value->account->user->lname}}</th>
                                    <th>{{$value->account->accNo}}</th>
                                    <td>{{$value->trans_no}}</td>
                                    <td>{{\Carbon\Carbon::parse($value->created_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i')}}</td>
                                    <td>{{$value->description}}</td>
                                    <td class="text-danger"> - {{$value->debit}}</td>
                                    <td class="text-success"> + {{$value->credit}}</td>
                                    <td>{{$value->balance}}</td>
                                </tr>
                            @endforeach                           
                        </tbody>                       
                    </table>                  
                </div> 
            </div>
        </div>
   
    <x-footer></x-footer>
</x-admin-layout>
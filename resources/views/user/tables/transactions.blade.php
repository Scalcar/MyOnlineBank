<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>
   
    <div class="row my-5">
        <div class="card shadow-sm p-4 pb-0 col-8 m-auto my-5 border border-2 border-primary">                                                                           
            <table class="table table-hover align-middle mb-0">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="row" colspan="7" class="h4 text-center fw-bold pb-3">
                            <span class="float-start ms-2"><a href="{{ route('user.home',['account' => request()->query('list')]) }}" class="link-dark"><i class="bi bi-x-square"></i></a></span>
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
                        <div class="d-flex justify-content-center mt-3">{{$transactions->appends(['account' => $account->id,'list' => request()->get('list')])->links()}}</div>
                    </caption>            
                </tbody>                              
            </table>           
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
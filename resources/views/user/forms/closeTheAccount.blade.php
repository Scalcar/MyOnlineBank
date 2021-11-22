<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    <div class="row">      
        <div class="col-md-6 m-auto py-5">
            <div class="card shadow-sm p-3 border border-secondary mb-3">
                @if(Session::get('success'))
                    <div class="alert alert-success col-8 my-3 text-center m-auto alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body mb-2">
                    <h4 class="text-center my-4 text-primary">
                        <span class="float-start"><a class="link-secondary ms-2" href="{{ route('user.home') }}" style="font-size: 22px;"><i class="bi bi-arrow-left-square"></i></a></span> 
                        ~ Select which account you want to close ~ </h4>                   
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>                              
                                <th>Account Number</th>
                                <th>Account Branch</th>
                                <th>Account Type</th>
                                <th>Account Balance</th>
                                <th>Account Currency</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $key => $account)
                            @if($account->user_id === Auth::user()->id && $account->status->status === 1)                                                              
                                <tr>                                   
                                    <th scope="row"><span class="ms-2">{{$account->accNo}}</span></th>
                                    <td>{{$account->AccountBranch}}</td>
                                    <td>{{$account->AccountType}}</td>
                                    <td>{{$account->balance}}</td>
                                    <td>{{$account->AccountCurrency}}</td>
                                    <td class="d-flex">
                                        <a class="link-danger m-auto" href="{{ route('user.request_close_form',['account' => $account->id]) }}" style="font-size: 18px;" title="Close this account"><i class="bi bi-shield-minus"></i></a>
                                    </td>
                                </tr>                                                                                                   
                            @endif
                        @endforeach
                        </tbody>
                        <caption>
                            <div class="text-danger text-center mt-2">Note: The request will be verified by an admin as soon as posible.</div>
                        </caption>
                    </table>                 
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
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
    <!--  remember $admin->users  si $user->admin->name -->
    <div class="row">
        @if(Session::get('success'))
            <div class="alert alert-success col-6 mt-3 text-center m-auto alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">
            <div class="card-body">
                <div class="h4 text-center my-3">Accounts Waiting for Actions</div>                                                                           
                <table class="table  align-middle">
                    <thead style="height: 50px;">
                        <tr>
                            <th scope="col"> # </th>
                            <th scope="col"> Account Number </th>
                            <th scope="col"> Account Name </th>
                            <th scope="col"> Type </th>
                            <th scope="col"> Balance </th>
                            <th scope="col"> Status </th>
                            <th scope="col"> Since </th>                                               
                            <th scope="col"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>     
                        @if(count($forApproval) === 0)
                            <tr style="height: 70px;">
                                <td class="text-center h4" colspan="7">There are no accounts waiting for approval</td>
                            </tr>
                        @else                      
                            @foreach($forApproval as $key => $status)                             
                                <tr style="height: 60px;">
                                    <th scope="row">{{$key + 1}}</th>
                                    <td>{{$status->account->accNo}}</td>
                                    <td>{{$status->account->user->fname}} {{$status->account->user->lname}}</td>
                                    <td>{{$status->account->AccountType}}</td>
                                    <td>{{$status->account->balance}}</td>
                                    <td><span class="badge @if($status->status === 2) bg-secondary @else bg-danger @endif">
                                        @if($status->status === 2 || $status->status === 0)
                                            {{$status->statusName}}
                                        @elseif($status->account->pinStatus === 2)
                                            {{$status->account->statusPin}}
                                        @endif
                                    </span></td>
                                    <td>{{\Carbon\Carbon::parse($status->updated_at)->timezone('Europe/Bucharest')->diffForHumans()}}</td>
                                    <td>
                                        <a class="btn btn-lg w-50 m-auto link-info" href="{{ route('admin.verify_account_form',['account' => $status->account->id]) }}" title="Verify this account"><i class="bi bi-clipboard-check"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif                
                    </tbody>    
                </table>
                <div class="d-flex justify-content-center mt-4">{{$forApproval->links()}}</div> 
            </div>
        </div>
    </div>

    <x-footer></x-footer>
</x-admin-layout>
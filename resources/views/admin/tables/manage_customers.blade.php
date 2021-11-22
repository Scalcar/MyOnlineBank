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
                <a class="nav-link active" aria-current="page" href="#">Manage Customers</a>
                <a class="nav-link" href="{{ route('admin.manage_messages') }}">Manage Messages</a>
                <a class="nav-link" href="#">Post News</a>
            </nav>
        </div>    
    </x-slot>

    <div class="row" style="margin-top: 8%;">
        <div class="card shadow-sm p-4">
                @if(Session::get('success'))
                    <div class="alert alert-success col-9 my-4 text-center m-auto alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            <table class="table table-hover align-middle">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> First Name </th>
                        <th scope="col"> Last Name </th>
                        <th scope="col"> Gender </th>                     
                        <th scope="col"> Email </th>
                        <th scope="col"> Phone </th>
                        <th scope="col"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr style="height: 60px;">
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{$user->fname}}</td>
                            <td>{{$user->lname}}</td>
                            <td>{{$user->genderName}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                            <a href="{{ route('admin.show_customer',['customer' => $user->id]) }}" class="btn btn-outline-info btn-sm px-3"> Show <i class="bi bi-eye"> </i></a>
                            <a href="{{ route('admin.edit_customer_form',['user' => $user->id]) }}" class="btn btn-outline-primary btn-sm mx-3 px-3"> Edit <i class="bi bi-person-check-fill"> </i></a>
                            <form method="POST" action="{{ route('admin.delete_customer') }}" style="display:inline-block">
                                @csrf
                                <input type="hidden" value="{{$user->id}}" name="modelId" />
                                <div class="d-none">
                                    <select class="form-control" multiple name="accounts[]">
                                        @foreach ($user->accounts as $account)
                                            <option value="{{$account->id}}" selected>{{$account->status->statusName}}</option>
                                        @endforeach
                                    </select>
                                </div>                                                                                 
                                <button type="submit" class="btn btn-outline-danger btn-sm px-2 shadow-primary"> Delete <i class="bi bi-person-x-fill"> </i></button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>    
            </table>
            
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
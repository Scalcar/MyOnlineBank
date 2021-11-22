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
                <a class="nav-link active" aria-current="page" href="#">Manage Admins</a>
                <a class="nav-link" href="{{ route('admin.add_customer') }}"> Customer <i class="bi bi-person-plus" style="font-size: 16px;"> </i></a>
                <a class="nav-link" href="{{ route('admin.manage_customers') }}">Manage Customers</a>
                <a class="nav-link" href="{{ route('admin.manage_messages') }}">Manage Messages</a>
                <a class="nav-link" href="#">Post News</a>
            </nav>
        </div>    
    </x-slot>

    <div class="row" style="margin-top: 8%;">
        <div class="card col-9 m-auto shadow-sm p-4">
                @if(Session::get('success'))
                    <div class="alert alert-success col-9 my-4 text-center m-auto alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            <table class="table table-hover align-middle" style="table-layout: fixed;">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $key => $admin)
                        <tr style="height: 60px;">
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                            <td>
                            <a href="{{ route('admin.edit_admin_form',['admin' => $admin->id]) }}" class="btn btn-outline-info btn-sm mx-3 px-3"> Edit <i class="bi bi-person-check"></i></a>
                            <form method="POST" action="{{ route('admin.delete') }}" style="display:inline-block">
                                @csrf
                                <input type="hidden" value="{{$admin->id}}" name="admin_id" />
                                <button type="submit" class="btn btn-outline-danger btn-sm px-2"> Delete <i class="bi bi-person-x"></i></button>
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
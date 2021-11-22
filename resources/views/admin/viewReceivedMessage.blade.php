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

    <div class="row my-5">      
        <div class="card col-md-9 m-auto shadow-sm p-4 my-5">         
            <div class="card-header text-white bg-info mx-5 mt-4 text-center py-3 h4">
                <span class="float-start ms-2"><a href="{{ route('admin.received_messages_table') }}" class="link-secondary"><i class="bi bi-x-square"></i></a></span>
                Received Message
                @if($message->sender_status === 0) 
                    <span class="float-end me-2">
                        <form method="POST" action="{{ route('admin.delete_received_message') }}" style="display:inline-block">
                            @csrf
                            <input type="hidden" value="{{$message->id}}" name="modelId" />
                            <button type="submit" class="btn btn-sm px-2 link-danger"><i class="bi bi-trash h4"></i></button>
                        </form>
                    </span>
                @endif
            </div>                          
            <div class="card-body text-dark bg-white mx-5 px-4 fs-5 border">
                <div class="card-text fw-bold"> Subject : </div>
                <div class="card-text ms-4"> {{$message->subject}} </div>                 
            </div>
            <div class="card-body text-dark bg-white mx-5 px-4 fs-5 border">
                <div class="card-text fw-bold"> Content : </div>
                <div class="card-text ms-4"> {{$message->body}} </div>                 
            </div>
            <div class="card-body text-dark bg-white mx-5 px-4 fs-5 border">
                <div class="card-text fw-bold"> From : </div>
                <div class="card-text ms-4"> {{$message->sender->fname}} {{$message->sender->lname}}</div>                 
            </div>
            <div class="card-body text-dark bg-white mx-5 px-4 mb-4 fs-5 border rounded-bottom">
                <div class="card-text fw-bold"> Date&Time : </div>
                <div class="card-text ms-4"> {{\Carbon\Carbon::parse($message->created_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i')}} </div>                 
            </div>                               
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
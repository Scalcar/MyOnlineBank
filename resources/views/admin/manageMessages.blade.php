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
                <a class="nav-link active" aria-current="page" href="#">Manage Messages</a>
                <a class="nav-link" href="#">Post News</a>
            </nav>
        </div>    
    </x-slot>

    <div class="row">                         
        <div class="col-7 m-auto mt-5">
            <div class="card shadow-sm border border-2 border-primary">
                <div class="card-body mb-2">
                    <h4 class="text-center my-3 text-primary"> ~ Manage Messages ~ </h4>
                    <nav class="nav nav-pills nav-justified flex-column w-75 m-auto">                                                                                                        
                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('admin.message_all_form') }}"> Message to All </a>
                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('admin.message_user_form') }}"> Message a User </a>
                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('admin.received_messages_table') }}">
                            Received Messages <span class="badge bg-info ms-2">{{$messagesReceived->total()}}</span> 
                        </a>
                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('admin.sent_messages_table') }}"> 
                            Sent Messages <span class="badge bg-info ms-2">{{$messagesSent->total()}}</span> 
                        </a>
                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('admin.messages_cleanup') }}"> Messages Cleanup </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>
</x-admin-layout>
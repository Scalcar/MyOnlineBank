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

    @if(Session::get('success'))
        <div class="alert alert-success col-9 m-auto alert-dismissible fade show mt-3 text-center" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
   
    <div class="row">
        <div class="col-7 m-auto py-4">
        <div class="card shadow-sm p-4 pb-0 my-4 m-auto border border-2 border-primary">                                                                           
            <table class="table table-hover align-middle mb-0">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="row" colspan="7" class="h4 text-center fw-bold py-3">
                            <span class="float-start ms-2"><a href="{{ route('admin.manage_messages')}}" class="link-dark"><i class="bi bi-x-square"></i></a></span>
                            All your sent messages</th>                                              
                    </tr>
                    <tr>
                        <th scope="col"> # </th>                  
                        <th scope="col"> Sent to : </th>                                           
                        <th scope="col"> Sent by : </th>
                        <th scope="col"> Date & Time : </th>
                        <th scope="col"> Actions : </th>    
                    </tr>
                </thead>
                <tbody>
                    @if($messages->total() > 0)                                               
                        @foreach($messages as $key => $message)
                        <tr style="height: 60px;">
                            <th scope="row">{{$key + $messages->firstItem()}}</th>             
                            <td class="w-50">{{$message->receiver->fname}} {{$message->receiver->lname}}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{$message->adminSender->name}}</span>
                            </td> 
                            <td>{{\Carbon\Carbon::parse($message->created_at)->timezone('Europe/Bucharest')->diffForHumans()}}</td>
                            <td class="text-center">                             
                                <a href="{{ route('admin.view_sent_message',['message' => $message->id]) }}" class="h4 link-info" title="View the message"><i class="bi bi-eye"></i></a>
                            </td>                                                                                          
                        </tr>                
                        @endforeach
                    @else
                        <tr style="height: 70px;">
                            <th scope="row" colspan="6" class="text-center h5">You have sent no messages.</th>
                        </tr>
                    @endif
                    <caption>
                        <div class="d-flex justify-content-center mt-3">{{$messages->links()}}</div>
                    </caption>            
                </tbody>                              
            </table>           
        </div>
        </div>
    </div>

    <x-footer></x-footer>
</x-admin-layout>
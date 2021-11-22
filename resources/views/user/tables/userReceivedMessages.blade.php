<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    @if(Session::get('success'))
        <div class="alert alert-success col-6 mt-5 text-center m-auto alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
   
    <div class="row">
        <div class="col-md-6 m-auto py-4">
        <div class="card shadow-sm p-4 pb-0 my-4 m-auto border border-2 border-primary">                                                                           
            <table class="table table-hover align-middle mb-0">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="row" colspan="7" class="h4 text-center fw-bold pb-3">
                            <span class="float-start ms-2"><a href="{{ route('user.home')}}" class="link-dark"><i class="bi bi-x-square"></i></a></span>
                            All your received messages</th>                                              
                    </tr>
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> Subject : </th>
                        <th scope="col"> Sent from : </th>
                        <th scope="col"> Date & Time : </th>                                                            
                        <th scope="col"> Actions : </th>    
                    </tr>
                </thead>
                <tbody>
                    @if($messages->total() > 0)                                               
                        @foreach($messages as $key => $message)
                        <tr style="height: 60px;">
                            <th scope="row">{{$key + $messages->firstItem()}}</th>
                            <td>{{$message->subject}}</td>
                            <td><span class="badge bg-info">
                                @if(!empty($message->adminSender))
                                    {{$message->adminSender->name}}
                                @else 
                                    {{$message->sender->fname}} {{$message->sender->lname}}
                                @endif
                                </span>
                            </td> 
                            <td>{{\Carbon\Carbon::parse($message->created_at)->timezone('Europe/Bucharest')->diffForHumans()}}</td>                
                            <td class="text-center">
                                <a href="{{ route('user.view_received_message',['message' => $message->id]) }}" class="h4" title="Click to view">
                                    @if($message->status === 2)
                                        <span class="link-danger"><i class="bi bi-envelope"></i></span>
                                    @else
                                        <span class="link-dark"><i class="bi bi-envelope-open"></i></span>
                                    @endif
                                </a>                                               
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

    <x-darkFooter></x-darkFooter>
</x-app-layout>
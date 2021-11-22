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
        <div class="col-md-8 m-auto py-4">
        <div class="card shadow-sm p-4 pb-0 my-4 m-auto border border-2 border-primary">                                                                           
            <table class="table table-hover align-middle mb-0">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="row" colspan="7" class="h4 text-center fw-bold pb-3">
                            <span class="float-start ms-2"><a href="{{ route('user.home')}}" class="link-dark"><i class="bi bi-x-square"></i></a></span>
                            All your sent messages</th>                                              
                    </tr>
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> Subject : </th>
                        <th scope="col"> Date & Time : </th>
                        <th scope="col"> Content : </th>                                           
                        <th scope="col"> Sent to : </th>
                        <th scope="col"> Status : </th>
                        <th scope="col"> Actions : </th>    
                    </tr>
                </thead>
                <tbody>
                    @if($messages->total() > 0)                                               
                        @foreach($messages as $key => $message)
                        <tr style="height: 60px;">
                            <th scope="row">{{$key + $messages->firstItem()}}</th>
                            <td>{{$message->subject}}</td>
                            <td>{{\Carbon\Carbon::parse($message->created_at)->timezone('Europe/Bucharest')->diffForHumans()}}</td>
                            <td class="w-50">{{$message->body}}</td>
                            <td class="text-center"><span class="badge bg-secondary">
                                @if(!empty($message->adminReceiver))
                                    {{$message->adminReceiver->name}}
                                @else 
                                    {{$message->receiver->username}}
                                @endif
                                </span>
                            </td> 
                            <td>
                                @if($message->status === 2)
                                    <span class="badge bg-danger">{{$message->statusName}}</span>
                                @elseif($message->status === 3)
                                    <span class="badge bg-success">{{$message->statusName}}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.edit_sent_message_form',['message' => $message->id]) }}" class="btn btn-sm btn-outline-info me-2 px-3 @if($message->status === 3) disabled @endif"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form method="POST" action="{{ route('user.delete_sent_message') }}" style="display:inline-block">
                                    @csrf
                                    <input type="hidden" value="{{$message->id}}" name="modelId" />
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-2 shadow-primary"> Delete <i class="bi bi-trash"></i></button>
                                </form>
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
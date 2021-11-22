<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    <div class="row my-5">      
        <div class="card col-md-6 m-auto shadow-sm p-4 my-5">         
            <div class="card-header text-white bg-info mx-5 mt-4 text-center py-3 h4">
                <span class="float-start ms-2"><a href="{{ route('user.received_messages_view') }}" class="link-secondary"><i class="bi bi-x-square"></i></a></span>
                Received Message       
                <span class="float-end me-2">
                    <form method="POST" action="{{ route('user.delete_received_message') }}" style="display:inline-block">
                        @csrf
                        <input type="hidden" value="{{$message->id}}" name="modelId" />
                        <button type="submit" class="btn btn-sm px-2 link-danger"><i class="bi bi-trash h4"></i></button>
                    </form>
                </span>          
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
                <div class="card-text ms-4">
                    @if(!empty($message->adminSender))
                        {{$message->adminSender->name}}
                    @else 
                        {{$message->sender->fname}} {{$message->sender->lname}}
                    @endif
                </div>                 
            </div>
            <div class="card-body text-dark bg-white mx-5 px-4 mb-4 fs-5 border rounded-bottom">
                <div class="card-text fw-bold"> Date&Time : </div>
                <div class="card-text ms-4"> {{\Carbon\Carbon::parse($message->created_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i')}} </div>                 
            </div>                               
        </div>
    </div>
    <x-darkFooter></x-darkFooter>
</x-app-layout>
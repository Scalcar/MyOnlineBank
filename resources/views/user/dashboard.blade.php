<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold ms-3">
           ~ {{ __('Dashboard') }} ~
        </h2>
        <div class="m-auto h5 py-2 d-flex justify-content-end me-5">Current Balance: 
            <span class="badge bg-success me-5 ms-3"> + {{number_format($balance)}} RON </span>
        </div>
    </x-slot>

    <div class="row justify-content-evenly">     
        <div class="col-3">
            <div class="card my-4 bg-secondary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Accounts <small class="fs-5">Owned</small> : <span class="badge bg-success rounded-pill">{{$accounts->total()}}</span></h3> 
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card my-4 bg-secondary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Messages <small class="fs-5">Total</small> : <span class="badge bg-success rounded-pill">{{$messages->total()}}</span></h3> 
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card my-4 bg-secondary text-light">
                <div class="card-body d-flex justify-content-around">
                    <h3>Contacts <small class="fs-5">Total</small> : <span class="badge bg-success rounded-pill">{{$contacts->total()}}</span></h3> 
                </div>
            </div>
        </div>
        <div class="col-8 text-center mt-3">
            <div class="card my-4 border border-secondary">
                <div class="card-header bg-secondary text-light py-3">
                    <h3>Latest 5 messages</h3>
                </div>
                <div class="card-body p-0 @if($messages->total() <= 5) pb-4 @endif">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr style="height: 42px;">
                                <th>#</th>
                                <th>Subject</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Date&Time</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $key => $value)
                                <tr style="height: 45px;">
                                    <th scope="row">{{$key + $messages->firstItem()}}</th>
                                    <td>{{$value->subject}}</td>
                                    <td>{{$value->body}}</td>
                                    <td class="text-center">
                                        @if($value->sender_id === Auth::user()->id)
                                            <span class="badge bg-secondary px-3">Sent</span>
                                        @elseif($value->sent_to_id === Auth::user()->id)
                                            <span class="badge bg-success px-2">Received</span>
                                        @endif
                                    </td>                                 
                                    <td>{{\Carbon\Carbon::parse($value->created_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i')}}</td>
                                </tr>
                            @endforeach
                            @if($messages->total() > 5)
                                <caption>
                                    <div class="d-flex justify-content-center mt-2">{{$messages->links()}}</div>
                                </caption>
                            @endif
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>
   
    <x-darkFooter></x-darkFooter>
</x-app-layout>
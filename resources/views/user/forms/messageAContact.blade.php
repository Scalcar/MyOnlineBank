<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    @if(Session::get('success'))
        <div class="alert alert-success col-6 mt-4 text-center m-auto alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
   
    <div class="row">           
        <div class="col-md-6 m-auto py-5">          
            <div class="card shadow-sm border border-2 border-primary">              
                <div class="card-body mb-2">
                    <h4 class="text-center my-4 text-primary"> ~ Send message to a Contact ~ </h4>                
                    <form action="{{ route('user.message_contact') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="sender_id" value="{{$user->id}}" />
                            <input type="hidden" name="status" value="{{App\General\Concretes\Enums\MessageStatus::UNREAD_STATUS_ID}}" />                                    
                        </div>
                        <div class="row mb-5">
                            <div class="col-8 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="sent_to_id" id="sent_to_id">
                                    <option>Choose contact :</option>
                                    @if(count($contacts) >0)
                                        @foreach($contacts as $key => $contact)
                                            <option value="{{$contact->user_id}}"> {{$loop->iteration}}) {{$contact->nickname}} </option>
                                        @endforeach
                                    @else 
                                        <option>You have no contacts.</option>
                                    @endif
                                </select>
                                <label for="sent_to_id" class="text-muted ps-4">Contact to message :</label>
                                <span class="text-danger">@error('sent_to_id') {{ $message }} @enderror</span>
                            </div>
                        </div> 
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Subject" id="subject" name="subject" value="{{ old('subject') }}" />
                                <label for="subject" class="text-muted ps-4">Subject :</label>
                                <span class="text-danger">@error('subject') {{ $message }} @enderror</span>
                            </div>
                        </div>                        
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <textarea class="form-control text-primary" placeholder="The Message text" id="body" name="body" style="height: 200px">{{old('body')}}</textarea>
                                <label for="body" class="text-muted ps-4">Write the message : </label>
                                <span class="text-danger">@error('body') {{ $message }} @enderror</span>
                            </div>
                        </div>                                                                                                                                                       
                        <div class="text-danger text-center my-3">Note: If you don't have contacts you can create some. </div>                                                                        
                        <div class="d-flex justify-content-evenly mt-5 mb-3">
                            <a href="{{ route('user.home') }}" class="btn btn-lg btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Submit</button>
                        </div>
                    </form>                  
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
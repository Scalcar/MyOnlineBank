<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>
  
    <div class="row">           
        <div class="col-md-6 m-auto py-5">          
            <div class="card shadow-sm border border-2 border-primary">              
                <div class="card-body mb-2">
                    <h4 class="text-center my-4 text-primary"> ~ Edit The Sent Message ~ </h4>                
                    <form action="{{ route('user.edit_sent_message') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="modelId" value="{{$message->id}}" />                    
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Subject" id="subject" name="subject" value="{{ $message->subject }}" />
                                <label for="subject" class="text-muted ps-4">Subject :</label>
                                <span class="text-danger">@error('subject') {{ $message }} @enderror</span>
                            </div>
                        </div> 
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <textarea class="form-control text-primary" placeholder="The Message text" id="body" name="body" style="height: 200px">{{$message->body}}</textarea>
                                <label for="body" class="text-muted ps-4">Write the message : </label>
                                <span class="text-danger">@error('body') {{ $message }} @enderror</span>
                            </div>
                        </div>                                                                                                                                                                                                                                                
                        <div class="d-flex justify-content-evenly mt-5 mb-4">
                            <a href="{{ route('user.sent_messages_view') }}" class="btn btn-lg btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Edit</button>
                        </div>
                    </form>                  
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
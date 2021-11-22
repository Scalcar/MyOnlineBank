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
    @if(Session::get('fail'))
        <div class="alert alert-danger col-9 m-auto alert-dismissible fade show mb-3 text-center" role="alert">
            {{ Session::get('fail') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-9 m-auto py-5">
            <div class="card shadow-sm p-4 border border-secondary mb-3">
                <div class="card-body mb-2">
                    <h4 class="text-center mb-3 text-primary"> ~ Send Message to a Customer ~ </h4>
                    <form action="{{ route('admin.message_user') }}" method="POST" autocomplete="off" class="p-2">                     
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="admin_sender_id" value="{{Auth::user()->id}}" />
                        </div>
                        <div class="row mb-5">
                            <div class="col-8 m-auto form-floating">
                                <select class="form-select text-primary" aria-label="Default select example" name="sent_to_id" id="sent_to_id">
                                    <option>Choose customer :</option>
                                    @foreach($users as $key => $user)
                                        <option value="{{$user->id}}"> {{$loop->iteration}}) {{$user->fname}} {{$user->lname}} </option>
                                    @endforeach
                                </select>
                                <label for="sent_to_id" class="text-muted ps-4">Customer to message :</label>
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
                        <div class="d-flex justify-content-evenly mt-5 mb-3">
                            <a href="{{ route('admin.manage_messages') }}" class="btn btn-lg btn-outline-secondary w-25">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25"> Submit </button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-admin-layout>
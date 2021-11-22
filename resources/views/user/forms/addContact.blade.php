<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4 position-relative">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
    </x-slot>
   
    <div class="row">           
        <div class="col-md-4 m-auto py-5">          
            <div class="card shadow-sm border border-2 border-primary">              
                <div class="card-body mb-2">
                    <h4 class="text-center my-4 text-primary"> ~ Add New Contact ~ </h4>
                    <form action="{{ route('user.add_contact') }}" method="POST" autocomplete="off" class="p-2 mt-4">
                        @csrf
                        <div class="row mb-2">
                            <input type="hidden" name="list_id" value="{{$user->id}}" />
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Nickname" id="nickname" name="nickname" value="{{old('nickname')}}" />
                                <label for="nickname" class="text-muted ps-4">Nickname :</label>
                                <span class="text-danger">@error('nickname') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                            <input type="email" class="form-control text-primary" placeholder="Email" id="email" name="email" value="{{ old('email') }}" />
                                <label for="email" class="text-muted ps-4">Email :</label>
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                            </div>                          
                        </div>
                        <div class="row mb-4">
                            <div class="col-8 m-auto form-floating">
                                <input type="text" class="form-control text-primary" placeholder="Account Number" id="accNo" name="accNo" value="{{old('accNo')}}" />
                                <label for="accNo" class="text-muted ps-4">Account Number :</label>
                                <span class="text-danger">@error('accNo') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="text-danger text-center my-3">Note: The contact must be a member and have an account active.</div>
                        <div class="d-flex justify-content-evenly mt-4 mb-3">
                            <a href="{{ route('user.user_contacts_table') }}" class="btn btn-lg btn-outline-primary w-25 me-4">Back</a>
                            <button type="submit" class="btn btn-lg btn-outline-primary w-25">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
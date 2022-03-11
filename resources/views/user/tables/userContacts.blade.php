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
    @if ($errors->any())
        <div class="alert alert-danger col-6 mt-5 text-center m-auto alert-dismissible fade show" role="alert">  
           <span class="me-3">@error('searchForm') {{ $message }} @enderror</span>
           <span class="">@error('searchSelect') {{ $message }} @enderror</span> 
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="card shadow-sm p-4 col-9 m-auto mt-5 border border-2 border-primary">          
            <div class="row mt-3">
                <a href="{{ route('user.user_contacts_table') }}" class="link-primary h3 mb-4" style="width: 50px;"><i class="bi bi-arrow-clockwise"></i></a>                            
                <div class="col-12 d-flex justify-content-between">
                    <form class="d-flex w-50 ms-3" action="{{ route('user.search') }}" method="POST">
                        @csrf
                        <input class="form-control me-3 w-100" type="search" name="searchForm" placeholder="Search" aria-label="Search" value="{{old('searchForm')}}">                      
                        <button class="btn btn-outline-secondary me-3 w-25" type="submit"><i class="bi bi-search"></i> Search</button>
                        <select class="form-select w-50" id="searchSelect" name="searchSelect" aria-label="Example search select">
                            <option>Search By:</option>
                            @foreach(App\General\Concretes\Enums\Search::$enum as $key => $value)
                                <option value="{{$value}}">{{ucwords($key)}}</option>
                            @endforeach
                        </select>                                           
                    </form>                 
                    <a href="{{ route('user.add_contact_form') }}" class="btn btn-outline-primary px-4 me-4">Adauga <i class="bi bi-person-plus"></i></a>
                </div>
            </div>
            <table class="table table-hover align-middle mt-4">
                <thead style="height: 50px;">
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col"> Nickname </th>
                        <th scope="col"> Full Name </th>
                        <th scope="col"> Account Number </th>                     
                        <th scope="col"> Email </th>
                        <th scope="col"> Phone </th>
                        <th scope="col"> Actions </th>
                    </tr>
                </thead>
                <tbody>                 
                @if(count($contacts) === 0)
                    @if(isset($search))
                        <tr style="height: 60px;">
                            <th scope="row" colspan="7" class="text-center h5">You found nothing. Try again! </th>                      
                        </tr>
                    @else
                        <tr style="height: 60px;">
                            <th scope="row" colspan="7" class="text-center h5">You have no contacts</th>                      
                        </tr>
                    @endif
                @else                  
                    @foreach($contacts as $key => $contact)
                    <tr style="height: 60px;">
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$contact->nickname}}</td>
                        <td>{{$contact->user->fname}} {{$contact->user->lname}}</td>
                        <td>
                            @if(!empty($contact->account))
                                {{$contact->account->accNo}}
                            @else
                                <span class="badge bg-danger">Account Closed</span> 
                            @endif
                        </td>
                        <td>{{$contact->user->email}}</td>
                        <td>{{$contact->user->phone}}</td>
                        <td>                         
                            <form method="POST" action="{{ route('user.delete_contact') }}" style="display:inline-block">
                                @csrf
                                <input type="hidden" value="{{$contact->id}}" name="modelId" />
                                <button type="submit" class="btn btn-outline-danger btn-sm px-2 shadow-primary"> Delete <i class="bi bi-person-x-fill"> </i></button>
                            </form>
                        </td>
                    </tr>                
                    @endforeach
                @endif
                </tbody>    
            </table>           
        </div>
    </div>

    <x-darkFooter></x-darkFooter>
</x-app-layout>
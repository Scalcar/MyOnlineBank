<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{$user->fname}} {{$user->lname}}</span> 
            </h2>
        </div>
        <div class="col-8 m-auto">
            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">My accounts</button>
                </li>
                @if($accounts->total() > 0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-transactions-tab" data-bs-toggle="pill" data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-transactions" aria-selected="false">Transactions</button>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">My Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-messages-tab" data-bs-toggle="pill" data-bs-target="#pills-messages" type="button" role="tab" aria-controls="pills-messages" aria-selected="false">Messages</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-settings" type="button" role="tab" aria-controls="pills-settings" aria-selected="false">Settings</button>
                </li>
            </ul>
        </div>
    </x-slot>
    <!--  remember $admin->users  si $user->admin->name -->
      
    <div class="row">
        @if(Session::get('success'))
            <div class="alert alert-success col-6 mt-3 text-center m-auto alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="d-flex justify-content-evenly mx-3 mt-4">
                    <div class="@if(count($accounts) === 0) col-6 mt-4  @else col-4 me-3 @endif">
                        <div class="card border border-2 border-primary">
                            <div class="card-body">
                                <div class="h4 text-center my-3 d-flex align-items-baseline justify-content-between">                               
                                    <a class="btn btn-sm btn-link text-danger ms-3 @if(count($accounts) === 0 || $accounts->first()->status->status === 0) disabled @endif" href="{{ route('user.close_account_form') }}" title="Click to close your account"  @if(count($accounts) === 0 || $user->accounts->first()->status->status === 0) aria-disabled="true" @endif style="font-size: 20px;" ><i class="bi bi-x-circle"></i></a>
                                    Account Details
                                    <a class="link-info me-3" href="{{ route('user.new_account_form') }}" title="Click if you want to open new account"><i class="bi bi-plus-circle"></i></a>
                                </div>                           
                                @if(count($accounts) === 0 || $accounts->first()->status->status === 0)
                                    <div class="p-2 border border-primary rounded my-5 p-4 mx-2 text-center">You have no account. Please contact admin at email: {{$user->admin->email}}</div>
                                </div>
                            </div>
                        </div>
                            @else                                                              
                                @foreach($accounts as $account)                                                              
                                <div class="d-grid gap-3">
                                    <div class="p-2 border border-primary rounded ps-3">Account Number : {{$account->accNo}}</div>
                                    <div class="p-2 border border-primary rounded ps-3">Account Branch : {{$account->AccountBranch}}</div>
                                    <div class="p-2 border border-primary rounded ps-3">Account Name : {{$account->user->fname}} {{$account->user->lname}}</div>
                                    <div class="p-2 border border-primary rounded ps-3">Account Type : {{$account->AccountType}}</div>
                                    <div class="p-2 border border-primary rounded ps-3">Available Balance : {{$account->balance}} {{$account->AccountCurrency}}</div>
                                    <div class="p-2 border border-primary rounded ps-3">Account Status : <span class="badge @if($account->status->status === 2) bg-secondary  @else bg-success @endif ms-2">{{$account->status->statusName}}</span></div>
                                    <div class="p-2 border border-primary rounded ps-3 mb-3">Pin Status : <span class="badge @if($account->pinStatus === 0) bg-danger  @else bg-success @endif ms-2">{{$account->statusPin}}</span></div>
                                    @if($account->status->status === 2)                               
                                        <div class="p-2 text-danger d-flex justify-content-evenly align-items-baseline">                                                                                                                                                               
                                                <span class="text-danger font-weight-bold"><i class="bi bi-bell"></i> Close Time: {{explode('f',$account->status->closeExpires->diffForHumans())[0].'left'}} <i class="bi bi-bell"></i></span>
                                                <a class="link-success btn" href="{{ route('user.recover_account_form',['account' => $account->id]) }}"><i class="bi bi-stars"></i> Recover <i class="bi bi-stars"></i></a>                                      
                                        </div>
                                    @endif                                    
                                    <div class="d-flex justify-content-center">{{$accounts->links()}}</div>                               
                                </div>                               
                            </div>                       
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card border border-2 border-primary">
                            <div class="card-body">
                                <table class="table table-hover align-middle">
                                    <thead style="height: 50px;">
                                        <tr>
                                            <th scope="row" colspan="7" class="h4 text-center fw-bold">Latest Transactions
                                                @if(count($account->transactions) > 8)
                                                    <span class="float-end me-4"><a href="{{ route('user.transactions_view',['account' => $account->id,'list' => $accounts->currentPage()]) }}" class="link-dark" title="View All Transactions"><i class="bi bi-card-list"></i></a></span>
                                                @endif
                                            </th>                                                                              
                                        </tr>
                                        <tr>
                                            <th scope="col"> # </th>
                                            <th scope="col"> Number </th>
                                            <th scope="col"> Date & Time </th>
                                            <th scope="col"> Remarks </th>                                                             
                                            <th scope="col"> Debit ({{$account->AccountCurrency}})</th>
                                            <th scope="col"> Credit ({{$account->AccountCurrency}})</th>
                                            <th scope="col"> Balance ({{$account->AccountCurrency}})</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="d-flex justify-content-center"></div>                                     
                                        @foreach($account->transactions->sortDesc()->forPage(1,8) as $key => $transaction)
                                            <tr style="height: 60px;">
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$transaction->trans_no}}</td>
                                                <td>{{$transaction->formatDate}}</td>
                                                <td>{{$transaction->description}}</td>
                                                <td class="text-danger"> - {{$transaction->debit}}</td>
                                                <td class="text-success"> + {{$transaction->credit}}</td>                                          
                                                <td>{{$transaction->balance}}</td>
                                            </tr>
                                        @endforeach                                   
                                    </tbody>                                    
                                </table>                             
                            </div>
                        </div>                      
                    </div>
                    @endforeach
                    @endif
                </div>                    
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">           
                    <div class="col-7 m-auto mt-4">
                        <div class="card border border-2 border-primary">                     
                            <div class="card-body m-auto p-4 d-flex justify-content-evenly">
                                <div class="col-4 mt-3">
                                    <h4 class="text-center mb-3 text-primary">{{$user->username}} Profile Picture </h4>
                                    <div class="col-12 text-center border border-secondary rounded">
                                        @if ($user->profile_picture)
                                            <img src="{{$user->profile_picture}}" class="img-fluid rounded" />
                                        @else
                                            <img src="/images/profile/default2.png" class="img-fluid" />
                                        @endif
                                    </div>                                   
                                </div>
                                <div class="col-7 mt-3">
                                    <div class="d-grid gap-3 p-3 text-primary">
                                        <div class="d-flex border-bottom border-secondary">
                                            <div class="col-6 p-2 h5">First Name : {{$user->fname}}</div>
                                            <div class="col-6 p-2 h5">Last Name : {{$user->lname}}</div>
                                        </div>
                                        <div class="d-flex border-bottom border-secondary">
                                            <div class="col-6 p-2 h5">Gender : {{$user->genderName}}</div>
                                            <div class="col-6 p-2 h5">Date of Birth : {{date("d/m/Y", strtotime($user->dob))}}</div>
                                        </div>
                                        <div class="d-flex border-bottom border-secondary">
                                            <div class="col-6 p-2 h5">CNP : {{$user->cnp}}</div>
                                            <div class="col-6 p-2 h5">Email : {{$user->email}}</div>
                                        </div>
                                        <div class="d-flex border-bottom border-secondary">
                                            <div class="col-12 p-2 h5">Address : {{$user->address}}</div>                                             
                                        </div>
                                        <div class="d-flex border-bottom border-secondary">
                                            <div class="col-6 p-2 h5">Phone : {{$user->phone}}</div>
                                            <div class="col-6 p-2 h5">Username : {{$user->username}}</div>
                                        </div>
                                        <div class="d-flex border-bottom border-secondary">                                           
                                            <div class="col-6 p-2 h5">Number of Accounts : <span class="badge bg-secondary">{{count($profile)}}</span></div>
                                            <div class="col-6 p-2 h5">Number of Messages : <span class="badge bg-info">{{count($messages)}}</span></div>                                        
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="col-6 p-2 h5">Number of Contacts : <span class="badge bg-secondary">{{count($contact)}}</span></div>                                          
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                                                                                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-transactions" role="tabpanel" aria-labelledby="pills-transactions-tab">
                <div class="row">                         
                    <div class="col-4 m-auto mt-4">
                        <div class="card shadow-sm border border-2 border-primary">
                            <div class="card-body mb-2">
                                <h4 class="text-center my-3 text-primary"> ~ Manage Transactions ~ </h4>
                                <nav class="nav nav-pills nav-justified flex-column w-75 m-auto">                                  
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" data-bs-toggle="collapse" href="#transfer" role="button" aria-expanded="false" aria-controls="transfer"> Transfer Funds </a>
                                    <div class="collapse my-2" id="transfer">
                                        <div class="card card-body border border-primary">
                                            <nav class="nav nav-pills nav-justified w-75 m-auto">
                                                <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.external_transfer_form') }}">External Transfer</a>
                                                <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.internal_transfer_form') }}">Internal Transfer</a>
                                            </nav>
                                        </div>
                                    </div>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.atm_simulator_form') }}"> ATM Simulator </a>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.user_contacts_table') }}"> Contacts </a>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.transfer_between_accounts_form') }}"> Between Accounts Transfer </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-messages" role="tabpanel" aria-labelledby="pills-messages-tab">
                <div class="row">                         
                    <div class="col-4 m-auto mt-4">
                        <div class="card shadow-sm border border-2 border-primary">
                            <div class="card-body mb-2">
                                <h4 class="text-center my-3 text-primary"> ~ Manage Messages ~ </h4>
                                <nav class="nav nav-pills nav-justified flex-column w-75 m-auto">                                                                                                        
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.message_admin_form') }}"> Message an Admin </a>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.message_contact_form') }}"> Message a Contact </a>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.received_messages_view') }}"> Received Messages <span class="badge bg-info ms-2">{{count($receivedMessages)}}</span></a>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.sent_messages_view') }}"> Sent Messages <span class="badge bg-info ms-1">{{count($sentMessages)}}</span></a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
                <div class="row">                         
                    <div class="col-4 m-auto mt-4">
                        <div class="card shadow-sm border border-2 border-primary">
                            <div class="card-body mb-2">
                                <h4 class="text-center my-3 text-primary"> ~ Manage Settings ~ </h4>
                                <nav class="nav nav-pills nav-justified flex-column w-75 m-auto flex-nowrap">                                  
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.edit_personal_data_form') }}"> Change Personal Data </a>                                 
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" data-bs-toggle="collapse" href="#changePicture" role="button" aria-expanded="false" aria-controls="changePicture">Change Profile Picture</a>    
                                    <div class="collapse my-2" id="changePicture">
                                        <div class="card card-body border border-primary">
                                            <form action="{{ route('user.add_profile_picture') }}" method="POST" enctype="multipart/form-data" class="mb-3 mt-4 text-center">
                                                @csrf
                                                <input type="file" class="form-control mb-3 m-auto" name="profile_picture" />
                                                <span class="text-danger ps-1">@error('profile_picture') {{ $message }} @enderror</span>
                                                <button type="submit" class="btn btn-outline-primary w-50 mt-2">Add picture</button>
                                            </form>
                                        </div>
                                    </div>
                                    <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.change_password_form') }}"> Change Password </a>                                                                               
                                    <a class="list-group-item list-group-item-action list-group-item-primary mt-2 mb-4 rounded text-center" data-bs-toggle="collapse" href="#changePin" role="button" aria-expanded="false" aria-controls="changePin">Change Pin</a>
                                    <div class="collapse mt-2 mb-4" id="changePin">
                                        <div class="card card-body border border-primary">
                                            <nav class="nav nav-pills nav-justified flex-column w-75 m-auto">
                                                @if(count($profile) === 0)
                                                    <span class="text-center">You have no accounts.</span>
                                                @else
                                                    @foreach($profile as $key => $value)
                                                        <a class="list-group-item list-group-item-action list-group-item-primary my-2 rounded text-center" href="{{ route('user.change_pin_status_form',['account' => $value->id]) }}">{{$key + 1}}) Account #{{$value->accNo}} / Pin: {{$value->statusPin}} </a>
                                                    @endforeach
                                                @endif
                                            </nav>
                                        </div>
                                    </div>                                       
                                </nav>                                                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>       
    <x-darkFooter></x-darkFooter>
</x-app-layout>
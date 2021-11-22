<?php

namespace App\Http\Controllers;

use App\General\Concretes\Repositories\ContactRepository;
use App\General\Concretes\Repositories\UserRepository;
use App\Http\Requests\User\addContactRequest;
use App\Http\Requests\User\SearchRequest;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private $userRepository;
    private $contactRepository;

    public function __construct(UserRepository $userRepository, ContactRepository $contactRepository)
    {
        $this->userRepository = $userRepository;
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $user = $this->userRepository->getById(Auth::user()->id);
        $contacts = $this->contactRepository->getAll()->where('list_id', Auth::user()->id);

        return view('user.tables.userContacts',[
            'user' => $user,
            'contacts' => $contacts           
        ]);
    }

    public function addContactView()
    {
        $user = $this->userRepository->getById(Auth::user()->id);

        return view('user.forms.addContact',[
            'user' => $user,
        ]);
    }

    public function addContact(addContactRequest $request)
    {
        if($request->validated())
        {
            $user = User::where('email',$request->post('email'))->first();
            $account = Account::where('accNo',$request->post('accNo'))->first();

            $contact = $this->contactRepository->store([
                'nickname' => $request->post('nickname'),
                'list_id' => $request->post('list_id'),
                'user_id' => $user->id,
                'account_id' => $account->id,                
            ]);

            if($contact !== null && $contact instanceof Contact)
            {
                return redirect()->route('user.user_contacts_table')->with('success',"Contact: $contact->nickname was added successfully!");
            }           
        }
    }
   
    public function deleteContact(Request $request)
    {
        if($this->contactRepository->delete($request->all()))
        {
            return redirect()->back()->with('success','The selected contact removed successfully!');
        }
    }

    public function search(SearchRequest $request)
    {
        if($request->validated())
        {                 
              $results = $this->contactRepository->search($request->post('searchSelect'),$request->post('searchForm'));

                if($results !== null)
                {
                    return view('user.tables.userContacts',[
                        'user' => Auth::user(),
                        'contacts' => $results           
                    ])->with('search',true);
                }
                    
            
        }
    }

}

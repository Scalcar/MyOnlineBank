<?php

namespace App\Http\Controllers;

use App\General\Concretes\Repositories\AccountRepository;
use App\General\Concretes\Repositories\AdminRepository;
use App\General\Concretes\Repositories\UserRepository;
use App\Http\Requests\EditAdminRequest;
use App\Http\Requests\EditCustomerRequest;
use App\Models\AccountStatus;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    private $userRepository;
    private $adminRepository;
    private $accountRepository;

    public function __construct(UserRepository $userRepository, AdminRepository $adminRepository, AccountRepository $accountRepository)
    {
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $admins = $this->adminRepository->getAll();
        $accounts = $this->accountRepository->getAll();
        $forApproval = AccountStatus::where('status','0')->orWhere('status','2')->orderBy('updated_at', 'desc')->paginate(7);

        // -- Nu am implementat inca pinStatus 2 (forgot pin)
        // $forApproval = AccountStatus::whereHas('account', function($q) { 
        //     return $q->where('pinStatus',2)->orWhere('status',0)->orWhere('status',2);
        // })->orderBy('updated_at', 'desc')->paginate(7);

        return view('admin.home',[
            'admins' => $admins,
            'accounts' => $accounts,
            'forApproval' => $forApproval,
        ]);
    }

    public function manage()
    {
        $admins = $this->adminRepository->getAll();

        return view('admin.tables.manage_admins',[
            'admins' => $admins
        ]);
    }

    public function manageCustomers()
    {
        $users = $this->userRepository->getAll();

        return view('admin.tables.manage_customers',[
            'users' => $users,
        ]);
    }

    public function editAdminView(Request $request)
    {
        return view('admin.forms.edit_admin',[
            'admin' => $this->adminRepository->getById($request->get('admin'))
        ]);
    }

    public function editCustomerView(Request $request)
    {
        return view('admin.forms.edit_customer',[
            'user' => $this->userRepository->getById($request->get('user'))
        ]);
    }

    public function showCustomer(Request $request)
    {
        return view('admin.tables.show_customer',[
            'customer' => $this->userRepository->getById($request->get('customer'))
        ]);
    }

    public function editAdmin(EditAdminRequest $request)
    {
        if($request->validated())
        {
            $admin = $this->adminRepository->update($request->all());

            if($admin !== null && $admin instanceof Admin){
                return redirect()->route('admin.manage_admins')->with('success','Admin edited successfully!');
            }
        }
    }

    public function editCustomer(EditCustomerRequest $request)
    {
        if($request->validated())
        {
            $user = $this->userRepository->update($request->all());

            if($user !== null && $user instanceof User){
                return redirect()->route('admin.manage_customers')->with('success','Customer edited successfully!');
            }
        }
    }

    public function deleteCustomer(Request $request)
    {
        if($this->userRepository->delete($request->all()))
        {
            return redirect()->back()->with('success','Customer removed successfully!');
        }         
    }
}

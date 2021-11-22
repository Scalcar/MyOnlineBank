<?php

use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\Accounts\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\RegController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\MessageAdminController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\ContactUserController;
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\User\NewsUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function(){
    return view('first');
}); 

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login','admin.login')->name('login');
        Route::post('/check',[AdminController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::get('/home',[HomeAdminController::class, 'index'])->name('home');
        Route::get('/dashboard',[DashboardAdminController::class, 'index'])->name('dashboard'); 

        //Post Routes for admin
        Route::post('/logout',[AdminController::class, 'logout'])->name('logout');
        Route::post('/create',[AdminController::class,'create'])->name('create');
        Route::post('/delete',[AdminController::class,'delete'])->name('delete');
        Route::post('/edit',[HomeAdminController::class,'editAdmin'])->name('edit');
        Route::post('/customer_edit',[HomeAdminController::class,'editCustomer'])->name('edit_customer');
        Route::post('/add_account',[AccountController::class,'addAccountAdmin'])->name('admin_add_account');
        Route::post('/customer_delete',[HomeAdminController::class,'deleteCustomer'])->name('delete_customer');
        Route::post('/account_delete',[AccountController::class,'deleteAccount'])->name('delete_account');
        Route::post('/account_verify',[AccountController::class,'verifyAccount'])->name('verify_account');
        Route::post('/message_user',[MessageAdminController::class,'messageUser'])->name('message_user');
        Route::post('/delete_sent_message',[MessageAdminController::class,'deleteSentMessage'])->name('delete_sent_message');
        Route::post('/delete_received_message',[MessageAdminController::class,'deleteReceivedMessage'])->name('delete_received_message');
        Route::post('/delete_message',[MessageAdminController::class,'deleteMessage'])->name('delete_message');
        Route::post('/message_all',[MessageAdminController::class,'messageAll'])->name('message_all');

        // here are get routes
       Route::get('/home/add_customer',[RegController::class,'index'])->name('add_customer');
       Route::get('/home/add_admin',[AdminController::class,'index'])->name('add_admin');
       Route::get('/home/manage_admins',[HomeAdminController::class,'manage'])->name('manage_admins');
       Route::get('/home/manage_admins/edit',[HomeAdminController::class,'editAdminView'])->name('edit_admin_form');
       Route::get('/home/manage_customers',[HomeAdminController::class,'manageCustomers'])->name('manage_customers');
       Route::get('/home/manage_customers/edit',[HomeAdminController::class,'editCustomerView'])->name('edit_customer_form');
       Route::get('/home/manage_customers/show',[HomeAdminController::class,'showCustomer'])->name('show_customer');
       Route::get('/home/accounts/add',[AccountController::class,'addAccountView'])->name('add_account_form');
       Route::get('/home/accounts/show',[AccountController::class,'showAccount'])->name('show_account');
       Route::get('/home/accounts/transactions',[AccountController::class,'showTransactions'])->name('show_transactions');
       Route::get('/home/accounts/verify',[AccountController::class,'verifyAccountView'])->name('verify_account_form');
       Route::get('/home/manage_messages',[MessageAdminController::class,'manageMessages'])->name('manage_messages');
       Route::get('/home/manage_messages/message_user',[MessageAdminController::class,'messageUserView'])->name('message_user_form');
       Route::get('/home/manage_messages/sent_messages',[MessageAdminController::class,'sentMessagesView'])->name('sent_messages_table');
       Route::get('/home/manage_messages/sent_messages/View',[MessageAdminController::class,'viewSentMessage'])->name('view_sent_message');
       Route::get('home/manage_messages/received_messages',[MessageAdminController::class,'receivedMessagesView'])->name('received_messages_table');
       Route::get('/home/manage_messages/received_messages/view',[MessageAdminController::class,'viewReceivedMessage'])->name('view_received_message');
       Route::get('/home/manage_messages/message_all',[MessageAdminController::class,'messageAllView'])->name('message_all_form');
       Route::get('/home/manage_messages/messages_cleanup',[MessageAdminController::class,'messagesCleanup'])->name('messages_cleanup');
    });
});

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest','PreventBackHistory'])->group(function(){
        Route::view('/login','user.login')->name('login');
        Route::view('/register','user.register')->name('register');
        Route::get('/publicNews',[NewsUserController::class,'newsView'])->name('publicNews');
        Route::get('/publicContact',[ContactUserController::class,'contact'])->name('publicContact');
        Route::post('/create',[RegController::class,'create'])->name('create');
        Route::post('/check',[RegController::class,'check'])->name('check');
    });

    Route::middleware(['auth','PreventBackHistory'])->group(function(){
        Route::get('/home',[HomeUserController::class,'index'])->name('home');
        Route::get('/news',[NewsUserController::class,'index'])->name('news');
        Route::get('/contact',[ContactUserController::class,'index'])->name('contact');
        //Home routes views
        Route::get('/home/accounts/new_account',[HomeUserController::class,'newAccountView'])->name('new_account_form');
        Route::get('/home/accounts/close_account',[HomeUserController::class,'closeAccountView'])->name('close_account_form');
        Route::get('/home/accounts/request_close',[HomeUserController::class,'requestCloseView'])->name('request_close_form');
        Route::get('/home/accounts/recover',[HomeUserController::class,'recoverAccountView'])->name('recover_account_form');
        Route::get('/home/settings/edit',[HomeUserController::class,'editPersonalDataView'])->name('edit_personal_data_form');
        Route::get('/home/settings/change_password',[RegController::class,'changePasswordView'])->name('change_password_form');
        Route::get('/home/settings/change_pin',[HomeUserController::class,'changePinStatusView'])->name('change_pin_status_form');
        Route::get('/home/accounts/transactions',[TransactionController::class,'transactionsView'])->name('transactions_view');

        Route::get('/home/contacts',[ContactController::class,'index'])->name('user_contacts_table');
        Route::get('home/contacts/add',[ContactController::class,'addContactView'])->name('add_contact_form');

        Route::get('home/accounts/transfer_between_accounts',[AccountController::class,'transferBetweenAccountsView'])->name('transfer_between_accounts_form');
        Route::get('home/accounts/atm_simulator',[AccountController::class,'atmSimulatorView'])->name('atm_simulator_form');
        Route::get('home/accounts/external_transfer',[AccountController::class,'externalTransferView'])->name('external_transfer_form');
        Route::get('home/accounts/internal_transfer',[AccountController::class,'internalTransferView'])->name('internal_transfer_form');

        Route::get('home/messages/message_admin',[MessageController::class,'messageAdminView'])->name('message_admin_form');
        Route::get('home/messages/sent_messages',[MessageController::class,'sentMessagesView'])->name('sent_messages_view');
        Route::get('/home/messages/edit',[MessageController::class,'editSentMessageView'])->name('edit_sent_message_form');
        Route::get('/home/messages/message_contact',[MessageController::class,'messageContactView'])->name('message_contact_form');
        Route::get('/home/messages/received_messages',[MessageController::class,'receivedMessagesView'])->name('received_messages_view');
        Route::get('/home/messages/received_messages/View',[MessageController::class,'viewReceivedMessage'])->name('view_received_message');

        //Home routes actions
        Route::post('/request_account',[HomeUserController::class,'requestAccount'])->name('request_account');
        Route::post('/request_close',[HomeUserController::class,'requestClose'])->name('request_close');
        Route::post('/recover_account',[HomeUserController::class,'recoverAccount'])->name('recover_account');
        Route::post('/edit_personal_data',[HomeUserController::class,'editPersonalData'])->name('edit_personal_data');
        Route::post('/add_profile_picture',[RegController::class,'addProfilePicture'])->name('add_profile_picture');
        Route::post('/change_password',[HomeUserController::class,'changePassword'])->name('change_password');
        Route::post('/change_pin',[HomeUserController::class,'changePin'])->name('change_pin');

        Route::post('/add_contact',[ContactController::class,'addContact'])->name('add_contact');
        Route::post('/delete_contact',[ContactController::class,'deleteContact'])->name('delete_contact');
        Route::post('/home/contacts',[ContactController::class,'search'])->name('search');
        Route::post('/delete_sent_message',[MessageController::class,'deleteSentMessage'])->name('delete_sent_message');
        Route::post('/edit_sent_message',[MessageController::class,'editSentMessage'])->name('edit_sent_message');
        Route::post('/delete_received_message',[MessageController::class,'deleteReceivedMessage'])->name('delete_received_message');

        Route::post('/accounts/transfer_between_accounts',[AccountController::class,'transferBetweenAccounts'])->name('transfer_between_accounts');
        Route::post('/accounts/atm_simulator',[AccountController::class,'atmSimulator'])->name('atm_simulator');
        Route::post('/accounts/external_transfer',[AccountController::class,'externalTransfer'])->name('external_transfer');
        Route::post('/accounts/internal_transfer',[AccountController::class,'internalTransfer'])->name('internal_transfer');

        Route::post('/messages/message_admin',[MessageController::class,'messageAdmin'])->name('message_admin');
        Route::post('/messages/message_contact',[MessageController::class,'messageContact'])->name('message_contact');

        Route::get('/dashboard',[DashboardUserController::class,'index'])->name('dashboard');

        Route::post('/logout',[RegController::class,'logout'])->name('logout');
    });
});




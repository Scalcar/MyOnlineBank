<?php

namespace App\Http\Controllers;

use App\General\Concretes\Enums\MessageStatus;
use App\General\Concretes\Repositories\MessageRepository;
use App\General\Concretes\Repositories\UserRepository;
use App\Http\Requests\AdminMessageAllRequest;
use App\Http\Requests\AdminMessageUserRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageAdminController extends Controller
{
    private $userRepository;
    private $messageRepository;

    public function __construct(UserRepository $userRepository, MessageRepository $messageRepository)
    {
        $this->userRepository = $userRepository;
        $this->messageRepository = $messageRepository;
    }

    public function manageMessages()
    {
        $messagesSent = Message::where('admin_sender_id','!=', null)->orderBy('created_at','desc')->paginate(7,['*'],'list');
        $messagesReceived = Message::where('admin_id','!=', null)->orderBy('created_at','desc')->paginate(7,['*'],'list');

        return view('admin.manageMessages',[
            'messagesSent' => $messagesSent,
            'messagesReceived' => $messagesReceived,
        ]);
    }

    public function messageUserView()
    {
        $users = $this->userRepository->getAll();

        return view('admin.forms.messageAUser',[
            'users' => $users,
        ]);
    }

    public function messageAllView()
    {
        return view('admin.forms.messageAllUsers');
    }

    public function sentMessagesView()
    {
        $messages = Message::where('admin_sender_id','!=', null)->orderBy('created_at','desc')->paginate(7,['*'],'list');

        return view('admin.tables.sentMessages',[
            'messages' => $messages,
        ]);
    }

    public function receivedMessagesView()
    {
        $messages = Message::where('admin_id','!=', null)->orderBy('created_at','desc')->paginate(7,['*'],'list'); 

        return view('admin.tables.receivedMessages',[
            'messages' => $messages,
        ]);
    }

    public function viewSentMessage(Request $request)
    {
        $message = $this->messageRepository->getById($request->get('message'));

        return view('admin.viewSentMessage',[
            'message' => $message,
        ]);
    }

    public function viewReceivedMessage(Request $request)
    {
        $model = $this->messageRepository->getById($request->get('message'));
        $message = $this->messageRepository->update([
            'modelId' => $model->id,
            'status' => MessageStatus::READ_STATUS_ID,
        ]);

        if($message !== null && $message instanceof Message)
        {
            return view('admin.viewReceivedMessage',[
                'message' => $message,
            ]);
        }
    }

    public function messagesCleanup()
    {
        $messages = Message::where(function ($q) {
            return $q->where('sender_status',MessageStatus::INACTIVE_STATUS_ID)->where('receiver_status',MessageStatus::INACTIVE_STATUS_ID);
        })->orWhere(function($q) {
            return $q->where('receiver_status',MessageStatus::INACTIVE_STATUS_ID)->where('sender_status',null);
        })->orderBy('created_at','desc')->paginate(7,['*'],'list');

        return view('admin.tables.messages_cleanup',[
            'messages' => $messages,
        ]);
    }

    public function messageUser(AdminMessageUserRequest $request)
    {
        if($request->validated())
        {
            $message = $this->messageRepository->store([
                'subject' => $request->post('subject'),
                'body' => $request->post('body'),
                'sent_to_id' => $request->post('sent_to_id'),
                'admin_sender_id' => $request->post('admin_sender_id'),
                'receiver_status' => MessageStatus::ACTIVE_STATUS_ID,
                'status' => MessageStatus::UNREAD_STATUS_ID,
            ]);

            if($message !== null && $message instanceof Message)
            {
                return redirect()->back()->with('success','The message was sent successfully!');
            }          
        }
    }

    public function messageAll(AdminMessageAllRequest $request)
    {
        if($request->validated())
        {
            $users = $this->userRepository->getAll();

            if(!empty($users))
            {
                foreach($users as $user)
                {
                    $message = $this->messageRepository->store([
                        'subject' => $request->post('subject'),
                        'body' => $request->post('body'),
                        'sent_to_id' => $user->id,
                        'admin_sender_id' => $request->post('admin_sender_id'),
                        'receiver_status' => MessageStatus::ACTIVE_STATUS_ID,
                        'status' => MessageStatus::UNREAD_STATUS_ID,
                    ]);
                }

                if($message !== null && $message instanceof Message)
                {
                    return redirect()->back()->with('success','The message was sent successfully!');
                }
            }
        }
    }

    public function deleteSentMessage(Request $request)
    {    
        $message = $this->messageRepository->delete($request->all());
        
        if($message !== null && $message instanceof Message)
        {
            return redirect()->route('admin.sent_messages_table')->with('success','The message was deleted successfully!');
        }
    }

    public function deleteReceivedMessage(Request $request)
    {    
        $message = $this->messageRepository->delete($request->all());
        
        if($message !== null && $message instanceof Message)
        {
            return redirect()->route('admin.received_messages_table')->with('success','The message was deleted successfully!');
        }
    }

    public function deleteMessage(Request $request)
    {
        $message = $this->messageRepository->delete($request->all());
        
        if($message !== null && $message instanceof Message)
        {
            return redirect()->back()->with('success','The message was deleted successfully!');
        }
    }
}

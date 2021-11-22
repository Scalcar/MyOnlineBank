<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\General\Concretes\Enums\MessageStatus;
use App\General\Concretes\Repositories\MessageRepository;
use App\Http\Requests\User\EditSentMessageRequest;
use App\Http\Requests\User\MessageAContactRequest;
use App\Http\Requests\User\MessageAnAdminRequest;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function messageAdminView()
    {
        return view('user.forms.messageAnAdmin',[
            'user' => Auth::user(),
        ]);
    }

    public function sentMessagesView()
    {
        $messages = Message::where('sender_id', Auth::user()->id)->where('sender_status',MessageStatus::ACTIVE_STATUS_ID)->orderBy('created_at','desc')->paginate(7,['*'],'list');

        return view('user.tables.userSentMessages',[
            'user' => Auth::user(),
            'messages' => $messages,
        ]);
    }

    public function receivedMessagesView()
    {
        $messages = Message::where('sent_to_id', Auth::user()->id)->where('receiver_status',MessageStatus::ACTIVE_STATUS_ID)->orderBy('created_at','desc')->paginate(7,['*'],'list');

        return view('user.tables.userReceivedMessages',[
            'user' => Auth::user(),
            'messages' => $messages,
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
            return view('user.viewReceivedMessage',[
                'message' => $message,
                'user' => Auth::user(),
            ]);
        }
    }

    public function editSentMessageView(Request $request)
    {
        $message = $this->messageRepository->getById($request->get('message'));

        return view('user.forms.editSentMessages',[
            'user' => Auth::user(),
            'message' => $message,
        ]);
    }

    public function messageContactView()
    {
        $contacts = Contact::where('list_id', Auth::user()->id)->get();
        return view('user.forms.messageAContact',[
            'user' => Auth::user(),
            'contacts' => $contacts,
        ]);
    }

    public function messageAdmin(MessageAnAdminRequest $request)
    {
        if($request->validated())
        {
            $message = $this->messageRepository->store([
                'subject' => $request->post('subject'),
                'body' => $request->post('body'),
                'sender_id' => $request->post('user_id'),
                'admin_id' => $request->post('admin_id'),
                'sender_status' => MessageStatus::ACTIVE_STATUS_ID,
                'receiver_status' => MessageStatus::ACTIVE_STATUS_ID, 
                'status' => MessageStatus::UNREAD_STATUS_ID,                         
            ]);

            if($message !== null && $message instanceof Message)
            {
                return redirect()->back()->with('success','The message was sent successfully!');
            }
        }  
    }

    public function messageContact(MessageAContactRequest $request)
    {
        if($request->validated())
        {
            $message = $this->messageRepository->store($request->all());

            if(!empty($message))
            {
                $message = $this->messageRepository->update([
                    'modelId' => $message->id,
                    'sender_status' => MessageStatus::ACTIVE_STATUS_ID,
                    'receiver_status' => MessageStatus::ACTIVE_STATUS_ID,              
                ]);
    
                if($message !== null && $message instanceof Message)
                {
                    return redirect()->back()->with('success','The message was sent successfully!');
                }
            }            
        }
    }

    public function editSentMessage(EditSentMessageRequest $request)
    {
        if($request->validated())
        {
            $message = $this->messageRepository->update($request->all());
            
            if($message !== null && $message instanceof Message)
            {
                return redirect()->route('user.sent_messages_view')->with('success','The message was edited successfully!');
            }
        }
    }

    public function deleteSentMessage(Request $request)
    {
        $message = $this->messageRepository->update([
            'modelId' => $request->post('modelId'),
            'sender_status' => MessageStatus::INACTIVE_STATUS_ID,
        ]);

        if($message !== null && $message instanceof Message)
        {
            return redirect()->back()->with('success','The message was deleted successfully!');
        }
    }

    public function deleteReceivedMessage(Request $request)
    {
        $message = $this->messageRepository->update([
            'modelId' => $request->post('modelId'),
            'receiver_status' => MessageStatus::INACTIVE_STATUS_ID,
        ]);

        if($message !== null && $message instanceof Message)
        {
            return redirect()->route('user.received_messages_view')->with('success','The message was deleted successfully!');
        }
    }
}

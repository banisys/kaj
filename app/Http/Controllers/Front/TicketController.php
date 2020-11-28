<?php

namespace App\Http\Controllers\Front;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function showForm()
    {
        return view('front.panel.ticketForm');
    }

    public function storeForm(Request $request)
    {
        $rules = [
            'department' => ['required'],
            'subject' => ['required'],
            'body' => ['required'],
        ];

        $customMessages = [
            'department.required' => 'انتخاب دپارتمان الزامی است.',
            'subject.required' => 'وارد کردن موضوع الزامی است.',
            'body.required' => 'متن تیکت را وارد کنید.',
        ];

        $this->validate($request, $rules, $customMessages);

        $user_id = auth()->user()->id;
        if (isset($request->attachment)) {
            $attachment = time() . '.' . $request->attachment->getClientOriginalExtension();
            $request->attachment->move(public_path('uploads/attachment'), $attachment);
        } else {
            $attachment = null;
        }


        $ticket = Ticket::create([
            'department' => $request['department'],
            'subject' => $request['subject'],
            'body' => $request['body'],
            'attachment' => $attachment,
            'from' => $user_id,
            'status' => 'در انتظار پاسخ',
            'type' => 'ticket',
        ]);
        $ticket->shamsi_c = Verta::instance($ticket->created_at)->format('Y/n/j');
        $ticket->group = $ticket->id;
        $ticket->pointer = $ticket->id;
        $ticket->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function list()
    {
        return view('front.panel.ticketList');
    }

    public function fetchTicket()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::where('from', $userId)->whereNotNull('pointer')->orWhere('to', $userId)->whereNotNull('pointer')
            ->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($tickets);
    }

    public function detailTicket()
    {
        return view('front.panel.ticketDetail');
    }

    public function fetchDetailTicket($group)
    {
        $tickets = Ticket::where('group', $group)->with('user')->with('admin')->get();

        return response()->json($tickets);
    }

    public function storeFormDetail(Request $request)
    {
        Ticket::where('group', $request['group'])->latest()->update(['pointer' => null]);
        Ticket::where('group', $request['group'])->update(['status' => $request['در انتظار پاسخ']]);
        $user_id = auth()->user()->id;
        if (isset($request->attachment)) {
            $attachment = time() . '.' . $request->attachment->getClientOriginalExtension();
            $request->attachment->move(public_path('uploads/attachment'), $attachment);
        } else {
            $attachment = null;
        }

        $ticket = Ticket::create([
            'department' => $request['department'],
            'subject' => $request['subject'],
            'body' => $request['body'],
            'group' => $request['group'],
            'attachment' => $attachment,
            'from' => $user_id,
            'status' => 'در انتظار پاسخ',
            'type' => 'ticket',
            'pointer' => $request['group'],
            'for' => $request['for'],
        ]);
        $ticket->shamsi_c = Verta::instance($ticket->created_at)->format('Y/n/j');
        $ticket->save();

        return response()->json(['key' => 'value'], 200);
    }
}

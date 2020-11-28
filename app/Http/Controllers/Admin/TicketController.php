<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Ticket;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.ticket.index');
    }

    public function fetchTicket()
    {
        $tickets = Ticket::whereNotNull('pointer')->orderBy('created_at', 'DESC')->with('admin2')->paginate(9);

        return response()->json($tickets);
    }

    public function detailTicket()
    {
        return view('admin.ticket.show');
    }

    public function fetchDetailTicket($group)
    {
        $tickets = Ticket::where('group', $group)->orderBy('created_at', 'ASC')->with('user')->with('admin')->get();

        return response()->json($tickets);
    }

    public function storeForm(Request $request)
    {
//        $request->validate([
//            'name' => 'required',
//            'name_f' => 'required',
//            'image' => 'required',
//            'cat_id' => 'required',
//            'description' => 'required',
//        ]);
        $latest = Ticket::where('group', $request['group'])->whereNotNull('from')->latest()->first();
        Ticket::where('group', $request['group'])->latest()->update(['pointer' => null]);
        Ticket::where('group', $request['group'])->update(['status' => $request['status']]);

        if (isset($request->attachment)) {
            $attachment = time() . '.' . $request->attachment->getClientOriginalExtension();
            $request->attachment->move(base_path('uploads/attachment'), $attachment);
        } else {
            $attachment = null;
        }

        $user_id = auth('admin')->user()->id;

        $ticket = Ticket::create([
            'department' => $latest['department'],
            'subject' => $latest['subject'],
            'body' => $request['body'],
            'admin_id' => $user_id,
            'status' => $request['status'],
            'type' => 'ticket',
            'to' => $latest['from'],
            'group' => $request['group'],
            'pointer' => $request['group'],
            'attachment' => $attachment,
            'for' => $user_id,
        ]);
        $ticket->shamsi_c = Verta::instance($ticket->created_at)->format('Y/n/j');
        $ticket->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchNewTicket()
    {
        $tickets = Ticket::whereNull('for')->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($tickets);
    }

    public function fetchAdmin()
    {
        $admins = Admin::get();

        return response()->json($admins);
    }

    public function setAdmin(Request $request)
    {
        $ticket = Ticket::find($request['ticket_id']);

        Ticket::where('group', $ticket->group)->update(['for' => $request['admin_id']]);

        return response()->json(['key' => 'value'], 200);
    }

    public function indexMy()
    {
        return view('admin.ticket.index_my');
    }

    public function fetchMyTicket()
    {
        $admin_id = auth('admin')->user()->id;
        $tickets = Ticket::where('for', $admin_id)->whereNotNull('pointer')->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($tickets);
    }
}

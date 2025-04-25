<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Incident;
use App\Models\LeaveType;
use App\Models\Solution;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use PhpParser\Builder;
use function PHPUnit\TestFixture\func;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
        {

            $query  =  $request->get('query');
            if($request->ajax()){
                $data = Ticket::query()->where('title', 'LIKE', $query . '%')
                    ->limit(10)
                    ->get();
                $output = '';
                $loop = 0;
                if (count($data) > 0){
                    foreach ($data as $row){
                        $output .= '
                                    <tr>
                                        <td>' . $loop+1 . '</td>
                                        <td>' . $row->title . '</td>
                                        <td>' . $row->description . '</td>
                                        <td>' . $row->ticket_type . '</td>
                                        <td>' . $row->status . '</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-success me-1" href="' . route('tickets.show', $row->id) . '">Show</a>
                                            <a class="btn btn-primary me-1" href="' . route('tickets.edit', $row->id) . '">Edit</a>
                                            <form action="' . route('tickets.destroy', $row->id) . '" method="post">
                                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger me-1">Delete</button>
                                            </form>
                                        </td>
                                        </tr>
                                    ';
                        $loop+=1;
                    }
                }else{
                    $output .= '<td colspan="6">
                            <div class="d-flex justify-content-center">
                                No Record Found
                            </div>
                        </td>';
                }
                return $output;
            }

            if (auth()->user()->roles == 'admin'){
                $tickets = Ticket::query()->where('title', 'LIKE', '%' . $query . '%')
                    ->simplePaginate(8);
            }else{
                $user_id = auth()->user()->id;
                $tickets = Ticket::query()
                    ->where('title', 'LIKE', '%' . $query . '%')
                    ->where('user_id', '=', $user_id)
                    ->simplePaginate(8);
            }



            return view('tickets.index', compact('tickets'));
        }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $incidents = \App\Models\Incident::all();
        $isAdmin = auth()->user()->roles === 'admin';
        $admins = \App\Models\User::where('roles', 'admin')->get();
        return response(view('tickets.create', compact('incidents', 'isAdmin', 'admins')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->user_id = auth()->id();
        $ticket->ticket_type = $request->ticket_type;
        $ticket->status = 'open';
        $ticket->is_resolved = false;

        // If binding to an incident, set priority from incident
        if ($request->incident_id) {
            $incident = \App\Models\Incident::find($request->incident_id);
            if ($incident) {
                $ticket->priority = $incident->priority;
                $ticket->requestable_id = $incident->id;
                $ticket->requestable_type = get_class($incident);
            }
        } else {
            $ticket->priority = 'Low'; // or whatever default
        }

        if ($request->hasFile('file')){
            $pathFile = $request->file('file')->store('files', 'public');
            $ticket->files = $pathFile;
        }else{
            $ticket->files = '';
        }

        $ticket->save($request->validated());
        return redirect(route('tickets.index'))
            ->with('success','Ticket created successfully')
            ->withErrors('error','Ticket created unsuccessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket = Ticket::with('solutions')->find($ticket->id);
        $admins = \App\Models\User::where('roles', 'admin')->get();
        return view('tickets.show', compact('ticket', 'admins'));
    }

    public function createMessage(Request $request, $id){

        $solution = new Solution();
        $solution->ticket_id = $id;
        $solution->messages = $request->message;
        $solution->save();

        return redirect()->route('tickets.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket): View
    {
        $users = \App\Models\User::all();
        $admins = \App\Models\User::where('roles', 'admin')->get();
        return view('tickets.edit', compact('ticket', 'users', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        if ($request->hasFile('files')) {
            if ($oldFile = $ticket->files) {
                unlink(storage_path('app/files/') . $oldFile);
            }
            $pathFile = $request->file('file')->store('files', 'public');
            $ticket->files = $pathFile;
        }
        $ticket->ticket_type = $request->ticket_type;

        if ($request->has('assignee_id') && $ticket->assignee_id != $request->assignee_id) {
            $ticket->assignee_id = $request->assignee_id;
        }

        $ticket->update($request->validated());

        return redirect(route('tickets.index'))
            ->with('success', 'Ticket updated successfully')
            ->withErrors('error', 'Ticket updated unsuccessfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $oldFile = $ticket->files;
        unlink(storage_path('app/public/') . $oldFile);
        $ticket->delete();

        return redirect(route('tickets.index'))
            ->with('success', 'Deleted successfully')
            ->withErrors('error', 'Sorry, unable to delete this!');
    }

    public function close(Ticket $ticket): RedirectResponse
    {
        ;
        $ticket->status = "closed";
        $ticket->save();

        return redirect()->route('tickets.index');

    }

    public function reopen(Ticket $ticket): RedirectResponse
    {
        $ticket->status = "open";
        $ticket->save();

        return redirect()->route('tickets.index');

    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $comments = $ticket->comments ? json_decode($ticket->comments, true) : [];
        $comments[] = [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'message' => $request->message,
            'created_at' => now()->toDateTimeString(),
        ];
        $ticket->comments = json_encode($comments);
        $ticket->save();
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Comment added!');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|string',
            // add other fields if needed
        ]);
        $ticket->status = $request->status;
        if ($request->has('priority')) {
            $ticket->priority = $request->priority;
        }
        if ($request->has('assignee_id')) {
            $ticket->assignee_id = $request->assignee_id;
        }
        $ticket->save();
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket updated!');
    }
}

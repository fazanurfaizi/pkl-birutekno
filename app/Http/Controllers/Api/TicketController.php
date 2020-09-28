<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illumiate\Support\Facades\Storage;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)
            ->orderBy('status', 'ASC')
            ->orderBy('id', 'DESC')
            ->when($request->q, function($tickets) {
                $tickets = $tickets->where('subject', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('id', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('status', 'LIKE', '%' . request()->q . '%');
            })->paginate($request->per_page);
        foreach ($tickets as $ticket) {
            $ticket->project;                
        }

        return response()->json([
            'data' => $tickets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'project_id' => 'required',
            'subject' => 'required|string',
            'description' => 'sometimes',
        ];                

        $filename = '';

        if($request->file()) {
            $fileRules = [
                'file' => 'mimes:jpeg,jpg,png,gif,pdf,docs,csv,txt,xlx,xls,docs',
            ];

            array_merge($rules, $fileRules);
            $filename = time().'_'.$request->file->getClientOriginalName();
            $request->file('file')->storeAs('uploads', $filename, 'public');            
        }

        $request->validate($rules);

        $ticket = new Ticket([
            'user_id' => auth()->user()->id,
            'project_id' => $request->project_id,
            'subject' => $request->subject,
            'description' => $request->description,
        ]);

        $ticket->file = $filename;

        $ticket->save();

        return response()->json([
            'message' => 'Ticket successfully created',
            'data' => $ticket
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        if(!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticket->user;
        $ticket->project->category;

        return response()->json([
            'data' => $ticket
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        if(!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticket->update([
            'status' => $request->status,
            'response' => $request->response,
            'started_at' => $request->start,
            'ended_at' => $request->end
        ]);
        $ticket->save();

        return response()->json([
            'data' => $ticket,
            'message' => 'Update Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        if(!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket successfully deleted'
        ], 200);
    }
}

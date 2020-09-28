<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request) {
        $tickets = Ticket::orderBy('status', 'ASC')
            ->orderBy('id', 'DESC')
            ->when($request->q, function($tickets) {
                $tickets = $tickets->where('subject', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('status', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('id', 'LIKE', '%' . request()->q . '%');
            })->paginate($request->per_page);

        return response()->json([
            'data' => $tickets
        ]);
    }
}

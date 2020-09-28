<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::orderBy('status', 'DESC')
            ->orderBy('id', 'DESC')
            ->when($request->q, function($projects) {
                $projects = $projects->where('subject', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('status', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('id', 'LIKE', '%' . request()->q . '%');
            })->paginate($request->per_page);

        return response()->json([
            'data' => $projects
        ]);
    }
}

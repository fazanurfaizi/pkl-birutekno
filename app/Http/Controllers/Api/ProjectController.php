<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('user_id', auth()->user()->id)
            ->orderBy('status', 'DESC')
            ->orderBy('id', 'DESC')
            ->when($request->q, function($projects) {
                $projects = $projects->where('name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('id', 'LIKE', '%' . request()->q . '%');
            })->paginate($request->per_page);
        
        foreach ($projects as $project) {
            $project->category;
        }

        return response()->json([
            'data' => $projects
        ], 200);    
    }

    public function getAll() {
        $projects = auth()->user()->projects;

        foreach ($projects as $project) {
            $project->category;
        }

        return response()->json([
            'data' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([            
            'category_id' => 'required',
            'priority_id' => 'sometimes',
            'name' => 'string|required', 
            'estimated_budget' => 'required',
            'description' => 'required',
            'status' => 'sometimes',
            'started_at' => 'sometimes',
            'ended_at' => 'sometimes'
        ]);

        $project = new Project([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'priority_id' => $request->priority_id,
            'name' => $request->name, 
            'estimated_budget' => $request->estimated_budget,
            'description' => $request->description,
            'status' => $request->status,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at
        ]);      

        $project->save();

        return response()->json([
            'message' => 'Project successfully created',
            'data' => $project
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
        $project = Project::where('id', $id)->first();        
        if(!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->user;
        $project->category;

        return response()->json([
            $project
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
        $project = Project::where('id', $id)->first();
        if(!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->update($request->all());

        return response()->json([
            'message' => 'Project successfully updated',
            'data' => $project
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
        $project = Project::where('id', $id)->first();
        if(!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project successfully deleted'
        ], 200);
    }
}

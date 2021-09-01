<?php

namespace App\Http\Controllers;

use App\Models\ProjectComments;
use Illuminate\Http\Request;

class ProjectCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectComments  $projectComments
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectComments $projectComments)
    {
        return abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectComments  $projectComments
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectComments $projectComments)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectComments  $projectComments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectComments $projectComments)
    {
        $comment=ProjectComments::findOrfail($request->request_id);
        $comment->update([
            'isShown'=>1,
        ]);
        session()->flash('updated',"le commentaire est affiché");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectComments  $projectComments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $comment=ProjectComments::findOrfail($request->request_id);
        $comment->delete();
        session()->flash('updated',"le commentaire a été supprimé");
        return back();
    }

    public function getComments($project_id){
        $comments=ProjectComments::
        where('project_id',$project_id)
        ->where('isShown',1)
        ->with('UserComment')->get();
        return $comments;
    }

    public function postComment(Request $request){
        $comment= new ProjectComments();
        $comment->client_id=$request->client_id;
        $comment->comment=$request->comment;
        $comment->project_id=$request->project_id;
        $comment->save();

        return response()->json('Votre commentaire a été ajouté ');

    }
}

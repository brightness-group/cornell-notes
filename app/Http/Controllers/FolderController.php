<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderRequest;
use App\Models\Folder;
use App\Models\Note;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $folders = Folder::with('notes')->user()->get();

        return response()->json([
            'data' => $folders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FolderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FolderRequest $request)
    {
        $folder = $request->user()->folders()->create($request->all());
        $folder = $folder->load('notes');

        return response()->json([
            'data' => $folder,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FolderRequest  $request
     * @param  Folder  $folder
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FolderRequest $request, Folder $folder)
    {
        $folder->update($request->all());

        return response()->json([
            'data' => $folder,
            'note' => Note::with('folder')->find($request->note_id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Folder  $folder
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Folder deleted successfully.',
        ]);
    }
}

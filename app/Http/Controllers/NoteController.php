<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Folder;
use App\Models\Note;
use App\Utils\Media;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $folders = Folder::with('notes')->user()->get();

        return view('user.cornell-notes.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NoteRequest $request)
    {
        if (!auth()->user()->isMemoryExceed()) {               
            return response()->json([ 'message' => 'Your memory limit is exceed!!.' ], 203);
        }

        $input = $request->all();
        $folder = '';

        if (! isset($input['folder_id'])) {
            $folder = $request->user()->folders()
                ->updateOrCreate(
                    ['name' => config('diligentnotes.default.folder')],
                    ['name' => config('diligentnotes.default.folder')]
                );

            $input['folder_id'] = $folder->id;
        }

        $note = $request->user()->notes()->create($input);

        return response()->json([
            'data' => $note,
            'folder' => $folder,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Note $note)
    {
        $note->load('folder');
        auth()->user()->update(['last_opened_note' => $note->id]);

        return view('user.cornell-notes.index', compact('note'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NoteRequest $request, Note $note)
    {
        $oldContent = $note->content;

        $beforeUpdateSize = $note->size;

        $note->update($request->all());

        $afterUpdate = $note->size;

        if (!auth()->user()->isMemoryExceed()) {

            if ($afterUpdate > $beforeUpdateSize) {

                $note->update(['content' => $oldContent]);
                return response()->json([ 'message' => 'Your memory limit is exceed!!.' ], 203);
            }
        }

        $note->load('folder');

        return response()->json([
            'data' => $note,
            'message' => 'Note updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully.',
        ]);
    }

    public function search(Request $request)
    {
        $notes = Note::with('folder')->user()->search($request->term)->take(10)->get();

        return response()->json(['data' => $notes]);
    }

    public function uploadImage(Request $request, Note $note)
    {
        if (auth()->user()->isMemoryExceed()) {

            if ($request->hasFile('upload')) {
                $path = Media::upload($request, 'upload', $note->dirPath());

                return response()->json(['url' => asset($path)]);
            }
        } else {
            $message['message'] = ['The image upload failed because the memory limit exceed.'];
            return response()->json(['error' => $message]);
        }
    }

    public function move(Request $request, Note $note)
    {
        $note->update(['folder_id' => $request->folder_id]);
        $note->load('folder');

        return response()->json([
            'success' => true,
            'message' => 'Note moved successfully.',
            'data' => $note,
        ]);
    }

    public function publicNote(Request $request, Note $note)
    {
        $note->load('folder');

        return view('user.cornell-notes.public-note', compact('note'));
    }
}

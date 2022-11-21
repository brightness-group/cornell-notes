<?php

namespace App\Http\Controllers\CP;

use Illuminate\Http\Request;
use App\Models\DemoFolder;
use App\Models\DemoNote;
use App\Http\Requests\NoteRequest;
use App\Http\Requests\FolderRequest;
use App\Utils\Media;
use Auth;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index()
    {
        $note = DemoNote::welcome()->get()->first();

        return redirect( route('statamic.cp.cornell-notes.show', $note->id) );
    }

    public function store(NoteRequest $request, DemoNote $note)
    {
        $input = $request->all();
        $folder = '';

        if ( !isset($input['folder_id']) ) {
            $folder = DemoFolder::updateOrCreate(
                ['name' => config('diligentnotes.default.folder')],
                ['name' => config('diligentnotes.default.folder')]
            );

            $input['folder_id'] = $folder->id;
        }

        $note = $note->create($input);

        return response()->json([
            'data' => $note,
            'folder' => $folder,
        ]);
    }

    public function show(DemoNote $note)
    {
        $note->load('folder');

        return view('admin.cornell-notes.index', compact('note'));
    }


    public function update(NoteRequest $request, DemoNote $note)
    {
        $note->update($request->all());

        $note->load('folder');

        return response()->json([
            'data' => $note,
            'message' => 'Note updated successfully.',
        ]);
    }

    public function destroy(DemoNote $note)
    {
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully.',
        ]);
    }

    public function uploadImage(Request $request, DemoNote $note)
    {
        if ($request->hasFile('upload')) {
            $path = Media::upload($request, 'upload', $note->dirPath());

            return response()->json(['url' => asset($path)]);
        }
    }

    public function folders()
    {
        $folders = DemoFolder::with('notes')->get();

        return response()->json([
            'data' => $folders,
        ]);
    }

    public function storeFolder(FolderRequest $request, DemoFolder $folder)
    {
        $folder = $folder->create($request->all());
        $folder = $folder->load('notes');

        return response()->json([
            'data' => $folder,
        ]);
    }

    public function updateFolder(FolderRequest $request, DemoFolder $folder)
    {
        $folder->update($request->all());

        return response()->json([
            'data' => $folder,
            'note' => DemoNote::with('folder')->find($request->note_id),
        ]);
    }

    public function destroyFolder(DemoFolder $folder)
    {
        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Folder deleted successfully.',
        ]);
    }
}

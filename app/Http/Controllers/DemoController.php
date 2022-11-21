<?php

namespace App\Http\Controllers;

use App\Models\DemoFolder;
use App\Models\DemoNote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        $note = DemoNote::welcome(0)->get()->first();

        return redirect( route('demo.note', $note->id) );
    }

    public function folders(Request $request)
    {
        $folders = DemoFolder::welcome(0)->with('notes')->get();

        return response()->json([
            'data' => $folders,
        ]);
    }

    public function show($id)
    {
        $note = DemoNote::find($id);

        if ($note) {
            $note->load('folder');
        } else {
            $note = new DemoNote();
            $note->title = '';
            $note->folder_id = '';
            $note->content = [['cue' => '', 'note' => '', 'summary' => '']];
            $note->id = $id;
            $note->created_at = Carbon::now()->format('Y-m-d H:i:s');
        }

        return view('user.cornell-notes.demo', compact('note'));
    }

    public function search(Request $request)
    {
        $notes = DemoNote::with('folder')->search($request->term)->take(10)->get();

        return response()->json(['data' => $notes]);
    }
}

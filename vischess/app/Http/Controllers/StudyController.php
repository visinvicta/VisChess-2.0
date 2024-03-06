<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class StudyController extends Controller
{
    public function index()
    {
        $studies = Study::all();
        return view('studies/index')->with('studies', $studies);
    }

    public function create()
    {
        return view('studies/create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        $data['user_id'] = Auth::id();

        try {
            Study::create($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return redirect('/studies')->with('success', 'Study created succesfully');
    }

    public function show($id)
    {
        $study = Study::findOrFail($id);
        $chapters = Chapter::where('study_id', $id)->get();
        $comments = Comment::where('study_id', $id)->get();

        return view('studies.show')
            ->with('study', $study)
            ->with('chapters', $chapters)
            ->with('comments', $comments);
    }
    
    public function update()
    {
    }



    public function getChapterPgn($chapterId)
    {
        $chapter = Chapter::findOrFail($chapterId);
        $pgnData = $chapter->pgn; 
        return response()->json(['pgn' => $pgnData]);
    }

    
}

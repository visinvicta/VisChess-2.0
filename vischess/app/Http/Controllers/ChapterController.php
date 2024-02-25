<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    public function store(Request $request) {
        $requestData = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'pgn' => ['required', 'string'],
            'startingMove' => ['required', 'integer'],
            'study_id' => ['required', 'exists:studies,id'], 

        ]);
            
        $chapter = Chapter::create($requestData);
       
        return response()->json(['message' => 'Chapter created successfully'], 201);
    }
}

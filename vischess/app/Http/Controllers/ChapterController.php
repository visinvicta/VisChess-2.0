<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewChapterRequest;
use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    public function store(StoreNewChapterRequest $request) {
        $validatedRequest = $request->validated();
        Chapter::create($validatedRequest);
       
        return response()->json(['message' => 'Chapter created successfully'], 201);
    }
}

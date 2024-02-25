<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'comment' => ['required', 'string'],
            'move_number' => ['required', 'integer'],
            'study_id' => ['required'],
            'chapter_id'=> ['required'],

        ]);

        $requestData['user_id'] = auth()->id();
        $comment = Comment::create($requestData);

        return response()->json(['message' => 'Comment created successfully'], 201);
    }
}

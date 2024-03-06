<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\StoreNewCommentRequest;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(StoreNewCommentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        Comment::create($validatedData);

        return response()->json(['message' => 'Comment created successfully'], 201);
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            $message = 'Comment deleted successfully';
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
    }
}

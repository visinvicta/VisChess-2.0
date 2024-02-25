<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite; 

class FavoriteController extends Controller
{
    public function store(Request $request) {
        
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'pgn' => ['required', 'string'],
            'whiteplayer' => ['required', 'string'],
            'blackplayer' => ['required', 'string'],
            'result' => ['required', 'string'],
        ]);
   
        try {
            Favorite::create([...$data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }   
        return response()->json(['message' => 'Favorite game saved successfully'], 201);
    }

    public function destroy($id) {
        try {
            $favorite = Favorite::findOrFail($id);
            $favorite->delete();
            $message = 'Favorite game deleted successfully';
        } catch (\Exception $e) {
            $message = 'Favorite game not found';
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
            
        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        } else {
            return redirect('/favorites')->with('success', $message);
        }
    }

    public function index() {
        $user = auth()->user();
        $favorites = $user->favorites;
        return view('favorites/index')->with('favorites', $favorites);
    }
    
    public function show($id) {
        $favorite = Favorite::findOrFail($id);
        return view('favorites/show')->with('favorite', $favorite);
    }
}

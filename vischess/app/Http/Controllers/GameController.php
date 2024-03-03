<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function store(Request $request) {
        
        $data = $request->validate([
            'pgn' => ['required','string'],
            'whiteplayer' => ['required', 'string'],
            'blackplayer' => ['required', 'string'],
            'result' => ['required', 'string'],
        ]);

        $data['user_id'] = auth()->id();
   
        try {
            Game::create([...$data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }   
        return response()->json(['message' => 'Game saved successfully'], 201);
    }

    public function destroy(int $id) { 
        try {
            $game = Game::findOrFail($id);
            $game->delete();
            $message = 'Game deleted successfully';
        } catch (\Exception $e) {
            $message = 'Game not found';
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
            
        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        } else {
            return redirect('/games')->with('success', $message);
        }
    }

    public function show($id) {
        $game = Game::findOrFail($id);
        return view('games/show')->with('game', $game);
    }

    public function index() {
        $games = Game::with('user')->get();        

        return view('games/index')
        ->with('games', $games);
    }
}

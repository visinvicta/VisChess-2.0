<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewFavoriteRequest;
use Illuminate\Http\Request;
use App\Models\Favorite; 
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class FavoriteController extends Controller
{
    public function store(StoreNewFavoriteRequest $request) {
        $request['user_id'] = auth()->id();
        try {
            Favorite::create($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }   
        return response()->json(['message' => 'Favorite game saved successfully'], 201);
    }

    public function destroy(int $id) {
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

    public function index()
{
    $favorites = Auth::user()->favorites()->paginate(8); 
    return view('favorites/index', compact('favorites'));
}
    
    public function show(Favorite $favorite): View {
        return view('favorites/show')->with('favorite', $favorite);
    }
}

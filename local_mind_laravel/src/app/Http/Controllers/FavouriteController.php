<?php

namespace App\Http\Controllers;

use App\Models\Question;

use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $favoriteQuestions = $user->favoriteQuestions()
            ->with('user')        
            ->latest()
            ->get();

        return view('pages.user.favorites', compact('favoriteQuestions'));

    }
    //
    public function setFavourite(Question $question)
    {
        $user = auth()->user();
            
        if ($question->isFavorited()) {
            $user->favoriteQuestions()->detach($question->id);
        } else {
            $user->favoriteQuestions()->attach($question->id);
        }

        return back();
    }
}

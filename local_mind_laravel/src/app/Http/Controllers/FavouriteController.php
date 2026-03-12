<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Question;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $questions = $user->favoriteQuestions()
            ->with('user')
            ->withCount('answers')
            ->latest()
            ->get()
            ->map(function ($question) use ($user) {
                return [
                    'id' => $question->id,
                    'title' => $question->title,
                    'content' => $question->content,
                    'location' => $question->location,
                    'created_at' => $question->created_at,
                    'answers_count' => $question->answers_count,
                    'is_favourited' => true,
                    'is_owner' => $question->user_id === $user->id,
                    'user' => [
                        'id' => $question->user?->id,
                        'name' => $question->user?->name,
                        'email' => $question->user?->email,
                    ],
                ];
            });

        return response()->json(['data' => $questions]);
    }

    public function toggle(Request $request, Question $question)
    {
        $user = $request->user();

        $existing = Favourite::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['is_favourited' => false]);
        }

        Favourite::create([
            'user_id'     => $user->id,
            'question_id' => $question->id,
        ]);

        return response()->json(['is_favourited' => true]);
    }
}

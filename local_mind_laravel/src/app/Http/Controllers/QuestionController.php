<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string|min:10',
            'location'  => 'required|string|max:255',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $question = Question::create([
            'user_id'   => $user->id,
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'location'  => $validated['location'],
            'latitude'  => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'message' => 'Question created successfully!',
            'question' => $question,
        ], 201);
    }

    public function index()
    {
        $questions = Question::with('user')
            ->latest()
            ->paginate(15);

        return response()->json($questions);
    }

    public function show(Question $question)
    {
        return response()->json($question->load(['user', 'answers.user']));
    }


 
}

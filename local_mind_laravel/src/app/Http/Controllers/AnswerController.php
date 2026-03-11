<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class AnswerController extends Controller
{
    //
       public function storeAnswer(Request $request, Question $question)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $answer = $question->answers()->create([
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Answer posted successfully!',
            'answer' => $answer->load('user'),
        ], 201);
    }
}

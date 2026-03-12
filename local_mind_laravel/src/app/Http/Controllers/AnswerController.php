<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

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
     public function answersApi(Request $request)
    {
        $answers = Answer::with(['user', 'question'])
            ->latest()
            ->get()
            ->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'content' => $answer->content,
                    'created_at' => $answer->created_at,
                    'user' => [
                        'id' => $answer->user?->id,
                        'name' => $answer->user?->name,
                        'email' => $answer->user?->email,
                    ],
                    'question' => [
                        'id' => $answer->question?->id,
                        'title' => $answer->question?->title,
                    ],
                ];
            });

        return response()->json(['data' => $answers]);
    }

      public function deleteAnswerApi(Request $request, int $id)
    {

        $answer = Answer::findOrFail($id);
        $answer->delete();

        return response()->json(['message' => 'Answer deleted successfully.']);
    }
}

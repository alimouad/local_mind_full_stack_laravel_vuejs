<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
  

    public function dashboardApi(Request $request)
    {

        $totalQuestions = Question::count();
        $totalAnswers = Answer::count();
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        $recentQuestions = Question::with('user')
            ->withCount('answers')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'title' => $question->title,
                    'content' => $question->content,
                    'created_at' => $question->created_at,
                    'answers_count' => $question->answers_count,
                    'user' => [
                        'id' => $question->user?->id,
                        'name' => $question->user?->name,
                    ],
                ];
            });

        return response()->json([
            'totals' => [
                'questions' => $totalQuestions,
                'answers' => $totalAnswers,
                'new_users' => $newUsers,
            ],
            'recent_questions' => $recentQuestions,
        ]);
    }


  

  

   


}

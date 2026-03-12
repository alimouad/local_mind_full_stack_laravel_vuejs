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

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $questions = Question::with('user')
            ->latest()
            ->paginate(15);

        $questions->getCollection()->transform(function ($question) use ($userId) {
            $question->is_favourited = $question->favoritedBy()->where('user_id', $userId)->exists();
            $question->is_owner = $question->user_id === $userId;
            return $question;
        });

        return response()->json($questions);
    }

    public function show(Request $request, Question $question)
    {
        $userId = $request->user()->id;
        $question->load(['user', 'answers.user']);

        $question->is_favourited = $question->favoritedBy()->where('user_id', $userId)->exists();
        $question->is_owner = $question->user_id === $userId;

        $question->answers->transform(function ($answer) use ($userId) {
            $answer->is_owner = $answer->user_id === $userId;
            return $answer;
        });

        return response()->json($question);
    }

    public function destroy(Request $request, Question $question)
    {
        if ($question->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $question->delete();

        return response()->json(['message' => 'Question deleted successfully.']);
    }
    public function questionsApi(Request $request)
    {
      

        $questions = Question::with('user')
            ->withCount('answers')
            ->latest()
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'title' => $question->title,
                    'content' => $question->content,
                    'location' => $question->location,
                    'created_at' => $question->created_at,
                    'answers_count' => $question->answers_count,
                    'user' => [
                        'id' => $question->user?->id,
                        'name' => $question->user?->name,
                        'email' => $question->user?->email,
                    ],
                ];
            });

        return response()->json(['data' => $questions]);
    }
      public function deleteQuestionApi(Request $request, int $id)
    {

        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully.']);
    }
}

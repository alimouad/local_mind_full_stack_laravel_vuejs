<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $questions =  Question::all();
        return view('pages.user.home', [
            'questions' => $questions
        ]);
    }

    public function questionForm()
    {
        return view('pages.user.add_question');
    }

    public function questionProcess(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        Auth::user()->questions()->create($data);

        return redirect()->route('home')->with('success', 'Question submitted successfully!');
    }

        public function viewQuestion($id)
        {
            $question = Question::with(['user', 'answers.user'])->findOrFail($id);

            return view('pages.user.view_question', compact('question'));
        }

    public function deleteQuestion(Request $request, Question $question)
    {
        Gate::authorize('delete', $question);
        
        $question->delete();
        return redirect()->route('home')
            ->with('success', 'Question deleted successfully!');
    }



    public function addAnswer(Request $request, Question $question)
    {
        $data = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $question->answers()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('question.view', $question->id)
            ->with('success', 'Answer submitted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        // Cards data
        $totalQuestions = Question::count();
        $totalAnswers   = Answer::count();
        $newUsers       = User::where('created_at', '>=', now()->subDays(7))->count();
        $recentQuestions = Question::with('user')
            ->whereDate('created_at', '>=', now()->subDay())
            ->latest()
            ->take(10)
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalQuestions',
            'totalAnswers',
            'newUsers',
            'recentQuestions'
        ));

       
    }
    
    public function getQuestions()
    {
        $questions = Question::all();
        return view('pages.admin.questions', compact('questions'));
    }
    public function getAnswers()
    {
        $answers = Answer::all();
        return view('pages.admin.answers', compact('answers'));
    }

    public function deleteQuestions($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.questions')
            ->with('success', 'Question deleted successfully!');
    }
      public function deleteAnswers($id)
    {
        $question = Answer::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.answers')
            ->with('success', 'Answer deleted successfully!');
    }
      public function getUsers()
    {
        $users = User::all();
        return view('pages.admin.users', compact('users'));
    }

    public function deleteUsers($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }
}

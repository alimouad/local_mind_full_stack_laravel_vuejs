<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class UserController extends Controller
{


    public function usersApi(Request $request)
    {


        $users = User::withCount(['questions', 'answers'])
            ->latest()
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at,
                    'questions_count' => $user->questions_count,
                    'answers_count' => $user->answers_count,
                ];
            });

        return response()->json(['data' => $users]);
    }


    public function deleteUserApi(Request $request, int $id)
    {

        $user = User::findOrFail($id);

        if ($user->role === 'ADMIN') {
            return response()->json(['message' => 'Admin accounts cannot be deleted.'], 422);
        }

        if ($request->user()?->id === $user->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}

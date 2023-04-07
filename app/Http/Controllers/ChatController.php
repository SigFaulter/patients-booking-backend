<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        try {
            $messages = Chat::where('sender_id', $user->id)->firstOrFail()
            ->orWhere('receiver_id', $user->id)
            ->get();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'error' => false,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();

        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string|max:255',
        ]);

        $Chat = new Chat([
            'sender_id' => $user_id,
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['body'],
        ]);

        try {
         $Chat->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
        return response()->json(['Chat' => $Chat], 201);
    }
}

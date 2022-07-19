<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\MessageRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Message::orderBy('created_at', 'desc')->paginate(20),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MessageRequest $request
     * @return JsonResponse
     */
    public function store(MessageRequest $request): JsonResponse
    {
        $message = Message::create([
            'text' => $request->text,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json($message,201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $message = Message::find($id);
        if ( is_null($message) ) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }
        return response()->json($message,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $message = Message::find($id);

        if ( is_null($message) ) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }

        if (auth()->user()->id === $message->user_id) {
            if ( (Carbon::parse($message->created_at)->diffInHours(Carbon::now(),false)) <= 24 ) {
                $message->delete();
                return response()->json('', 204);
            }
            return response()->json(['error' => true, 'message' => 'Forbidden'], 403);
        }
        return response()->json(['error' => true, 'message' => 'Forbidden'], 403);
    }
}

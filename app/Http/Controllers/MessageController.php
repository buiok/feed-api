<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $message = Message::create($request->all());
        return response()->json($message,201);
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function show(Message $message): JsonResponse
    {
        return response()->json($message,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return Response
     */
    public function destroy(Message $message)
    {
        //
    }
}

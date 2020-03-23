<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Comment;
use Tymon\JWTAuth\Exceptions\JWTException;

class CommentController extends Controller
{
    public function index()
    {
        return response()->json(Comment::all(), 200);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment, 200);
    }

    public function store(Request $request)
    {
        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());

        return response()->json($comment, 200);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Article $article)
    {
        return response()->json(CommentResource::collection($article->comments), 200);
    }

    public function show(Comment $comment)
    {
        return response()->json(new CommentResource($comment), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'article_id' => 'required|integer|exists:articles,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'data_validation_failed', "error_list"=>$validator->errors()], 400);
        }

        $article = Article::find($request->get('article_id'));
        $comment = new Comment(['text'=> $request->get('text')]);
        $article->comments()->save($comment);
//        $comment = Comment::create($request->all());
        return response()->json(new CommentResource($comment), 201);
    }

    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'article_id' => 'required|number'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'data_validation_failed', "error_list"=>$validator->errors()], 400);
        }

        $comment->update($request->all());
        return response()->json(new CommentResource($comment), 200);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
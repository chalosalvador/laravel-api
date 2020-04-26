<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Article::class);
        return response()->json(ArticleResource::collection(Article::all()), 200);
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);
        return response()->json(new ArticleResource($article), 200);
    }

    public function image(Article $article)
    {
        return response()->download(public_path('storage/'.$article->image), $article->title. '.jpeg');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'image|dimensions:min_width=200,min_height=200',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'data_validation_failed', "error_list"=>$validator->errors()], 400);
        }

        $article = new Article($request->all());
        $path = $request->image->store('articles', 'public');
//        $path = $request->image->storeAs('public/articles', $request->user()->id . '_' . $article->title . '.' . $request->image->extension());
        $article->image = $path;

        $article->save();

        return response()->json(new ArticleResource($article), 201);
    }

    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'data_validation_failed', "error_list" => $validator->errors()], 400);
        }

        $article->update($request->all());
        return response()->json(new ArticleResource($article), 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
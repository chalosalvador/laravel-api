<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(ArticleResource::collection(Article::all()), 200);
    }

    public function show(Article $article)
    {
        return response()->json(new ArticleResource($article), 200);
    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());
        return response()->json(new ArticleResource($article), 201);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json(new ArticleResource($article), 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $array = json_decode($request->array);
        return response()->json(compact('array'),200);
    }
}

<?php

namespace MWazovzky\Taggable\Http;

use MWazovzky\Taggable\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TagsController extends BaseController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return response($tags, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags,name'
        ]);

        $attributes = [
            'name' => $request->name,
        ];

        // Laravel 5.5. validation
        // $attributes = $request->validate(['name' => 'required|unique:tags,name']);

        $tag = Tag::create($attributes);

        return response($tag, 201);
    }
}

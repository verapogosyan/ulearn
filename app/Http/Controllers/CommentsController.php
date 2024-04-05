<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use Illuminate\Http\Request;

class CommentsController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentCreateRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CommentsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = 'Comment';
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentCreateRequest $request)
    {
        $data = $request->validated();
        $comment = new Comment([
            'content' => $data['content'],
            'rating' => isset($data['rating']) ? $data['rating'] :  null,
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] :  null,
            'user_id' => auth()->user()->id
        ]);

        $commentableType = $data['commentable_type'];

        if ($commentableType === 'user') {
            $commentableModel = App::make(\App\Models\User::class);
            $commentable = $commentableModel::find($data['commentable_id']);
            $commentable->reviews()->save($comment);
        } else {
            $commentableModel = App::make(\App\Models\Course::class);
            $commentable = $commentableModel::find($data['commentable_id']);
            $commentable->comments()->save($comment);
        }

        return $this->response(['message' => 'created'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, string $id)
    {
        //to do
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //to do
    }
}

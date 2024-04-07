<?php

namespace App\Traits;

trait CommentsTrait
{
    public function formCommentsTree($comments)
    {
        $grouped = $comments->groupBy('parent_id')->sortBy('parent_id');
        $firstLevelComments = $grouped->get('');

        return $this->formChildren($firstLevelComments, $grouped);
    }

    public function formChildren($parentComments, $groupedComments)
    {
        $parentComments->each(function ($comment) use ($groupedComments) {
            $comment->children = $groupedComments->get($comment->id) ?? [];
            $groupedComments->forget($comment->id);

            if (count($comment->children) && $groupedComments->count()) {
                $this->formChildren($comment->children, $groupedComments);
            }
        });

        return $parentComments;
    }
}

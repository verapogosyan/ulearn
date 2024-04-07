<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'rating' => "sometimes|integer|min:0|max:5",
            'commentable_type' => 'required|string|in:user,course',
            'commentable_id'  => 'required|exists:' . $this->commentable_type . 's,id',
            'parent_id' => 'sometimes|exists:comments,id'
        ];
    }
}

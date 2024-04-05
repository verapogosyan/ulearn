<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        $found = array_filter($this->author_ids, function ($id) use ($user) {
            return $id == $user->id;
        });

        return (bool) count($found);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'bio'  => 'required|string|max:500',
            'content' => 'required|string',
            'author_ids' => 'required|array',
            'author_ids.*' => 'required|exists:users,id'
        ];
    }
}

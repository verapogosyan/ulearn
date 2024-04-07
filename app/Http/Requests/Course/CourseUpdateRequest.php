<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        $count = Course::where('id', $this->route('course'))->whereHas('authors', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        return (bool) $count;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'bio'  => 'sometimes|string|max:500',
            'content' => 'sometimes|string'
        ];
    }
}

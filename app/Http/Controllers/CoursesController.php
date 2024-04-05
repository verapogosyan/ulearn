<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CoursesListRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CoursesController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->model = 'Course';
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CoursesListRequest $request)
    {
        $searchData = $request->validated();

        if (count($searchData) && $searchData['searchTerm'] && $searchData['searchValue']) {
            $courses = Course::where($searchData['searchTerm'], 'like', '%' . $searchData['searchValue'] . '%')->get();
        } else {
            $courses = Course::all();
        }

        return $this->response($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseCreateRequest $request)
    {
        try {
            $validated = $request->validated();
            $course = Course::create($validated);
            $authors = User::whereIn('id', $validated['author_ids'])->get();

            foreach ($authors as $author) {
                $author->courses()->save($course);
            }

            return $this->response(['message' => 'created', 'data' => $course], 201);
        } catch (Exception $e) {
            return $this->somethingWentWrongResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with('comments')->find($id);

        return $course ? $this->response(['data' => $course], 200) : $this->notFoundResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return $this->notFoundResponse();
        }

        $course->update($request->validated());

        return $this->response(['message' => 'updated', 'data' => $course], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return $this->notFoundResponse();
        }

        $course->delete();

        return $this->response(['message' => 'deleted'], 204);
    }
}

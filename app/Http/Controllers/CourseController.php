<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    //add course
    public function addCourse(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
            'url' => 'required',
            'awardingbody_id' => 'required',
            'resoursetype_id' => 'required',
        ]);

        $course = new Course();
        $course->name = $request->input('name');
        $course->image = $request->input('image');
        $course->url = $request->input('url');
        $course->awardingbody_id = $request->input('awardingbody_id');
        $course->resoursetype_id = $request->input('resoursetype_id');

        $course->save();

        return response()->json(['message' => 'Course Added Successfully']);
    }

    //edit course
    public function editCourse(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
            'url' => 'required',
            'awardingbody_id' => 'required',
            'resoursetype_id' => 'required',
        ]);

        $course = Course::find($id);

        //check if course exists before updating
        if (!isset($course)) {
            return response()->json(['message' => 'No course found'], 404);
        }

        $course->name = $request->input('name');
        $course->image = $request->input('image');
        $course->url = $request->input('url');
        $course->awardingbody_id = $request->input('awardingbody_id');
        $course->resoursetype_id = $request->input('resoursetype_id');

        $course->save();

        return response()->json(['success' => 'Course Updated']);
    }

    //delete course
    public function deleteCourse($id)
    {
        $course = Course::find($id);

        //check if course exists before deleting
        if (!isset($course)) {
            return response()->json(['error' => 'No Course Found'], 404);
        }

        $course->delete();

        return response()->json(['success' => 'Course Deleted']);
    }

    //get all courses
    public function getCourses()
    {
        $courses = Course::all();

        //check if courses exists
        if (!isset($courses)) {
            return response()->json(['error' => 'No Courses Found'], 404);
        }

        return response()->json($courses);
    }

    //get single course
    public function getCourse($id)
    {
        $course = Course::find($id);

        //check if course exists
        if (!isset($course)) {
            return response()->json(['error' => 'No Course Found'], 404);
        }

        return response()->json($course); 
    }
}

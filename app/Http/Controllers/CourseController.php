<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //add course
    public function addCourse(Request $request)
    {
        try {
            //validate the data
            $this->validate($request, [
                'course_name' => 'required',
                'course_image' => 'required',
                'course_url' => 'required',
                'awardingbody_id' => 'required',
                'resourcetype_id' => 'required',
            ]);

            //check if the course already exists
            $course = Course::where('course_name', $request->course_name)->first();
            if ($course) {
                return response()->json(['error' => 'Course already exists'], 401);
            }

            //save the data
            $course = new Course();
            $course->course_name = $request->course_name;
            $course->course_image = $request->course_image;
            $course->course_url = $request->course_url;
            $course->awardingbody_id = $request->awardingbody_id;
            $course->resourcetype_id = $request->resourcetype_id;

            //check if saved
            if ($course->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course added successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Course could not be added',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //edit course
    public function editCourse(Request $request, $id)
    {
        try {
            //validate the data
            $this->validate($request, [
                'course_name' => 'required',
                'course_image' => 'required',
                'course_url' => 'required',
                'awardingbody_id' => 'required',
                'resourcetype_id' => 'required',
            ]);

            $course = Course::find($id);

            //check if course exists before updating
            if (!isset($course)) {
                return response()->json(['message' => 'No course found'], 404);
            }

            //update course
            $course->course_name = $request->course_name;
            $course->course_image = $request->course_image;
            $course->course_url = $request->course_url;
            $course->awardingbody_id = $request->awardingbody_id;
            $course->resourcetype_id = $request->resourcetype_id;

            //check if updated
            if ($course->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Course could not be updated',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete course
    public function deleteCourse($id)
    {
        try {
            //find course
            $course = Course::find($id);

            //check if course exists before deleting
            if (!isset($course)) {
                return response()->json(['error' => 'No Course Found'], 404);
            }

            //delete course
            if ($course->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Course could not be deleted',
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //get all courses
    public function getCourses()
    {
        try {

            //get all courses
            $courses = Course::all();

            //check if courses exists
            if (!isset($courses)) {
                return response()->json(['error' => 'No Courses Found'], 404);
            }

            //return courses
            return response()->json($courses);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get single course
    public function getCourse($id)
    {
        try {
            //find course
            $course = Course::find($id);

            //check if course exists
            if (!isset($course)) {
                return response()->json(['error' => 'No Course Found'], 404);
            }

            //return course
            return response()->json($course);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}

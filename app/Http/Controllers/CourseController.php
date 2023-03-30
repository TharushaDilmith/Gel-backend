<?php

namespace App\Http\Controllers;

use App\Models\AwardingBody;
use App\Models\Brand;
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
                'brand' => 'required',
                'course_type' => 'required',
                'course_link' => 'required',
                'validity' => 'required',
                'awarding_body' => 'required',
            ]);

            //check if the course already exists
            $course = Course::where('course_name', $request->course_name)->first();
            if ($course) {
                return response()->json(['error' => 'Course already exists'], 401);
            }

            //save the data
            $course = new Course();
            $course->course_name = $request->course_name;
            $course->brand = $request->brand;
            $course->course_type = $request->course_type;
            $course->course_link = $request->course_link;
            $course->validity = $request->validity;
            $course->awarding_body = $request->awarding_body;

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
                'brand' => 'required',
                'course_type' => 'required',
                'course_link' => 'required',
                'validity' => 'required',
                'awarding_body' => 'required',
            ]);

            $course = Course::find($id);

            //check if course exists before updating
            if (!isset($course)) {
                return response()->json(['message' => 'No course found'], 404);
            }

            //update course
            $course->course_name = $request->course_name;
            $course->brand = $request->brand;
            $course->course_type = $request->course_type;
            $course->course_link = $request->course_link;
            $course->validity = $request->validity;
            $course->awarding_body = $request->awarding_body;

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


            // add brand name to the course
            $brands = Brand::all();
            foreach ($courses as $course) {
                foreach ($brands as $brand) {
                    if ($course->brand == $brand->id) {
                        $course->brand_name = $brand->name;
                    }
                }
            }

            // add awarding body name to the course
            $awarding_bodies = AwardingBody::all();
            foreach ($courses as $course) {
                foreach ($awarding_bodies as $awarding_body) {
                    if ($course->awarding_body == $awarding_body->id) {
                        $course->awarding_body_name = $awarding_body->awarding_body_name;
                    }
                }
            }

            // set valid if course is valid
            foreach ($courses as $course) {
                if ($course->validity == 1) {
                    $course->valid = 'Valid';
                } else {
                    $course->valid = 'Expired';
                }
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

    //get a deleted course
    public function getDeletedCourse($id)
    {
        try {
            //find course
            $course = Course::withTrashed()->find($id);

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

    //get deleted courses
    public function getAllDeletedCourses()
    {
        try {

            //get all courses
            $courses = Course::onlyTrashed()->get();

            //return courses
            return response()->json($courses);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore course
    public function restoreCourse($id)
    {
        try {
            //find course
            $course = Course::withTrashed()->find($id)->restore();

            //check if course exists
            if (!isset($course)) {
                return response()->json(['error' => 'No Course Found'], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Course restored successfully',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore all courses
    public function restoreAllCourses()
    {
        try {

            //get all courses
            $courses = Course::onlyTrashed()->restore();

            //return courses
            return response()->json([
                'success' => true,
                'message' => 'All courses restored successfully',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete permanently course
    public function deletePermanentlyCourse($id)
    {
        try {
            //find course
            $course = Course::withTrashed()->find($id);

            //check if course exists
            if (!isset($course)) {
                return response()->json(['error' => 'No Course Found'], 404);
            }

            //delete permanently course
            if ($course->forceDelete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course deleted permanently',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Course could not be deleted permanently',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete all courses permanently
    public function deletePermanentlyAllCourses()
    {
        try {

            //get all courses
            $courses = Course::onlyTrashed()->get();

            //delete all courses permanently
            foreach ($courses as $course) {
                $course->forceDelete();
            }

            //return courses
            return response()->json($courses);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get all courses with deleted
    public function getAllCourses()
    {
        try {

            //get all courses
            $courses = Course::withTrashed()->get();

            //return courses
            return response()->json($courses);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

}

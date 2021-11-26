<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    //add resource
    public function addResource(Request $request)
    {
        try {
            //validate the data
            $this->validate($request, [
                'resource_name' => 'required',
                'resource_image' => 'required',
                'resource_url' => 'required',
                'awardingbody_id' => 'required',
                'resourcetype_id' => 'required',
                'course_id' => 'required',
            ]);

            //check if the resource already exists
            $resource = Resources::where('resource_name', $request->resource_name)->first();
            if ($resource) {
                return response()->json(['error' => 'Resource already exists'], 401);
            }

            //save the data
            $resource = new Resources();
            $resource->resource_name = $request->resource_name;
            $resource->resource_image = $request->resource_image;
            $resource->resource_url = $request->resource_url;
            $resource->awardingbody_id = $request->awardingbody_id;
            $resource->resourcetype_id = $request->resourcetype_id;
            $resource->course_id = $request->course_id;

            //check if saved
            if ($resource->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'resource added successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'resource could not be added',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //edit resource
    public function editResource(Request $request, $id)
    {
        try {
            //validate the data
            $this->validate($request, [
                'resource_name' => 'required',
                'resource_image' => 'required',
                'resource_url' => 'required',
                'awardingbody_id' => 'required',
                'resourcetype_id' => 'required',
                'course_id' => 'required',
            ]);

            $resource = Resources::find($id);

            //check if resource exists before updating
            if (!isset($resource)) {
                return response()->json(['message' => 'No resource found'], 404);
            }

            //update resource
            $resource->resource_name = $request->resource_name;
            $resource->resource_image = $request->resource_image;
            $resource->resource_url = $request->resource_url;
            $resource->awardingbody_id = $request->awardingbody_id;
            $resource->resourcetype_id = $request->resourcetype_id;
            $resource->course_id = $request->course_id;

            //check if updated
            if ($resource->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'resource updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'resource could not be updated',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete resource
    public function deleteResource($id)
    {
        try {
            //find resource
            $resource = Resources::find($id);

            //check if resource exists before deleting
            if (!isset($resource)) {
                return response()->json(['error' => 'No resource Found'], 404);
            }

            //delete resource
            if ($resource->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resource deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource could not be deleted',
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //get all resources
    public function getResources()
    {
        try {

            //get all resources
            $resources = Resources::all();

            //check if resources exists
            if (!isset($resources)) {
                return response()->json(['error' => 'No Resources Found'], 404);
            }

            //return resources
            return response()->json($resources);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get single resource
    public function getResource($id)
    {
        try {
            //find resource
            $resource = Resources::find($id);

            //check if resource exists
            if (!isset($resource)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No resource found',
                ], 200);
            }

            //return resource
            return response()->json([
                'success' => true,
                'resource' => $resource,
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}

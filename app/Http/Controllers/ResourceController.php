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

    //get a deleted resource
    public function getDeletedResource($id)
    {
        try {
            //find resource
            $resource = Resources::onlyTrashed()->find($id);

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

    //get all deleted resources
    public function getAllDeletedResources()
    {
        try {

            //get all resources
            $resources = Resources::onlyTrashed()->get();

            //return resources
            return response()->json($resources);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore resource
    public function restoreResource($id)
    {
        try {
            //find resource
            $resource = Resources::onlyTrashed()->find($id)->restore();

            //check if resource exists
            if (!isset($resource)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No resource found',
                ], 200);
            }

            //restore resource

            return response()->json([
                'success' => true,
                'message' => 'Resource restored successfully',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore all resources
    public function restoreAllResources()
    {
        try {

            //restore all resources
            if (Resources::onlyTrashed()->restore()) {
                return response()->json([
                    'success' => true,
                    'message' => 'All resources restored successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'All resources could not be restored',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete resource permanently
    public function deletePermanentlyResource($id)
    {
        try {
            //find resource
            $resource = Resources::onlyTrashed()->find($id);

            //check if resource exists
            if (!isset($resource)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No resource found',
                ], 200);
            }

            //delete resource permanently
            if ($resource->forceDelete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resource deleted permanently',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource could not be deleted permanently',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete all resources permanently
    public function deletePermanentlyAllResources()
    {
        try {

            //delete all resources permanently
            if (Resources::onlyTrashed()->forceDelete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'All resources deleted permanently',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'All resources could not be deleted permanently',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get resources with deleted
    public function getResourcesWithDeleted()
    {
        try {

            //get all resources
            $resources = Resources::withTrashed()->get();

            //return resources
            return response()->json($resources);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

}

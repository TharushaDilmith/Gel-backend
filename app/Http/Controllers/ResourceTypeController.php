<?php

namespace App\Http\Controllers;

use App\Models\ResourceType;
use Illuminate\Http\Request;

class ResourceTypeController extends Controller
{
    //add resource type
    public function addResourceType(Request $request)
    {
        try {

            //validate request
            $this->validate($request, [
                'resource_type_name' => 'required|string|max:255',
            ]);

            //check if resource type already exists
            $resourceType = ResourceType::where('resource_type_name', $request->resource_type_name)->first();

            if ($resourceType) {
                return response()->json([
                    'message' => 'Resource type already exists',
                    'status' => false,
                ], 200);
            }

            //create resource type
            $resource_type = new ResourceType();
            $resource_type->resource_type_name = $request->resource_type_name;
            $resource_type->save();

            //check if resource type was created
            if ($resource_type) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Resource type created successfully',
                    'resource_type' => $resource_type,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error creating resource type',
                ], 500);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //get all resource types
    public function getAllResourceTypes()
    {
        try {
            //get all resource types
            $resource_types = ResourceType::all();

            //check if resource types exist
            if ($resource_types->isEmpty()) {
                return response()->json(['message' => 'No resource types found'], 404);
            }
            //return resource types
            return response()->json($resource_types, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //get resource type by id
    public function getResourceTypeById($id)
    {
        try {
            //get resource type by id
            $resource_type = ResourceType::find($id);

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }
            //return resource type
            return response()->json(['resource_type' => $resource_type], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //update resource type
    public function updateResourceType(Request $request, $id)
    {
        try {
            //validate request
            $this->validate($request, [
                'resource_type_name' => 'required|string|max:255',
            ]);

            //get resource type by id
            $resource_type = ResourceType::find($id);

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }

            $resource_type->resource_type_name = $request->resource_type_name;
            $resource_type->save();

            //check if resource type was updated
            if ($resource_type) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Resource type updated successfully',
                    'resource_type' => $resource_type,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating resource type',
                ], 500);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //delete resource type
    public function deleteResourceType($id)
    {
        try {
            //get resource type by id
            $resource_type = ResourceType::find($id);

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }

            //delete resource type
            $resource_type->delete();

            //return success message
            return response()->json(['message' => 'Resource type deleted successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }
}

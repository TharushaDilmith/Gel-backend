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
                'brand' => 'required|integer',
                'awarding_body' => 'required|integer',
            ]);

            //check if resource type already exists
            $resourceType = ResourceType::
            where('resource_type_name', $request->resource_type_name)
                ->where('brand', $request->brand)
                ->where('awarding_body', $request->awarding_body)
                ->first();

            if ($resourceType) {
                return response()->json([
                    'message' => 'Resource type already exists',
                    'status' => false,
                ], 200);
            }

            //create resource type
            $resource_type = new ResourceType();
            $resource_type->resource_type_name = $request->resource_type_name;
            $resource_type->brand = $request->brand;
            $resource_type->awarding_body = $request->awarding_body;
            $resource_type->validity = $request->validity;
            $resource_type->save();

            //check if resource type was created
            if ($resource_type) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resource type created successfully',
                    'resource_type' => $resource_type,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
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
                return response()->json([
                    'success' => false,
                    'message' => 'Resource type not found'], 200);
            }

            $resource_type->resource_type_name = $request->resource_type_name;
            $resource_type->save();

            //check if resource type was updated
            if ($resource_type) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resource type updated successfully',
                    'resource_type' => $resource_type,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
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
            $resource_type = ResourceType::findOrFail($id);

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }

            //delete resource type
            $resource_type->delete();

            //return success message
            return response()->json([
                'success' => true,
                'message' => 'Resource type deleted successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //get a deleted resource type
    public function getDeletedResourceType($id)
    {
        try {
            //get resource type by id
            $resource_type = ResourceType::onlyTrashed()->find($id);

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

    //get deleted resource types
    public function getAllDeletedResourceTypes()
    {
        try {
            //get all deleted resource types
            $resource_types = ResourceType::onlyTrashed()->get();

            //check if resource types exist
            if (!$resource_types) {
                return response()->json(['message' => 'No deleted resource types found'], 404);
            }

            //return resource types
            return response()->json($resource_types);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //restore resource type
    public function restoreResourceType($id)
    {
        try {
            //get resource type by id
            $resource_type = ResourceType::onlyTrashed()->findOrFail($id)->restore();

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }

            //return success message
            return response()->json([
                'success' => true,
                'message' => 'Resource type restored successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //restore all resource types
    public function restoreAllResourceTypes()
    {
        try {
            //restore all resource types
            ResourceType::onlyTrashed()->restore();

            //return success message
            return response()->json([
                'success' => true,
                'message' => 'All resource types restored successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //delete resource type permanently

    public function deleteResourceTypePermanently($id)
    {
        try {
            //get resource type by id
            $resource_type = ResourceType::onlyTrashed()->findOrFail($id);

            //check if resource type exist
            if (!$resource_type) {
                return response()->json(['message' => 'Resource type not found'], 404);
            }

            //delete resource type permanently
            $resource_type->forceDelete();

            //return success message
            return response()->json([
                'success' => true,
                'message' => 'Resource type deleted permanently'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    //delete all resource types permanently
    public function deleteAllResourceTypesPermanently()
    {
        try {
            //delete all resource types permanently
            ResourceType::onlyTrashed()->forceDelete();

            //return success message
            return response()->json([
                'success' => true,
                'message' => 'All resource types deleted permanently'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

}

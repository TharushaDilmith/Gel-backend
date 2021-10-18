<?php

namespace App\Http\Controllers;

use App\Models\AwardingBody;
use Illuminate\Http\Request;

class ResourceTypeController extends Controller
{
    //add resource type
    public function addResourceType(Request $request)
    {
        $this->validate($request, [
            'resource_type' => 'required|string|max:255',
        ]);

        $resource_type = new ResourceType();
        $resource_type->resource_type = $request->resource_type;
        $resource_type->save();

        return response()->json(['message' => 'Resource type added successfully'], 200);
    }

    //get all resource types
    public function getAllResourceTypes()
    {
        $resource_types = ResourceType::all();

        //check if resource types exist
        if ($resource_types->isEmpty()) {
            return response()->json(['message' => 'No resource types found'], 404);
        }

        return response()->json(['resource_types' => $resource_types], 200);
    }

    //get resource type by id
    public function getResourceTypeById($id)
    {
        $resource_type = ResourceType::find($id);

        //check if resource type exist
        if (!$resource_type) {
            return response()->json(['message' => 'Resource type not found'], 404);
        }

        return response()->json(['resource_type' => $resource_type], 200);
    }

    //update resource type
    public function updateResourceType(Request $request, $id)
    {
        $this->validate($request, [
            'resource_type' => 'required|string|max:255',
        ]);

        $resource_type = ResourceType::find($id);

        //check if resource type exist
        if (!$resource_type) {
            return response()->json(['message' => 'Resource type not found'], 404);
        }

        $resource_type->resource_type = $request->resource_type;
        $resource_type->save();

        return response()->json(['message' => 'Resource type updated successfully'], 200);
    }

    //delete resource type
    public function deleteResourceType($id)
    {
        $resource_type = ResourceType::find($id);

        //check if resource type exist
        if (!$resource_type) {
            return response()->json(['message' => 'Resource type not found'], 404);
        }

        $resource_type->delete();

        return response()->json(['message' => 'Resource type deleted successfully'], 200);
    }
}

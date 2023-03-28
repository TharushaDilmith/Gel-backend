<?php

namespace App\Http\Controllers;

use App\Models\ResourceName;
use Illuminate\Http\Request;

class ResourceNameController extends Controller
{
    // get all resource names
    public function getAllResourceNames()
    {
        try {
            // get all resource names
            $resource_names = ResourceName::all();

            // return response
            return response()->json(['success' => true, 'resource_names' => $resource_names]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // add a resource name
    public function addResourceName(Request $request)
    {
        try {
            // validate request
            $request->validate([
                'name' => 'required|string',
            ]);

            // create resource name
            $resource_name = ResourceName::create([
                'name' => $request->name,
            ]);

            // return response
            return response()->json(['success' => true, 'resource_name' => $resource_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // update a resource name
    public function updateResourceName(Request $request, $id)
    {
        try {
            // validate request
            $request->validate([
                'name' => 'required|string',
            ]);

            // get resource name
            $resource_name = ResourceName::find($id);

            // update resource name
            $resource_name->update([
                'name' => $request->name,
            ]);

            // return response
            return response()->json(['success' => true, 'resource_name' => $resource_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

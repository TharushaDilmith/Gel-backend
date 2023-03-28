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

    // delete a resource name
    public function deleteResourceName($id)
    {
        try {
            // get resource name
            $resource_name = ResourceName::find($id);

            // delete resource name
            $resource_name->delete();

            // return response
            return response()->json(['success' => true, 'resource_name' => $resource_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // get all deleted resource names
    public function getAllDeletedResourceNames()
    {
        try {
            // get all deleted resource names
            $resource_names = ResourceName::onlyTrashed()->get();

            // return response
            return response()->json(['success' => true, 'resource_names' => $resource_names]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // restore a deleted resource name
    public function restoreResourceName($id)
    {
        try {
            // get deleted resource name
            $resource_name = ResourceName::onlyTrashed()->find($id);

            // restore resource name
            $resource_name->restore();

            // return response
            return response()->json(['success' => true, 'resource_name' => $resource_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // restore all deleted resource names
    public function restoreAllResourceNames()
    {
        try {
            // get all deleted resource names
            $resource_names = ResourceName::onlyTrashed()->get();

            // restore all deleted resource names
            foreach ($resource_names as $resource_name) {
                $resource_name->restore();
            }

            // return response
            return response()->json(['success' => true, 'resource_names' => $resource_names]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // permanently delete a resource name
    public function permanentlyDeleteResourceName($id)
    {
        try {
            // get deleted resource name
            $resource_name = ResourceName::onlyTrashed()->find($id);

            // permanently delete resource name
            $resource_name->forceDelete();

            // return response
            return response()->json(['success' => true, 'resource_name' => $resource_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

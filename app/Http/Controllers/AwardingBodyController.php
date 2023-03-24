<?php

namespace App\Http\Controllers;

use App\Models\AwardingBody;
use App\Models\Brand;
use Illuminate\Http\Request;

class AwardingBodyController extends Controller
{
    //add AwardingBody
    public function addAwardingBody(Request $request)
    {
        try {

            //validate incoming request
            $this->validate($request, [
                'awarding_body_name' => 'required|string',
                'brand' => 'required|integer',
            ]);

            //check if AwardingBody already exists
            $awarding_body = AwardingBody::where('awarding_body_name', $request->awarding_body_name)->where('brand', $request->brand)->first();
            if ($awarding_body) {
                return response()->json(['error' => 'AwardingBody already exists'], 401);
            }

            //create AwardingBody
            $awardingBody = new AwardingBody();
            $awardingBody->awarding_body_name = $request->awarding_body_name;
            $awardingBody->brand = $request->brand;

            //save AwardingBody
            $awardingBody->save();

            //check if saved
            if ($awardingBody->wasRecentlyCreated) {
                return response()->json(['success' => true, 'message' => 'Awarding Body Added Successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Awarding Body Could Not Be Added']);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get all awarding bodies
    public function getAllAwardingBodies()
    {
        try {
            //get all AwardingBodies
            $awarding_bodies = AwardingBody::all();

            // get all brands
            $brands = Brand::all();

            // add brand name to awarding body
            foreach ($awarding_bodies as $awarding_body) {
                foreach ($brands as $brand) {
                    if ($awarding_body->brand == $brand->id) {
                        $awarding_body->brand_name = $brand->name;
                    }
                }
            }


            //return all awarding bodies
            return response()->json($awarding_bodies, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get an awarding body
    public function getAwardingBody($id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::find($id);

            // add brand name to awarding body
            $brand = Brand::find($awarding_body->brand);
            $awarding_body->brand_name = $brand->name;

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }
            //return the awarding body
            return response()->json($awarding_body, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //update an awarding body
    public function updateAwardingBody(Request $request, $id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::find($id);

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }

            //update the awarding body
            $awarding_body->update($request->all());

            //return the updated awarding body
            return response()->json(['success' => true, 'message' => 'Awarding Body Updated Successfully']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete an awarding body
    public function deleteAwardingBody($id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::find($id);

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }

            //delete the awarding body
            $awarding_body->delete();

            //return the deleted awarding body
            return response()->json(['success' => true, 'message' => 'Awarding Body Deleted Successfully']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get a deleted awarding body
    public function getDeletedAwardingBody($id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::onlyTrashed()->find($id);

            // add brand name to awarding body
            $brand = Brand::find($awarding_body->brand);
            $awarding_body->brand_name = $brand->name;

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }
            //return the deleted awarding body
            return response()->json($awarding_body, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //get deleted awarding bodies
    public function getAllDeletedAwardingBodies()
    {
        try {
            //get all deleted AwardingBodies
            $awarding_bodies = AwardingBody::onlyTrashed()->get();

            // get all brands
            $brands = Brand::all();

            // add brand name to awarding body
            foreach ($awarding_bodies as $awarding_body) {
                foreach ($brands as $brand) {
                    if ($awarding_body->brand == $brand->id) {
                        $awarding_body->brand_name = $brand->name;
                    }
                }
            }

            //return all deleted awarding bodies
            return response()->json($awarding_bodies, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore an awarding body
    public function restoreAwardingBody($id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::onlyTrashed()->find($id)->restore();

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }

            //return the restored awarding body
            return response()->json(['success' => true, 'message' => 'Awarding Body Restored Successfully']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //restore all deleted awarding bodies
    public function restoreAllDeletedAwardingBodies()
    {
        try {
            //get all deleted AwardingBodies
            $awarding_bodies = AwardingBody::onlyTrashed()->restore();


            //return all deleted awarding bodies
            return response()->json(['success' => true, 'message' => 'All Awarding Bodies Restored Successfully']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete an awarding body permanently
    public function deleteAwardingBodyPermanently($id)
    {
        try {
            //get an AwardingBody
            $awarding_body = AwardingBody::onlyTrashed()->find($id);

            //check if awarding body exists
            if (is_null($awarding_body)) {
                return response()->json(["message" => "Awarding Body with id $id not found"], 404);
            }

            //delete the awarding body permanently
            $awarding_body->forceDelete();

            //return the deleted awarding body
            return response()->json(['success' => true, 'message' => 'Awarding Body Deleted Permanently']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //delete all deleted awarding bodies permanently
    public function deleteAllDeletedAwardingBodiesPermanently()
    {
        try {
            //get all deleted AwardingBodies
            $awarding_bodies = AwardingBody::onlyTrashed()->get();

            //delete all deleted awarding bodies permanently
            $awarding_bodies->forceDelete();

            //return all deleted awarding bodies
            return response()->json(['success' => true, 'message' => 'All Awarding Bodies Deleted Permanently']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

}

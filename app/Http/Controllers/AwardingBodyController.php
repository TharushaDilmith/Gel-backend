<?php

namespace App\Http\Controllers;

use App\Models\AwardingBody;
use Illuminate\Http\Request;

class AwardingBodyController extends Controller
{
    //add AwardingBody
    public function addAwardingBody(Request $request)
    {
        try {

            //validate incoming request
            $this->validate($request, [
                'awarding_body_name' => 'required',
            ]);

            //check if AwardingBody already exists
            $awarding_body = AwardingBody::where('awarding_body_name', $request->awarding_body_name)->first();
            if ($awarding_body) {
                return response()->json(['error' => 'AwardingBody already exists'], 401);
            }

            //create AwardingBody
            $awardingBody = new AwardingBody();
            $awardingBody->awarding_body_name = $request->awarding_body_name;

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

            //check if there are any awarding bodies
            if (count($awarding_bodies) == 0) {
                return response()->json(['message' => 'No Awarding Bodies Found'], 404);
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
}

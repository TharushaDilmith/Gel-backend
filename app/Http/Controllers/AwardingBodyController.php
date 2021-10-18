<?php

namespace App\Http\Controllers;

use App\Models\AwardingBody;
use Illuminate\Http\Request;

class AwardingBodyController extends Controller
{
    //add AwardingBody
    public function addAwardingBody(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);

        $awardingBody = new AwardingBody();
        $awardingBody->name = $request->name;

        $awardingBody->save();

        return response()->json(['success' => 'Awarding Body Added Successfully']);
    }

    //get all awarding bodies
    public function getAllAwardingBodies()
    {
        $awarding_bodies = AwardingBody::all();

        //check if there are any awarding bodies
        if (count($awarding_bodies) == 0) {
            return response()->json(['message' => 'No Awarding Bodies Found'], 404);
        }

        return response()->json($awarding_bodies, 200);
    }

    //get an awarding body
    public function getAwardingBody($id)
    {
        $awarding_body = AwardingBody::find($id);

        //check if awarding body exists
        if (is_null($awarding_body)) {
            return response()->json(["message" => "Awarding Body with id $id not found"], 404);
        }

        return response()->json($awarding_body, 200);
    }

    //update an awarding body
    public function updateAwardingBody(Request $request, $id)
    {
        $awarding_body = AwardingBody::find($id);

        //check if awarding body exists
        if (is_null($awarding_body)) {
            return response()->json(["message" => "Awarding Body with id $id not found"], 404);
        }

        $awarding_body->update($request->all());

        return response()->json($awarding_body, 200);
    }

    //delete an awarding body
    public function deleteAwardingBody($id)
    {
        $awarding_body = AwardingBody::find($id);

        //check if awarding body exists
        if (is_null($awarding_body)) {
            return response()->json(["message" => "Awarding Body with id $id not found"], 404);
        }

        $awarding_body->delete();

        return response()->json(null, 204);
    }
}

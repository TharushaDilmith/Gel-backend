<?php

namespace App\Http\Controllers;

use App\Models\brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // get all brands
            $brands = Brand::all();
            return response()->json([
                'success' => true,
                'message' => 'All Brands Successfully Fetched',
                'data' => $brands,
            ], 200);
        }catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            // save brand with backend validation
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'success' => false], 200);
            }

            //check whether brand exists by name
            $brand = brand::where('name', $request->name)->first();
            if ($brand) {
                return response()->json(['message' => 'Brand already exists','success' => false], 200);
            }

            $brand = brand::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Brand Successfully Created',
                'data' => $brand,
            ], 200);
        }catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //update brand
    public function update(Request $request, $id)
    {
        try {
            // update brand with backend validation
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'status' => false], 200);
            }

            //check whether brand exists by name
            $brand = brand::where('name', $request->name)->first();
            if ($brand) {
                return response()->json(['message' => 'Brand already exists','success' => false,], 200);
            }

            $brand = brand::find($id);
            $brand->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Brand Successfully Updated',
                'data' => $brand,
            ], 200);
        }catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // delete brand
    public function delete($id)
    {
        try {
            $brand = brand::find($id);
            $brand->delete();
            return response()->json([
                'success' => true,
                'message' => 'Brand Successfully Deleted',
            ], 200);
        }catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //get deleted awarding bodies
    public function getAllDeletedBrands()
    {
        try {
            //get all deleted AwardingBodies
            $brands = Brand::onlyTrashed()->get();

            //return all deleted awarding bodies
            return response()->json($brands, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}

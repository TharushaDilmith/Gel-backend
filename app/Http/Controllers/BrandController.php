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
        // get all brands
        $brands = Brand::all();
        return response()->json([
            'success' => true,
            'message' => 'All Brands Successfully Fetched',
            'data' => $brands,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // save brand with backend validation
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false], 200);
        }
        $brand = brand::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Brand Successfully Created',
            'data' => $brand,
        ], 200);
    }

    //update brand
    public function update(Request $request, $id)
    {
        // update brand with backend validation
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false], 200);
        }
        $brand = brand::find($id);
        $brand->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Brand Successfully Updated',
            'data' => $brand,
        ], 200);
    }
}

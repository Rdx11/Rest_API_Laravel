<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Santri;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Santri as SantriResource;

class SantriController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $santris = Santri::all();
    
        return $this->sendResponse(SantriResource::collection($santris), 'santris retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nama' => 'required',
            'alamat' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $santri = Santri::create($input);
   
        return $this->sendResponse(new SantriResource($santri), 'Santri created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $santri = Santri::find($id);
  
        if (is_null($santri)) {
            return $this->sendError('Santri not found.');
        }
   
        return $this->sendResponse(new SantriResource($santri), 'Santri retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Santri $santri)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nama' => 'required',
            'alamat' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $santri->name = $input['nama'];
        $santri->detail = $input['alamat'];
        $santri->save();
   
        return $this->sendResponse(new SantriResource($santri), 'Santri updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Santri $santri)
    {
        $santri->delete();
   
        return $this->sendResponse([], 'santri deleted successfully.');
    }
}

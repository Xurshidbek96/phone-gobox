<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\ManagerResource as ManagerResource;

class ManagerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = Manager::all();
        return $this->sendResponse(ManagerResource::collection($manager), 'Manager fetched.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors();       
        }
   
        else
        {
            $manager = Manager::create($request->all());
            
            return $this->sendResponse(new ManagerResource($manager), 'Manager created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manager = Manager::find($id);

        if ($manager)
            return $this->sendResponse(new ManagerResource($manager), 'Manager fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $manager = Manager::find($id)->update($request->all());
        
        return $this->sendResponse($manager, 'Manager updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manager = Manager::where('id', $id)->delete();
        return $this->sendResponse([], 'Manager deleted.');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\BillingResource as BillingResource;

class BillingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing = Billing::all();
        return $this->sendResponse(BillingResource::collection($billing), 'Billing fetched.');
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
            'type' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
   
        else
        {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $billing = Billing::create($input);
            
            return $this->sendResponse(new BillingResource($billing), 'Billing created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::find($id);

        if ($billing)
            return $this->sendResponse(new BillingResource($billing), 'Billing fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $billing = Billing::find($id)->update($request->all());
        
        return $this->sendResponse($billing, 'Billing updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $billing = Billing::where('id', $id)->delete();
        return $this->sendResponse([], 'Billing deleted.');
    }
}

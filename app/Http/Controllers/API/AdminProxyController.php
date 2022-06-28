<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proxy;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProxyResource as ProxyResource;

class AdminProxyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proxy = Proxy::all();
        return $this->sendResponse(ProxyResource::collection($proxy), 'Proxy fetched.');
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
            'list_number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
   
        else
        {
            $serach_result = Proxy::where('ip', $request->ip)->count();

            if($serach_result >= 1)
                return (' Такой IP Proxy в базе уже есть ! '. $request->ip);

            $request->validate([
                'list_number' => 'required',
            ]);
            

            Proxy::create($request->all());

            return 'Proxy успешно создан!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proxy = Proxy::find($id);

        if ($proxy)
            return $this->sendResponse(new ProxyResource($proxy), 'Proxy fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $proxy = Proxy::find($id)->update($request->all());
        
        return $this->sendResponse($proxy, 'Proxy updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proxy = Proxy::where('id', $id)->delete();
        return $this->sendResponse([], 'Proxy deleted.');
    }
}

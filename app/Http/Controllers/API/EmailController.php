<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\EmailResource as EmailResource;

class EmailController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = Email::all();
        return $this->sendResponse(EmailResource::collection($email), 'Email fetched.');
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
            'email' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
   
        else
        {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $email = Email::create($input);
            
            return $this->sendResponse(new EmailResource($email), 'Email created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Email::find($id);

        if ($email)
            return $this->sendResponse(new EmailResource($email), 'Email fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $email = Email::find($id)->update($request->all());
        
        return $this->sendResponse($email, 'Email updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = Email::where('id', $id)->delete();
        return $this->sendResponse([], 'Email deleted.');
    }
}

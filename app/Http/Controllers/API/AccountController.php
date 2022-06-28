<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\AccountResource as AccountResource;

class AccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::where('user_id', Auth::user()->id)->get();
        return $this->sendResponse(AccountResource::collection($account), 'Account fetched.');
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
            'account' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors();       
        }
   
        else
        {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $account = Account::create($input);
            
            return $this->sendResponse(new AccountResource($account), 'Account created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::find($id);

        if ($account)
            return $this->sendResponse(new AccountResource($account), 'Account fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $account = Account::find($id)->update($request->all());
        
        return $this->sendResponse($account, 'Account updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::where('id', $id)->delete();
        return $this->sendResponse([], 'Account deleted.');
    }
}

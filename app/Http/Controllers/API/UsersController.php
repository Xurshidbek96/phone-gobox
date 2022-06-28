<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource as UserResource;

class UsersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return $this->sendResponse(UserResource::collection($user), 'User fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'manager_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors();       
        }
   
        else
        {
            $input = $request->all();
            $input['api_token'] = Str::random(60);
            $input['password'] = Hash::make($request->password);
           
            $user = User::create($input);
            
            return $this->sendResponse(new UserResource($user), 'User created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user)
            return $this->sendResponse(new UserResource($user), 'User fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // return $request->manager_id;

        $input = $request->all();
        
        // $input['manager_id'] = $request->manager_id;
        

        $user = User::find($id)->update($input);
        
        return $this->sendResponse($user, 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->delete();
        return $this->sendResponse([], 'User deleted.');
    }
}

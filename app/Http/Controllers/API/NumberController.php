<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Number;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Resources\NumberResource as NumberResource;

class NumberController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $select_number_user = DB::table('number_selects')
        ->where('user_id', $user->id)
        ->get();

        $result_array = [];

        foreach($select_number_user as $resp){
            $result_array[] = $resp->list_number;
        }

        $number = Number::whereIn('number', $result_array)
         ->whereIn('icon', ['Facebook','Google','TikTok', 'Faceboo', 'Rental', 'Verify'])
        ->orderBy('id', 'desc')->get();

        // return $number;
        return $this->sendResponse(NumberResource::collection($number), 'Number fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user=\Auth::user();

        $serach_result = DB::table('number_selects')->where('status', 0)->count();

        if($serach_result > 0) {
       
        $select_number_user = DB::table('number_selects')
                     ->where(['status' => 0, 'country' => $request->country])
                     ->limit(1)
                     ->get();
 
        if($select_number_user->count() == 0) 
            return ('Соединенные Штаты Америки - Номер закончилься :)!');                
                     
                
        $serach_result_numbers = DB::table('number_selects')->where('country', $request->country)->count();
            if($serach_result_numbers == 0) {
                  DB::table('number_selects')
                  ->where('list_number', $select_number_user[0]->list_number)
                  ->update(['user_id' => $user->id, 'status' => 1]);
            } 
              else
            {
                  DB::table('number_selects')
                  ->where('list_number', $select_number_user[0]->list_number)
                  ->update(['user_id' => $user->id, 'status' => 1, 'country' => $request->country]);
        }



        
        return ('Номер успешно добавлен ! - ' .$select_number_user[0]->list_number);
        } 
        else 
        {
            return ('Номер закончилься :)!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $number = Number::find($id);

        if ($number)
            return $this->sendResponse(new NumberResource($number), 'Post fetched.');

        else
            return 'No Content';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $number = Number::find($id)->update($request->all());
        
        return $this->sendResponse($number, 'Number updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $number = Number::where('id', $id)->delete();
        return $this->sendResponse([], 'Number deleted.');
    }
}

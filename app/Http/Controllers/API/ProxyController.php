<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proxy;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\ProxyResource as ProxyResource;

class ProxyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $select_number_user = Proxy::where('user_id', $user->id)
        ->get();

        $result_array = [];

        foreach($select_number_user as $resp){
            $result_array[] = $resp->user_id;
        }

        $proxy = Proxy::whereIn('user_id', $result_array)
        ->orderBy('id', 'desc')->get();

        return $this->sendResponse(ProxyResource::collection($proxy), 'Proxy fetched.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proxy_city(Request $request)
    {
        
    //   return $request->idusers; // idusers

        // https://api.g-obox.ru/api/connect/new/b91bfcba32234c13a1289a52206ef1ba/SHV
    /*
    $arrContextOptions=array(
       "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
       ),
     );  

    $response = file_get_contents("https://api.g-obox.ru/api/connect/new/".$request->uuid."/".$request->region, false, stream_context_create($arrContextOptions));
    $array = json_decode($response);
    $dataUsers = $array->result;
    */
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, "https://api.g-obox.ru/api/connect/new/".$request->uuid."/".$request->region);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like        Gecko) Chrome/0.A.B.C Safari/525.13");
        $data = curl_exec($ch);
        curl_close($ch);
        
        $manage = json_decode($data, true);
        $itemserror =  isset($manage['data']['result']) ? : 'error';    


/*
    if($manage['message'] ?? null != 'document error'){
        return $manage;
        //  return back()->with('success', 'Proxy сервер не доступен');
    }else {
         return $manage;
       //  return back()->with('success', 'Успешно измененно');
    }
 */   
 
     if($itemserror === 'error'){
         return('Сеть перегружена 📡 '. $request->region);
     }
     
    $items = $manage['data']['result'];  
    
    $user=\Auth::user();
    
       $serach_result = Proxy::where('ip', $items['ip'])->count();
       if($serach_result == 0) {
     //  DB::table('proxys')->where('id', $request->idusers)->delete();
                DB::table('proxies')
                ->where('user_id', $request->idusers)
                ->update(array(
                    'user_id' => $user->id,
                    'uuid' => $items['uuid'],
                    'list_number' => '9000',
                    'name' => $items['name'],
                    'location_id' => $items['location_id'],
                    'region' => $items['location_id'],
                    'login' => $items['username'],
                    'password' => $items['password'],
                    'ip_port' => $items['port'],
                    'ip' => $items['ip'],
                    'status' => 1,
                    'cros' => 1
                ));  
                
$geo_prox = "";
switch ($items['location_id']) {
    case 'SAN':
        $geo_prox = "San Diego, CA";
        break;
    case 'PHX':
        $geo_prox = "Phoenix, AZ";
        break;
    case 'MKE':
        $geo_prox = "Milwaukee, WI";
        break;
    case 'DFW':
        $geo_prox = "Dallas-Fort Worth, TX";
        break;
    case 'NYC':
        $geo_prox = "New York, NY";
        break;
    case 'LAX':
        $geo_prox = "Los Angeles County, CA";
        break;
    case 'SEA':
        $geo_prox = "Seattle, WA";
        break;
    case 'MIA':
        $geo_prox = "Miami/Orlando, FL";
        break;
    case 'PHL':
        $geo_prox = "Philadelphia, PA";
        break;
    case 'DEN':
        $geo_prox = "Denver, CO";
        break;
    case 'HOU':
        $geo_prox = "Houston, TX";
        break;
    case 'BNA':
        $geo_prox = "Nashville, TN";
        break;
    case 'BUF':
        $geo_prox = "Buffalo, NY";
        break;
    case 'CLT':
        $geo_prox = "Charlotte, NC";
        break;
    case 'DTW':
        $geo_prox = "Detroit, MI";
        break;
    case 'ATL':
        $geo_prox = "Atlanta, GA";
        break;
    case 'ORF':
        $geo_prox = "Norfolk, VA";
        break;
    case 'CMH':
        $geo_prox = "Columbus, OH";
        break;
    case 'IND':
        $geo_prox = "Indianapolis, IN";
        break;
    case 'BHM':
        $geo_prox = "Birmingham, AL";
        break;
    case 'SAT':
        $geo_prox = "San Antonio, TX";
        break;
    case 'SJC':
        $geo_prox = "San Jose, CA";
        break;
    case 'PDX':
        $geo_prox = "Portland, OR";
        break;
    case 'LAS':
        $geo_prox = "Las Vegas, NV";
        break;
    case 'JAX':
        $geo_prox = "Jacksonville, FL";
        break;
    case 'LAXA':
        $geo_prox = "Los Angeles, CA (AT&T)";
        break;
    case 'NYCA':
        $geo_prox = "New York, NY (AT&T)";
        break;
    case 'ORDA':
        $geo_prox = "Chicago, IL (AT&T)";
        break;
    case 'SFOA':
        $geo_prox = "San Francisco, CA (AT&T)";
        break;
    case 'STL':
        $geo_prox = "St. Louis, MO";
        break;
    case 'MCI':
        $geo_prox = "Kansas City, KS";
        break;
    case 'HNL':
        $geo_prox = "Honolulu, HI";
        break;
    case 'SLC':
        $geo_prox = "Salt Lake City, UT";
        break;
    case 'ABQ':
        $geo_prox = "Albuquerque, NM";
        break;
    case 'IDA':
        $geo_prox = "Idaho Falls, ID";
        break;
    case 'BDL':
        $geo_prox = "Hartford, CT";
        break;
    case 'HSV':
        $geo_prox = "Huntsville, AL";
        break;
    case 'BOS':
        $geo_prox = "Boston, MA";
        break;
    case 'MSP':
        $geo_prox = "Minneapolis, MN";
        break;
    case 'BWI':
        $geo_prox = "Baltimore, MD";
        break;
    case 'EWR':
        $geo_prox = "Newark, NJ";
        break;
    case 'PWM':
        $geo_prox = "Portland, ME";
        break;
    case 'OMA':
        $geo_prox = "Omaha, NE";
        break;
    case 'SHV':
        $geo_prox = "Shreveport, LA";
        break;
    case 'BIL':
        $geo_prox = "Billings, MT";
        break;
    case 'LIT':
        $geo_prox = "Littlerock, AR";
        break;
    case 'JAN':
        $geo_prox = "Jackson, MS";
        break;
    case 'DSM':
        $geo_prox = "Des Moines, IA";
        break;
     default:
        $geo_prox = "------";
        break;
};

                DB::table('users')
                  ->where('id', $user->id)
                  ->update(['geo_proxy' => $geo_prox]);
                
                     
               $user = DB::table('proxies')
                ->where('user_id', $request->idusers)->get();
                
                if(isset($user[0]->user_id)) {
                  DB::table('proxies')
                     ->where('user_id', $request->idusers)
                     ->update(['rotation_count' => $user[0]->rotation_count + 1]);
                }
    }

 
        return ('Вниамния ! Смена города занимет примерно 6-7 минут. Идет презапсук сервера не нажимате повторно кнопку Сменить. ✅ '. $items['ip']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            // $input = $request->all();
            // $input['user_id'] = Auth::user()->id;
            

            $user=\Auth::user();

            $serach_result = Proxy::where('status', 0)->where('region', $request->region)->count();
            // return $serach_result;
    
            if($serach_result > 0) {
        
            $select_number_user = Proxy::where('status', 0)
                         ->where('region', $request->region)
                         ->limit(1)
                         ->get();
    
            Proxy::where('ip', $select_number_user[0]->ip)
            ->update(['user_id' => $user->id, 'status' => 1, 'list_number' => '9000']);
    
            return ('Proxy успешно добавлен ! - ' .$select_number_user[0]->ip);
    
            } 
            else 
            {
                return 'Proxy закончилься :)!';
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
        // $proxy = Proxy::find($id);

        // if ($proxy)
        //     return $this->sendResponse(new ProxyResource($proxy), 'Proxy fetched.');

        // else
        //     return 'No Content';
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
        // $proxy = Proxy::find($id)->update($request->all());
        
        // return $this->sendResponse($proxy, 'Proxy updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $proxy = Proxy::where('id', $id)->delete();
        // return $this->sendResponse([], 'Proxy deleted.');
    }
}

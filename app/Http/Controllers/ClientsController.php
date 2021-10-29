<?php

namespace App\Http\Controllers;

// use App\Http\Helpers\Common;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ClientsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
       
        $clientMethod = new Client;
       $searchQuery['status'] = 1;
        $data = $clientMethod->searchClientCommon($searchQuery);
        $arrCompanyIds = [];
        $clients = $data['clients'];
        if ($clients->count() > 0) {
            foreach ($clients as $client) {
                $arrCompanyIds[] = $client->id;                
            }
        }
        
        $arrColumns = [
            'company_id',            
             DB::raw('count(DISTINCT(url)) as total_responded'),
        ];
        $objResponse = DB::table('users_survey_answer')
            ->select($arrColumns)
            ->whereIn('company_id', $arrCompanyIds)
            ->groupBy('company_id')
            ->get();
        
        $arrResponse = [];
        if ($objResponse->count() > 0) {
            foreach ($objResponse as $value) {
                $arrResponse[$value->company_id] = $value->total_responded;
            }
        }
        
        $data['arrResponse']           = $arrResponse;
        

        return view('admin.clients.index', $data);

    }

    public function addcompany(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {

            $status                = 0;
            $imgUrl                = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));
            $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
            $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');
            $company_logo = '';
            if ($request->hasFile('company_logo')) {
                $company_logo = $request->file('company_logo');
                $filename     = time() . '.' . $company_logo->getClientOriginalExtension();

                Image::make($company_logo)->save($company_original_path . $filename);
                // Image::make($company_logo)->resize(env('COMPANY_CROP_HEIGHT'), env('COMPANY_CROP_WIDTH'))->save($company_thumb_path . $filename);
                Image::make($company_logo)->resize(null, env('COMPANY_CROP_HEIGHT'), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($company_thumb_path . $filename);

                $company_logo = $filename;
            }

            $query = DB::table('clients')->insert([
                'company_name'   => $request->company_name,
                'contact_number' => $request->contact_number,
                'email'          => $request->email,
                'website'        => $request->website,
                'description'    => $request->description,
                'company_logo'   => $company_logo,
                'created_at'     => new \DateTime(),
                'updated_at'     => new \DateTime(),
            ]);

            if ($query !== false) {
                $status = 1;
            }

            $response = array('status' => $status);
            echo json_encode($response);
            exit;

        }

    }

    public function getcompany($id, Request $request)
    {

        $client = DB::table('clients')
            ->where(['id' => $id])
            ->first();

        $response = array();

        if (!empty($client)) {
            $imgUrl                = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));
            $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
            $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');
            if(!empty($client->company_logo)){
                $company_logo = url(env('COMPANY_THUMB_UPLOAD_PATH', '')) . '/' . $client->company_logo;
            }else {
                $company_logo = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));
            }

            // $company_logo = '';
            // if (file_exists($company_thumb_path . $client->company_logo)) {
            //     $company_logo = url($imgUrl) . '/' . $client->company_logo;
            // }
            $response = array(
                'id'             => $id,
                'company_name'   => $client->company_name,
                'contact_number' => $client->contact_number,
                'email'          => $client->email,
                'website'        => $client->website,
                'description'    => $client->description,
                'company_logo'   => $company_logo,
                'status'         => $client->status,

            );

        }

        echo json_encode($response);
        exit;

    }

    public function editcompany(Request $request)
    {
        if ($request->isMethod('post')) {
            $status                = 0;
            $id                    = $request->client_id;
            $client                = Client::where('id', $id)->first();
            $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
            $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');

            if ($request->hasFile('company_logo')) {

                $company_logo = $request->file('company_logo');
                $filename     = time() . '.' . $company_logo->getClientOriginalExtension();

                Image::make($company_logo)->save($company_original_path . $filename);
                //Image::make($company_logo)->resize(env('COMPANY_CROP_HEIGHT'), env('COMPANY_CROP_WIDTH'))->save($company_thumb_path . $filename);
                Image::make($company_logo)->resize(null, env('COMPANY_CROP_HEIGHT'), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($company_thumb_path . $filename);

                if (!empty($client->company_logo)) {
                    if (file_exists($company_original_path . $client->company_logo)) {
                        unlink($company_original_path . $client->company_logo);
                    }
                    if (file_exists($company_thumb_path . $client->company_logo)) {
                        unlink($company_thumb_path . $client->company_logo);
                    }
                }
                $company_logo = $filename;
            } else {
                $company_logo = $client->company_logo;
            }

            $query = DB::table('clients')
                ->where('id', $id)
                ->update([
                    'company_name'   => $request->company_name,
                    'contact_number' => $request->contact_number,
                    'email'          => $request->email,
                    'website'        => $request->website,
                    'description'    => $request->description,
                    'company_logo'   => $company_logo,
                    'status'         => $request->status,
                    'updated_at'     => new \DateTime(),
                ]);

            if ($query !== false) {

                $status = 1;
            }

            $response = array('status' => $status);
            echo json_encode($response);
            exit;

        }
    }

    public function checkclientname(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

            $valid        = true;
            $message      = '';
            $company_name = $request->company_name;

            if (isset($request->id)) {

                $id         = $request->id;
                $clientName = DB::table('clients')
                    ->where('company_name', '=', $company_name)
                    ->where('id', '!=', $id)
                    ->first();
                //dd($clientName);
            } else {

                $clientName = DB::table('clients')
                    ->where('company_name', '=', $company_name)
                    ->first();
            }

            if (!empty($clientName)) {
                $valid   = false;
                $message = 'Company name already in use';
            }

            $response = array('valid' => $valid, 'message' => $message);
            echo json_encode($response);
            exit;

        }

    }

    public function searchclients(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

           
            $status                = $request->status;
            $company_name          = $request->company_name;
            $offset                = $request->offset;


            $clientMethod = new Client;
            $searchQuery['status'] = $request->status;
            $searchQuery['company_name'] = $request->company_name;
            $searchQuery['offset'] = $request->offset;
            $data = $clientMethod->searchClientCommon($searchQuery);
           
            $clients = $data['clients'];
            $arrCompanyIds = [];
            if ($clients->count() > 0) {
                foreach ($clients as $client) {
                    $arrCompanyIds[] = $client->id;                    
                }
            }
            
            $arrColumns = [
                'company_id',
                DB::raw('count(survey_id) as total_responded'),
            ];
            $objResponse = DB::table('users_survey_answer')
                ->select($arrColumns)
                ->whereIn('company_id', $arrCompanyIds)
                ->groupBy('company_id')
                ->get();
            
            $arrResponse = [];
            if ($objResponse->count() > 0) {
                foreach ($objResponse as $value) {
                    $arrResponse[$value->company_id] = $value->total_responded;
                }
            }
            
            $data['arrResponse']           = $arrResponse;
           

            return view('admin.clients.search', $data);

            exit;
        }
    }

    public function deletecompany(Request $request)
    {
        if ($request->isMethod('post')) {

            $id = $request->id;

            // first we are checking if this company / client is associated with any user or not 
            $users = DB::table('user_client')->where('client_id', $id)->count();
            if($users > 0){
                 $response = array('status' => 2);
                echo json_encode($response);
                exit;

            }else {
                // first getting the surveys list based on company id
                $surveys = DB::table('surveys')->where('comp_id', $id)->get();
                if (!empty($surveys)) {
                    foreach ($surveys as $currSurvey) {
                        // Here we are deleting the survey blocks based on survey id we found from above query
                        DB::table('survey_blocks')->where('survey_id', $currSurvey->id)->delete();
                        DB::table('tmp_survey_questions')->where('tmp_survey_id', $currSurvey->id)->delete();
                        DB::table('users_survey_answer')->where('survey_id', $currSurvey->id)->delete();
                        
                    }
                }
                // Removing surveys based on company id
                DB::table('surveys')->where('comp_id', $id)->delete();

                // Removing users based on company id
                DB::table('user_client')->where('client_id', $id)->delete();

                DB::table('clients')->where('id', $id)->delete();
                $response = array('status' => 1);
                echo json_encode($response);
                exit;
            }

            
            //return \Redirect::back()->withMsgSuccess( 'Client deleted successfully.' );
        }

    }

    public function inactivateActivatecompany(Request $request)
    {
        if ($request->isMethod('post')) {

            $id = $request->id;
            $status = $request->status;
             $query = DB::table('clients')
                ->where('id', $id)
                ->update([
                    
                    'status'         => $status,
                    'updated_at'     => new \DateTime(),
                ]);
                
                $response = array('status' => 1);
                echo json_encode($response);
                exit;
            
        }

    }
}

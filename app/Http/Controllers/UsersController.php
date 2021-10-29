<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Common;
use App\Role;
use App\User;
use App\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Response;
use Yajra\Datatables\Datatables;
use Mail;

class UsersController extends Controller
{

    public function admin_userview(Request $request)
    {
        $data                           = array();
        $data['roles']                  = Common::getRoles()->toArray();
        
        return view('admin.users.list', $data);
    }

    public function admin_getAll(Request $request)
    {
       
        $users = DB::table('users')->
            select(['users.id', DB::raw('CONCAT(users.fname, " ", users.lname) as name'),'users.role_id',              
            DB::raw('GROUP_CONCAT(" ",clients.company_name) as company_name'),    
            DB::raw('GROUP_CONCAT(" ",clients.status) as clients_status'),                                    
            'users.contact_number', 'users.status', 'user_roles.name as role_name', 'users.email','users.remember_token'])               
            ->leftJoin('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->leftJoin('user_client', 'users.id', '=', 'user_client.user_id')
            // ->leftJoin('surveys', 'users.id', '=', 'surveys.user_id')
            ->leftJoin('clients', 'user_client.client_id', '=', 'clients.id')
            ->groupBy('users.id')
            // ->groupBy('user_client.client_id')
            //->where('users.id','!=',Auth::User()->id)
            ->whereIn('users.status',[1,2])
            ->distinct('clients.id')
            ;

           

            if (!isset($request->order)) {
                $users->orderBy('users.created_at', 'DESC');
            }
            
            $users->get();

           

        return Datatables::of($users)
           
            ->editColumn('role_name', function ($user) {
                if ($user->role_name == "") {
                    return '-';
                }
                return $user->role_name;
            })

            ->editColumn('company_name', function ($user) {
                $str = '';

                if($user->company_name != "")
                {
                    $companies = explode(",", $user->company_name);
                    $status = explode(",", $user->clients_status);

                    for($i=0;$i<count($companies);$i++ )
                    {
                        if($status[$i] != 1)
                        {
                            $bdge = "badge badge-secondary";
                        }
                        else
                        {
                            $bdge = "badge badge-success";
                        }

                        $str .= '<span class="'.$bdge.' text-capitalize m-1">' . $companies[$i] . '</span>';
                    }

                    // foreach ($companies as $company) {
                    //     $str .= '&nbsp;<span class="badge badge-info text-capitalize">' . $company . '</span>';
                    // }
                }               
                return $str;
            })
            
            ->editColumn('contact_number', function ($user) {
                if ($user->contact_number == "") {
                    return '-';
                }
                return $user->contact_number;
            })
            
            ->editColumn('status', function ($user) {
                
                $class  = "";
                $status = "";
                if($user->status == Common::$intStatusActive)
                {
                    $class  = "badge badge-success";
                    $status = "Active";
                } else {
                    $class  = "badge badge-secondary";
                    $status = "Inactive";
                }
                return '<span =' . $status . ' class="' . $class . '">' . $status . '</span>';
            })

            ->filterColumn('name', function ($query, $keyword) {
                
                $sql = "CONCAT(users.fname,' ',users.lname)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);

            })

            ->filterColumn('company_name', function ($query, $keyword) {
                
                $sql = "clients.company_name  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);

            })

            ->filterColumn('role_name', function ($query, $keyword) {                
                $sql = " user_roles.name  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->addColumn('bulkaction', function ($row) { 
                $disabledAttr = '';
                if($row->id == Auth::user()->id){
                    $disabledAttr = 'disabled';
                }

                return '<div class="checkbox"><label class="pure-material-checkbox"><input name="chkbox"' .  $disabledAttr . ' value="' . $row->id . '"  type="checkbox"><span></span></label></div>';
            })
            ->addColumn('action', function ($row) {
                
                $str = '<a class="textLink textlinkprimary" href="' . route('admin_edituser', ['id' => $row->id]) . '">Edit</a>';
                // if($row->surveyCount == 0)
                // {
                 $str .= '<span class="text-light"> |</span> <a class="textLink textlinkdanger delete" href="javascript:void(0)" data-id="' . $row->id . '" >Delete</a>';
                
                if( ($row->status == 2) && ($row->remember_token != ''))  {

                    $str .= '<span class="text-light"> |</span> <a class="textLink textlinkprimary resend_activation" href="javascript:void(0)" data-id="' . $row->id . '" >Resend Activation Link</a>';
                 }
                 // } 
                
                return $str;
            })
            ->rawColumns(['status','bulkaction', 'action','company_name'])
            ->make(true);
    }

    public function admin_edituser(Request $request ,$id = '')
    {
        if ($request->isMethod('post')) 
        {         
           
            
            
            $this->validate(
                $request,
                [
                    'fname' => 'required|min:2|max:200',
                    'lname'  => 'required|min:2|max:200',
                    'email'      => 'required|email|min:5|max:200|unique:users,email,' . $id . ',id',
                ]
            );

            $user_data['fname'] = $request->post('fname');
            $user_data['lname']  = $request->post('lname');
            $user_data['email']      = $request->post('email');
            //$user_data['role_id']    = $request->post('role_id_default');
            if(Auth::user()->id == $id){
                $user_data['role_id']    = $request->post('role_id_default');
            }else {
                $user_data['role_id'] = $request->post('role_id');
            }
            
            $user_data['contact_number']     = $request->post('contact_number');

            User::where('id', $id)->update($user_data);
            

            if($user_data['role_id'] == Common::$intRoleUser)
            {
                if( !empty($request->client_associated_id) && !empty($request->client_id) )
                {
                    $client_id = array_merge($request->client_associated_id, $request->client_id);
                }
                elseif(empty($request->client_associated_id))
                {
                    $client_id = $request->client_id;
                }
                elseif(empty($request->client_id))
                {
                    $client_id = $request->client_associated_id;
                }
                else {
                    
                }
                    
                

                $i = 0;
                DB::table('user_client')->where('user_id', $id)->delete();

                if(!empty($client_id))
                {
                    foreach ($client_id as $key => $value) 
                    {
                        $user_clients[$i]['client_id'] = $value;
                        $user_clients[$i]['user_id'] = $id;
                        $i++;
                    }
                    DB::table('user_client')->insert($user_clients);
                }
                
            }
            else{
                DB::table('user_client')->where('user_id', $id)->delete();
            }
            
            $msg = env('MSG_RECORDS_UPDATED');
            return redirect()->route('admin_users')->with('msg_success', $msg);
        } 
        else 
        {
            $data['user'] = array();
            $user = array();
            
            $user  = DB::table('users')->select(
                'users.id','users.fname','users.lname', 'users.email', 
                'users.password','users.role_id','users.profile_image','users.contact_number',
                'ur.id as role_id',
                DB::raw('GROUP_CONCAT(uc.client_id) as client_id'),
                DB::raw('GROUP_CONCAT(uc.id) as uc_ids')
            )
            ->leftJoin('user_roles AS ur','users.role_id', '=', 'ur.id')
            ->leftJoin('user_client AS uc','users.id', '=', 'uc.user_id')
            ->groupBy('users.id')
            ->where('users.id', $id)->get();

            if(!$user->count()) 
            {
                $msg = env('MSG_USER_WRONG');
                return redirect('users')->with('error', $msg);
            }

            $data['user'] = (array)$user[0];
            
            $data['user']['user_id'] = $id;
            $data['user']['roles'] = Common::getRoles();
            
            $data['user']['is_company_deletable'] = 1;
            if($user[0]->role_id == Common::$intRoleUser)
            {                
                $clientId = DB::table('user_client')->where('user_id',$user[0]->id)->first();
                if($clientId)
                {
                    // Here we are checking if user has survey then simply do not allow them to change company                    
                    $surveys = DB::table('surveys')->select(['id'])
                    ->where('user_id','=',$id)
                    ->where('comp_id','=',$clientId->client_id)->count();
                    if($surveys)
                    {
                        $data['user']['is_company_deletable'] = 0;
                        $data['user']['clients'] = Common::getClients('','',$clientId->client_id);
                    }
                }                               
            }

            $client_exclude = DB::table('user_client')->select(
                                 'clients.id as comp_id'
                                )
                                    ->leftJoin('users', 'users.id', '=', 'user_client.user_id')
                                    ->leftJoin('clients', 'clients.id', '=', 'user_client.client_id')
                                // ->where('clients.status',2)
                                    ->where('users.id', $id)
                                    ->get()->toArray();

                               
            foreach ($client_exclude as $value)
            {
                $data['user']['client_exclude'][] = $value->comp_id;
            }

            if(!empty($data['user']['client_exclude']))
            {
                $data['user']['client_exclude_name'] = Common::getAllClients()->whereIn('id', $data['user']['client_exclude']);
                $data['user']['clients'] = Common::getAllClients()->whereNotIn('id', $data['user']['client_exclude']);
            }
            else {
                $data['user']['client_exclude_name'] = [];
                $data['user']['clients'] = Common::getClients();
            }


            $data['user']['client_exclude_inactive_name'] = DB::table('user_client')->select(
                'clients.company_name','clients.status','clients.id'
            )            
            ->leftJoin('users', 'users.id', '=', 'user_client.user_id')
            ->leftJoin('clients', 'clients.id', '=', 'user_client.client_id')    
            // ->where('clients.status',2)        
            ->where('users.id', $id)
            ->get()->toArray();


            
            $asso_survey_id = DB::table('surveys')->select(
                ['surveys.comp_id as id']
            )

                ->where('user_id', $id)
                ->get()->toArray();

            $data['user']['asso_survey_id'] = [];
            foreach ($asso_survey_id as $sid) {
                $data['user']['asso_survey_id'][] = $sid->id;
            }

            $data['user']['asso_survey_id'] = array_unique($data['user']['asso_survey_id']);


            // if (!empty($data['user']['client_exclude'])) {
            //     $data['user']['client_exclude_name'] = Common::getAllClients()->whereIn('id', $data['user']['client_exclude']);
            //     $data['user']['clients'] = Common::getAllClients()->whereNotIn('id', $data['user']['client_exclude']);
            // } else {
            //     $data['user']['client_exclude_name'] = [];
            //     $data['user']['clients'] = Common::getClients();
            // }

            
            return view('admin.users.edit', $data['user']);
        }
    
    }


    public function admin_adduser(Request $request )
    {
   
        if ($request->isMethod('post')) 
        {         
            $this->validate(
                $request,
                [
                    'fname' => 'required|min:2|max:200',
                    'lname' => 'required|min:2|max:200',
                    'email' => 'required|email|min:5|max:200|unique:users,email',
                    'role_id' => 'required|not_in:0,select',
                  //  'contact_number' => 'required',
                    'password' => 'required'
                ]
            );

            $user_data['fname'] = $request->post('fname');
            $user_data['lname']  = $request->post('lname');
            $user_data['email'] = $request->post('email');
            $user_data['password'] = bcrypt($request->post('password'));
            $user_data['role_id'] = $request->post('role_id');
            $user_data['contact_number'] = $request->post('contact_number');
            $user_data['status'] = 2;

            $strToken   = time() . uniqid();
            $strName    = $user_data['fname'] . ' ' . $user_data['lname'];
            $strEmail   = $user_data['email'];
            $strSubject = 'Perception Mapping: Account created';
            $strLink    = route('activation', ['token' => $strToken]);
            $data       = array('name' => $strName, 'link' => $strLink);


            $user_data['remember_token'] = $strToken;
            
            $id = User::insertGetId($user_data);  

            /************************************ */

            $data['url']         = env('APP_URL');
            $data['maincontent'] = '<h1 style="color:#000;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Hi, ' . $strName . '</h1>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Your account has been created successfully.</p>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Please <a href="' . $strLink . '">Click Here</a> to activate your account</p>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Regards,
                        <br>' . env('MAIL_REGARDS') . '</p>'
            ;

            Mail::send('admin.mailtemplate.mail-template', $data, function ($message) use ($strEmail, $strName, $strSubject) {
                $message->to($strEmail, $strName)->subject($strSubject);
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            /************************************* */

            if(isset($request->client_id))
            {
                if($user_data['role_id'] == Common::$intRoleUser)
                {
                    for($i=0;$i<count($request->client_id);$i++)
                    {
                        $user_clients[$i]['client_id'] = $request->client_id[$i];
                        $user_clients[$i]['user_id'] = $id;                
                    }
    
                    DB::table('user_client')->insert($user_clients);
                }
            }
           

            $msg = env('MSG_RECORDS_ADDED');
            return redirect()->route('admin_users')->with('msg_success', $msg);
        } 
        else 
        {           
            $data = array();
            $data['roles'] = Common::getRoles();
            $data['clients'] = Common::getClients();  
            return view('admin.users.add',$data);
        }
    
    }

    public function activation(Request $request, $strToken = "")
    {
       
        
        $arrUser = DB::table('users')->where('remember_token', $strToken)->get()->first();
        
        
        if (!empty($arrUser)) {
            if($arrUser->status == 3){
                // DB::table('users')
                //         ->where('id', $arrUser->id)
                //         ->update([
                //                 'email_verified_at' => now(), 
                //                 'status' => Common::$intStatusActive,
                //                 'remember_token'=>''
                //                 ]);
                return redirect()->route('login')->withMsgFailed('This user no longer exists.');
            } else {
                if (empty($arrUser->email_verified_at)) {
                
                    DB::table('users')
                        ->where('id', $arrUser->id)
                        ->update([
                                'email_verified_at' => now(), 
                                'status' => Common::$intStatusActive,
                                'remember_token'=>''
                                ]);
                }

            }   
            
        }else {
            return redirect()->route('login')->withMsgFailed('This activation link is expired or have already been used.');
        }

        $data['arrUser'] = $arrUser;
        return view('admin.users.activation', $data );
    }


    public function ajax_call_delete(Request $request)
    {
        if($request->isMethod('post'))
        {
            $id = $request->post('select_all');
             $query = DB::table('users')
                ->where('id', $id)
                ->update([
                    'status'=>3
                     ]);

            /* CODE COMMENTED STARTS */ 
                // first getting the surveys list based on company id
                //     $surveys = DB::table('surveys')->where('user_id', $id)->get();
                //     if (!empty($surveys)) {
                //         foreach ($surveys as $currSurvey) {
                //             // Here we are deleting the survey blocks based on survey id we found from above query
                //             DB::table('survey_blocks')->where('survey_id', $currSurvey->id)->delete();
                //             DB::table('tmp_survey_questions')->where('tmp_survey_id', $currSurvey->id)->delete();
                //             DB::table('users_survey_answer')->where('survey_id', $currSurvey->id)->delete();
                            
                //         }
                //     }


                // DB::table('user_client')->where('user_id', $id)->delete();
            
                // User::where('id', $id )->delete();
            /* CODE COMMENTED ENDS */ 

            return response()->json(array('msg'=> $id.""
                , "suc" => '1'
            ), 200);

        }
        return redirect()->route('admin_users');
    }

    public function ajax_call_admin_change_status(Request $request)
    {
        if ($request->isMethod('post')) {
            $users_id            = $request->users_id;
            $users_id =  array_diff($users_id, array(Auth::user()->id)); // Removing logged in user id from the list 
            $user_data['status'] = $request->status_id;           
            User::whereIn('id', $users_id)->update($user_data);                        
            return response()->json(array("success" => '1'), 200);
        }
        return response()->json(array("success" => '0'), 200);
    }

    public function checkemailexists(Request $request)
    {
       

        
        if ($request->isMethod('post')) {
            
            $valid = true;
            $message = '';
            $email = $request->email;
            $userId = $request->userId;
            
            
            $u  = DB::table('users')
            ->where('email', '=', $email);
            
            if($userId != "")
            {
                $u->where('id', '!=', $userId);
            }

            $user = $u->first();

            if(!empty($user)){
                $valid = false;
                $message = 'Email already in use';                
            }
            
            
            $response = array('valid' => $valid,'message' => $message);
            echo json_encode($response);
            exit;
        
        }
        
    }

    public function ajax_call_resend_activation(Request $request)
    {
        if($request->isMethod('post'))
        {
            $id = $request->post('select_all');
             
            $strToken   = time() . uniqid();
           
            $query = DB::table('users')
                ->where('id', $id)
                ->update([
                    'remember_token'   => $strToken,                    
                    'updated_at'     => new \DateTime(),
                ]);

             $user_data = DB::table('users')
            ->where(['id' => $id])
            ->first();
            
            $strName    = $user_data->fname . ' ' . $user_data->lname;
            $strEmail   = $user_data->email;
            $strSubject = 'Perception Mapping: Account created';
            $strLink    = route('activation', ['token' => $strToken]);
            $data       = array('name' => $strName, 'link' => $strLink);
            $data['url']         = env('APP_URL');
            $data['maincontent'] = '<h1 style="color:#000;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Hi, ' . $strName . '</h1>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Your account has been created successfully.</p>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Please <a href="' . $strLink . '">Click Here</a> to activate your account</p>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Regards,
                        <br>' . env('MAIL_REGARDS') . '</p>'
            ;

            Mail::send('admin.mailtemplate.mail-template', $data, function ($message) use ($strEmail, $strName, $strSubject) {
                $message->to($strEmail, $strName)->subject($strSubject);
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            
             return response()->json(array('msg'=> $id.""
                , "suc" => '1'
            ), 200);
        }
    }

    

}

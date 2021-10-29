<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Common;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Survey;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        $arrColumns = [
            DB::raw('sum(max_invitations) as total_invitation'),
            DB::raw('count(*) as total_active'),
            DB::raw('GROUP_CONCAT(surveys.id) as survey_ids'),
        ];
        $objSurvey = DB::table('surveys')
            ->select($arrColumns)
            ->where('status', 1);
        if (!Common::isAdmin()) {
            $objSurvey->where('surveys.user_id', Auth::id());
              $objSurvey->whereIn('surveys.comp_id',function($query) {
               $query->select('client_id')->from('user_client')->where('user_id', '=', Auth::id());

            });  
        }
        $objSurvey = $objSurvey->first();        

        $arrSurveyIds = empty($objSurvey) ? [] : explode(',', $objSurvey->survey_ids);
        $objRespoded  = DB::table('users_survey_answer')
            ->select([DB::raw('count(DISTINCT(url)) as total_responded')]);
        if (!Common::isAdmin()) {
            $objRespoded->whereIn('survey_id', $arrSurveyIds);
        }
        $objRespoded = $objRespoded->first();
 
        
        $surveyMethod = new Survey;
        $searchQuery['limit'] = 12;
        $searchQuery['defaultLimit'] = 12;
        $data = $surveyMethod->searchSurveyCommon($searchQuery);
        $data['intActiveSurvey']         = empty($objSurvey) ? 0 : $objSurvey->total_active;
        $data['intInvited']              = empty($objSurvey) ? 0 : $objSurvey->total_invitation;
        $data['intResponed']             = empty($objRespoded) ? 0 : $objRespoded->total_responded;        
        $data['intAverageParticipation'] = $data['intInvited'] > 0 ? number_format((100 * $data['intResponed']) / $data['intInvited'],2) : 0;
        
        return view('admin/dashboard/dashboard', $data);
    }

    public function changePassword(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

            $status = 0;

            $rules = [
                'password'              => ['required', 'string', 'min:8'],
                'password_confirmation' => ['required', 'min:8', 'same:password'],
            ];

            $messages = [

                'password.required'              => 'Please enter new password.',
                'password.min'                   => 'New password must be minimum 8 characters long.',
                'password_confirmation.required' => 'Please enter confirm password.',
                'password_confirmation.min'      => 'Confirm password must be minimum 8 characters long.',
                'password_confirmation.same'     => 'New password and confirm password must be the same.',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $status = 0;

            } else {

                $password = Hash::make($request->password);
                $userId   = Auth::id();

                $query = DB::table('users')
                    ->where('id', $userId)
                    ->update([
                        'password'   => $password,
                        'updated_at' => new \DateTime(),
                    ]);

                if ($query !== false) {
                    $status = 1;
                }

            }
            $response = array('status' => $status);
            echo json_encode($response);
            exit;

        }

        return view('admin/profile/change_password');
    }

    public function profile(\Illuminate\Http\Request $request)
    {
        $user               = User::find(Auth::id());
        $imgUrl             = url(env('USER_THUMB_UPLOAD_PATH', ''));
        $user_original_path = public_path() . env('USER_ORIGINAL_UPLOAD_PATH', '');
        $user_thumb_path    = public_path() . env('USER_THUMB_UPLOAD_PATH', '');

        if ($request->isMethod('post')) {

            $status = 0;
            $data   = array();
            $rules  = [
                'fname' => ['required', 'string'],
                'lname' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'unique:users,email,' . Auth::id()],

            ];

            $messages = [
                'fname.required' => 'Please enter first name.',
                'lname.required' => 'Please enter last name.',
                'email.required' => 'Please enter email address.',
                'email.email'    => 'Please enter valid email address.',
                'email.unique'   => 'This email has already been taken.',
                //    'contact_number.required'=>'Please enter mobile number.',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $status = 0;
                $data   = array();
                //  return \Redirect::back()
                //         ->withErrors($validator)
                //         ->withInput();

            } else {
                $isImageNull = NULL;
                $userId = Auth::id();
                if ($request->hasFile('profile_image')) {

                    $profile_image = $request->file('profile_image');
                    $filename      = time() . '.' . $profile_image->getClientOriginalExtension();

                    Image::make($profile_image)->save($user_original_path . $filename);
                    Image::make($profile_image)->resize(env('USER_CROP_HEIGHT'), env('USER_CROP_WIDTH'))->save($user_thumb_path . $filename);

                    if (!empty($user->profile_image)) {
                        if (file_exists($user_original_path . $user->profile_image)) {
                            unlink($user_original_path . $user->profile_image);
                        }
                        if (file_exists($user_thumb_path . $user->profile_image)) {
                            unlink($user_thumb_path . $user->profile_image);
                        }
                    }
                    $profile_image = $filename;
                } else {
                     if(empty($user->profile_image)){
                        $isImageNull = true;
                        $profile_image = NULL;                        
                        $imgUrl =  url('/images/' . env('DEFAULT_USER_IMAGE',''));
                    }else {                    
                        $profile_image = $user->profile_image;
                    }
                }

                $query = DB::table('users')
                    ->where('id', $userId)
                    ->update([
                        'fname'          => $request->fname,
                        'lname'          => $request->lname,
                        'email'          => $request->email,
                        'contact_number' => $request->contact_number,
                        'profile_image'  => $profile_image,
                        'updated_at'     => new \DateTime(),
                    ]);

                if ($query !== false) {

                    $status = 1;
                    if($isImageNull){
                        $imageArray = $imgUrl;
                    }else {
                        $imageArray = $imgUrl . '/' . $profile_image;
                    }

                    $data   = array(
                        'name'  => $request->fname . ' ' . $request->lname,
                        'image' => $imageArray,
                    );
                }

            }
            $response = array('status' => $status, 'data' => $data);
            echo json_encode($response);
            exit;
        }

        return view('admin/profile/profile', ["user_thumb_path" => $user_thumb_path, 'user_original_path' => $user_original_path, 'imgUrl' => $imgUrl]);
    }

    public function checkemailprofileupdate(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

            $valid   = true;
            $message = '';
            $email   = $request->email;
            $userId  = $request->userId;

            $user = DB::table('users')
                ->where('email', '=', $email)
                ->where('id', '!=', $userId)
                ->first();

            if (!empty($user)) {
                $valid   = false;
                $message = 'Email already in use';
            }

            $response = array('valid' => $valid, 'message' => $message);
            echo json_encode($response);
            exit;

        }

    }

    public function checkoldpassword(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {
            $valid        = true;
            $message      = '';
            $old_password = $request->old_password;

            $user   = User::find(Auth::id());
            $hasher = app('hash');

            if (!empty($user)) {

                if (!$hasher->check($old_password, $user->password)) {
                    $valid   = false;
                    $message = 'Old Password is not correct.';

                }

            }

            $response = array('valid' => $valid, 'message' => $message);
            echo json_encode($response);
            exit;

        }

    }

    public function getprofile(\Illuminate\Http\Request $request)
    {
        $user     = User::find(Auth::id());
        $response = array();
        $status   = 0;
        if (!empty($user)) {
            $status = 0;

            $imgUrl = url(env('USER_THUMB_UPLOAD_PATH'));

            $profile_image      = '';
            $user_original_path = public_path() . env('USER_ORIGINAL_UPLOAD_PATH', '');
            $user_thumb_path    = public_path() . env('USER_THUMB_UPLOAD_PATH', '');

            if (!empty($user->profile_image) && file_exists($user_thumb_path . $user->profile_image)) {
                $profile_image = url($imgUrl) . '/' . $user->profile_image;
            } else {
                $profile_image = url('/images/' . env('DEFAULT_USER_IMAGE', ''));
            }

            $data = array(
                'fname'          => $user->fname,
                'lname'          => $user->lname,
                'email'          => $user->email,
                'contact_number' => $user->contact_number,
                'profile_image'  => $profile_image,
            );

        }

        $response = array('status' => $status, 'data' => $data);
        echo json_encode($response);
        exit;
    }

}

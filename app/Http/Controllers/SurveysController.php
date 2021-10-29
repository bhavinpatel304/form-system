<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Common;
use App\Survey;
use App\SurveyBlocks;
use App\SurveyLibrary;
use App\SurveyLibraryTemplates;

use App\TmpSurveyQuestions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use App\SkipLogic;
use App\TmpSkipLogic;
use Response;

class SurveysController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $surveyMethod = new Survey;
       
        $data = $surveyMethod->searchSurveyCommon();
        return view('admin.surveys.index', $data);

    }
    
    public function searchsurveys(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {            

            $surveyMethod = new Survey;
            
            $searchQuery['status'] = $request->status;
            $searchQuery['survey_name'] = $request->survey_name;
            $searchQuery['offset'] = $request->offset;
            $data = $surveyMethod->searchSurveyCommon($searchQuery);
            

            return view('admin.surveys.search', $data);

            exit;
        }
    }

    public function addsurvey(\Illuminate\Http\Request $request)
    {
        //    $randomStr =  Str::random();
        //$randomStr = sha1(time());
        $randomStr = (string) Str::uuid();

        if ($request->isMethod('post')) {
            
            $currentDate = Carbon::now()->format('Y-m-d');
            $page_number = $request->post('page_number');

            $survey_company_logo = '';
            if ($request->hasFile('survey_company_logo')) {
                $company_original_path = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH', '');
                $company_thumb_path    = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', '');

                $survey_company_logo = $request->file('survey_company_logo');
                $filename            = time() . '.' . $survey_company_logo->getClientOriginalExtension();

                Image::make($survey_company_logo)->save($company_original_path . $filename);

                Image::make($survey_company_logo)->resize(null, env('SURVEY_COMPANY_CROP_HEIGHT'), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($company_thumb_path . $filename);

                $survey_company_logo = $filename;

            }

            $welcome_image = '';
            if ($request->hasFile('welcome_image')) {

                $welcome_image_path = public_path() . env('SURVEY_UPLOAD_PATH', '');
                $welcome_image      = $request->file('welcome_image');
                $filename           = time() . '.' . $welcome_image->getClientOriginalExtension();
                Image::make($welcome_image)->save($welcome_image_path . $filename);
                $welcome_image = $filename;

            }
            $show_logo = 2;
            if ($request->has('show_logo')) {
                $show_logo = 1;
            }
            $start_date = NULL;
            $end_date = NULL;
            $max_invitations = NULL; 
            if ($request->filled('start_date')) {
                $start_date = date("Y-m-d", strtotime($request->post('start_date')));
            }
            if ($request->filled('end_date')) {
                $end_date   = date("Y-m-d", strtotime($request->post('end_date')));
            }
            if ($request->filled('max_invitations')) {
                $max_invitations   = $request->post('max_invitations');
            }

            try {

                $survey_data['comp_id']             = $request->post('comp_id');
                $survey_data['survey_company_logo'] = $survey_company_logo;
                $survey_data['survey_name']         = $request->post('survey_name');
                $survey_data['max_invitations']     = $max_invitations;
                $survey_data['start_date']          = $start_date;
                $survey_data['end_date']            = $end_date;

                $status = 2;
                if (($currentDate >= $start_date) && ($currentDate <= $end_date)) {
                    $status = 1;
                }

                $survey_data['show_logo']            = $show_logo;
                $survey_data['welcome_image']        = $welcome_image;
                $survey_data['welcome_description']  = $request->post('welcome_description');
                $survey_data['thankyou_description'] = $request->post('thankyou_description');
                $survey_data['url']                  = $randomStr;
                $survey_data['status']               = $status;
                $survey_data['created_at']           = DB::raw('NOW()');
                $survey_data['updated_at']           = DB::raw('NOW()');

                $page_heading_arr = array();
                foreach ($page_number as $curr_page_number) {
                    $show_heading = 0;
                    if ($request->has('show_heading_' . $curr_page_number)) {
                        $show_heading = 1;
                    }
                    $show_subheading = 0;
                    if ($request->has('show_subheading_' . $curr_page_number)) {
                        $show_subheading = 1;
                    }
                    $page_heading_arr[] = array(
                        'page_number'                 => $curr_page_number,
                        'show_heading'                => $show_heading,
                        'show_subheading'             => $show_subheading,
                        'survey_heading'              => $request->post('survey_heading_' . $curr_page_number),
                        'survey_sub_heading'          => $request->post('survey_sub_heading_' . $curr_page_number),
                        'is_heading_bold'             => $request->post('is_heading_bold_' . $curr_page_number),
                        'is_heading_italic'           => $request->post('is_heading_italic_' . $curr_page_number),
                        'is_heading_underline'        => $request->post('is_heading_underline_' . $curr_page_number),
                        'is_subheading_bold'          => $request->post('is_subheading_bold_' . $curr_page_number),
                        'is_subheading_italic'        => $request->post('is_subheading_italic_' . $curr_page_number),
                        'is_subheading_underline'     => $request->post('is_subheading_underline_' . $curr_page_number),
                        'survey_heading_fontSize'     => $request->post('survey_heading_fontSize_' . $curr_page_number),
                        'survey_sub_heading_fontSize' => $request->post('survey_sub_heading_fontSize_' . $curr_page_number),
                        'heading_fg_color'            => $request->post('heading_fg_color_' . $curr_page_number),
                        'sub_heading_fg_color'        => $request->post('sub_heading_fg_color_' . $curr_page_number),
                        'heading_bg_color'            => $request->post('heading_bg_color_' . $curr_page_number),
                        'sub_heading_bg_color'        => $request->post('sub_heading_bg_color_' . $curr_page_number),

                    );
                }

                $survey_data['page_heading'] = json_encode($page_heading_arr);

                $survey_data['user_id'] = Auth::id();

                $survey_id = Survey::insertGetId($survey_data);

                // getting all the surveys from temp table based on logged in user id
                $tmp_survey_questions = DB::table('tmp_survey_questions')
                    ->where('user_id', '=', Auth::id())
                    ->orderBy('page_number', 'asc')
                    ->get();
                if (!empty($tmp_survey_questions)) {
                    foreach ($tmp_survey_questions as $curr_tmp_survey_question) {
                        $question_data['user_id']              = $curr_tmp_survey_question->user_id;
                        $question_data['survey_id']            = $survey_id;
                        $question_data['survey_question']      = $curr_tmp_survey_question->question;
                        $question_data['survey_question_type'] = $curr_tmp_survey_question->question_type;
                        $question_data['page_number']          = $curr_tmp_survey_question->page_number;
                        $question_data['question_number']      = $curr_tmp_survey_question->question_number;
                        $question_data['is_required']          = $curr_tmp_survey_question->is_required;
                        $question_data['survey_order_number']  = $curr_tmp_survey_question->tmp_survey_order_number;
                        $question_data['is_skip_logic_avail']          = $curr_tmp_survey_question->is_skip_logic_avail;

                        $question_id = SurveyBlocks::insertGetId($question_data);

                        // Here first we are finding id from temp table to tmp_skip_logic and updating with the survey block id 
                        $tmp_skip_logic_data['question_id'] = $question_id;
                        TmpSkipLogic::where('question_id', $curr_tmp_survey_question->id)->update($tmp_skip_logic_data);

                        $tmp_skip_logic_data_skip_question_id['skip_question_id'] = $question_id;
                        TmpSkipLogic::where('skip_question_id', $curr_tmp_survey_question->id)->update($tmp_skip_logic_data_skip_question_id);
                    }

                    DB::table('tmp_survey_questions')->where('user_id', Auth::id())->delete();
                }
                //dd('sdfsd');

                 // getting all the skip logic question from tmp_skip_logic table based on logged in user id
                $tmp_skip_logic_questions = DB::table('tmp_skip_logic')
                    ->where('user_id', '=', Auth::id())
                    ->orderBy('id', 'asc')
                    ->get();
                if (!empty($tmp_skip_logic_questions)) {

                    foreach ($tmp_skip_logic_questions as $curr_tmp_skip_logic_question) {
                        $skip_logic_data['user_id'] = $curr_tmp_skip_logic_question->user_id;
                        $skip_logic_data['question_id'] = $curr_tmp_skip_logic_question->question_id;
                        $skip_logic_data['skip_question_id'] = $curr_tmp_skip_logic_question->skip_question_id;
                        $skip_logic_data['answer'] = $curr_tmp_skip_logic_question->answer;
                        $skip_logic_data['question_type'] = $curr_tmp_skip_logic_question->question_type;
                        $skip_logic_data['survey_id'] = $survey_id;
                        $skip_logic_data['page_number'] = $curr_tmp_skip_logic_question->page_number;

                         $skip_logic_id = SkipLogic::insertGetId($skip_logic_data);

                    }

                    DB::table('tmp_skip_logic')->where('user_id', Auth::id())->delete();

                }
                return redirect()->route('surveylist')->withMsgSuccess('Survey Created Successfully.');
            } catch (\Exception $e) {
                return redirect()->route('surveylist')->withMsgFailed('There is some problem.');
            }

        }

        $isUserAdmin = 1;
        $companyId   = '';
        if (Auth::User()->role_id == Common::$intRoleUser) {
            $isUserAdmin = 0;
            $clientId    = DB::table('user_client')->where('user_id', Auth::User()->id)->get()->toArray();
            $clientIds   = [];
            if ($clientId) {
                foreach ($clientId as $currClientId) {
                    //dd($currClientId->client_id);
                    $clientIds[] = $currClientId->client_id;
                }
                // $companyId = $clientId->client_id;
            }

            //dd($clientIds);
            $first = DB::table('clients d')->whereIn('d.id', $clientIds);
            //  ->where('id','=',$clientId->client_id);

            $clients = DB::table('clients')
                ->select(['clients.*'])
                ->join('user_client AS c', 'clients.id', '=', 'c.client_id')
                ->where('status', '=', '1')
                ->where('c.user_id', '=', Auth::User()->id)
            //->union($first)
                ->orderBy('company_name', 'ASC')
                ->get();
            //dd($clients);
        } else {
            $clients = DB::table('clients')
                ->select(['clients.*'])
                ->where('status', '=', '1')
                ->orderBy('company_name', 'ASC')
                ->get();
        }

        DB::table('tmp_skip_logic')->where('user_id', Auth::id())->delete();
        DB::table('tmp_survey_questions')->where('user_id', Auth::id())->delete();
        //DB::table('tmp_survey_questions')->delete();

        $default_company_img = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));
        // return view('admin.surveys.add',['clients'=>$clients,'default_company_img'=>$default_company_img,'randomStr'=>$randomStr]);
        return view('admin.surveys.add', ['clients' => $clients, 'default_company_img' => $default_company_img, 'isUserAdmin' => $isUserAdmin, 'companyId' => $companyId]);
    }
    public function deletesurvey(Request $request)
    {
        if ($request->isMethod('post')) {

            $id = $request->id;

            $surveys = DB::table('users_survey_answer')->where('survey_id', $id)->count();
            if ($surveys > 0) {
                $response = array('status' => 2, 'dashboardData' => []);
                echo json_encode($response);
                exit;

            } else {
                DB::table('tmp_survey_questions')->where('tmp_survey_id', $id)->delete();
                DB::table('users_survey_answer')->where('survey_id', $id)->delete();
                // DB::table('survey_invitation')->where('survey_id',  $id)->delete();
                DB::table('survey_blocks')->where('survey_id', $id)->delete();

                DB::table('surveys')->where('id', $id)->delete();
                DB::table('skip_logic')->where('survey_id', $id)->delete();
                DB::table('tmp_skip_logic')->where('survey_id', $id)->delete();
                $dashboardData = $this->dashboardData();

                $response = array('status' => 1, 'dashboardData' => $dashboardData);
                echo json_encode($response);
                exit;
            }

        }

    }

    public function searchcompanyforsurvey(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

            $response = array('status' => '0');
            $comp_id  = $request->comp_id;
            if (!empty($comp_id)) {
                $client = DB::table('clients')->where('id', '=', $comp_id)->first();

                if (!empty($client)) {
                    
                    if(!empty($client->company_logo)){
                        $clientImage = url(env('COMPANY_THUMB_UPLOAD_PATH', '')) . '/' . $client->company_logo;
                        $response    = array('clientImage' => $clientImage, 'status' => '1');
                        

                    }else {
                       $clientImage = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));
                        $response    = array('clientImage' => $clientImage, 'status' => '1');
                       
                    }
                    

                }
            } else {
                $clientImage = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));
                $response    = array('clientImage' => $clientImage, 'status' => '1');
            }

            echo json_encode($response);
            exit;

        }
    }

    public function editsurvey(Request $request, $id = '')
    {
       


        $imgUrl                = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));
        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');

        $survey_company_imgUrl        = url(env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', ''));
        $survey_company_original_path = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $survey_company_thumb_path    = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', '');

        $welcome_image_path = public_path() . env('SURVEY_UPLOAD_PATH', '');
        $welcomeimgUrl      = url(env('SURVEY_UPLOAD_PATH', ''));

        $survey = DB::table('surveys')
            ->select(['surveys.*', 'c.company_logo'])
            ->join('clients AS c', 'surveys.comp_id', '=', 'c.id')
            ->where(['surveys.id' => $id])
            ->first();

            if (Auth::User()->role_id == Common::$intRoleUser) {
                
                $clientIds    = DB::table('user_client')->where('user_id', Auth::User()->id)->get()->toArray();
                
                $finalClientIds = [];
                if(!empty($clientIds)){
                    foreach ($clientIds as $currClientId) {
                        $finalClientIds[] = $currClientId->client_id;
                    }
                }
                // dd($survey->comp_id);
                // dd($finalClientIds);
                
                if (!in_array($survey->comp_id, $finalClientIds)) 
                {
                    return redirect()->route('surveylist')->with('msg_failed', 'You can not authorise to perform this action.');                     
                }
            
            

            }
        

        $client = DB::table('clients')->where(['id' => $id])->first();
        //dd($survey->comp_id);

        $data['survey']                = $survey;
        $data['imgUrl']                = $imgUrl;
        $data['company_original_path'] = $company_original_path;
        $data['company_thumb_path']    = $company_thumb_path;

        $data['survey_company_imgUrl']        = $survey_company_imgUrl;
        $data['survey_company_original_path'] = $survey_company_original_path;
        $data['survey_company_thumb_path']    = $survey_company_thumb_path;

        $data['welcome_image_path'] = $welcome_image_path;
        $data['welcomeimgUrl']      = $welcomeimgUrl;

         DB::table('tmp_survey_questions')->where('tmp_survey_id', '=', $id)->delete();
        //DB::table('tmp_survey_questions')->where('user_id', Auth::id())->delete();
        // DB::table('tmp_skip_logic')->where('user_id', Auth::id())->delete();
        DB::table('tmp_skip_logic')->where('survey_id', '=', $id)->delete();


          // getting all the skip logic question from skip_logic table based on logged in user id and survey id 
                $skip_logic_questions = DB::table('skip_logic')
                  //  ->where('user_id', '=', Auth::id())
                    ->where('survey_id', '=', $id)
                    ->orderBy('id', 'asc')
                    ->get();
                if (!empty($skip_logic_questions)) {

                    foreach ($skip_logic_questions as $curr_skip_logic_question) {
                        $tmp_skip_logic_data['user_id'] = $curr_skip_logic_question->user_id;
                        $tmp_skip_logic_data['question_id'] = $curr_skip_logic_question->question_id;
                        $tmp_skip_logic_data['skip_question_id'] = $curr_skip_logic_question->skip_question_id;
                        $tmp_skip_logic_data['answer'] = $curr_skip_logic_question->answer;
                        $tmp_skip_logic_data['question_type'] = $curr_skip_logic_question->question_type;
                        $tmp_skip_logic_data['survey_id'] = $curr_skip_logic_question->survey_id;
                        $tmp_skip_logic_data['page_number'] = $curr_skip_logic_question->page_number;

                         $tmp_skip_logic_id = TmpSkipLogic::insertGetId($tmp_skip_logic_data);

                    }

                    

                }


        // getting all the surveys from main table based on logged in user id and survey id adding to temp table

        // DB::connection()->enableQueryLog();

        $survey_questions = DB::table('survey_blocks')
        //->where('user_id', '=', Auth::id())
            ->where('survey_id', '=', $id)
            ->orderBy('survey_order_number', 'asc')
            ->orderBy('page_number', 'asc')

            ->get();

        // $queries = DB::getQueryLog();

        // dd($queries);

        // here we are getting if this survey filled by any user or not
        $checkSurveyFilled = DB::table('users_survey_answer')
            ->where('survey_id', '=', $id)
            ->count();

        $data['default_company_img'] = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));

        $survey_detail = DB::table('surveys')
            ->select(['sb.*'])
            ->leftJoin('survey_blocks AS sb', 'surveys.id', '=', 'sb.survey_id')
            ->where(['surveys.id' => $id])
            ->orderBy('sb.survey_order_number', 'ASC')
            ->get()->toArray();

        $data['survey_detail'] = $survey_detail;
        $i                     = 0;

        $pages = [];

        if (!empty($survey_detail)) {
            foreach ($survey_detail as $sd) {

                if (!empty($sd->page_number)) {

                    $q = json_decode($sd->survey_question);
                    $tmp_question_data[$i]['is_skip_logic_avail']     = $sd->is_skip_logic_avail;
                    $tmp_question_data[$i]['is_required']             = $sd->is_required;
                    $tmp_question_data[$i]['page_number']             = $sd->page_number;
                    $tmp_question_data[$i]['tmp_survey_order_number'] = $sd->survey_order_number;
                    $tmp_question_data[$i]['question_number']         = $sd->question_number;
                    $tmp_question_data[$i]['question_type']           = $sd->survey_question_type;
                    $tmp_question_data[$i]['user_id']                 = $sd->user_id;
                    $tmp_question_data[$i]['question']                = json_encode($q);
                    $tmp_question_data[$i]['tmp_survey_id']           = $id;
                    $tmp_question_data[$i]['tmp_id']                  = TmpSurveyQuestions::insertGetId($tmp_question_data[$i]);

                    // Here first we are finding id from temp table to tmp_skip_logic and updating with the survey block id 
                    $tmp_skip_logic_data_new['question_id'] = $tmp_question_data[$i]['tmp_id'];
                    TmpSkipLogic::where('question_id', $sd->id)->update($tmp_skip_logic_data_new);



                    $tmp_skip_logic_data_skip_question_id['skip_question_id'] = $tmp_question_data[$i]['tmp_id'];
                    TmpSkipLogic::where('skip_question_id', $sd->id)->update($tmp_skip_logic_data_skip_question_id);

                    $tmp_question_data[$i]['question'] = $q->question;

                    if (isset($q->question_points)) {
                        $tmp_question_data[$i]['question_points'] = $q->question_points;
                    } else {
                        $tmp_question_data[$i]['question_points'] = "";
                    }

                    if ($tmp_question_data[$i]['question_type'] == Common::$intPoll || $tmp_question_data[$i]['question_type'] == Common::$intMatrix) {
                        $tmp_question_data[$i]['survey_radio_options'] = DB::table('survey_radio_options')
                            ->leftJoin('survey_radio_points', 'survey_radio_points.radio_options_id', '=', 'survey_radio_options.id')
                            ->where('survey_radio_options.id', $q->sro_id)
                            ->get()->toArray();
                    } else {
                        $tmp_question_data[$i]['survey_radio_options'] = '';
                    }

                    $tmp_question_data[$i]['survey_question_type'] = $sd->survey_question_type;
                    $data['getview'][$i]                           = $this->getQuestion($tmp_question_data[$i]);
                    $data['page_numbs'][$i]                        = $sd->page_number;

                    $pages[] = $sd->page_number;
                    $i++;

                }
            }
        }

        $data['pages']       = array_values(array_unique($pages));
        $data['pages_count'] = array_values(array_unique($pages));

        $data['page_heading']      = json_decode($survey->page_heading);
        $data['id']                = $id;
        $data['checkSurveyFilled'] = $checkSurveyFilled;
        $isUserAdmin               = 1;
        $companyId                 = '';
        if (Auth::User()->role_id == Common::$intRoleUser) {
            //  dd(Auth::User()->id);
            $isUserAdmin = 0;
            $clientId    = DB::table('user_client')->where('user_id', Auth::User()->id)->get()->toArray();
            $clientIds   = [];
            if ($clientId) {

                foreach ($clientId as $currClientId) {

                    $clientIds[] = $currClientId->client_id;
                }
            }

            $first = DB::table('clients')
                ->select(['clients.*'])
                ->join('user_client AS c', 'clients.id', '=', 'c.client_id')
                ->where('client_id', '=', $survey->comp_id);

            $clients = DB::table('clients')
                ->select(['clients.*'])
                ->join('user_client AS c', 'clients.id', '=', 'c.client_id')
                ->where('status', '=', '1')
                ->where('c.user_id', '=', Auth::User()->id)
                ->union($first)
                ->orderBy('company_name', 'ASC')
                ->get();

            $data['clients'] = $clients;

        } else {
            $first = DB::table('clients')
                ->select(['clients.*'])
                ->where('id', '=', $survey->comp_id);

            $clients = DB::table('clients')
                ->select(['clients.*'])
                ->where('status', '=', '1')
                ->union($first)
                ->orderBy('company_name', 'ASC')
                ->get();

            $data['clients'] = $clients;
        }
        return view('admin.surveys.edit', $data, ['isUserAdmin' => $isUserAdmin, 'companyId' => $companyId]);
    }

    public function getQuestion($q)
    {

        $data = array(
            'question'            => $q['question'],
            'question_points'     => $q['question_points'],
            'tmp_question_id'     => $q['tmp_id'],
            'survey_radio_points' => $q['survey_radio_options'],
            'page_number'         => $q['page_number'],
            'question_number'     => $q['question_number'],
            'is_required'         => $q['is_required'],
            'is_skip_logic_avail' => $q['is_skip_logic_avail'],
        );

        switch ($q['survey_question_type']) {

            case Common::$intPoll:
                $view = 'admin.surveys.radioData';
                break;

            case Common::$intCheckboxList:
                $view = 'admin.surveys.checkboxesLabel';
                break;

            case Common::$intMatrix:
                $view = 'admin.surveys.matrixLabel';
                break;

            case Common::$intTextArea:
                $view = 'admin.surveys.commentLabel';
                break;

            case Common::$intTextBox:
                $view = 'admin.surveys.textboxLabel';
                break;

            case Common::$intRadioButtonList:
                $view = 'admin.surveys.singleradioLabel';
                break;

            case Common::$intCheckbox:
                $view = 'admin.surveys.singlechkboxLabel';
                break;

            case Common::$intDropDownList:
                $view = 'admin.surveys.dropdownLabel';
                break;

        }

        return view($view, $data);
    }

    public function addQuestion(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {
            $type = $request->type;
            switch ($type) {
                case 1:
                    $view = 'admin.surveys.radiogroup';
                    break;
                case 2:
                    $view = 'admin.surveys.checkboxes';
                    break;
                case 3:
                    $view = 'admin.surveys.matrix';
                    break;
                case 4:
                    $view = 'admin.surveys.comment';
                    break;
                case 5:
                    $view = 'admin.surveys.textbox';
                    break;
                default:
                    $view = 'admin.surveys.textbox';
            }

            return view($view);
            exit;
        }
    }

    public function questionPopup(\Illuminate\Http\Request $request)
    {
        $survey_radio_options = DB::table('survey_radio_options')
        //->select(['id','title'])
            ->orderBy('id', 'asc')
            ->get();
        $radioPointsOptions = array();
        if (!empty($survey_radio_options)) {
            foreach ($survey_radio_options as $currRadioOption) {
                // $radioPointsOptions[$currRadioOption->id] = $currRadioOption->title . ' (' . $currRadioOption->option_point . 'pts)';
                $radioPointsOptions[$currRadioOption->id] = $currRadioOption->option_point . 'pts' . ' (' . $currRadioOption->title . ')';
            }
        }
        $data = array(
            'radioPointsOptions' => $radioPointsOptions,
        );

        $response = array('status' => 1, 'data' => $data);

        echo json_encode($response);
        exit;

    }

    public function questionsubData(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $id                  = $request->id;
            $survey_radio_points = DB::table('survey_radio_points')
                ->where('radio_options_id', '=', $id)
                ->orderBy('id', 'asc')
                ->get();
            return view('admin.surveys.radioPoints', ['survey_radio_points' => $survey_radio_points]);
            exit;

        }

    }

    public function questionparentData(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $id = $request->id;

            switch ($id) {
                case 1:
                    $survey_radio_points = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $id)
                        ->orderBy('id', 'asc')
                        ->get();
                    return view('admin.surveys.radioPoints', ['survey_radio_points' => $survey_radio_points]);
                    break;
                case 2:
                    $view = 'admin.surveys.checkboxes';
                    return view($view);
                    break;
                case 3:
                    $view = 'admin.surveys.matrix';
                    return view($view);
                    break;
                case 4:
                    $view = 'admin.surveys.comment';
                    return view($view);
                    break;
                case 5:
                    $view = 'admin.surveys.textbox';
                    return view($view);
                    break;
                case 6:
                    $view = 'admin.surveys.singleradio';
                    return view($view);
                    break;
                case 7:
                    $view = 'admin.surveys.singlechkbox';
                    return view($view);
                    break;
                case 8:
                    $view = 'admin.surveys.dropdown';
                    return view($view);
                    break;
                default:
                    $view = 'admin.surveys.textbox';
                    return view($view);
            }

            exit;

        }
    }
    public function getQuestionNumber($page_number, $user_id, $tmp_survey_id = null)
    {

        if (!empty($tmp_survey_id)) {
            $questionNumber = DB::table('tmp_survey_questions')
                ->where('page_number', '=', $page_number)
                //->where('user_id', '=', $user_id)
                ->where('tmp_survey_id', '=', $tmp_survey_id)
                ->orderBy('id', 'asc')
                ->get();

        } else {
            $questionNumber = DB::table('tmp_survey_questions')
                ->where('page_number', '=', $page_number)
                ->where('user_id', '=', $user_id)
                ->orderBy('id', 'asc')
                ->get();
        }

        $questionNumber = count($questionNumber);
        return $questionNumber;

    }

    public function addQuestionTmp(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {
            $radioId     = $request->post('radio_id');
            $page_number = $request->post('page_number');

            switch ($radioId) {
                case 1:

                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;

                    $tmp_question_data['question'] = json_encode(array(
                        'question' => $request->post('question'),
                        'sro_id'   => $request->post('radio_id_sub'),
                    ));
                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;

                    $tmp_question_id = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $survey_radio_points = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $request->post('radio_id_sub'))
                        ->orderBy('id', 'asc')
                        ->get();

                    return view('admin.surveys.radioData', ['tmp_question_id' => $tmp_question_id, 'survey_radio_points' => $survey_radio_points, 'question' => $request->post('question'), 'question_number' => $question_number, 'is_required' => '0','is_skip_logic_avail'=>'0']);

                case 2:
                    $view = 'admin.surveys.checkboxesLabel';

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    );

                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    ));

                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;

                    $last_id = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';

                    return view($view, $data);
                    break;

                case 3:
                    $view = 'admin.surveys.matrixLabel';
                    $final_question_points = [];
                    
                    $question_points = array_filter($request->post('array_points'));
                    $array_points_numbers = array_filter($request->post('array_points_numbers'));
                   
                    for($i=0;$i<count($question_points);$i++){
                        
                        $final_question_points[] = (object)  array(
                                                            'question'=> $question_points[$i],
                                                            'question_number'=>$array_points_numbers[$i],
                                                        );

                    }
                    
                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $final_question_points,
                    );
                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => $final_question_points,
                        'sro_id'          => $request->post('radio_id_sub'),
                    ));

                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data['tmp_question_id']     = $last_id;
                    $data['question_number']     = $question_number;
                    $data['survey_radio_points'] = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $request->post('radio_id_sub'))
                        ->orderBy('id', 'asc')
                        ->get()->toArray();
                    $data['is_required'] = '0';
                    $data['is_skip_logic_avail']     = '0';

                    return view($view, $data);
                    break;

                case 4:
                    $view                               = 'admin.surveys.commentLabel';
                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                    ));
                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                        'tmp_question_id' => $tmp_question_id,

                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';
                    return view($view, $data);

                    break;

                case 5:
                    $view = 'admin.surveys.textboxLabel';

                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                    ));
                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                        'tmp_question_id' => $tmp_question_id,
                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';
                    return view($view, $data);
                    break;

                case 6:
                    $view = 'admin.surveys.singleradioLabel';

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    );
                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    ));

                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';

                    return view($view, $data);
                    break;

                case 7:
                    $view = 'admin.surveys.singlechkboxLabel';

                    // dd( $request->post('array_points'));

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                    );
                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                    ));
                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';
                    return view($view, $data);
                    break;

                case 8:
                    $view = 'admin.surveys.dropdownLabel';

                    $tmp_question_data['page_number']   = $page_number;
                    $tmp_question_data['question_type'] = $radioId;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    $tmp_question_data['question']      = json_encode(array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    ));

                    $question_number                              = $this->getQuestionNumber($page_number, Auth::id(), $request->survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                        'tmp_question_id' => $tmp_question_id,
                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = '0';
                    $data['is_skip_logic_avail']     = '0';
                    return view($view, $data);

                    break;

            }

            //exit;

        }
    }

    public function deleteQuestionTmp(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $tmp_id      = $request->post('tmp_id');
            $page_number = $request->post('page_number');
            $user_id     = $request->post('user_id');
            $tmpIdsArray      = $request->post('tmpIdsArray');
            DB::table('tmp_survey_questions')->where('id', $tmp_id)->delete();
            $questions = DB::table('tmp_survey_questions');
            $questions->where('page_number', '=', $page_number);
            
            if ($request->post('survey_id') != '') {
                $questions->where('tmp_survey_id', '=', $request->post('survey_id'));
            }else {
                $questions->where('user_id', '=', $user_id);
            }
            $questions->orderBy('question_number', 'asc');
            $question = $questions->get();

            $questions = $question;

            $newPageNumber   = 1;
            $isDataAvailable = 'no';
            if ($questions->isNotEmpty()) {
                $isDataAvailable = 'yes';
            }
            if (!empty($questions)) {

                foreach ($questions as $currQuestion) {

                    DB::table('tmp_survey_questions')
                        ->where('id', $currQuestion->id)
                        ->update([
                            'question_number'         => $newPageNumber,
                            'tmp_survey_order_number' => $newPageNumber,

                        ]);

                    $newPageNumber = $newPageNumber + 1;
                }
            }
            // Deleting from tmp_skip_logic table based on tmp_id 
            DB::table('tmp_skip_logic')->where('question_id', $tmp_id)->delete();
            DB::table('tmp_skip_logic')->where('skip_question_id', $tmp_id)->delete();

            if(!empty($tmpIdsArray)){
                DB::table('tmp_skip_logic')->whereIn('question_id', $tmpIdsArray)->delete();
                DB::table('tmp_skip_logic')->whereIn('skip_question_id', $tmpIdsArray)->delete();
            }
            


            // resetting the numbers based on user id  and page number
            $response = array('status' => 1, 'isDataAvailable' => $isDataAvailable);
            echo json_encode($response);
            exit;
        }
    }

    public function cloneQuestionTmp(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $tmp_id = $request->post('tmp_id');

            $tmp_survey_question = DB::table('tmp_survey_questions')
                ->where('id', '=', $tmp_id)
                ->first();
           // dd($tmp_survey_question);
            $question_type = $tmp_survey_question->question_type;

            switch ($question_type) {

                /**********************
                 * Mittul Code start
                 *************************/

                case 1:

                    $tmp_question_data['question_type'] = $question_type;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['question']      = $tmp_survey_question->question;
                    $tmp_question_data['page_number']   = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id'] = $tmp_survey_question->tmp_survey_id;
                    //$tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;

                    $question_number                      = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                      = $question_number + 1;
                    $tmp_question_data['question_number'] = $question_number;

                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_question_id)
                            ->first())->toArray();

                    $sro_id   = json_decode($tmp_survey_question['question'])->sro_id;
                    $question = json_decode($tmp_survey_question['question'])->question;

                    //dd($tmp_survey_question->question->sro_id);
                    $survey_radio_points = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $sro_id)
                        ->orderBy('id', 'asc')
                        ->get();

                    return view('admin.surveys.radioData', ['tmp_question_id' => $tmp_question_id, 'survey_radio_points' => $survey_radio_points, 'question' => $question, 'question_number' => $question_number, 'is_required' => $tmp_survey_question['is_required'],'is_skip_logic_avail'=>$tmp_survey_question['is_skip_logic_avail']]);

                    break;
                case 8:

                    $view                               = 'admin.surveys.dropdownLabel';
                    $tmp_question_data['question_type'] = $question_type;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['question']      = $tmp_survey_question->question;
                    $tmp_question_data['page_number']   = $tmp_survey_question->page_number;

                    $tmp_question_data['tmp_survey_id'] = $tmp_survey_question->tmp_survey_id;

                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                   // $tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_question_id)
                            ->first())->toArray();

                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_question_id,
                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;

                case 5:
                    $view = 'admin.surveys.textboxLabel';

                    $tmp_question_data['question_type']           = $question_type;
                    $tmp_question_data['user_id']                 = Auth::id();
                    $tmp_question_data['question']                = $tmp_survey_question->question;
                    $tmp_question_data['page_number']             = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id']           = $tmp_survey_question->tmp_survey_id;
                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                    //$tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_question_id)
                            ->first())->toArray();

                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_question_id,
                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;

                case 4:
                    $view                                         = 'admin.surveys.commentLabel';
                    $tmp_question_data['question_type']           = $question_type;
                    $tmp_question_data['user_id']                 = Auth::id();
                    $tmp_question_data['question']                = $tmp_survey_question->question;
                    $tmp_question_data['page_number']             = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id']           = $tmp_survey_question->tmp_survey_id;
                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                    //$tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $tmp_question_id                              = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_question_id)
                            ->first())->toArray();

                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_question_id,
                    );
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;
                /**********************
                 * Mittul Code End
                 **********************/

                /**********************
                 * Bhavin Code start
                 *************************/

                case 7:

                    $view                                         = 'admin.surveys.singlechkboxLabel';
                    $tmp_question_data['question_type']           = $question_type;
                    $tmp_question_data['user_id']                 = Auth::id();
                    $tmp_question_data['question']                = $tmp_survey_question->question;
                    $tmp_question_data['page_number']             = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id']           = $tmp_survey_question->tmp_survey_id;
                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                    //$tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $last_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 2:
                    $view = 'admin.surveys.checkboxesLabel';

                    $tmp_question_data['question_type']           = $question_type;
                    $tmp_question_data['user_id']                 = Auth::id();
                    $tmp_question_data['question']                = $tmp_survey_question->question;
                    $tmp_question_data['page_number']             = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id']           = $tmp_survey_question->tmp_survey_id;
                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                   // $tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $last_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 6:
                    $view = 'admin.surveys.singleradioLabel';

                    $tmp_question_data['question_type']           = $question_type;
                    $tmp_question_data['user_id']                 = Auth::id();
                    $tmp_question_data['question']                = $tmp_survey_question->question;
                    $tmp_question_data['page_number']             = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id']           = $tmp_survey_question->tmp_survey_id;
                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                  //  $tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $last_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $last_id;
                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 3:
                    $view = 'admin.surveys.matrixLabel';

                    $tmp_question_data['question_type'] = $question_type;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['question']      = $tmp_survey_question->question;
                    $tmp_question_data['page_number']   = $tmp_survey_question->page_number;
                    $tmp_question_data['tmp_survey_id'] = $tmp_survey_question->tmp_survey_id;

                    $question_number                              = $this->getQuestionNumber($tmp_survey_question->page_number, Auth::id(), $tmp_survey_question->tmp_survey_id);
                    $question_number                              = $question_number + 1;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['is_required']             = $tmp_survey_question->is_required;
                   // $tmp_question_data['is_skip_logic_avail'] = $tmp_survey_question->is_skip_logic_avail;
                    $last_id                                      = TmpSurveyQuestions::insertGetId($tmp_question_data);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $last_id)
                            ->first())->toArray();

                    $sro_id                      = json_decode($tmp_survey_question['question'])->sro_id;
                    $data['survey_radio_points'] = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $sro_id)
                        ->orderBy('id', 'asc')
                        ->get();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $last_id;

                    $data['question_number'] = $question_number;
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;

                    /**********************
             * Bhavin Code End
             **********************/
            }

            exit;

        }
    }

    public function editQuestionTmpPopup(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $tmp_id = $request->post('tmp_id');

            $tmp_survey_question = DB::table('tmp_survey_questions')
                ->where('id', '=', $tmp_id)
                ->first();

            $question_type        = $tmp_survey_question->question_type;
            $survey_radio_options = DB::table('survey_radio_options')
                ->orderBy('id', 'asc')
                ->get();
            $radioPointsOptions = array();
            if (!empty($survey_radio_options)) {
                foreach ($survey_radio_options as $currRadioOption) {
                    $radioPointsOptions[$currRadioOption->id] = $currRadioOption->title . ' (' . $currRadioOption->option_point . 'pts)';
                }
            }
            switch ($question_type) {

                case 1:

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data = array(
                        'radioPointsOptions'  => $radioPointsOptions,
                        'tmp_survey_question' => $tmp_survey_question,
                        'tmp_id'              => $tmp_id,
                        'page_number'         => $tmp_survey_question->page_number,
                        'question_number'     => $tmp_survey_question->question_number,

                    );

                    $response = array('status' => 1, 'data' => $data, 'question_type' => $question_type);

                    echo json_encode($response);

                    break;
                case 2:
                    $view = 'admin.surveys.checkboxesEdit';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 3:
                    $view = 'admin.surveys.matrixEdit';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 4:
                    $view = 'admin.surveys.comment';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 5:
                    $view = 'admin.surveys.textbox';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 6:
                    $view = 'admin.surveys.singleradioEdit';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 7:
                    $view = 'admin.surveys.singlechkboxEdit';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
                case 8:
                    $view = 'admin.surveys.dropdownEdit';
                    $data = $this->editViewQuery($view, $tmp_id, $question_type);
                    echo json_encode($data);
                    break;
            }

            return;

        }
    }

    public function editViewQuery($view, $tmp_id, $question_type)
    {
        $tmp_survey_question = Collect(DB::table('tmp_survey_questions')->where('id', '=', $tmp_id)->first())->toArray();

        $question_points = json_decode($tmp_survey_question['question'])->question_points;
        $question        = json_decode($tmp_survey_question['question'])->question;

        $returnHTML = view($view)
            ->with(
                [
                    'question_points' =>  $question_points,
                    'question'        => $question,
                ]
            )
            ->render();
        $survey_radio_options = DB::table('survey_radio_options')
            ->orderBy('id', 'asc')
            ->get();
        $radioPointsOptions = array();
        if (!empty($survey_radio_options)) {
            foreach ($survey_radio_options as $currRadioOption) {
                $radioPointsOptions[$currRadioOption->id] = $currRadioOption->title . ' (' . $currRadioOption->option_point . 'pts)';
            }
        }

        //dd($returnHTML);

        $data = array(
            'tmp_survey_question' => $tmp_survey_question,
            'tmp_id'              => $tmp_id,
            'page_number'         => $tmp_survey_question['page_number'],
            'question_points'     => $question_points,
            'question'            => $question,
            'status'              => 1,
            'question_type'       => $question_type,
            'data'                => [
                'tmp_survey_question' => [
                    'question_type'   => $question_type,
                    'question_number' => $tmp_survey_question['question_number'],
                ],
                'radioPointsOptions'  => $radioPointsOptions,
            ],
            'dataView'            => $returnHTML,
        );

        return $data;
    }

    public function updateQuestionTmp(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {

            $tmp_id              = $request->post('tmp_id');
            $tmpIdsArray              = $request->post('tmpIdsArray');
            // Deleting from tmp_skip_logic table based on tmp_id 
            DB::table('tmp_skip_logic')->where('question_id', $tmp_id)->delete();
            DB::table('tmp_skip_logic')->where('skip_question_id', $tmp_id)->delete();

            if(!empty($tmpIdsArray)){
                DB::table('tmp_skip_logic')->whereIn('question_id', $tmpIdsArray)->delete();
                DB::table('tmp_skip_logic')->whereIn('skip_question_id', $tmpIdsArray)->delete();
            }
            
            $tmp_survey_question = DB::table('tmp_survey_questions')
                ->where('id', '=', $tmp_id)
                ->first();

            //   $question_type = $tmp_survey_question->question_type;
            $question_type = $request->post('radio_id');

            switch ($question_type) {
                case 1:

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question' => $request->post('question'),
                                'sro_id'   => $request->post('radio_id_sub'),
                            )),

                        ]);

                    $survey_radio_points = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $request->post('radio_id_sub'))
                        ->orderBy('id', 'asc')
                        ->get();

                    return view('admin.surveys.radioData', ['tmp_question_id' => $tmp_id, 'survey_radio_points' => $survey_radio_points, 'question' => $request->post('question'), 'question_number' => $tmp_survey_question->question_number, 'is_required' => $tmp_survey_question->is_required,'is_skip_logic_avail'=>$tmp_survey_question->is_skip_logic_avail]);
                    break;

                case 2:
                    $view = 'admin.surveys.checkboxesLabel';

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    );

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => array_filter($request->post('array_points')),
                            )),

                        ]);

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['tmp_question_id'] = $tmp_id;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;

                    return view($view, $data);
                    break;

                case 3:
                    $view = 'admin.surveys.matrixLabel';

                    $final_question_points = [];
                    
                    $question_points = array_filter($request->post('array_points'));
                    $array_points_numbers = array_filter($request->post('array_points_numbers'));
                   
                    for($i=0;$i<count($question_points);$i++){
                        
                        $final_question_points[] = (object)  array(
                                                            'question'=> $question_points[$i],
                                                            'question_number'=>$array_points_numbers[$i],
                                                        );

                    }


                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $final_question_points,
                    );
                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => $final_question_points,
                                'sro_id'          => $request->post('radio_id_sub'),
                            )),

                        ]);

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;

                    $data['tmp_question_id'] = $tmp_id;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;

                    $data['survey_radio_points'] = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $request->post('radio_id_sub'))
                        ->orderBy('id', 'asc')
                        ->get()->toArray();

                    return view($view, $data);
                    break;

                case 4:

                    $view = 'admin.surveys.commentLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => $request->post('array_points'),
                            )),

                        ]);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                        'tmp_question_id' => $tmp_id,
                    );

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;
                    return view($view, $data);

                    break;

                case 5:

                    $view = 'admin.surveys.textboxLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => $request->post('array_points'),
                            )),

                        ]);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                        'tmp_question_id' => $tmp_id,
                    );

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;
                    return view($view, $data);
                    break;

                case 6:
                    $view = 'admin.surveys.singleradioLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => array_filter($request->post('array_points')),
                            )),

                        ]);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                    );

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;
                    $data['tmp_question_id'] = $tmp_id;

                    return view($view, $data);
                    break;

                case 7:
                    $view = 'admin.surveys.singlechkboxLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => $request->post('array_points'),
                            )),

                        ]);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => $request->post('array_points'),
                    );

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['is_required']     = $tmp_survey_question->is_required;

                    $data['tmp_question_id'] = $tmp_id;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;
                    return view($view, $data);
                    break;

                case 8:
                    $view = 'admin.surveys.dropdownLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'question_type' => $question_type,
                            'user_id'       => Auth::id(),
                            'question'      => json_encode(array(
                                'question'        => $request->post('question'),
                                'question_points' => array_filter($request->post('array_points')),
                            )),

                        ]);

                    $data = array(
                        'question'        => $request->post('question'),
                        'question_points' => array_filter($request->post('array_points')),
                        'tmp_question_id' => $tmp_id,
                    );

                    $tmp_survey_question = DB::table('tmp_survey_questions')
                        ->where('id', '=', $tmp_id)
                        ->first();

                    $data['question_number'] = $tmp_survey_question->question_number;
                    $data['is_required']     = $tmp_survey_question->is_required;
                    $data['is_skip_logic_avail']     = $tmp_survey_question->is_skip_logic_avail;
                    return view($view, $data);
            }

            exit;

        }
    }

    public function isRequiredQuestionTmp(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {

            $tmp_id      = $request->post('tmp_id');
            $is_required = $request->post('is_required');

            $tmp_survey_question = DB::table('tmp_survey_questions')
                ->where('id', '=', $tmp_id)
                ->first();

            $question_type = $tmp_survey_question->question_type;

            switch ($question_type) {

                case 1:

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $sro_id   = json_decode($tmp_survey_question['question'])->sro_id;
                    $question = json_decode($tmp_survey_question['question'])->question;

                    //dd($tmp_survey_question->question->sro_id);
                    $survey_radio_points = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $sro_id)
                        ->orderBy('id', 'asc')
                        ->get();

                    return view('admin.surveys.radioData', ['tmp_question_id' => $tmp_id, 'survey_radio_points' => $survey_radio_points, 'question' => $question, 'question_number' => $tmp_survey_question['question_number'], 'is_required' => $tmp_survey_question['is_required'],'is_skip_logic_avail'=>$tmp_survey_question['is_skip_logic_avail']]);
                    break;

                case 2:
                    $view = 'admin.surveys.checkboxesLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $tmp_id;
                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 3:
                    $view = 'admin.surveys.matrixLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);
                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $sro_id                      = json_decode($tmp_survey_question['question'])->sro_id;
                    $data['survey_radio_points'] = DB::table('survey_radio_points')
                        ->where('radio_options_id', '=', $sro_id)
                        ->orderBy('id', 'asc')
                        ->get();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $tmp_id;

                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;

                case 4:
                    $view = 'admin.surveys.commentLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_id,
                    );
                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 5:
                    $view = 'admin.surveys.textboxLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();
                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_id,
                        'question_number' => $tmp_survey_question['question_number'],
                        'is_required'     => $tmp_survey_question['is_required'],
                    );
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;

                case 6:
                    $view = 'admin.surveys.singleradioLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $tmp_id;
                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 7:

                    $view = 'admin.surveys.singlechkboxLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);
                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $data['question_points'] = json_decode($tmp_survey_question['question'])->question_points;
                    $data['question']        = json_decode($tmp_survey_question['question'])->question;
                    $data['tmp_question_id'] = $tmp_id;
                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);

                    break;

                case 8:

                    $view = 'admin.surveys.dropdownLabel';

                    DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_required' => $is_required,

                        ]);

                    $tmp_survey_question = Collect(DB::table('tmp_survey_questions')
                            ->where('id', '=', $tmp_id)
                            ->first())->toArray();

                    $data = array(
                        'question'        => json_decode($tmp_survey_question['question'])->question,
                        'question_points' => json_decode($tmp_survey_question['question'])->question_points,
                        'tmp_question_id' => $tmp_id,
                    );
                    $data['question_number'] = $tmp_survey_question['question_number'];
                    $data['is_required']     = $tmp_survey_question['is_required'];
                    $data['is_skip_logic_avail']     = $tmp_survey_question['is_skip_logic_avail'];
                    return view($view, $data);
                    break;
            }
        }
    }

    public function getSurveyLink(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $surveyId  = $request->post('surveyId');
            $getSurvey = DB::table('surveys')
                ->select('url')
                ->where('id', '=', $surveyId)
                ->first();

            $response = array('status' => 1, 'surveyUrl' => $getSurvey->url);
            echo json_encode($response);
            exit;
        }
    }
    public function downloadSurveyReport($intSurveyId)
    {
        
       $surveyAnswerUrls = DB::table('users_survey_answer')
            ->select(DB::raw('MIN(users_survey_answer.id) AS MINID '), 'users_survey_answer.url')
            ->orderBy('MINID')  
             ->where('survey_id', $intSurveyId)     
            ->groupBy('users_survey_answer.url')     
             
            ->get()
            ->toArray();
            
            $i = 0;
            foreach ($surveyAnswerUrls as $currsurveyAnswerUrls) {
               $question =  DB::table('users_survey_answer')
                    ->where('url', '=', $currsurveyAnswerUrls->url)
                     ->orderBy('page_number')
                    ->orderBy('survey_order_number')
                    // ->orderBy('users_survey_answer.id')       
                    ->get();
                   
                $j = 0;
                $num  = $i + 1;
                $arrQuestions[$i][] = 'User ID : ' . $num;
                 $arrAnswers[$i][] = '';
                 //$arrQuestions[$i][] = 'User ID';
                foreach($question as $currQuestion){                   
                    
                    // For Question Starts 
                   
                    $arrQue = json_decode($currQuestion->question, 1);
                    if ($currQuestion->question_type == 3) {
                          array_multisort(array_map(function($element) {
                                                   return $element['question_number'];
                                             }, $arrQue['question_points']), SORT_ASC, $arrQue['question_points']);
                        foreach ($arrQue['question_points'] as $value) {                            
                            $arrQuestions[$i][] = empty($arrQue['question']) ? '"' . $value['question'] . '"' : '"'  . $value['question'] . '"';
                        }
                    } else {
                        $arrQuestions[$i][] = '"' . $arrQue['question'] . '"';
                    }
                    // For Question Ends 

                    // For Answer Starts 
                   
                     $arrAns = json_decode($currQuestion->answer, 1);
                    //  echo '<pre>';
                    //  print_r($arrAns);
                    if ($currQuestion->question_type == 2) {
                        $arrAnswers[$i][] = '"' . implode(',', $arrAns) . '"';
                    } elseif ($currQuestion->question_type == 1 || $currQuestion->question_type == 3) {
                        foreach ($arrAns as $value) {
                            $arrAnswers[$i][] = isset($arrPoll[$value]) ? $arrPoll[$value] : $value;
                        }
                    } elseif ($currQuestion->question_type == 7) {
                        // dd($arrAns);
                        if (isset($arrAns[0]) && $arrAns[0] == 'yes') {
                            $arrAnswers[$i][] = 1;
                        } elseif (isset($arrAns[0]) && $arrAns[0]  == 'no') {
                            $arrAnswers[$i][] = 2;
                        } else {
                            $arrAnswers[$i][] = '"' . implode(',', $arrAns) . '"';
                        }

                    } else {
                        $arrAnswers[$i][] = '"' . implode(',', $arrAns) . '"';
                    }
                    // For Answer Ends  
                    $j++;
                }
                 
                $i++;
            }

            
            // echo '<pre>';
            // print_r($arrQuestions);
            // print_r($arrAnswers);
            // exit;
            $finalArray = array();
            if(!empty($arrQuestions)){
                for($z=0;$z<count($arrQuestions);$z++){
                    if($z != 0){
                            $finalArray[] = array();
                    }
                    $finalArray[] = $arrQuestions[$z];
                    
                    $finalArray[] = $arrAnswers[$z];
                }
            }

            $output = '';
            if(!empty($finalArray)){
                foreach ($finalArray as $finalArrays) {           
                      $output .=  implode(",", $finalArrays) . "\n" ; 
                }
            }
             

            $getSurvey = DB::table('surveys')
            ->select('survey_name')
            ->where('id', '=', $intSurveyId)
            ->first();

            $filename = str_slug($getSurvey->survey_name, "-");            
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );
            return Response::make(rtrim($output, "\n"), 200, $headers);
              
            
    }
    public function downloadSurveyReportBkp($intSurveyId)
    {

        $objQuestions = DB::table('survey_blocks AS sb')
            ->select(['sb.survey_question', 'sb.survey_order_number', 'sb.survey_question_type'])
            ->where('sb.survey_id', $intSurveyId)
            ->orderBy('sb.survey_order_number')
            ->get();
           // dd($objQuestions);
        // dd($objQuestions);
        $arrQuestions = [];
        if ($objQuestions->count() > 0) {
            $arrQuestions[] = 'User ID';
            foreach ($objQuestions as $key => $objQuestion) {
                $arrQue = json_decode($objQuestion->survey_question, 1);
                if ($objQuestion->survey_question_type == 3) {
                    foreach ($arrQue['question_points'] as $value) {
                        //$arrQuestions[] = empty($arrQue['question']) ? '"' . $value . '"' : '"' . $arrQue['question'] . ' - ' . $value . '"';
                        $arrQuestions[] = empty($arrQue['question']) ? '"' . $value . '"' : '"'  . $value . '"';
                    }
                } else {
                    $arrQuestions[] = '"' . $arrQue['question'] . '"';
                }
            }
        }
        // dd($arrQuestions);

        $objRadioOption = DB::table('survey_radio_points')->get();
        $arrPoll        = [];
        if ($objRadioOption->count() > 0) {
            foreach ($objRadioOption as $value) {
                // $arrPoll[$value->id] = $value->point_option;
                $arrPoll[$value->id] = $value->number;
            }
        }
        // dd($arrPoll);

        $arrColumns = [
            'usa.answer', 'usa.question_type', 'usa.survey_block_id', 'usa.url', 'usa.survey_number',
            'sb.survey_question', 'sb.survey_order_number', 'sb.survey_question_type', 'sb.page_number',
        ];
        $objAnswers = DB::table('users_survey_answer AS usa')
            ->select($arrColumns)
        // ->join('surveys AS s', 's.id', 'usa.survey_id')
            ->join('survey_blocks AS sb', 'sb.id', 'usa.survey_block_id')
            ->where('usa.survey_id', $intSurveyId)
            ->orderBy('sb.page_number')
            ->orderBy('sb.survey_order_number')
            ->get();
        // dd($objAnswers);
        $arrAnswers = [];
        if ($objAnswers->count() > 0) {
            $intTotalRow = $objAnswers->count() / $objQuestions->count();
            $intTotalCol = $objAnswers->count() / $intTotalRow;
            // dd($intTotalRow . '/' . $intTotalCol);
            $intId = $objAnswers[0]->survey_block_id;

            $row = $col = 1;
            foreach ($objAnswers as $key => $objAnswer) {
                if ($intId == $objAnswer->survey_block_id) {
                    // $arrAnswers[$row][] = isset($objAnswer->url) ? $objAnswer->url : 'N/A';
                    // $arrAnswers[$row][] = "Survey-" . $row;
                    $arrAnswers[$row][] = '"' . sprintf('%07d', $objAnswer->survey_number) . '"';
                }
                if ($row > $intTotalRow) {
                    $row = $col = 1;
                }
                $arrAns = json_decode($objAnswer->answer, 1);
                if ($objAnswer->survey_question_type == 2) {
                    $arrAnswers[$row][] = '"' . implode(',', $arrAns) . '"';
                } elseif ($objAnswer->survey_question_type == 1 || $objAnswer->survey_question_type == 3) {
                    foreach ($arrAns as $value) {
                        $arrAnswers[$row][] = isset($arrPoll[$value]) ? $arrPoll[$value] : $value;
                    }
                } elseif ($objAnswer->survey_question_type == 7) {
                    // dd($arrAns);
                    if (isset($arrAns[0]) && $arrAns[0] == 'yes') {
                        $arrAnswers[$row][] = 1;
                    } elseif (isset($arrAns[0]) && $arrAns[0]  == 'no') {
                        $arrAnswers[$row][] = 2;
                    } else {
                        $arrAnswers[$row][] = '"' . implode(',', $arrAns) . '"';
                    }

                } else {
                    $arrAnswers[$row][] = '"' . implode(',', $arrAns) . '"';
                }
                $row++;
            }
        }
        // dd($arrAnswers);
        // the csv file with the first row
        $output = implode(",", $arrQuestions);

        foreach ($arrAnswers as $arrAnswer) {
            // iterate over each tweet and add it to the csv
            $output .= "\n" . implode(",", $arrAnswer); // append each row
        }
        // $columns = array('Answer');
        // $callback = function () use ($reviews, $columns) {
        //     $file = fopen('php://output', 'w');
        //     fputcsv($file, $columns);

        //     foreach ($reviews as $review) {
        //         fputcsv($file, array($review->answer));
        //     }
        //     fclose($file);
        // };

        // getting survey name based on survey id
        $getSurvey = DB::table('surveys')
            ->select('survey_name')
            ->where('id', '=', $intSurveyId)
            ->first();

        $filename = str_slug($getSurvey->survey_name, "-");

        //$filename = $getSurvey->survey_name;
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );
        return Response::make(rtrim($output, "\n"), 200, $headers);
        // return (new StreamedResponse($callback, 200, $headers))->sendContent();
        // return Response::stream($callback, 200, $headers);
    }

    public function reorderQuestions(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) {
            $dataIds      = $request->post('dataIds');
            $orderNumbers = $request->post('orderNumbers');
            $i            = 0;
            foreach ($dataIds as $currentDataId) {
                DB::table('tmp_survey_questions')
                    ->where('id', $currentDataId)
                    ->update([
                        'tmp_survey_order_number' => $orderNumbers[$i],
                        'question_number'         => $orderNumbers[$i],

                    ]);

                $i++;
            }
            // $surveyId  = $request->post('surveyId');
            // $getSurvey = DB::table('surveys')
            //     ->select('url')
            //     ->where('id', '=', $surveyId)
            //     ->first();

            $response = array('status' => 1);
            echo json_encode($response);
            exit;
        }
    }
    public function dashboardData()
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
        }
        $objSurvey = $objSurvey->first();
        // dd($objSurvey);

        $arrSurveyIds = empty($objSurvey) ? [] : explode(',', $objSurvey->survey_ids);
        $objRespoded  = DB::table('users_survey_answer')
            ->select([DB::raw('count(DISTINCT(url)) as total_responded')]);
        if (!Common::isAdmin()) {
            $objRespoded->whereIn('survey_id', $arrSurveyIds);
        }
        $objRespoded = $objRespoded->first();

        $data['intActiveSurvey'] = empty($objSurvey) ? 0 : $objSurvey->total_active;
        $data['intInvited']      = empty($objSurvey) ? 0 : $objSurvey->total_invitation;
        $data['intResponed']     = empty($objRespoded) ? 0 : $objRespoded->total_responded;

        $data['intAverageParticipation'] = $data['intInvited'] > 0 ? number_format((100 * $data['intResponed']) / $data['intInvited'], 2) : 0;
        return $dashboarData             = $data;
    }

    public function copysurvey(Request $request)
    {
        if ($request->isMethod('post')) {
            $surveyId = $request->id;

            // First Getting all the survey data based on survey id
            $survey = DB::table('surveys')
                ->where(['surveys.id' => $surveyId])
                ->first();
            $status = '0';
            if ($survey) {
                $status = '1';

                $survey_company_logo_new = '';
                if (!empty($survey->survey_company_logo)) {
                    $company_original_path   = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH', '');
                    $company_thumb_path      = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', '');
                    $survey_company_logo     = $survey->survey_company_logo;
                    $logoExtension           = explode('.', $survey->survey_company_logo);
                    $filename                = time() . '.' . end($logoExtension);
                    $survey_company_logo_new = $filename;

                    if (\File::copy($company_original_path . $survey_company_logo, $company_original_path . $filename)) {
                    }

                    if (\File::copy($company_thumb_path . $survey_company_logo, $company_thumb_path . $filename)) {
                    }

                }

                $welcome_image_new = '';
                if (!empty($survey->welcome_image)) {
                    $welcome_image_path = public_path() . env('SURVEY_UPLOAD_PATH', '');
                    $welcome_image      = $survey->welcome_image;
                    $logoExtension      = explode('.', $survey->welcome_image);
                    $filename           = time() . '.' . end($logoExtension);
                    $welcome_image_new  = $filename;
                    if (\File::copy($welcome_image_path . $welcome_image, $welcome_image_path . $filename)) {
                    }

                }

                $randomStr                           = (string) Str::uuid();
                $survey_data['user_id']              = Auth::id();
                $survey_data['page_heading']         = $survey->page_heading;
                $survey_data['url']                  = $randomStr;
                $survey_data['comp_id']              = $survey->comp_id;
                $survey_data['survey_company_logo']  = $survey_company_logo_new;
                $survey_data['survey_name']          = $survey->survey_name . ' - Copy';
                $survey_data['max_invitations']      = $survey->max_invitations;
                $survey_data['start_date']           = $survey->start_date;
                $survey_data['end_date']             = $survey->end_date;
                $survey_data['show_logo']            = $survey->show_logo;
                $survey_data['welcome_image']        = $welcome_image_new;
                $survey_data['welcome_description']  = $survey->welcome_description;
                $survey_data['thankyou_description'] = $survey->thankyou_description;
                $survey_data['status']               = $survey->status;
                $survey_data['created_at']           = DB::raw('NOW()');
                $survey_data['updated_at']           = DB::raw('NOW()');
                $survey_id                           = Survey::insertGetId($survey_data);

                // Now we are getting survey block records based on the old survey id we have (getting survey questions etc)
                $surveyBlocks = DB::table('survey_blocks')
                    ->where('survey_id', '=', $surveyId)
                    ->orderBy('page_number', 'asc')
                    ->get();
                if ($surveyBlocks) {
                    foreach ($surveyBlocks as $curr_survey_block) {
                        $question_data['user_id']              = Auth::id();
                        $question_data['survey_id']            = $survey_id;
                        $question_data['survey_question']      = $curr_survey_block->survey_question;
                        $question_data['survey_question_type'] = $curr_survey_block->survey_question_type;
                        $question_data['page_number']          = $curr_survey_block->page_number;
                        $question_data['question_number']      = $curr_survey_block->question_number;
                        $question_data['is_required']          = $curr_survey_block->is_required;
                        $question_data['survey_order_number']  = $curr_survey_block->survey_order_number;

                        $question_id = SurveyBlocks::insertGetId($question_data);
                    }
                }

            }
            $dashboardData = $this->dashboardData();
            $response      = array('status' => $status, 'dashboardData' => $dashboardData);
            echo json_encode($response);
            exit;

        }

    }

    public function searchsurveysdashboard(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {

           

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
            
            $searchQuery['defaultLimit'] = 12;
            $searchQuery['offset'] = $request->offset;
            $data = $surveyMethod->searchSurveyCommon($searchQuery);
            $data['intActiveSurvey'] = empty($objSurvey) ? 0 : $objSurvey->total_active;
            $data['intInvited']      = empty($objSurvey) ? 0 : $objSurvey->total_invitation;
            $data['intResponed']     = empty($objRespoded) ? 0 : $objRespoded->total_responded;            
            $data['intAverageParticipation'] = $data['intInvited'] > 0 ? number_format((100 * $data['intResponed']) / $data['intInvited'], 2) : 0;
            return view('admin.surveys.search', $data);

            exit;
        }
    }

    public function updatePageNumberQuestionTmp(Request $request)
    {
        if ($request->isMethod('post')) {
            $old_page_number = $request->post('old_page_number');
            $new_page_number = $request->post('new_page_number');
            $survey_id = $request->post('survey_id');
            $user_id       =  $request->post('user_id');
            $checkDragValue = $request->post('checkDragValue');

            $all_questions = DB::table('tmp_survey_questions')->where('page_number', $old_page_number);
            if ($survey_id != '') 
            {
                $all_questions->where('tmp_survey_id', $survey_id);
                
            }else 
            {
                $all_questions->where('user_id', $user_id);
            }
            if($checkDragValue == 'yes')
            {                
                $all_questions->where('is_page_dragged', 0);
            }
            
            $all_questions = $all_questions->get();

             if(!empty($all_questions))
             {                       
                $updateArray['page_number'] = $new_page_number;
                $updateArray['is_page_dragged'] = 1;                 

                foreach ($all_questions as $currQuestion) 
                {
                    $updatepageNumberQuestion = DB::table('tmp_survey_questions')
                                        ->where('id', $currQuestion->id)
                                        ->update($updateArray);
                }
            }


            // for skip question 
            $all_skip_questions = DB::table('tmp_skip_logic')->where('page_number', $old_page_number);
            if ($survey_id != '') 
            {
                $all_skip_questions->where('survey_id', $survey_id);
                
            }else 
            {
                $all_skip_questions->where('user_id', $user_id);
            }
            if($checkDragValue == 'yes')
            {                
                $all_skip_questions->where('is_page_dragged', 0);
            }
            
            $all_skip_questions = $all_skip_questions->get();

             if(!empty($all_skip_questions))
             {                       
                $updateArray['page_number'] = $new_page_number;
                $updateArray['is_page_dragged'] = 1;                 

                foreach ($all_skip_questions as $currSkipQuestion) 
                {
                    $updatepageNumberSkipQuestion = DB::table('tmp_skip_logic')
                                        ->where('id', $currSkipQuestion->id)
                                        ->update($updateArray);
                }
            }
           


            $response = array('status' => 1);
            echo json_encode($response);
            exit;

        }
    }

    public function removeDraggableValue(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            
            $survey_id = $request->post('survey_id');
            $user_id       =  $request->post('user_id');

            $resetDragged = DB::table('tmp_survey_questions');
            if ($survey_id != '') {
                $resetDragged->where('tmp_survey_id', $survey_id);
            }else {
                $resetDragged->where('user_id', $user_id);
            }
            $resetDragged->update(['is_page_dragged'=>0]);




            $resetDraggedSkipQuestion = DB::table('tmp_skip_logic');
            if ($survey_id != '') {
                $resetDraggedSkipQuestion->where('survey_id', $survey_id);
            }else {
                $resetDraggedSkipQuestion->where('user_id', $user_id);
            }
            $resetDraggedSkipQuestion->update(['is_page_dragged'=>0]);


            $response = array('status' => 1);
            echo json_encode($response);
            exit;
            
        }
    }
    public function deletesurveypage(Request $request)
    {
        if ($request->isMethod('post')) {
            $page_number   = $request->page_number;
            $user_id       = $request->user_id;
            $tmp_survey_id = $request->survey_id;
            $is_data_available = false;
             $tmpIdsArray = [];
            if ($request->post('survey_id') != '') {
                $all_questions = DB::table('tmp_survey_questions')->where('page_number', $page_number)->where('user_id', $user_id)->where('tmp_survey_id', $tmp_survey_id)->get();
                
                $is_data_available = false;
               
                if(!empty($all_questions)){
                    foreach ($all_questions as $currQuestion) {
                        $skip_question_data_question_ids = DB::table('tmp_skip_logic')->where(['question_id' => $currQuestion->id])->get();

                        if(!empty($skip_question_data_question_ids)){
                            foreach ($skip_question_data_question_ids as $curr_skip_question_data_question_id) {
                                $tmpIdsArray[] = $curr_skip_question_data_question_id->question_id;
                                $tmpIdsArray[] = $curr_skip_question_data_question_id->skip_question_id;
                            }

                        }
                        
                        
                        $skip_question_data_skip_question_ids = DB::table('tmp_skip_logic')->where(['skip_question_id' => $currQuestion->id])->get();

                         if(!empty($skip_question_data_skip_question_ids)){

                            foreach ($skip_question_data_skip_question_ids as $skip_question_data_skip_question_id) {
                                $tmpIdsArray[] = $skip_question_data_skip_question_id->question_id;
                                $tmpIdsArray[] = $skip_question_data_skip_question_id->skip_question_id;
                            }
                        }


                    }

                }
                
                
                


            }else {

            }
            if(!empty($tmpIdsArray)){
                $is_data_available = true;
                $tmpIdsArray = array_unique($tmpIdsArray);
            }
            
            if ($request->post('survey_id') != '') {
                DB::table('tmp_survey_questions')->where('page_number', $page_number)->where('user_id', $user_id)->where('tmp_survey_id', $tmp_survey_id)->delete();
                DB::table('tmp_skip_logic')->where('page_number', $page_number)->where('user_id', $user_id)->where('survey_id', $tmp_survey_id)->delete();

            } else {
                DB::table('tmp_survey_questions')->where('page_number', $page_number)->where('user_id', $user_id)->delete();
                DB::table('tmp_skip_logic')->where('page_number', $page_number)->where('user_id', $user_id)->delete();
            }
            $response = array('status' => 1,'is_data_available'=>$is_data_available,'tmpIdsArray'=>$tmpIdsArray);
            echo json_encode($response);
            exit;

        }

    }

    public function updatesurveypage(Request $request)
    {
        if ($request->isMethod('post')) {

            $user_id       = $request->user_id;
            $tmp_survey_id = $request->survey_id;
            $currPageId    = $request->currPageId;
            $pageId        = $request->pageId;
            if ($request->post('survey_id') != '') {
                DB::table('tmp_survey_questions')
                    ->where('user_id', $user_id)
                    ->where('tmp_survey_id', $tmp_survey_id)
                    ->where('page_number', $currPageId)

                    ->update([
                        'page_number' => $pageId,
                    ]);

                    DB::table('tmp_skip_logic')
                    ->where('user_id', $user_id)
                    ->where('survey_id', $tmp_survey_id)
                    ->where('page_number', $currPageId)

                    ->update([
                        'page_number' => $pageId,
                    ]);
            } else {
                DB::table('tmp_survey_questions')
                    ->where('user_id', $user_id)
                    ->where('page_number', $currPageId)

                    ->update([
                        'page_number' => $pageId,
                    ]);


                    DB::table('tmp_skip_logic')
                    ->where('user_id', $user_id)
                    ->where('page_number', $currPageId)

                    ->update([
                        'page_number' => $pageId,
                    ]);

            }
            $response = array('status' => 1);
            echo json_encode($response);
            exit;

        }

    }

    public function addQuestionToLibrary(Request $request)
    {
        if ($request->isMethod('post')) {
            // first we are checking whether we have a new template or old template .. 
            if($request->template_name == '0'){
                $data_survey_library_templates['user_id']              = Auth::User()->id;
                $data_survey_library_templates['template_name']      = $request->template_new_name;
                $data_survey_library_templates['created_at']           = DB::raw('NOW()');
                $template_id    = SurveyLibraryTemplates::insertGetId($data_survey_library_templates);
            }else {
                $template_id = $request->template_name;
            }
            

            // first we are getting survey question data based on temp id
            $id                   = $request->tmp_id;
            $tmp_survey_questions = DB::table('tmp_survey_questions')
                ->where(['id' => $id])
                ->first();
            $is_question_already_added = 1;
            if (!empty($tmp_survey_questions)) {
                $tmpQuestionData = $tmp_survey_questions->question;
             //   dd($tmpQuestionData);
                // checking for page number 
                $questionNumberAllData = DB::table('survey_library')                            
                            ->where('user_id', '=', Auth::User()->id)                            
                            ->where('template_id', '=', $template_id)  
                            ->where('survey_question', 'like', $tmpQuestionData)
                            //->where('survey_question', '=', $tmpQuestionData)     
                            ->orderBy('id', 'asc')
                            ->first();
                if(empty($questionNumberAllData)){
                    $is_question_already_added = 0;
                
                    $questionNumber = DB::table('survey_library')                            
                                ->where('user_id', '=', Auth::User()->id)      
                                ->where('template_id', '=', $template_id)                       
                                ->orderBy('id', 'asc')
                                ->get();
                    $questionNumber  = count($questionNumber);
                    $question_number = $questionNumber;
                    $question_number = $question_number + 1;
                    $data_survey_library['template_id']              = $template_id;
                    $data_survey_library['user_id']              = Auth::User()->id;
                    $data_survey_library['survey_question']      = $tmp_survey_questions->question;
                    $data_survey_library['survey_question_type'] = $tmp_survey_questions->question_type;
                    $data_survey_library['question_number'] = $question_number;
                    $data_survey_library['created_at']           = DB::raw('NOW()');
                    $survey_library                              = SurveyLibrary::insertGetId($data_survey_library);
                }
                
            }
            $response = array('status' => 1,'is_question_already_added'=>$is_question_already_added);
            echo json_encode($response);
            exit;
        }

    }

    public function questionLibraryPopup(Request $request)
    {
           $subLibTemplates = DB::table('survey_library_templates')                
                ->where('user_id', '=', Auth::User()->id)         
                ->orderBy('id', 'asc')
                ->get()->toArray();

            $status = 0;
            $is_data_available = 0;
            $data = [];
            if(!empty($subLibTemplates)){
                $status = 1;
                
                $surveyLibQuestions = DB::table('survey_library')                
                ->where('user_id', '=', Auth::User()->id)         
                ->orderBy('id', 'asc')
                ->get()->toArray();
                if(!empty($surveyLibQuestions)){
                    $is_data_available = 1;
                }

              
                foreach($subLibTemplates as $currSubLibTemplate){
                    $data[$currSubLibTemplate->id][] = $currSubLibTemplate->template_name;
                }
            }
        
            echo json_encode(array('status'=>$status,'is_data_available'=>$is_data_available,'data'=>$data));
            exit;

        
    }

    public function getQuestionsbyTemplate(Request $request){
        if ($request->isMethod('post')) {
            $template_id = $request->template_id;
            
            $response = $this->getquestionLibraryPopupData($template_id);
            
            echo json_encode($response);
            exit;
        }
        
    }
    public function getquestionLibraryPopupData($template_id = NULL){
        // Here we are getting the list of question of the library based on logged in user id
            $data   = [];
            $status = 0;

            $survey_library = DB::table('survey_library')
                ->where('user_id','=',  Auth::User()->id);
            if(!empty($template_id)){
               $survey_library =  $survey_library->where('template_id', '=', $template_id);
            }
            $survey_library =  $survey_library->orderBy('id', 'asc')->get()->toArray();
            if (!empty($survey_library)) {
                foreach ($survey_library as $curr_survey_library) {

                    $question_type = $curr_survey_library->survey_question_type;
                    $tmp_id        = $curr_survey_library->id;
                    switch ($question_type) {

                        case Common::$intPoll:
                            $view                = 'admin.surveys.radioDataLibraryLabel';
                            $sro_id              = json_decode($curr_survey_library->survey_question)->sro_id;
                            $survey_radio_points = DB::table('survey_radio_points')
                                ->where('radio_options_id', '=', $sro_id)
                                ->orderBy('id', 'asc')
                                ->get()->toArray();

                            $question = json_decode($curr_survey_library->survey_question)->question;
                            $question_number = $curr_survey_library->question_number;

                            $returnHTML = view($view)
                                ->with(
                                    [
                                        'id'                  => $tmp_id,
                                        'question'            => $question,
                                        'survey_radio_points' => $survey_radio_points,
                                        'question_number'=>$question_number,
                                    ]
                                )
                                ->render();

                            $data[]['dataView'] = $returnHTML;
                            break;

                        case Common::$intCheckboxList:
                            $view   = 'admin.surveys.checkboxesLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                        case Common::$intMatrix:

                            $view = 'admin.surveys.matrixLibraryLabel';

                            $sro_id              = json_decode($curr_survey_library->survey_question)->sro_id;
                            $survey_radio_points = DB::table('survey_radio_points')
                                ->where('radio_options_id', '=', $sro_id)
                                ->orderBy('id', 'asc')
                                ->get()->toArray();
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library, $survey_radio_points);
                            break;

                        case Common::$intTextArea:
                            $view   = 'admin.surveys.commentLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                        case Common::$intTextBox:
                            $view   = 'admin.surveys.textboxLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                        case Common::$intRadioButtonList:
                            $view   = 'admin.surveys.singleradioLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                        case Common::$intCheckbox:
                            $view   = 'admin.surveys.singlechkboxLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                        case Common::$intDropDownList:
                            $view   = 'admin.surveys.dropdownLibraryLabel';
                            $data[] = $this->editViewQueryForLibrary($view, $tmp_id, $question_type, $curr_survey_library);
                            break;

                    }
                }
                $status = 1;
            }
            $response = array('status' => $status, 'data' => $data);
            return $response;
    }
    public function editViewQueryForLibrary($view, $id, $question_type, $curr_survey_library, $survey_radio_points = array())
    {

        $tmp_survey_question = (array) $curr_survey_library;

        $question_points = json_decode($tmp_survey_question['survey_question'])->question_points;
        $question        = json_decode($tmp_survey_question['survey_question'])->question;
        $question_number = $tmp_survey_question['question_number'];
        $returnHTML = view($view)
            ->with(
                [
                    'id'                  => $id,
                    'question_points'     => $question_points,
                    'question'            => $question,
                    'survey_radio_points' => $survey_radio_points,
                    'question_number'=>$question_number,
                ]
            )
            ->render();

        $survey_radio_options = DB::table('survey_radio_options')
            ->orderBy('id', 'asc')
            ->get();
        $radioPointsOptions = array();
        if (!empty($survey_radio_options)) {
            foreach ($survey_radio_options as $currRadioOption) {
                $radioPointsOptions[$currRadioOption->id] = $currRadioOption->title . ' (' . $currRadioOption->option_point . 'pts)';
            }
        }

        $data = array(
            'tmp_survey_question' => $tmp_survey_question,
            'id'                  => $id,

            'question_points'     => $question_points,
            'question'            => $question,
            'question_type'       => $question_type,
            'data'                => [
                'tmp_survey_question' => [
                    'question_type' => $question_type,

                ],
                'radioPointsOptions'  => $radioPointsOptions,

            ],
            'dataView'            => $returnHTML,
        );

        return $data;
    }

    public function removeQuestionFromLibrary(Request $request)
    {
        if ($request->isMethod('post')) {

            $id = $request->id;
            $template_id = $request->template_id;

            // getting the question number based on the id we want to remove record from 
             $surveyLibDataSingle = DB::table('survey_library')
                ->where('id', '=', $id)                
                ->where('template_id', '=', $template_id) 
                
                ->first();
            $question_number = $surveyLibDataSingle->question_number;
          

            // Now based on delete id, we are finding records greater than delete id from survey_library based on user id 
            $surveyLibData = DB::table('survey_library')
                ->where('id', '>', $id)        
                ->where('template_id', '=', $template_id) 
                ->where('user_id', '=', Auth::User()->id)         
                ->get()->toArray();
            if(!empty($surveyLibData)){
              foreach ($surveyLibData as $curr_sub_lib_data) {
                   DB::table('survey_library')
                        ->where('id', $curr_sub_lib_data->id)
                        ->update([
                            'question_number'         => $question_number,
                            

                        ]);

                    $question_number = $question_number + 1;

                  
              }
            }

            
            // removed question from survey library table based on id
            
            DB::table('survey_library')->where('id', $id)->delete();
            
            

            $is_data_available = 0;            
            $response = $this->getquestionLibraryPopupData($template_id);            
             if(!empty($response['data'])){
                 $is_data_available = 1;
             }
            
            $response['is_data_available']=$is_data_available;
            
            echo json_encode($response);
            exit;
        }

    }

    public function addQuestionfromLibrary(Request $request)
    {
        if ($request->isMethod('post')) {
            $libraryQuestionIds = $request->libraryQuestions;
            $page_number        = $request->page_number;
            $user_id            = Auth::id();

            // First we are getting all the records based on liraryId and userid of post
            $surveyLibData = DB::table('survey_library')
                ->whereIn('id', $libraryQuestionIds)
                // ->orderBy('id', 'desc')
                ->orderBy('id', 'asc')
                ->get()->toArray();
            $tmp_question_ids = [];
            if (!empty($surveyLibData)) {
                foreach ($surveyLibData as $currSurveyLibData) {

                    // Here we are also finding the last question number / page number based on user id and survey id (if exists)
                    if (isset($request->survey_id)) {
                        $questionNumber = DB::table('tmp_survey_questions')
                            ->where('page_number', '=', $page_number)
                           // ->where('user_id', '=', $user_id)
                            ->where('tmp_survey_id', '=', $request->survey_id)
                            ->orderBy('id', 'asc')
                            ->get();

                    } else {
                        $questionNumber = DB::table('tmp_survey_questions')
                            ->where('page_number', '=', $page_number)
                            ->where('user_id', '=', $user_id)
                            ->orderBy('id', 'asc')
                            ->get();
                    }
                    $questionNumber  = count($questionNumber);
                    $question_number = $questionNumber;
                    $question_number = $question_number + 1;

                    // Now here, we are inserting each record to tmp_survey_questions table from survey_library table
                    $tmp_question_data['question_type'] = $currSurveyLibData->survey_question_type;
                    $tmp_question_data['user_id']       = Auth::id();
                    $tmp_question_data['question']      = $currSurveyLibData->survey_question;
                    $tmp_question_data['page_number']   = $page_number;
                    if (isset($request->survey_id)) {
                        $tmp_question_data['tmp_survey_id'] = $request->survey_id;
                    }
                    $tmp_question_data['tmp_survey_order_number'] = $question_number;
                    $tmp_question_data['question_number']         = $question_number;
                    $tmp_question_ids[]                           = TmpSurveyQuestions::insertGetId($tmp_question_data);
                }
            }

            $data   = [];
            $status = 0;
            // Now based on tmp ids, we are finding all the records from tmp table
            $tmp_survey_data = DB::table('tmp_survey_questions')
                ->whereIn('id', $tmp_question_ids)
                ->orderBy('id', 'asc')
                ->get()->toArray();
            if (!empty($tmp_survey_data)) {
                foreach ($tmp_survey_data as $curr_tmp_survey) {

                    $question_type = $curr_tmp_survey->question_type;
                    $tmp_id        = $curr_tmp_survey->id;
                    switch ($question_type) {

                        case Common::$intPoll:
                            $view                = 'admin.surveys.radioData';
                            $sro_id              = json_decode($curr_tmp_survey->question)->sro_id;
                            $survey_radio_points = DB::table('survey_radio_points')
                                ->where('radio_options_id', '=', $sro_id)
                                ->orderBy('id', 'asc')
                                ->get()->toArray();

                            $question = json_decode($curr_tmp_survey->question)->question;

                            $returnHTML = view($view)
                                ->with(
                                    [
                                        'tmp_question_id'     => $tmp_id,
                                        'question'            => $question,
                                        'survey_radio_points' => $survey_radio_points,
                                        'is_required'         => $curr_tmp_survey->is_required,
                                        'question_number'     => $curr_tmp_survey->question_number,
                                        'is_skip_logic_avail'     => $curr_tmp_survey->is_skip_logic_avail,
                                    ]
                                )
                                ->render();

                            $data[]['dataView'] = $returnHTML;
                            break;

                        case Common::$intCheckboxList:
                            $view   = 'admin.surveys.checkboxesLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                        case Common::$intMatrix:

                            $view = 'admin.surveys.matrixLabel';

                            $sro_id              = json_decode($curr_tmp_survey->question)->sro_id;
                            $survey_radio_points = DB::table('survey_radio_points')
                                ->where('radio_options_id', '=', $sro_id)
                                ->orderBy('id', 'asc')
                                ->get()->toArray();
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey, $survey_radio_points);
                            break;

                        case Common::$intTextArea:
                            $view   = 'admin.surveys.commentLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                        case Common::$intTextBox:
                            $view   = 'admin.surveys.textboxLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                        case Common::$intRadioButtonList:
                            $view   = 'admin.surveys.singleradioLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                        case Common::$intCheckbox:
                            $view   = 'admin.surveys.singlechkboxLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                        case Common::$intDropDownList:
                            $view   = 'admin.surveys.dropdownLabel';
                            $data[] = $this->editViewQueryForLibraryAdd($view, $tmp_id, $question_type, $curr_tmp_survey);
                            break;

                    }
                }
                $status = 1;
            }
            $response = array('status' => $status, 'data' => $data);
            echo json_encode($response);
            exit;

        }
    }

    public function editViewQueryForLibraryAdd($view, $id, $question_type, $curr_survey_library, $survey_radio_points = array())
    {

        $tmp_survey_question = (array) $curr_survey_library;

        $question_points = json_decode($tmp_survey_question['question'])->question_points;
        $question        = json_decode($tmp_survey_question['question'])->question;

        $returnHTML = view($view)
            ->with(
                [
                    'tmp_question_id'     => $id,
                    'question_points'     => $question_points,
                    'question'            => $question,
                    'survey_radio_points' => $survey_radio_points,
                    'is_required'         => $tmp_survey_question['is_required'],
                    'question_number'     => $tmp_survey_question['question_number'],
                    'is_skip_logic_avail'         => $tmp_survey_question['is_skip_logic_avail'],
                ]
            )
            ->render();

        $survey_radio_options = DB::table('survey_radio_options')
            ->orderBy('id', 'asc')
            ->get();
        $radioPointsOptions = array();
        if (!empty($survey_radio_options)) {
            foreach ($survey_radio_options as $currRadioOption) {
                $radioPointsOptions[$currRadioOption->id] = $currRadioOption->title . ' (' . $currRadioOption->option_point . 'pts)';
            }
        }

        $data = array(
            'tmp_survey_question' => $tmp_survey_question,
            'id'                  => $id,
            'tmp_question_id'     => $id,

            'question_points'     => $question_points,
            'question'            => $question,
            'question_type'       => $question_type,
            'data'                => [
                'tmp_survey_question' => [
                    'question_type' => $question_type,

                ],
                'radioPointsOptions'  => $radioPointsOptions,

            ],
            'dataView'            => $returnHTML,
        );

        return $data;
    }

    public function addQuestionToLibraryPopup(Request $request){
        if ($request->isMethod('post')) {
            // Getting templates based on logged in user id 
            $subLibTemplates = DB::table('survey_library_templates')                
                ->where('user_id', '=', Auth::User()->id)         
                ->orderBy('id', 'asc')
                ->get()->toArray();

            $status = 0;
            $is_data_available = 0;
            $data = [];
            if(!empty($subLibTemplates)){
                $status = 1;
                $is_data_available = 1;
                foreach($subLibTemplates as $currSubLibTemplate){
                    $data[$currSubLibTemplate->id][] = $currSubLibTemplate->template_name;
                }
            }
        
            echo json_encode(array('status'=>$status,'is_data_available'=>$is_data_available,'data'=>$data));
            exit;

        }

    }

    public function checkQuestionTemplateName(Request $request){
    

       if ($request->isMethod('post')) {

            $valid   = true;
            $message = '';
            $template_name   = $request->template_new;
            $userId  = $request->userId;
            
            if(!empty($request->template_new)){
                $survey_library_templates = DB::table('survey_library_templates')
                    ->where('template_name', '=', $template_name)
                    ->where('user_id', '=', $userId)
                    ->first();

                if (!empty($survey_library_templates)) {
                    $valid   = false;
                    $message = 'Template already exists';
                }
            }

            $response = array('valid' => $valid, 'message' => $message);
            echo json_encode($response);
            exit;

        }
    }

    public function updatePageNumberQuestionTmpArray(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $arrData = $request->post();
            $survey_id = $request->post('survey_id');                    
            $user_id       =  $request->post('user_id');
             
            if(!empty($arrData))
            {
                if(isset($arrData['arrupdatePageNumber']) && !empty($arrData['arrupdatePageNumber']))
                {
                    $arrupdatePageNumberArr = $arrData['arrupdatePageNumber'];
                    foreach ($arrupdatePageNumberArr as $currArrupdatePageNumberArr) 
                    {
                    
                        $old_page_number = $currArrupdatePageNumberArr['oldPageNumber'];                        
                        $new_page_number = $currArrupdatePageNumberArr['newPageNumber'];
                        $checkDragValue = $currArrupdatePageNumberArr['checkDragValue'];
                        $all_questions = DB::table('tmp_survey_questions')->where('page_number', $old_page_number);
                        if ($survey_id != '') 
                        {
                            $all_questions->where('tmp_survey_id', $survey_id);
                            
                        }else 
                        {
                            $all_questions->where('user_id', $user_id);
                        }
                        if($checkDragValue == 'yes')
                        {                
                            $all_questions->where('is_page_dragged', 0);
                        }
                        
                        $all_questions = $all_questions->get();

                        if(!empty($all_questions))
                        {                       
                            $updateArray['page_number'] = $new_page_number;
                            $updateArray['is_page_dragged'] = 1;                 

                            foreach ($all_questions as $currQuestion) 
                            {
                                $updatepageNumberQuestion = DB::table('tmp_survey_questions')
                                                    ->where('id', $currQuestion->id)
                                                    ->update($updateArray);
                            }
                        }


                        // for skip question 
                        $all_skip_questions = DB::table('tmp_skip_logic')->where('page_number', $old_page_number);
                        if ($survey_id != '') 
                        {
                            $all_skip_questions->where('survey_id', $survey_id);
                            
                        }else 
                        {
                            $all_skip_questions->where('user_id', $user_id);
                        }
                        if($checkDragValue == 'yes')
                        {                
                            $all_skip_questions->where('is_page_dragged', 0);
                        }
                        
                        $all_skip_questions = $all_skip_questions->get();

                        if(!empty($all_skip_questions))
                        {                       
                            $updateArray['page_number'] = $new_page_number;
                            $updateArray['is_page_dragged'] = 1;                 

                            foreach ($all_skip_questions as $currSkipQuestion) 
                            {
                                $updatepageNumberSkipQuestion = DB::table('tmp_skip_logic')
                                                    ->where('id', $currSkipQuestion->id)
                                                    ->update($updateArray);
                            }
                        }

                        
                    }
                }
            }

            $response = array('status' => 1);
            echo json_encode($response);
            exit;

        }
    }



}

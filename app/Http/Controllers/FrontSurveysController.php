<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\TmpSurveyQuestions;
use App\Http\Helpers\Common;
use Mail;
//use Illuminate\Support\Str;
class FrontSurveysController extends Controller
{
    public function index(Request $request,$id)
    {   
        $survey_id = collect(DB::table('surveys')->where('url',$id)->first())->toArray();
        
        if(empty($survey_id))
        {
            // return redirect()->route('surveyfrontdefault')->with('msg_failed', 'Invalid Survey URL.');
            $data['survey']['show_logo'] = 0;
            $data['survey']['url'] = '';
            $data['custom_url'] = '';

            $data['not_found_survey'] = 1;

            return view('front.survey.template', $data);

        }
        
        $data = $this->call_db($request,$id);     
        $data['imgUrl']  = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));         
        $data['company_original_path'] = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $data['company_thumb_path']    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');
        $data['survey_company_imgUrl']        = url(env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', ''));
        $data['survey_company_original_path'] = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $data['survey_company_thumb_path']    = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', '');
        $data['default_company_img'] = url('/images/' . env('DEFAULT_COMPANY_IMAGE', ''));
        
        return view('front.survey.index',$data);
    }

    public function main(Request $request)
    {
        $data['survey']['show_logo'] = 0;
        $data['survey']['url'] = '';
        $data['custom_url'] = '';
        $data['not_found_survey'] = 0;

        return view('front.survey.template', $data);

   
    }

    public function call_ajax(Request $request)
    { 
       
        $id = $request->id;    
        $data = $this->call_db($request,$id);         
        return view('front.survey.ajax-form',$data); 
    }

    public function call_db(Request $request,$id)
    {        
        $survey_id = collect(DB::table('surveys')->where('url',$id)->first())->toArray();
         //dd($survey_id);
        if(!empty($survey_id))
        {
           
            $total_submitted_surveys = DB::table('users_survey_answer')->distinct('url')->where('survey_id',$survey_id['id'])->count('url');
            $max_invitations = $survey_id['max_invitations'];
            
        
            $survey_id['survey_id'] = $survey_id['id'];

            $sid = $survey_id['survey_id'];

            $survey = collect(DB::table('surveys')->select(['surveys.*', 'c.company_logo'])->join('clients AS c', 'surveys.comp_id', '=', 'c.id')->where('surveys.id',$sid)->first())->toArray();
            
            $tmp_qry = DB::table('survey_blocks')->select(['survey_question_type','id','survey_question','is_skip_logic_avail'])
            ->where('survey_id',$sid)
            ->orderBy('survey_order_number','asc')    
            ->orderBy('page_number','asc')
            
            ->get()->toArray();

            $survey_blocks = [];
            $page_number = [];
            $col = [];
            $i =0;

            foreach($tmp_qry as $q)
            {
                $survey_question = json_decode($q->survey_question);

                $survey_blocks[$i]['survey_blocks'] = DB::table('survey_blocks')->where('id',$q->id)->first();
                $page_number[$i] = DB::table('survey_blocks')->select('page_number')->where('id',$q->id)->first();
                
                if($q->survey_question_type == Common::$intPoll || $q->survey_question_type == Common::$intMatrix)
                {               
                    $survey_blocks[$i]['survey_radio_options'] = DB::table('survey_radio_options')
                    ->leftJoin('survey_radio_points', 'survey_radio_points.radio_options_id', '=', 'survey_radio_options.id')
                    ->where('survey_radio_options.id', $survey_question->sro_id)
                    ->get()->toArray();
                }
                else
                {
                    $survey_blocks[$i]['survey_radio_options'] = '';
                }
                $i++;
            }

            
            

            foreach($page_number as $n)
            {
                
                $col[] = $n->page_number;
            }
            
            // dd($page_number);
            $col = array_values(array_unique($col));
            
            
            $data['survey'] = $survey;
            $data['survey_questions'] = $survey_blocks;
                
            $data['survey_company_thumb_path'] = env('SURVEY_COMPANY_THUMB_UPLOAD_PATH');
            $data['welcome_img_path'] = env('SURVEY_UPLOAD_PATH');

            $data['survey_heading'] = json_decode($data['survey']['page_heading']);
            $data['pages'] = $col;
            $data['max_invitations'] = (int)$max_invitations;
            $data['total_submitted_surveys'] = (int)$total_submitted_surveys;
        
            $data['custom_url'] = $id;

            $clients = DB::table('clients')
            // ->where('status','=',1)
            ->where('id',$survey['comp_id'])
            ->first(); 

            $data['clients_check'] = $clients;

            $company_original_path =  env('COMPANY_ORIGINAL_UPLOAD_PATH','');
            $company_thumb_path = public_path() . env('COMPANY_THUMB_UPLOAD_PATH','');

            $data['company_original_logo'] = $company_original_path.$clients->company_logo;        
            $data['company_logo_only'] = $clients->company_logo;
            $data['company_logo_new'] = $request->company_logo;

        
            return $data;
        }else {

            $data['survey']['show_logo'] = 0;
            $data['survey']['url'] = '';
            $data['custom_url'] = '';

            $data['not_found_survey'] = 1;


            return view('front.survey.template', $data);

        }
    }

    public function save(Request $request)
    {
        

        $survey = DB::table('users_survey_answer')->select( "url")
       ->where('survey_id',$request->survey_id)->get()
        ->toArray();
$total_submitted_surveys = DB::table('users_survey_answer')->distinct('url')->where('survey_id',$request->survey_id)->count('url');
 

        $url = [];
        foreach($survey as $s)
        {
            $url[] = $s->url;
        }

        $count = count( array_unique($url) );


        $survey_fillup_to_count = DB::table('surveys')->select( "max_invitations")
       ->where('id',$request->survey_id)->first()
        ;
$max_invitations =  $survey_fillup_to_count->max_invitations;
       // if($count > $survey_fillup_to_count->max_invitations)
       if($max_invitations === $total_submitted_surveys)
        {
            echo 0;
            exit;
        }

        $data = array();

        $survey_block_id_arr = array_values($request->survey_block_id);

        $max_data = DB::table('users_survey_answer')->select(
             DB::raw('max(survey_number) as survey_number')
        )->first();

           
        $max_survey_number = $max_data->survey_number + 1;
       for($i=0;$i<count($survey_block_id_arr);$i++)
       {
           // getting question json from survey_blocks table based on survey block id 
            $surveyQuestionJson = DB::table('survey_blocks')->select(["survey_question","page_number","survey_order_number"])->where('id',$survey_block_id_arr[$i])->first();

            // $questionNumberAllData = DB::table('user_survey_questions')
            //                         ->where('question', 'like', $surveyQuestionJson->survey_question)                            
            //                         ->orderBy('id', 'asc')
            //                         ->first();
            // if(!empty($questionNumberAllData)){
            //     $data[$i]['question_id'] = $questionNumberAllData->id;
            // }else {
               
            //     $dataQuestion = array(
            //         'question'=>$surveyQuestionJson->survey_question
            //     );
            //      $questionId = DB::table('user_survey_questions')->insertGetId($dataQuestion);
            //      $data[$i]['question_id'] = $questionId;
            // }

            $data[$i]['url'] = $request->url_unique;

            $data[$i]['survey_number'] = $max_survey_number;

            $data[$i]['survey_id'] = $request->survey_id;
            $data[$i]['company_id'] = $request->company_id;
            $data[$i]['user_id'] = $request->user_id;
            $data[$i]['question'] = $surveyQuestionJson->survey_question;
            $data[$i]['survey_order_number'] = $surveyQuestionJson->survey_order_number;
            $data[$i]['page_number'] = $surveyQuestionJson->page_number;
            $data[$i]['survey_block_id'] = $survey_block_id_arr[$i];
            $data[$i]['question_type'] = $request->question_type[$survey_block_id_arr[$i]];

           
            if($data[$i]['question_type'] == 3)
            {
                
                $ar_ans = [];
                $count = count(json_decode($data[$i]['question'])->question_points);

                for($m=0;$m<$count;$m++)
                {
                    if(isset($request->ans[$data[$i]['survey_block_id']][$m]))
                    {
                        $ar_ans[$m] = $request->ans[$data[$i]['survey_block_id']][$m];
                    }
                    
                    else {
                         $ar_ans[$m] = null;
                    }
                }

                $data[$i]['answer'] =  json_encode($ar_ans);
                
            }
            else {
                if(isset($request->ans[$data[$i]['survey_block_id']]))
                {
                    $data[$i]['answer'] = json_encode($request->ans[$survey_block_id_arr[$i]]);
                }
                else
                {
                    $data[$i]['answer'] = json_encode(array(null));
                }
            }

            
            
            // $data[$i]['url'] = $request->url;
       }

       

        DB::table('users_survey_answer')->insert($data);

        echo 1;
        exit;

        //return redirect()->back()->with('success','Operation Successful !');
        
    }

     public function surveyTroubleForm(\Illuminate\Http\Request $request)
    {

        if ($request->isMethod('post')) {
            $survey_number  = $request->survey_number;
            $name  = $request->name;
            $email  = $request->email;
            $issue  = $request->issue;


            // Sending Email to Admin 
            $strEmail = env('ADMIN_EMAIL_ADDRESS'); 
            //dd($strEmail);
            $strName = env('MAIL_FROM_NAME');
            $strSubject = "You have received a survey enquiry as follows.";
            $data['url']         = env('APP_URL');
            $data['maincontent'] = '<h1 style="color:#000;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Hi, Admin</h1>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Your have new survey enquiry.</p>
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Survey Number</b> : ' . $survey_number . '</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Name</b> : ' . $name . '</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Email</b> : ' . $email . '</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Issue</b> : ' . nl2br($issue) . '</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Regards</b>,<br>' . env('MAIL_REGARDS') . '</p>';

            Mail::send('admin.mailtemplate.survey-trouble-template', $data, function ($message) use ($strEmail, $strName, $strSubject,$email,$name) {
                $message->to($strEmail, $strName)->subject($strSubject);
                $message->from($email, $name);
                $message->replyTo($email, $name);
            });


             // Sending Email to User 
            //    $strEmail = env('MAIL_FROM_ADDRESS');
           
            $strSubject = "Thank you for your enquiry";
            $data['url']         = env('APP_URL');
            $data['maincontent'] = '<h1 style="color:#000;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Hi, ' . $name . '</h1>                        
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thank you for your enquiry</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">We will get back to you shortly.</p>            
            <p style="color:#000;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Regards</b>,<br>' . env('MAIL_REGARDS') . '</p>';

            Mail::send('admin.mailtemplate.survey-trouble-template', $data, function ($message) use ($email,$strSubject,$name) {
                $message->to($email, $name)->subject($strSubject);
                $message->from(env('ADMIN_EMAIL_ADDRESS'), env('MAIL_FROM_NAME'));
                
            });

            $data = [];
             $response = array('status' => 1, 'data' => $data);

            echo 1;
            exit;
        }
    }

    public function skipLogicShowHideQuestion(Request $request){
        $selectedAnswer  = $request->post('selectedAnswer');
        $questionType  = $request->post('questionType');
        if($questionType == '7'){
            if($selectedAnswer == 'yes'){
                $selectedAnswer = '1';
            }else {
                $selectedAnswer = '0';
            }
        }
        $questionId  = $request->post('questionId');
        $skipLogicMode  = $request->post('skipLogicMode');
        $is_data_available = false;
        
        $data = [];
        $is_required = '';
        $arrQuestionIdsToHide = [];
        $arrQuestionIdsToShow = [];
        $singleQuestionIdToShow = '';
        $arr_is_required = [];
        
        if($skipLogicMode == 'front')
        {
            $logic_table = 'skip_logic';
            $questions_table = 'survey_blocks';
        }
        else
        {
            $logic_table = 'tmp_skip_logic';
            $questions_table = 'tmp_survey_questions';
        }


        $checkDataExists = DB::table($logic_table)->where(['skip_question_id' => $questionId])->get();
        if(!empty($checkDataExists))
        {
            
            foreach ($checkDataExists as $currCheckData) 
            {
                $is_answer_correct = false;

                // Now here we are checking whether we need skip logic available or not in parent question id 
                $checkWhetherWeNeedSkipLogic = DB::table($questions_table)->where(['id' => $currCheckData->question_id])->first();
                

                if(!empty($checkWhetherWeNeedSkipLogic))
                {
                    
                    //$checkWhetherWeNeedSkipLogic->is_required;
                    if($checkWhetherWeNeedSkipLogic->is_skip_logic_avail === 1)
                    {
                        $arrQuestionIdsToHide[] = $currCheckData->question_id;

                            if($questionType == '2')
                            {
                                $selectedAnswer = explode('###',$selectedAnswer);
                            if (in_array($currCheckData->answer, $selectedAnswer))
                            {
                                $singleQuestionIdToShow = $currCheckData->question_id;
                                $is_answer_correct = true;
                                $is_data_available = true;
                                $data = $currCheckData;
                                $arrQuestionIdsToShow[] =  array(
                                            'question_id'=> $checkWhetherWeNeedSkipLogic->id,
                                            'is_required'=> $checkWhetherWeNeedSkipLogic->is_required,
                                            'is_answer_correct'=>$is_answer_correct
                                            ) ;
                            }
                            }
                        else 
                        {
                            if($selectedAnswer === $currCheckData->answer)
                            {
                                $singleQuestionIdToShow = $currCheckData->question_id;
                                $is_answer_correct = true;
                                $is_data_available = true;
                                $data = $currCheckData;

                                 $arrQuestionIdsToShow[] =  array(
                                            'question_id'=> $checkWhetherWeNeedSkipLogic->id,
                                            'is_required'=> $checkWhetherWeNeedSkipLogic->is_required,
                                            'is_answer_correct'=>$is_answer_correct
                                            ) ;
                            }
                        }
                    }

                    $arr_is_required[] = array(
                                            'question_id'=> $checkWhetherWeNeedSkipLogic->id,
                                            'is_required'=> $checkWhetherWeNeedSkipLogic->is_required,
                                            'is_answer_correct'=>$is_answer_correct
                                            ) ;
                }

                
            }
        }
        
        if(!empty($arrQuestionIdsToHide))
        {
            if(!empty($singleQuestionIdToShow))
            {
                if (in_array($singleQuestionIdToShow, $arrQuestionIdsToHide))
                {
                    foreach ($arrQuestionIdsToHide as $key => $value)
                    {
                        if ($value == $singleQuestionIdToShow) {
                            unset($arrQuestionIdsToHide[$key]);
                        }
                    }
                    
                }                 
            }
        }
        
        $response = array('status' => 1,'is_data_available'=>$is_data_available,'data'=>$data,'is_required'=>$is_required,'singleQuestionIdToShow'=>$singleQuestionIdToShow,'arrQuestionIdsToHide'=>array_values($arrQuestionIdsToHide),'arr_is_required'=>$arr_is_required,'arrQuestionIdsToShow'=>$arrQuestionIdsToShow);
             echo json_encode($response);
            exit;

    }
    public function skipLogicShowHideQuestionBkp(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $selectedAnswer  = $request->post('selectedAnswer');
            $questionType  = $request->post('questionType');
            if($questionType == '7'){
                if($selectedAnswer == 'yes'){
                    $selectedAnswer = '1';
                }else {
                    $selectedAnswer = '0';
                }
            }
            $questionId  = $request->post('questionId');
            $skipLogicMode  = $request->post('skipLogicMode');
            $is_data_available = false;
            $is_answer_correct = false;
            $data = [];
            $is_required = '';
            if($skipLogicMode == 'front'){

                
                $checkDataExists = DB::table('skip_logic')->where(['skip_question_id' => $questionId])->first();
                if(!empty($checkDataExists)){
                    
                    $is_data_available = true;


                    // Now here we are checking whether we need skip logic available or not in parent question id 
                    $checkWhetherWeNeedSkipLogic = DB::table('survey_blocks')->where(['id' => $checkDataExists->question_id])->first();
                    

                    if(!empty($checkWhetherWeNeedSkipLogic)){
                        $is_required = $checkWhetherWeNeedSkipLogic->is_required;
                        if($checkWhetherWeNeedSkipLogic->is_skip_logic_avail === 1){
                            
                            $data = $checkDataExists;

                            if($questionType == '2'){
                                $selectedAnswer = explode('###',$selectedAnswer);

                                if (in_array($checkDataExists->answer, $selectedAnswer))
                                {
                                    $is_answer_correct = true;
                                }   
                                
                            }else {
                                if($selectedAnswer === $checkDataExists->answer){
                                    $is_answer_correct = true;
                                }
                            }
                            

                        }
                        
                    }
                    
                }
            }else {
                $checkDataExists = DB::table('tmp_skip_logic')->where(['skip_question_id' => $questionId])->first();
                if(!empty($checkDataExists)){
                    $is_data_available = true;


                    // Now here we are checking whether we need skip logic available or not in parent question id 
                    $checkWhetherWeNeedSkipLogic = DB::table('tmp_survey_questions')->where(['id' => $checkDataExists->question_id])->first();
                    

                    if(!empty($checkWhetherWeNeedSkipLogic)){
                        $is_required = $checkWhetherWeNeedSkipLogic->is_skip_logic_avail;
                        if($checkWhetherWeNeedSkipLogic->is_skip_logic_avail === 1){
                            
                            $data = $checkDataExists;

                            if($questionType == '2'){
                                $selectedAnswer = explode('###',$selectedAnswer);

                                if (in_array($checkDataExists->answer, $selectedAnswer))
                                {
                                    $is_answer_correct = true;
                                }   
                                
                            }else {
                                if($selectedAnswer === $checkDataExists->answer){
                                    $is_answer_correct = true;
                                }
                            }
                            

                        }
                        
                    }
                    
                }

            }

            
            $response = array('status' => 1,'is_data_available'=>$is_data_available,'is_answer_correct'=>$is_answer_correct,'data'=>$data,'is_required'=>$is_required);
             echo json_encode($response);
            exit;
        }

    }
}



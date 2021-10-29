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

class SkipLogicController extends Controller
{
    public function isSkipLogicAvail(\Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $tmp_id      = $request->post('tmp_id');
            $is_skip_logic_avail = $request->post('is_skip_logic_avail');

             DB::table('tmp_survey_questions')
                        ->where('id', $tmp_id)
                        ->update([
                            'is_skip_logic_avail' => $is_skip_logic_avail,

                        ]);
            
            $response = array('status' => 1);
            echo json_encode($response);
            exit;

        }
    }


    public function addSkipLogicPopup(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            // Here we are getting the questions list based on user id from temp table 
            $tmp_id      = $request->post('tmp_id');
            $page_number      = $request->post('page_number');
            
           $user_id            = Auth::id();
            
            $questions = DB::table('tmp_survey_questions as tsq');
            $questions->select('tsq.*');
            if ($request->post('survey_id') != '') {
                $questions->where('tsq.tmp_survey_id', '=', $request->post('survey_id'));
            }else {
                 $questions->where('tsq.user_id', '=', $user_id);
            }
            
            $questions->where('tsq.id', '!=', $tmp_id);
            $questions->whereNotIn('tsq.id',function($query) use ($tmp_id){

               $query->select('question_id')->from('tmp_skip_logic')->where('question_id', '=', $tmp_id)->orWhere('skip_question_id', '=', $tmp_id);
               

            });
           // $questions->where('page_number', '=', $page_number);
            $questions->orderBy('tsq.question_number', 'asc');
          //  $questions->orderBy('page_number', 'asc');
            $questions = $questions->get();

            
            $skipLogicQuestionDropdownArr = [];
            if(!empty($questions))
            {
                $i = 1;
                foreach ($questions as $currQuestion) 
                {
                    $question_type = $currQuestion->question_type;                    
                    $tmp_id = $currQuestion->id;
                    $question_number = '(Page -' . $currQuestion->page_number .')' .  ' Q' . $currQuestion->question_number . ' ' ;                    
                    
                    switch ($question_type) 
                    {

                        case Common::$intPoll:
                              $question = json_decode($currQuestion->question)->question;
                               $skipLogicQuestionDropdownArr[$tmp_id] = $question_number  .  $question;
                        break;

                        case Common::$intCheckboxList:
                             $question = json_decode($currQuestion->question)->question;
                              $skipLogicQuestionDropdownArr[$tmp_id] = $question_number  .  $question;
                        break;

                        case Common::$intMatrix:
                            //  $question  = json_decode($question['question'])->question;
                        break;

                        case Common::$intTextArea:
                             $question = $question_number .   json_decode($currQuestion->question)->question;
                            //  $skipLogicQuestionDropdownArr[$tmp_id] = $question;
                        break;


                        case Common::$intTextBox:
                             $question = $question_number  .  json_decode($currQuestion->question)->question;
                           //   $skipLogicQuestionDropdownArr[$tmp_id] = $question;
                        break;

                        case Common::$intRadioButtonList:
                             $question = json_decode($currQuestion->question)->question;
                              $skipLogicQuestionDropdownArr[$tmp_id] = $question_number  .  $question;
                        break;

                        case Common::$intCheckbox:
                             $question = json_decode($currQuestion->question)->question;
                              $skipLogicQuestionDropdownArr[$tmp_id] = $question_number  .  $question;
                        break;

                        case Common::$intDropDownList:
                             $question = json_decode($currQuestion->question)->question;
                              $skipLogicQuestionDropdownArr[$tmp_id] = $question_number  .  $question;
                        break;
                        
                       
                    }

                   

                    $i++;
                }
            }
            
            $tmp_id      = $request->post('tmp_id');
            
            // finding first from tmp_survey_questions table based on skip_question_id
            $question_data = DB::table('tmp_skip_logic')->where(['question_id' => $tmp_id])->first();
            $answerData = [];
            $is_data_available = false;
            $question_id = '';
            $answer = '';
            $skip_question_id = '';
            if (!empty($question_data)) {
                $question_id = $tmp_id;
                $skip_question_id  = $question_data->skip_question_id;
                $answer = $question_data->answer;    
                $skip_question_data = DB::table('tmp_survey_questions')->where(['id' => $skip_question_id])->first();
                if (!empty($skip_question_data)) {

                    $question_type = $skip_question_data->question_type;
                    switch ($question_type) {
                        case Common::$intPoll:
                            $sro_id              = json_decode($skip_question_data->question)->sro_id;
                                $survey_radio_points = DB::table('survey_radio_points')
                                    ->where('radio_options_id', '=', $sro_id)
                                    ->orderBy('id', 'asc')
                                    ->get()->toArray();
                                    if(!empty($survey_radio_points)){
                                        $is_data_available = true;
                                        foreach ($survey_radio_points as $curr_survey_radio_points) {
                                            $answerData[$curr_survey_radio_points->id] = $curr_survey_radio_points->point_option;
                                        }
                                    }
                            break;
                        case Common::$intCheckboxList:    
                            $question_points = json_decode($skip_question_data->question)->question_points;                        
                            if(!empty($question_points)){
                                $is_data_available = true;
                                foreach ($question_points as $curr_question_point) {
                                    $answerData[$curr_question_point] = $curr_question_point;
                                }
                            }
                            
                            break;
                        case Common::$intRadioButtonList:   
                            $question_points = json_decode($skip_question_data->question)->question_points;                        
                            if(!empty($question_points)){
                                $is_data_available = true;
                                foreach ($question_points as $curr_question_point) {
                                    $answerData[$curr_question_point] = $curr_question_point;
                                }
                            }                         
                            break;
                        case Common::$intCheckbox:   
                            $is_data_available = true;
                            $answerData[0] = 'No';
                            $answerData[1] = 'Yes';
                            break;
                        case Common::$intDropDownList:                            
                            $question_points = json_decode($skip_question_data->question)->question_points;                        
                            if(!empty($question_points)){
                                $is_data_available = true;
                                foreach ($question_points as $curr_question_point) {
                                    $answerData[$curr_question_point] = $curr_question_point;
                                }
                            }    
                            break;
                    }
                }
                

            }
            //$data = [];
           // dd($skipLogicQuestionDropdownArr);
            $response = array('status' => 1,'skipLogicQuestionDropdownArr'=>$skipLogicQuestionDropdownArr,'is_data_available'=>$is_data_available,'answerData'=>$answerData,'question_id'=>$question_id,'skip_question_id'=>$skip_question_id,'answer'=>$answer);
            echo json_encode($response);
            exit;
        }
    }

    public function addSkipLogicTmp(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            
            $user_id = Auth::id();
            $question_id  = $request->post('tmp_id');
            $skip_question_id  = $request->post('skip_question_id');
            $answer  = $request->post('answer');
            $page_number  = $request->post('page_number');
            
            // finding first from tmp_survey_questions table based on tmp_id
             $tmp_survey_question = DB::table('tmp_survey_questions')
            ->where(['id' => $question_id])
            ->first();

            // first deleting old (if found) then inserting the new one 
            DB::table('tmp_skip_logic')->where('question_id', $question_id)->delete();

            $tmp_skip_question_data['user_id'] = $user_id;
            $tmp_skip_question_data['question_id'] = $question_id;
            $tmp_skip_question_data['skip_question_id'] = $skip_question_id;
            $tmp_skip_question_data['answer'] = $answer;
            $tmp_skip_question_data['question_type'] = $tmp_survey_question->question_type;
            $tmp_skip_question_data['survey_id'] = $tmp_survey_question->tmp_survey_id;
            $tmp_skip_question_data['page_number'] = $page_number;
            $tmp_skip_question_data_id = TmpSkipLogic::insertGetId($tmp_skip_question_data);
            $response = array('status' => 1);
            echo json_encode($response);
            exit;
        }
    }

     public function getSkipLogicQuestionData(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $skip_question_id  = $request->post('skip_question_id');
            // finding first from tmp_survey_questions table based on skip_question_id
            $skip_question_data = DB::table('tmp_survey_questions')->where(['id' => $skip_question_id])->first();
            $answerData = [];
            $is_data_available = false;
            if (!empty($skip_question_data)) {

                $question_type = $skip_question_data->question_type;
                switch ($question_type) {
                    case Common::$intPoll:
                          $sro_id              = json_decode($skip_question_data->question)->sro_id;
                            $survey_radio_points = DB::table('survey_radio_points')
                                ->where('radio_options_id', '=', $sro_id)
                                ->orderBy('id', 'asc')
                                ->get()->toArray();
                                if(!empty($survey_radio_points)){
                                    $is_data_available = true;
                                    foreach ($survey_radio_points as $curr_survey_radio_points) {
                                        $answerData[$curr_survey_radio_points->id] = $curr_survey_radio_points->point_option;
                                    }
                                }
                        break;
                    case Common::$intCheckboxList:    
                        $question_points = json_decode($skip_question_data->question)->question_points;                        
                        if(!empty($question_points)){
                            $is_data_available = true;
                            foreach ($question_points as $curr_question_point) {
                                $answerData[$curr_question_point] = $curr_question_point;
                            }
                        }
                        
                        break;
                    case Common::$intRadioButtonList:   
                        $question_points = json_decode($skip_question_data->question)->question_points;                        
                        if(!empty($question_points)){
                            $is_data_available = true;
                            foreach ($question_points as $curr_question_point) {
                                $answerData[$curr_question_point] = $curr_question_point;
                            }
                        }                         
                        break;
                    case Common::$intCheckbox:   
                        $is_data_available = true;
                        $answerData[0] = 'No';
                        $answerData[1] = 'Yes';
                        break;
                    case Common::$intDropDownList:                            
                        $question_points = json_decode($skip_question_data->question)->question_points;                        
                        if(!empty($question_points)){
                            $is_data_available = true;
                            foreach ($question_points as $curr_question_point) {
                                $answerData[$curr_question_point] = $curr_question_point;
                            }
                        }    
                        break;
                }
            }
            $response = array('status' => 1,'is_data_available'=>$is_data_available,'answerData'=>$answerData);
            echo json_encode($response);
            exit;
        }
    }

    public function checkSkipLogicAvail(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $tmp_id  = $request->post('tmp_id');
            $skip_question_data_question_ids = DB::table('tmp_skip_logic')->where(['question_id' => $tmp_id])->get();
            $skip_question_data_skip_question_ids = DB::table('tmp_skip_logic')->where(['skip_question_id' => $tmp_id])->get();
            $is_data_available = false;
            $tmpIdsArray = [];
            $dataCount = count($skip_question_data_question_ids) + count($skip_question_data_skip_question_ids);

            if($dataCount > 0){
                $is_data_available = true;
                
                if(!empty($skip_question_data_question_ids)){
                    foreach ($skip_question_data_question_ids as $curr_skip_question_data_question_id) {
                        $tmpIdsArray[] = $curr_skip_question_data_question_id->question_id;
                        $tmpIdsArray[] = $curr_skip_question_data_question_id->skip_question_id;
                    }

                }

                if(!empty($skip_question_data_skip_question_ids)){

                    foreach ($skip_question_data_skip_question_ids as $skip_question_data_skip_question_id) {
                        $tmpIdsArray[] = $skip_question_data_skip_question_id->question_id;
                        $tmpIdsArray[] = $skip_question_data_skip_question_id->skip_question_id;
                    }
                }
            }
            
            if(!empty($tmpIdsArray)){
                $tmpIdsArray = array_unique($tmpIdsArray);
            }
            $response = array('status' => 1,'is_data_available'=>$is_data_available,'tmpIdsArray'=>$tmpIdsArray);
            echo json_encode($response);
            exit;

        }
    }

    public function checkSkipLogicDataExists(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $tmp_id  = $request->post('tmp_id');
            $skip_question_data_question_id = DB::table('tmp_skip_logic')->where(['question_id' => $tmp_id])->first();
             $is_data_available = false;
            if(!empty($skip_question_data_question_id)){
                $is_data_available = true;
            }
            $response = array('status' => 1,'is_data_available'=>$is_data_available);
            echo json_encode($response);
            exit;
        }
    }


    

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\TmpSurveyQuestions;
use App\SurveyBlocks;
use Illuminate\Support\Str;
use App\Http\Controllers\FrontSurveysController;

use App\Http\Helpers\Common;
use Carbon\Carbon;
use App\SkipLogic;
use App\TmpSkipLogic;


class EditSurveysController extends Controller
{
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

     public function updatesurvey(Request $request,$id)
     {
         $currentDate = Carbon::now()->format('Y-m-d');
        $isWelcomeComeImageExists = $request->post('isWelcomeComeExists');
        // dd($request->post());
          $imgUrl =  url(env('COMPANY_THUMB_UPLOAD_PATH',''));
          $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH','');
          $company_thumb_path = public_path() . env('COMPANY_THUMB_UPLOAD_PATH','');
          
          $survey_company_imgUrl = url(env('SURVEY_COMPANY_THUMB_UPLOAD_PATH','')); 
          $survey_company_original_path = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH','');
          $survey_company_thumb_path = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH','');
  
          $welcome_image_path = public_path() . env('SURVEY_UPLOAD_PATH','');
          $welcomeimgUrl =  url(env('SURVEY_UPLOAD_PATH',''));

  
          $clients = DB::table('clients')      
                              ->where('status','=','1')                      
                              ->orderBy('company_name', 'ASC')
                              ->get(); 
          
          $survey = DB::table('surveys')
                              ->select(['surveys.*','c.company_logo'])
                              ->join('clients AS c','surveys.comp_id', '=', 'c.id')     
                              ->where(['surveys.id'=>$id])                       
                              ->first();
        
            $client  = DB::table('clients')->where(['id'=>$id]) ->first();
  
  
          $data['clients'] = $clients;
          $data['survey'] = $survey;
          $data['imgUrl'] = $imgUrl;
          $data['company_original_path'] = $company_original_path;
          $data['company_thumb_path'] = $company_thumb_path;
  
          $data['survey_company_imgUrl']  = $survey_company_imgUrl;
          $data['survey_company_original_path']  = $survey_company_original_path;
          $data['survey_company_thumb_path']  = $survey_company_thumb_path;
  
          $data['welcome_image_path'] = $welcome_image_path;
          $data['welcomeimgUrl'] = $welcomeimgUrl;



           $survey_company_logo = $survey->survey_company_logo;
          if ($request->hasFile('survey_company_logo')) {
              $company_original_path = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH','');
              $company_thumb_path = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH','');

               $survey_company_logo   = $request->file('survey_company_logo');
              $filename = time() . '.' . $survey_company_logo->getClientOriginalExtension();

              Image::make($survey_company_logo)->save($company_original_path . $filename);
              
              Image::make($survey_company_logo)->resize(null, env('SURVEY_COMPANY_CROP_HEIGHT'), function ($constraint) {
                  $constraint->aspectRatio();
                  $constraint->upsize();
              })->save($company_thumb_path . $filename);


              if (!empty($survey->survey_company_logo)) {
                  if (file_exists($company_original_path . $survey->survey_company_logo)) {
                      unlink($company_original_path . $survey->survey_company_logo);
                  }
                  if (file_exists($company_thumb_path . $survey->survey_company_logo)) {
                      unlink($company_thumb_path . $survey->survey_company_logo);
                  }
              }
              $survey_company_logo = $filename;

          }

          $welcome_image = $survey->welcome_image;
          if ($request->hasFile('welcome_image')) {

              $welcome_image_path = public_path() . env('SURVEY_UPLOAD_PATH','');
              $welcome_image   = $request->file('welcome_image');
              $filename = time() . '.' . $welcome_image->getClientOriginalExtension();
              Image::make($welcome_image)->save($welcome_image_path . $filename);
              $welcome_image = $filename;

               if (!empty($survey->welcome_image)) {
                  if (file_exists($welcome_image_path . $survey->welcome_image)) {
                      unlink($welcome_image_path . $survey->welcome_image);
                  }
                 
              }

          }else {
              if($isWelcomeComeImageExists == '0'){
                $welcome_image = '';
              }
          }
          $show_logo = 2;
          if ($request->has('show_logo')) {
              $show_logo = 1;
          }
          
            $start_date = $survey->start_date;
            $end_date = $survey->end_date;
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

       
        //   $start_date =  date("Y-m-d", strtotime($request->post('start_date')) );
        //   $end_date =  date("Y-m-d", strtotime($request->post('end_date')) );

            $status = 2;
            if (($currentDate >= $start_date) && ($currentDate <= $end_date)){                
                $status = 1;
            }
          
          // try{

            // if(Auth::User()->role_id == Common::$intRoleUser)
            //     {   
            //         $clientId = DB::table('user_client')->where('user_id',Auth::User()->id)->first();
            //         if($clientId){
            //             $survey_data['comp_id'] = $clientId->client_id;
            //         }
            //     }else {
            //         $survey_data['comp_id']  = $request->post('comp_id');
            //     }
          
              $survey_data['comp_id'] = $request->post('comp_id');
              $survey_data['survey_company_logo'] = $survey_company_logo;
              $survey_data['survey_name'] = $request->post('survey_name');
              $survey_data['max_invitations'] = $max_invitations;
              $survey_data['start_date'] = $start_date;
              $survey_data['end_date'] = $end_date;
              $survey_data['show_logo'] = $show_logo;
              $survey_data['welcome_image'] = $welcome_image;
              $survey_data['welcome_description'] = $request->post('welcome_description');            
              //$survey_data['status'] = $request->post('status');  
              $survey_data['status']  = $status;
              $survey_data['thankyou_description'] = $request->post('thankyou_description');
              $survey_data['updated_at'] = DB::raw('NOW()');
             

              $page_heading_arr = [];
              $page_number = $request->post('page_number');


              for($i=1;$i<=count($page_number);$i++)
              {

                    $curr_page_number = $i;

                    $show_heading = 0;
                        if ($request->has('show_heading_' . $curr_page_number)) {
                            $show_heading = 1;
                        }
                        $show_subheading = 0;
                        if ($request->has('show_subheading_' . $curr_page_number)) {
                            $show_subheading = 1;
                        }
              
              
                    $page_heading_arr[] =  array(
                    'page_number'=>$curr_page_number,
                    'show_heading'=>$show_heading,
                    'show_subheading'=>$show_subheading,
                    'survey_heading'=>$request->post('survey_heading_' . $curr_page_number),
                    'survey_sub_heading'=>$request->post('survey_sub_heading_' . $curr_page_number),
                    'is_heading_bold'=>$request->post('is_heading_bold_' . $curr_page_number),
                    'is_heading_italic'=>$request->post('is_heading_italic_' . $curr_page_number),
                    'is_heading_underline'=>$request->post('is_heading_underline_' . $curr_page_number),
                    'is_subheading_bold'=>$request->post('is_subheading_bold_' . $curr_page_number),
                    'is_subheading_italic'=>$request->post('is_subheading_italic_' . $curr_page_number),
                    'is_subheading_underline'=>$request->post('is_subheading_underline_' . $curr_page_number),
                    'survey_heading_fontSize'=>$request->post('survey_heading_fontSize_' . $curr_page_number),
                    'survey_sub_heading_fontSize'=>$request->post('survey_sub_heading_fontSize_' . $curr_page_number),
                    'heading_fg_color'=>$request->post('heading_fg_color_' . $curr_page_number),
                    'sub_heading_fg_color'=>$request->post('sub_heading_fg_color_' . $curr_page_number),
                    'heading_bg_color'=>$request->post('heading_bg_color_' . $curr_page_number),
                    'sub_heading_bg_color'=>$request->post('sub_heading_bg_color_' . $curr_page_number),
                    
                    );

                    
              }

             
              $survey_heading_data['page_heading'] = json_encode($page_heading_arr);

            
             
              $survey_id =   Survey::where('id', $id)->update($survey_heading_data);



  
               // Now we simply need to re insert all by getting data from temp table to main table 
               
              
               $tmp_survey_questions = DB::table('tmp_survey_questions')                            
                    //->where('user_id','=',Auth::id())
                    ->where('tmp_survey_id','=',$id)
                    ->orderBy('tmp_survey_order_number','asc')    
                    ->orderBy('page_number','asc')
                    ->get();    

                           
               DB::table('survey_blocks')->where('survey_id','=',$id)->delete();
               DB::table('skip_logic')->where('survey_id','=',$id)->delete();
              $i = 1;
              if(!empty($tmp_survey_questions)){

                  foreach ($tmp_survey_questions as $curr_tmp_survey_question) {

                      $question_data['user_id'] = $curr_tmp_survey_question->user_id;
                      $question_data['survey_id'] = $id;
                      $question_data['page_number'] = $curr_tmp_survey_question->page_number;
                      $question_data['survey_question'] = $curr_tmp_survey_question->question;
                      $question_data['survey_question_type'] = $curr_tmp_survey_question->question_type; 
                      $question_data['question_number'] = $curr_tmp_survey_question->question_number;                                                
                    //   $question_data['survey_order_number'] =$i;  
                    $question_data['survey_order_number'] = $curr_tmp_survey_question->tmp_survey_order_number;                                                
                      $question_data['is_required'] = $curr_tmp_survey_question->is_required;                                                
                      $question_data['is_skip_logic_avail'] = $curr_tmp_survey_question->is_skip_logic_avail;                                                
                      
                      $question_id = SurveyBlocks::insertGetId($question_data);  

                       // Here first we are finding id from temp table to tmp_skip_logic and updating with the survey block id 
                        $tmp_skip_logic_data['question_id'] = $question_id;
                        TmpSkipLogic::where('question_id', $curr_tmp_survey_question->id)->update($tmp_skip_logic_data);

                        $tmp_skip_logic_data_skip_question_id['skip_question_id'] = $question_id;
                        TmpSkipLogic::where('skip_question_id', $curr_tmp_survey_question->id)->update($tmp_skip_logic_data_skip_question_id);
                      $i++;
                  }

                  
              }

              DB::table('tmp_survey_questions')->where('tmp_survey_id','=',$id)->delete();

               // getting all the skip logic question from tmp_skip_logic table based on logged in user id
                $tmp_skip_logic_questions = DB::table('tmp_skip_logic')
                    //->where('user_id', '=', Auth::id())
                    ->where('survey_id', '=', $id)
                    ->orderBy('id', 'asc')
                    ->get();
                if (!empty($tmp_skip_logic_questions)) {

                    foreach ($tmp_skip_logic_questions as $curr_tmp_skip_logic_question) {
                        $skip_logic_data['user_id'] = $curr_tmp_skip_logic_question->user_id;
                        $skip_logic_data['question_id'] = $curr_tmp_skip_logic_question->question_id;
                        $skip_logic_data['skip_question_id'] = $curr_tmp_skip_logic_question->skip_question_id;
                        $skip_logic_data['answer'] = $curr_tmp_skip_logic_question->answer;
                        $skip_logic_data['question_type'] = $curr_tmp_skip_logic_question->question_type;
                        $skip_logic_data['survey_id'] = $id;
                        $skip_logic_data['page_number'] = $curr_tmp_skip_logic_question->page_number;

                         $skip_logic_id = SkipLogic::insertGetId($skip_logic_data);

                    }

                    DB::table('tmp_skip_logic')->where('survey_id', $id)->delete();

                }
              
               $survey_id =   Survey::where('id', $id)->update($survey_heading_data);
               $survey_id =   Survey::where('id', $id)->update($survey_data);
              return redirect()->route('surveylist')->withMsgSuccess( 'Survey Updated Successfully.' );


          // } catch(\Exception $e) {
          //     return redirect()->route('surveylist')->withMsgFailed( 'There is some problem.' );
          // }
      
     
     }


    public function previewsurvey(Request $request,$id)
    {       
        $data = $this->call_data($request,$id);
        return view('front.survey.index',$data);
    }

    public function call_ajax(Request $request)
    { 
       // dd('sd');
        $id = $request->id;
        $data = $this->call_data($request,$id);
        
        
        return view('front.survey.ajax-form',$data); 
    }

       
     public function call_data(Request $request,$id="")
     {
// dd($data);
        $sid = $id;

        $survey = collect(DB::table('surveys')->where('id',$sid)->first())->toArray();

        $tmp_qry = DB::table('survey_blocks')->select(['survey_question_type','id','survey_question'])
        ->where('survey_id',$sid)
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

       $col = array_values(array_unique($col));
        
        $data['survey'] = $survey;
        $data['survey_questions'] = $survey_blocks;        
        $data['survey_company_thumb_path'] = env('SURVEY_COMPANY_THUMB_UPLOAD_PATH');
        $data['welcome_img_path'] = env('SURVEY_UPLOAD_PATH');

        $data['survey_heading'] = json_decode($data['survey']['page_heading']);
        $data['pages'] = $col;

        $data['custom_url'] = $id;

        $clients = DB::table('clients')
       ->where('status','=',1)
       ->where('id',$survey['comp_id'])
       ->first(); 

        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH','');
        $company_thumb_path = public_path() . env('COMPANY_THUMB_UPLOAD_PATH','');

       $data['company_original_logo'] = $company_original_path.$clients->company_logo;
       $data['company_logo_only'] = $clients->company_logo;
       //$data['company_logo_new'] = $request->company_logo;
       
        return $data;
    
     }

     /* for tmp preview only */

    public function tmp_previewsurvey(Request $request)
    {       
        $id="";

        if($request->survey_id != "")
        {
            $id = $request->survey_id;
        }
       
        $data = $this->tmp_call_data($request,$id);

        return view('front.survey.indexpreview',$data);
    }

    public function tmp_call_ajax(Request $request,$id="")
    { 
      
        
        $id="";
        if($request->id != "call_data")
        {
            $data = $this->call_data_user_id($request,$id); 
        }
        else
        {
            $data = $this->tmp_call_data($request,$id);
        }
        return view('front.survey.ajax-form',$data); 
    }

       
     public function tmp_call_data(Request $request,$id="")
     {
        
        $survey = $request->all();

       
        $survey['welcome_description'] = $survey['welcome_description_dummy'];
         $survey['welcome_image'] = $survey['welcome_image_dummy'];

        // $survey['survey_company_logo_dummy'] = $survey['survey_company_logo_dummy'];

       
        
        $survey['start_date'] = Carbon::parse($survey['start_date'])->format('Y-m-d');
        $survey['end_date'] = Carbon::parse($survey['end_date'])->format('Y-m-d');  
        $comp_id = $request->comp_id;
        
        
        $survey_blocks = [];
        $page_number = [];
        $col = [];
        $i =0;
        $ar = [];

        

        for($i=1;$i<=count($request->page_number);$i++)
        {
            foreach($survey as $key => $value) 
            {
                if (preg_match("/([A-z])*([".$i."])/",$key))
                {
                    $key = substr_replace($key ,"",-2);
                    $ar[$i][$key] = $value; 
                }
            }

        }

        if (array_key_exists('show_logo', $survey)) 
        {
            $survey['show_logo'] = 1;         
        }
        else
        {
            $survey['show_logo'] = 2;
        }

        $i = 1;
        
        foreach($ar as $a)
        {
            $a['page_number'] = $i;
            $i++;
        }

        foreach($page_number as $n)
        {
            $col[] = $n->page_number;
        }

        


        for($i=1;$i<=count($ar);$i++)
        {
            if (array_key_exists('show_heading', $ar[$i])) 
            {
                $ar[$i]['show_heading'] = 1;        
            }
            else
            {
                $ar[$i]['show_heading'] = 0;
            }

            if (array_key_exists('show_subheading', $ar[$i])) 
            {
                $ar[$i]['show_subheading'] = 1;        
            }
            else
            {
                $ar[$i]['show_subheading'] = 0;
            }

            

            if (!array_key_exists('survey_heading', $ar[$i])) 
            {
                $ar[$i]['survey_heading'] = "";
            }

            if (!array_key_exists('survey_sub_heading', $ar[$i])) 
            {
                $ar[$i]['survey_sub_heading'] = "";
            }
            
        }


        $survey['page_heading'] =  $survey['survey_heading'] = json_encode($ar);

       
        if(!isset($survey['survey_id']))
        {
            $tmp_survey['survey_id'] = '';
        }
        else
        {
            $tmp_survey['survey_id'] = $survey['survey_id'];
        }

        $tmp_survey['page_heading'] = json_encode($ar);
        $tmp_survey['show_logo'] = $survey['show_logo'];
        $tmp_survey['user_id'] = Auth::User()->id;
        $tmp_survey['comp_id'] = $survey['comp_id'];
        $tmp_survey['survey_name'] = $survey['survey_name'];
        $tmp_survey['thankyou_description'] = $survey['thankyou_description'];
        
        
        
        
        $data['survey'] = $survey;
            
        $data['survey_company_thumb_path'] = env('SURVEY_COMPANY_THUMB_UPLOAD_PATH');
        $data['welcome_img_path'] = env('SURVEY_UPLOAD_PATH');

        $data['survey_heading'] = json_decode($data['survey']['page_heading']);
        $data['pages'] = $col;

        $clients = DB::table('clients')
       //->where('status','=',1)
       ->where('id',$comp_id)
       ->first(); 

        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH','');
        $company_thumb_path = public_path() . env('COMPANY_THUMB_UPLOAD_PATH','');

       $data['company_original_logo'] = $company_original_path.$clients->company_logo;
       $data['company_logo_only'] = $clients->company_logo;

        if(isset($survey['survey_id']))
            DB::table('tmp_survey_preview')->where('survey_id',$survey['survey_id'])->delete();
        else
        {
            DB::table('tmp_survey_preview')->where('user_id',Auth::id())->delete();
        }
           
        sleep(1);
        DB::table('tmp_survey_preview')->insert($tmp_survey);
      
        //dd($data);
        return $data;
    
     }


     public function call_data_user_id(Request $request,$id="")
     {

        

        if(Str::contains(\URL::previous(), 'edit') ) 
        {
            $sid = explode("/" , \URL::previous());
            $survey_id = end($sid) ;
            $tmp_qry = DB::table('tmp_survey_questions')->select(['question_type','id','question','page_number'])
            ->where('tmp_survey_id',$survey_id)
            ->orderBy('tmp_survey_order_number','asc')    
            ->orderBy('page_number','asc')
            ->get()->toArray();

            $survey = collect(DB::table('tmp_survey_preview')->where('survey_id',$survey_id)->first())->toArray();
        }
        else
        {
            $sid = Auth::User()->id;
            $tmp_qry = DB::table('tmp_survey_questions')->select(['question_type','id','question','page_number'])
            ->where('user_id',$sid)
            ->orderBy('tmp_survey_order_number','asc')    
            ->orderBy('page_number','asc')
            ->get()->toArray();
           
            $survey = collect(DB::table('tmp_survey_preview')->where('user_id',$sid)->first())->toArray();
        }
      
       


        $survey_blocks = [];
        $page_number = [];
        $col = [];
        $i =0;

        


        foreach($tmp_qry as $q)
        {
            $survey_question = json_decode($q->question);

            $survey_blocks[$i]['survey_blocks'] = DB::table('tmp_survey_questions')->where('id',$q->id)->orderBy('tmp_survey_order_number','asc')    
            ->orderBy('page_number','asc')->first();
            // $survey_blocks[$i]['survey_blocks'] = $q->question;
            // $page_number[$i] = DB::table('tmp_survey_questions')->select('page_number')->where('id',$q->id)->first();
            $page_number[$i] = $q->page_number;
            
            if($q->question_type == Common::$intPoll || $q->question_type == Common::$intMatrix)
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

        $page_number = json_decode($survey['page_heading'])  ;

        


        $nc =1;
        foreach($page_number as $n)
        {
            $col[] =  $nc ; //$n->page_number;
            $nc++;
        }

        $col = array_values(array_unique($col));
        
       
        $data['survey'] = $survey;
        $data['survey_questions'] = $survey_blocks;        
        $data['survey_company_thumb_path'] = env('SURVEY_COMPANY_THUMB_UPLOAD_PATH');
        $data['welcome_img_path'] = env('SURVEY_UPLOAD_PATH');


      
        $data['survey_heading'] = [];
         $ash = json_decode($data['survey']['page_heading']);
        $data['pages'] = $col;

        foreach($ash as $a)
        {
            $data['survey_heading'][]  = $a;
        }
        
        $data['custom_url'] = $id;

        $clients = DB::table('clients')
       ->where('status','=',1)
       ->where('id',$survey['comp_id'])
       ->first(); 

       
        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH','');
        $company_thumb_path = public_path() . env('COMPANY_THUMB_UPLOAD_PATH','');

       $data['company_original_logo'] = $company_original_path.$clients->company_logo;
       $data['company_logo_only'] = $clients->company_logo;
        $data['company_logo_new'] = $request->company_logo;
       return view('front.survey.ajax-form',$data); 
    
     }


     public function tmp_delete(Request $request)
     {
        if($request->str == "edit")
        {
            DB::table('tmp_survey_preview')->where('survey_id', $request->id)->delete();
            DB::table('tmp_survey_questions')->where('tmp_survey_id', $request->id)->delete();
            
        }
        else
        {
            DB::table('tmp_survey_preview')->where('user_id', Auth::User()->id)->delete();
            DB::table('tmp_survey_questions')->where('user_id', Auth::User()->id)->delete();
        }
        
     }

    
}
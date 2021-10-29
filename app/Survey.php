<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Common;
use Illuminate\Support\Facades\Auth;
class Survey extends Model
{
    

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'company_name', 'contact_number', 'email', 'website', 'description', 'company_logo','status'
    // ];
    protected $guarded = ['id'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function searchSurveyCommon($searchQuery = []){
        if(isset($searchQuery['defaultLimit'])){
            $defaultLimit = $searchQuery['defaultLimit'];
        }else {
            $defaultLimit = 20;
        }
    
        $imgUrl                = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));
        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');

        $survey_company_imgUrl        = url(env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', ''));
        $survey_company_original_path = public_path() . env('SURVEY_COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $survey_company_thumb_path    = public_path() . env('SURVEY_COMPANY_THUMB_UPLOAD_PATH', '');

        $arrColumns = [
            'surveys.*', 'c.company_logo', 'c.company_name',
            DB::raw('count(DISTINCT(usa.url)) as total_responded'),
           // DB::raw('DATEDIFF(end_date,now()) AS remaining_days'),
            DB::raw('CASE WHEN end_date IS NOT NULL  THEN DATEDIFF(end_date,now()) ELSE 0 END AS remaining_days'),
        ];

        $query = DB::table('surveys')
                ->select($arrColumns)            
                ->leftJoin('clients AS c', 'surveys.comp_id', '=', 'c.id');
        if (!Common::isAdmin()) {  
               // $query->join('user_client AS uc', 'c.id', '=', 'uc.client_id');
        }
                $query->leftJoin('users_survey_answer AS usa', 'usa.survey_id', 'surveys.id');
                $query->groupBy('surveys.id');

        if (!Common::isAdmin()) {  
                      //dd('sdfsd');
            $query->where('surveys.user_id', Auth::id());
            $query->whereIn('surveys.comp_id',function($query) {
               $query->select('client_id')->from('user_client')->where('user_id', '=', Auth::id());

            });  
             //$query->whereIn('surveys.comp_id', Auth::id());
        }

        if (isset($searchQuery['status'])) {            
            $query->where('surveys.status', $searchQuery['status']);        
        }else{   
            $query->where('surveys.status', 1);
        }

        if (isset($searchQuery['survey_name'])) {
            $query->where('surveys.survey_name', 'LIKE', "%" . $searchQuery['survey_name'] ."%");
        }
        
        if (isset($searchQuery['limit'])) {            
            
            $query->take($defaultLimit)->skip(0);
        }else {
            if (isset($searchQuery['offset'])) {
                
                $query->take($defaultLimit)->skip($searchQuery['offset'] * $defaultLimit);
            }
            else{
                $query->take($defaultLimit)->skip(0);
            }
        }
       
        $query->orderBy('updated_at', 'desc');
        //dd(Common::getQuery($query));
        $surveys = $query->get();

        $data['surveys'] = $surveys;

        $data['imgUrl']                = $imgUrl;
        $data['company_original_path'] = $company_original_path;
        $data['company_thumb_path']    = $company_thumb_path;

        $data['survey_company_imgUrl']        = $survey_company_imgUrl;
        $data['survey_company_original_path'] = $survey_company_original_path;
        $data['survey_company_thumb_path']    = $survey_company_thumb_path;

        return $data;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Client extends Model
{
    

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'contact_number', 'email', 'website', 'description', 'company_logo','status'
    ];

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


    public function searchClientCommon($searchQuery = []){
        $imgUrl                = url(env('COMPANY_THUMB_UPLOAD_PATH', ''));
        $company_original_path = public_path() . env('COMPANY_ORIGINAL_UPLOAD_PATH', '');
        $company_thumb_path    = public_path() . env('COMPANY_THUMB_UPLOAD_PATH', '');

        $arrColumns = array(
            'clients.*',        
            DB::raw('count(surveys.id) as total_survey'),            
            DB::raw('IF(sum(surveys.max_invitations) IS NULL, 0, sum(surveys.max_invitations)) as total_invitation'),
        );
        $query = DB::table('clients')
                ->select($arrColumns)
                ->leftJoin('surveys', 'surveys.comp_id', 'clients.id')
                ->groupBy('clients.id');

        if (isset($searchQuery['status'])) {
            $query->where('clients.status', $searchQuery['status']);
        }

        if (isset($searchQuery['company_name'])) {           
            $query->where('company_name', 'LIKE', "%" . $searchQuery['company_name'] ."%");
        }
        if (isset($searchQuery['offset'])) {
            $query->take(20)->skip($searchQuery['offset'] * 20);
        }else {
            $query->take(20)->skip(0);
        }
        $query->orderBy('clients.updated_at', 'desc');
        $clients = $query->get();

        $data['clients']               = $clients;
        $data['imgUrl']                = $imgUrl;
        $data['company_original_path'] = $company_original_path;
        $data['company_thumb_path']    = $company_thumb_path;

        return $data;
    }
}

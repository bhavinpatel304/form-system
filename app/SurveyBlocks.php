<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyBlocks extends Model
{
    

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_blocks';

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
}

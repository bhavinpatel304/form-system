<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyLibrary extends Model
{
    

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_library';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '*'
    ];
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

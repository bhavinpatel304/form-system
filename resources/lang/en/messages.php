<?php

return [
    'email'                 => [ 
                                   'required' => 'Please enter email',
                                   'email' => 'Please enter valid email'
                                ],
    'contact_number'                => [ 
                                    'required' => 'Please enter mobile number' ,
                                    'numeric' => 'Please enter valid mobile number'
                                ],
    
    'password'              => 'Please enter password',
    'new_password'          => 'Please enter new password',
    'confirm_password'      => 'Please confirm password',
    'confirm_password_not'  => 'Confirm password is different than password',
    'fname'            => 'Please enter first name',
    'lname'             => 'Please enter last name',

    'role'                  => 'Please select role',
    'client'               => 'Please select client',

    'password_confirmation' => 'Password & confirm password must be same',
    'password_length'       =>'Password is too sort',
    'empty_datatble'        => 'No records found',
    'company_name'=> 'Please enter company name',
    'website'=>[
        'required'=> 'Please enter website URL',
        'url'=> 'Please enter valid website URL',
    ],
    'company_logo'=>[
        'required'=>'Please select company logo',
        'mime'=>'Please upload valid company logo',
        'size'=>'Logo size must be less than 1MB'
    ],
    'description'=>'Please enter description',
    'old_password'=>'Please enter old password',
     'profile_image'=>[
        'required'=>'Please select profile image',
        'mime'=>'Please upload valid profile image',
        'size'=>'Image size must be less than 1MB'

    ],

    'ajaxformchkbox' => 'Please select at least one.',
    'ajaxformtxtarea' => 'Please enter text.',
    'ajaxformtxtbox' => 'Please enter text.',
    'ajaxformradio' => 'Please select any one.',
    'ajaxformselectbox' => 'Please select any one.',

    

    
];

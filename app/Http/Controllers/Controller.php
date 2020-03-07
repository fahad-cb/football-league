<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** 
     * @var Object 
     * 
     * These are validation messages, will be used globally for extended controllers
    */
    public $messages = [
        'required' => 'The :attribute field is required.',
        'unique' => 'The :attribute field is already taken.',
        'email' => 'The :attribute field is not valid email.',
        'integer' => 'The :attribute field is not valid integer.',
        'string' => 'The :attribute field is not valid string.',
    ];
}

<?php


// namespace App\Helpers;

use App\Models\LogActivity as ModelsLogActivity;



    function addToLog($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        ModelsLogActivity::create($log);
    }


    


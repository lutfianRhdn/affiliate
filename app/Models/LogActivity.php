<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject','user_id','company_id'
    ];

    public function getData()
    {
        $logs = LogActivity::all();
        return $logs;
    }
}

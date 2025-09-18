<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbtSetting extends Model
{
    use HasFactory;

    protected $table = 'cbt_settings';

    protected $fillable = [
        'max_questions',
        'test_duration',
        'passing_grade',
    ];
}

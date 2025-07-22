<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceCenterSetting extends Model
{
    protected $fillable = [
        'banner_title',
        'banner_description',
        'banner_image',
        'button_text',
        'banner2_title',
        'banner2_description',
        'banner2_button_text',
        'container2_video',
        'container3_image',
    ];
}

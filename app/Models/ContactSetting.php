<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $table = 'contact_settings';
    protected $fillable = [
        'banner_title',
        'banner_description',
        'banner_image',
        'button_text',
        'newsletter_label',
    ];
    public $timestamps = false;
}

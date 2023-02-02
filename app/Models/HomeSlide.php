<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    use HasFactory;

    // nullable
    protected $guarded = [];

    // protected $fillable = [
    //     'title',
    //     'title_description',
    //     'slide_image',
    //     'video_url'
    // ];
}

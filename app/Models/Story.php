<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey ='id';
    protected $table = 'stories';
    protected $fillable=[
        'nameStory','status','slug','descriptionStory','category_id','image'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}

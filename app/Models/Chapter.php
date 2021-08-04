<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey ='id';
    protected $table = 'chapters';
    protected $fillable=[
        'name','status','slug','description','story_id','detail','status'
    ];

    public function story(){
        return $this->belongsTo('App\Models\Story','story_id');
    }
}

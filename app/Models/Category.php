<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=[
        'nameCategory','status','slug','descriptionCategory','parent_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'categories';
}

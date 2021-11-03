<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use App\Laravel\Traits\DateFormatterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use DateFormatterTrait,SoftDeletes;

	protected $table = "article";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desc','name'
    ];

    public $timestamps = true;

  


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Covid extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'covids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Age', 'SEX', 'Temperature', 'Score', 'Result',
    ];
}

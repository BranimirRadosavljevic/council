<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}

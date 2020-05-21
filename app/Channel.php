<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    protected static function booted()
    {
        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('archived', false);
        // });

        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public static function withArchived()
    {
        return (new static)->newQueryWithoutScope('active');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

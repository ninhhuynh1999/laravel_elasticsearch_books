<?php

namespace App\Traits;

trait RecordSignature
{
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {

            $model->modified_by = \Auth::User()->id;
        });

        static::creating(function ($model) {

            $model->created_by = \Auth::User()->id;
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lawyer extends Authenticatable
{
    protected $fillable = ['fullname', 'phones', 'email', 'address', 'brief', 'status', 'category_id', 'token', 'api_token','country_id','area_id','notes'];
    protected $casts = ['phones' => 'array'];
    protected $hidden = ['password'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function category()
    {
        return $this->belongsTo(LawCategory::class, 'category_id');
    }
    public function lawsuits()
    {
        return $this->belongsToMany(Lawsuit::class);
    }

    public function approved_lawsuits()
    {
        return $this->belongsToMany(Lawsuit::class)->wherePivot('approved', 1);
    }

    public function accepted_lawsuits()
    {
        return $this->belongsToMany(Lawsuit::class)->wherePivot('status', 'accepted')
            ->wherePivot('approved', null)
            ->withPivot('status', 'created_at', 'id');
    }

    public function rejected_lawsuits()
    {
        return $this->belongsToMany(Lawsuit::class)->wherePivot('status', 'rejected')
            ->withPivot('status', 'created_at', 'id');
    }

    public function pending_lawsuits()
    {
        return $this->belongsToMany(Lawsuit::class)->wherePivot('status', 'pending')
            ->withPivot('status', 'created_at', 'id');
    }
}

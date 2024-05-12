<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawsuit extends Model
{
    protected $fillable = ['content' , 'name' , 'category_id', 'user_id', 'status', 'area_id', 'address','files','notes'];
    protected $hidden = ['updated_at'];
    protected $appends = ['mystatus'];

    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class)->withPivot('status', 'created_at', 'id', 'approved');
    }

    public function lawyer()
    {
        return $this->belongsToMany(Lawyer::class)->wherePivot('approved', 1)->withPivot('fees' , 'percentage' , 'reason', 'approved', 'choose')
        ->select('lawyers.id' , 'fullname' , 'phones' , 'email');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(LawCategory::class, 'category_id');
    }

    public function getMystatusAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return "بانتظار تعيين محامي";
            case 'wait_lawyer_approve':
                return "بانتظار موافقة المحامين";
            case 'wait_payment':
                return "بانتظار السداد";
            default:
                return "تم تعيين المحامى";
        }
    }

    public function getCreatedAtAttribute($created_at)
    {
        return date('Y-m-d', strtotime($created_at));
    }
    public function getUpdatedAtAttribute($updated_at)
    {
        return date('Y-m-d', strtotime($updated_at));
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}

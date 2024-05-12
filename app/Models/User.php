<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'wallpaper','online','Expire_Date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo('\App\Models\Roles', 'role_id');
    }
    public function comments()
    {
        return $this->hasMany('\App\Models\Comments');
    }
    public function advs()
    {
        return $this->hasMany('\App\Models\Advs');
    }
    public function followers()
    {
        return $this->hasMany('\App\Models\Followers');
    }
    public function follows()
    {
        return $this->hasMany('\App\Models\Followers', 'follower_id');
    }
    public function likes()
    {
        return $this->hasMany('\App\Models\Likes');
    }
    public function likes_advs()
    {
        return $this->belongsToMany('\App\Models\Advs', 'likes');
    }
    public function contacts()
    {
        return $this->hasMany('\App\Models\User_contacts');
    }
    // public function chat(){
    //     return $this->hasMany('\App\Models\Chat','from_id');
    // }
    public function area()
    {
        return $this->belongsTo('\App\Models\Area', 'area_id');
    }
    public function country()
    {
        return $this->belongsTo('\App\Models\Country', 'country_id');
    }
    public function pays()
    {
        return $this->hasMany('\App\Models\Pays');
    }
    public function rate()
    {
        return $this->hasMany('\App\Models\Rates');
    }
    public function notfs()
    {
        return $this->hasMany('\App\Models\Notfs');
    }

    public function msgs()
    {
        return $this->hasMany('\App\Models\Chat', 'to');
    }
    public function getType()
    {
        return $this->belongsTo('\App\Models\Jointypes', 'type');
    }

    public function mylikes()
    {
        return $this->hasMany('\App\Models\Likes', 'person_id');
    }

    public function lawsuits()
    {
        return $this->hasMany(Lawsuit::class, 'user_id');
    }

    public function getImageAttribute($image)
    {
//        return is_file(public_path($image)) ? url($image) : url('user.png');
        if($image){
            $finalImage = url('/').$image;
            if (!is_file($finalImage)){
                $finalImage = url('user.png');
            }
        }
        else{
            $finalImage = url('user.png');
        }
        return $finalImage;
    }

    public function tokens()
    {
        return $this->hasMany(Tokens::class, 'user_id');
    }

    public function documentation()
    {
        return $this->hasOne(DocumentationForm::class, 'user_id');
    }

    public function getCheckDocAttribute() {
        $return = 0;
        $c = $this->documentation;
        if(!is_null($c)) {
            if($c->activeted == 1) {
                $return = 1;
            }
        }
        return $return;
    }
}

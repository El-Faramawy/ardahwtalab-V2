<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Advs extends Model
{

    protected $table = 'advs';
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];
    protected $appends = ['main_options', 'has_bids'];


    // public static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(function ($query) {
    //         if(!request()->is('admin*')) {
    //             $query->where('is_deleted',0);
    //         }
    //     });
    // }


    /**
     *
     * @return \App\Depts
     */
    public function getdept()
    {
        return $this->belongsTo(Depts::class, 'dept');
    }

    public function getSuperDeptAttribute()
    {
        return $this->getdept->super_parent ?? $this->getdept;
    }

    public function images()
    {
        $images = $this->hasMany(Images::class, 'adv_id');
        $img = $images->get();
        if (count($img) > 0) {
            if (isset($img[0]->image)) {
                $this->setAttribute('main_image', url('/imageresize/medium/') . $img[0]->getOriginal('image'));
            } else {
                // $IMAGE_URL = DB::table('site_config')->where('id', 1)->first()->logo ?? url('site/images/placeholder.png');
                $IMAGE_URL = route('SPhone','site/images/placeholder.png');
                $this->setAttribute('main_image', URL($IMAGE_URL));
            }
        } else {
            // $IMAGE_URL = DB::table('site_config')->where('id', 1)->first()->logo ?? url('site/images/placeholder.png');
            $IMAGE_URL = route('SPhone','site/images/placeholder.png');
            $this->setAttribute('main_image', URL($IMAGE_URL));
        }
        return $images;
    }

    public function getImageAttribute()
    {
        return $this->images()->count() ? $this->images()->first()->image : url('site/images/placeholder.png');
        // return $this->images()->count() ? $this->images()->first()->image : url('site/images/logo.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getarea()
    {
        return $this->belongsTo(Area::class, 'area');
    }

    public function getcountry()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'advs_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function getShortAttribute()
    {
        $description = strip_tags($this->description);
        if (mb_strlen($description) > 110) {
            return mb_substr($description, 0, 110) . ' ....';
        }
        return $description;
    }

    public function likes_users()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function gettype()
    {
        return $this->belongsTo(Operations::class, 'type');
    }

    public function bids()
    {
        return $this->hasMany(Bids::class)->orderBy('price', 'desc')->with('user');
    }

    public function getTimeAgoAttribute()
    {
        return time_ago($this->created_at);
    }

    public function getLinkAttribute()
    {
        return route('advertise.show', [$this->id, $this->slug]);
    }

    public function getOptionsAttribute($options)
    {
        return array_filter((array) json_decode($options));
    }

    public function getAddressAttriubte()
    {
        $str = "";
        if ($country = $this->getCountry) {
            $str .= "<a href='{$country->link}'>{$country->name}</a> - ";
        }
        if ($area = $this->getArea) {
            $str .= "<a href='{$area->link}'>{$area->name}</a>";
        }
        return $str;
    }

    public function getTitlesAttribute()
    {
        $newoptions = [];
        $options = is_string($this->options) ? (array) json_decode($this->options) : (array) $this->options;
        $options = array_filter($options);
        $props = Props::whereIn('id', array_keys($options))->orderBy('title_id', 'asc')->get();
        foreach ($options as $key => $opt) {
            $newoptions['_' . $key] = $opt;
        }
        $title_id = '-1';
        $title = '#';
        $rows = [];
        foreach ($props as $prop) {
            if ($title_id != $prop->title_id) {
                $title_id = $prop->title_id;
                $title = Titles::find($prop->title_id)->name ?? '#';
            }
            $rows[$title][$prop->name] = $newoptions['_' . $prop->id] ?? '';
        }
        return $rows;
    }

    public function getMainOptionsAttribute()
    {
        $newoptions = [];
        $options = is_string($this->options) ? (array) json_decode($this->options) : (array) $this->options;
        $options = array_filter($options);
        $props = Props::whereIn('id', array_keys($options))->where('main', 1)->take(3)->get();
        foreach ($options as $key => $opt) {
            $newoptions['_' . $key] = $opt;
        }
        $rows = [];
        foreach ($props as $prop) {
            $rows[$prop->icon] = $newoptions['_' . $prop->id] ?? '';
        }
        if (empty($rows)) {
            if ($this->getdept) {
                $props = Props::where('dept_id', $this->getdept->super_id)->where('main', 1)->get();
                foreach ($props as $prop) {
                    $rows[$prop->icon] = '';
                }
            }
        }
        return $rows;
    }


    public function getSimilarsAttribute()
    {
        return Advs::where('dept', $this->dept)->where('id', '!=', $this->id)->latest()->take(3)->get();
    }

    public function getTreeAttribute()
    {
        $dept = $this->getdept;
        $tree = "";
        if ($parent = $dept->parent) {
            $tree .= $this->hasTree($parent);
        }
        $tree .= "<li><a href='{$dept->link}' class='fixall'>{$dept->name}</a></li>";
        $tree .= "<li><a href='#' class='fixall'>{$this->title}</a></li>";
        return html_entity_decode($tree);
    }

    public function hasTree($val) {
        $return = '';
        if(!is_null($val->parent)) {
            $p = $val->parent;
            $return .= $this->hasTree($p);
        }
        $return .= "<li><a href='{$val->link}' class='fixall'>{$val->name}</a></li>";
        return $return;
    }

    public static function scopeGetByDistance($query, $lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM advs HAVING distance < ' . $distance . ' ORDER BY distance'));
        $ids = [];
        if (!empty($results)) {
            foreach ($results as $q) {
                array_push($ids, $q->id);
            }
        }
        return $query->whereIn('id', $ids);
    }

    public function getHasBidsAttribute()
    {
        $dept = Depts::find($this->getOriginal('dept'));
        return $dept && $dept->super_parent->home ? true : false;
    }

    public function catgeories() {
        return $this->belongsToMany(Depts::class, 'advs_depts_pivot', 'adv_id', 'dept_id');
    }
    public function subscription(){
        return $this->hasOne('App\Models\Subscription' , 'id' , 'subscription_id' );
    }
}

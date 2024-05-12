<?php
use Illuminate\Support\Str;

function get_contact_url($contact)
{
    $url = $contact->value;
    if ($contact->type == 'email') {
        $url = 'mailto:' . $contact->value;
    }
    if ($contact->type == 'whats') {
        $url = "https://api.whatsapp.com/send?phone={$contact->value}";
    }

    return $url;
}

function build_menu_item($item, $attrs = [])
{
    if (isset($item['in_login']) && $item['in_login'] === true && auth()->check() === false) {
        return;
    }
    $title = '';
    $url = '';
    if ($item['type'] == 'url') {
        $title = $item['title'];
        $url = asset($item['url']);
    } elseif ($item['type'] == 'page') {
        $page = \App\Models\Pages::find($item['page_id']);
        if ($page) {
            $title = $page->title;
            $url = asset('page/' . $title);
        } else {
            $title = '';
            $url = '/';
        }
    }
    @$res = "<li>";
    @$res .= "<a class='{$attrs['link_calss']}' href='$url'>";
    @$res .= isset($item['icon']) ? "<i class='{$item['icon']}'></i> " : '';
    @$res .= ""
        . "$title</a>"
        . "</li>";
    return $res;
}

function getSiteConfig($key = 'key')
{
    static $siteConfigList = null;
    if (null === $siteConfigList) {
        $siteConfigList = \App\Models\SiteConfig::first();
    }
    if (isset($siteConfigList->$key)) {
        return $siteConfigList->{$key} && $siteConfigList->{$key} != '' ? (string) $siteConfigList->{$key} : null;
    }
    if (null == $key) {
        return $siteConfigList;
    }
}

function user_roles($role)
{

    return true;

    $roles = \App\Models\Roles::find(Auth::user()->role_id);
    $roles = explode(',', $roles->roles);
    if (in_array($role, $roles)) {
        return 1;
    }
    return 0;
}

function base64_to_jpeg($base64_string, $output_file)
{
    $ifp = fopen($output_file, "wb");
    $data = explode(',', $base64_string);
    isset($data[1]) ? $data = $data[1] : $data = $data[0];
    fwrite($ifp, base64_decode($data));
    fclose($ifp);
    // return $output_file;
}

function uploadBaseImage($image)
{
    $filename = "assets/uplaods/" . time() . rand(1, 100) . '.png';
    $filename = (string) $filename;
    base64_to_jpeg($image, $filename);
    DoWaterMarkApiImage($filename);
    return $filename;
}
function get_watermark_image()
{
    static $watermark_image = null;
    if (null == $watermark_image) {
        $watermark_image = url('/') . DB::table('ads_config')->first()->watermark_image;
    }
    return $watermark_image;
}

function DoWaterMarkApiImage($file)
{

    $image = new Intervention\Image\ImageManagerStatic;
    $base_image = $image->make($file);
    $base_image_width = $base_image->width();


    $watermark = get_watermark_image();
    $watermark = $image->make($watermark)->opacity(50)->resize((10 / 100) * $base_image_width, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });


    $base_image->insert($watermark, 'bottom-left');
    $base_image->save($file);
}
 function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

function uploadImage($file, $width = 300, $height = 200, $watermark = false)
{
    if (!is_uploaded_file($file)) {
        return $file;
    }
    // $filename = md5(str_random() . time()) . '.png';
    $filename = md5(Str::random() . time()) . '.png';

    $path = 'assets/uplaods/' . $filename;

    $image = new Intervention\Image\ImageManagerStatic;
    if ($width) {
        $image->make($file)->resize($width, $height)->save($path);

    } else {
        $width = $image->make($file)->save($path)->width();
    }


    if ($watermark) {
        $watermark = url(site_config()->logo);
        $watermark = $image->make($watermark)->opacity(80)->resize((30 / 100) * $width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img = $image->make($path);
         // Dexter
            $source_img = $path;
            $destination_img = $source_img;
            $d = compress($source_img, $destination_img, 40);
        // Dexter
        $img->insert($watermark, 'bottom-left', 20, 20);
        $img->save($path);

       return '/' . $d;
    }else{
        return '/' .$path;
    }

   // return '/' . $path;


}

function site_config()
{
    return DB::table('site_config')->first();
}

function joinRules()
{
    return [
        'auto_active' => 'التفعيل تلقائى لﻻعﻻنات',
        'no_limit_ads' => 'اضافة عدد ﻻ محدود من الاعﻻنات',
        '20ads_24' => 'إضافة عدد 20 إعلانات خلال يوم 24 ساعة',
        '5ads_24' => 'إضافة عدد 5 إعلانات خلال يوم 24 ساعة',
        'del_ads' => 'أمكانية حذف الاعﻻنات',
        'manage_store' => 'إدارة وتعديل المتجر',
        'all_servs' => 'التمتع بكامل الخدمات من ( بيع - شراء - مزاد )',
        'chat' => 'استخدام الشات و المحادثات المباشرة',
        'send_msg' => 'امكانية ارسال رسائل لﻻعضاء',
    ];
}

function payTypes()
{
    return [
        'bank' => 'تحويل بنكى',
        'credit' => 'بطاقة ائتمانية',
        'onecard' => 'ون كارد',
        'cashu' => 'كاش يو',
        'western' => 'ويسترن يونيون',
        'iban' => 'الآيبان',
        'mail' => 'حوالة بريدية'
    ];
}

function positions()
{
    return [
        'top' => 'اعلى',
        'bottom' => 'اسفل',
        'left' => 'يسار',
        'right' => 'يمين'
    ];
}

function activeBy()
{
    return [
        'email' => 'البريد الإلكترونى',
        'sms' => 'رسائب نصية (sms)'
    ];
}

function contactTypes()
{
    return [
        'email' => 'البريد الإلكترونى',
        'phone' => 'الهاتف',
        'mobile' => 'الجوال',
        'fax' => 'الفاكس',
        'mail' => 'صندوق البريد',
        'address' => 'العنوان',
        'whats' => 'واتس اب',
        'facebook' => 'فيس بوك',
        'twitter' => 'تويتر',
        'google' => 'جوجل بلس',
        'youtube' => 'يوتيوب',
        'instagram' => 'انستجرام',
        'linkedin' => 'لينك ان',
        'snapchat-ghost' => 'سناب شات'
    ];
}

function contactIcons()
{
    return [
        'email' => 'fas fa-envelope',
        'phone' => 'fas fa-phone',
        'mobile' => 'fas fa-mobile-alt',
        'fax' => 'fas fa-fax',
        'mail' => 'fas fa-envelope',
        'address' => 'fas fa-map-marker-alt',
        'whats' => 'fab fa-whatsapp',
        'facebook' => 'fab fa-facebook',
        'twitter' => 'fab fa-twitter',
        'google' => 'fab fa-google-plus-g',
        'youtube' => 'fab fa-youtube',
        'instagram' => 'fab fa-instagram',
        'linkedin' => 'fab fa-linkedin-in',
        'snapchat-ghost' => 'fab fa-snapchat-ghost',
    ];
}

function smsPackages()
{
    return [
        'wasel' => 'waselsms.com'
    ];
}

function WatermarkPositions()
{
    return [
        '1' => 'أعلى يسار',
        '2' => 'أعلى يمين',
        '5' => 'أعلى منتصف',
        '4' => 'أسفل يسار',
        '3' => 'أسفل يمين',
        '7' => 'أسفل منتصف'
    ];
}

function AdminRoles()
{
    return [
        'site_config' => 'إعدادات الموقع',
        // 'payments'		=>	'وسائل الدفع',
        'area' => 'الدول والمناطق',
        'pages' => 'الصفحات',
        'depts' => 'الأقسام',
        // 'servs'			=>	'الخدمات',
        // 'posters'		=>	'المساحات الإعلانيه',
        // 'sliders'		=>	'شرائح السليدر الرئيسية',
        'advs' => 'الإعلانات',
        'users' => 'المستخدمين والصلاحيات',
    ];
}

function time_ago($datetime, $full = false)
{
    date_default_timezone_set('Asia/Riyadh');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'سنة',
        'm' => 'شهر',
        'w' => 'أسبوع',
        'd' => 'يوم',
        'h' => 'ساعة',
        'i' => 'دقيقة',
        's' => 'ثانية',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? 'قبل ' . implode(', ', $string) : 'الآن';
}

function layout_data()
{
    // $data['sliders']=\App\Sliders::all();
    static $depts = null;
    static $config = null;
    static $contacts = null;
    static $pages = null;
    static $area = null;
    if (is_null($depts)) {
        $depts = \App\Models\Depts::where('parent_id', null)->get();
    }
    if (null == $config) {
        $config = \App\Models\SiteConfig::first();
    }
    if (null == $contacts) {
        $contacts = \App\Models\SiteContacts::all();
    }
    if (null == $pages) {
        $pages = \App\Models\Pages::all();
    }
    if (null == $area) {
        $area = \App\Models\Area::all();
    }
    $data['depts'] = $depts;
    $data['dept_name'] = [];
    $data['config'] = $config;
    $data['area'] = $area;
    $data['pages'] = $pages;
    $data['contacts'] = $contacts;
    if (Auth::check()) {
        $data['notfs'] = Auth::user()->notfs()->where('seen', 0)->take(6)->get();
        //$data['msgs'] = Auth::user()->msgs()->where('seen', 0)->groupBy('from', 'to')->take(6)->get();
        $data['msgs'] = Auth::user()->msgs()->where('seen', 0)->take(6)->get();
    }
    $data = (object) $data;
    return $data;
}

function mail_data()
{
    $data['drivers'] = ['smtp', 'mandril', 'mailgun', 'mail'];
    $data['enc'] = ['tls', 'utf-8'];
    $data = (object) $data;

    return $data;
}

function send_sms($user, $pass, $telephone, $sender, $content)
{
    $phone = preg_replace('/000+/', '', $telephone);
    // User From Sending Site
    $smsUserName = $user;
    $smsUserPass = $pass;
    $Sender = $sender;
    $smsSenderName = str_replace(' ', '%20', $sender);
    $msg = str_replace(' ', '%20', $content);
    $telephone = $str = '966' . substr($telephone, 1);
    $sms = "http://www.waselsms.com/api.php?comm=sendsms&user=" . $smsUserName . "&pass=" . $smsUserPass . "&to=" . $telephone . "&sender=" . $smsSenderName . "&message=" . $msg;
    $url = (string) $sms;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // This is what solved the issue (Accepting gzip encoding)
    curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
    $response = curl_exec($ch);
    curl_close($ch);
    $dh = $response;
    // dd($dh);
    $msg = "";
    $result = explode(':', $dh);
    if ($result[0] == 'u') {
        $msg = "تم الارسال";
    } elseif ($result[0] == '-2') {
        $msg = "الرسائل غير متوفره في هذه البلد";
    } elseif ($result[0] == '-999') {
        $msg = "فشل في ارسال الرسالة";
    } elseif ($result[0] == '-100') {
        $msg = "خطأ في حساب المرسل";
    } elseif ($result[0] == '-110') {
        $msg = "خطأ في اسم المستخدم و كلمة المرور الخاصة بحساب المرسل";
    } elseif ($result[0] == '-111') {
        $msg = "حساب المرسل غير مفعل";
    } elseif ($result[0] == '-112') {
        $msg = "الحساب محظور";
    } elseif ($result[0] == '-113') {
        $msg = "رصيد الرسائل غير كافي";
    } elseif ($result[0] == '-114') {
        $msg = "الخدمة غير متاحه";
    } elseif ($result[0] == '-115') {
        $msg = "المرسل غير متاح";
    } elseif ($result[0] == '-116') {
        $msg = "خطأ في اسم المرسل";
    }
    $arr = ['code' => $result[0], 'message' => $msg];
    return $arr;
}

function site_socials()
{
    //'linkedin',
    $socials = DB::table('site_contacts')
        ->whereIn('type', ['twitter', 'facebook', 'google', 'youtube', 'instagram', 'snapchat-ghost', 'whats'])
        ->get();
    //    dd($socials);
    return $socials;
}

function get_site_contacts($type)
{
    return DB::table('site_contacts')
        ->where('type', $type)
        ->first()->value ?? '#';
}

function islike($id)
{
    if (Auth::check()) {
        if (Auth::user()->likes()->where('advs_id', $id)->first()) {
            return 1;
        }
    }
    return 0;
}

function api_model_set_pagenation($model)
{
    $pagnation['total'] = $model->total();
    $pagnation['lastPage'] = $model->lastPage();
    $pagnation['perPage'] = $model->perPage();
    $pagnation['currentPage'] = $model->currentPage();
    return $pagnation;
}

function has_unseen_messages($from = null)
{
    if (auth()->check()) {
        if ($from) {
            return \App\Models\Chat::where('to', auth()->user()->id)->where('from', $from)->where('seen', '0')->exists();
        }
        return \App\Models\Chat::where('to', auth()->user()->id)->where('seen', '0')->count();
    }
    return false;
}


function has_unseen_notfs()
{
    if (auth()->check()) {
        return auth()->user()->notfs()->where('seen', 0)->exists();
    }
    return false;
}



// \App\Advs::retrieved(function($ad) {
//     $ad->setAttribute('sasdasdasdasa','fsdfdsfsddfasdasdasdas');
//     dd($ad);
// });








function search_types()
{
    return [
        'similar'   =>  'الأكثر تطابقاً',
        'common'    =>  'الأكثر شيوعاً',
        'min_price' =>  'سعر : من الأقل للاكثر',
        'max_price' =>  'سعر : من الأكثر للأقل'
    ];
}

function GetUserRate($user) {
    $rates = \App\Models\Rates::where('user_rated',$user->id)->count();
    $rate  = \App\Models\Rates::where('user_rated',$user->id)->sum('rate');
    if($rates == 0) {
        return 0;
    } else {
        return $rate / $rates;
    }
}

/*  ====================================================================================================  */

function drawMenu($dept,$i) {
    $layout = '';
    $y = 0;
    $layout .= '<li class="navlink-li fixall megaxs-link">';
    if($dept->childs()->count() > 0) {
        $layout .= '<a href="#!" class="navlink fixall">'.$dept->name.'</a>';
        $layout .= '<div class="main-xs-nav mo-droplinks level2" data-id="'.$i.'">';
        $layout .= '<a class="back fixall">رجوع</a>';
        $layout .= '<ul class="fixall nav-links list-unstyled">';
            foreach($dept->childs as $child) {
                if($child->childs()->count() > 0) {
                    $layout .= '<li class="navlink-li fixall megaxs-link">';
                        $layout .= '<a href="#!" class="navlink fixall">'.$child->name.'</a>';
                        $layout .=    TreeDrawMenu($child,$i,$y);
                    $layout .= '</li>';
                } else {
                    $layout .= '<li class="navlink-li fixall">';
                        $layout .= '<a href="'.$child->link.'" class="navlink fixall">'.$child->name.'</a>';
                    $layout .= '</li>';
                }
            }
        $layout .= '</ul>';
        $layout .= '</div>';
    } else {
        $layout .= '<a href="'.$dept->link.'" class="navlink fixall">'.$dept->name.'</a>';
    }
    $layout .= '</li>';
    return $layout;
}


function TreeDrawMenu($child,$i,$y) {
    $layout = '';
    if($child->childs()->count() > 0) {
        $layout .= '<div class="main-xs-nav mo-droplinks level2" data-id="'.$i.'">';
        $layout .= '<ul class="fixall nav-links list-unstyled">';
        foreach($child->childs as $dd) {
            if($dd->childs()->count() > 0) {
            $layout .= '<li class="navlink-li fixall megaxs-link">';
                $layout .= '<a href="#!" class="navlink fixall">'.$dd->name.'</a>';
                    $layout .= TreeDrawMenu($dd,$i,$y+1);
                $layout .= '</li>';
            } else {
                $layout .= '<li class="navlink-li fixall">';
                    $layout .= '<a href="'.$dd->link.'" class="navlink fixall">'.$dd->name.'</a>';
                $layout .= '</li>';
            }
        }
        $layout .= '</ul>';
        $layout .= '</div>';
    }
    return $layout;
}

function TreeDrawMenuDeskTop($child) {
    $layout = '';
    if($child->childs()->count()) {
        $layout .='<li class="fixall navlink-li lawcat "><a class="fixall navlink moaccordion" href="#!">'.$child->name.'</a><ul class="with_childs mopanel">';
            foreach($child->childs as $dd) {
                $layout .= TreeDrawMenuDeskTop($dd);
            }
        $layout .='</ul></li>';
    } else {
        $layout .='<li class="fixall navlink-li"><a href="'.$child->full_link.'" class="fixall navlink">'.$child->name.'</a></li>';
    }
    return $layout;
}

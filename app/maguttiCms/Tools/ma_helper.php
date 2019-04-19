<?php
use Illuminate\Http\Request;
use Cocur\Slugify\Bridge\Laravel\SlugifyFacade;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
|   PATH HELPERS / SHORTCUTS
|--------------------------------------------------------------------------
*/


/*******************     DOC    *****************/
function ma_get_doc_path_from_repository($doc)
{
    $path = config('maguttiCms.admin.path.doc_repository');
    return public_path($path . $doc);
}
function ma_get_doc_from_repository($doc)
{
    $path = config('maguttiCms.admin.path.doc_repository');
    return asset($path . $doc);
}

/*******************      IMAGES      *****************/

/**
 * @param $img
 * @param bool $absolute
 * @return string
 */
function ma_get_image_path_from_repository($img,$absolute=true)
{
    $path = config('maguttiCms.admin.path.img_repository');
	if (file_exists($path.$img))
  		return ($absolute == true ) ? asset($path.$img) : $path.$img;
	else
		return ($absolute == true ) ? asset($path.'placeholder.png') : $path.'placeholder.png';
}

/**
 * @param $img
 * @param bool $absolute
 * @return string
 */
function ma_get_image_from_repository($img, $absolute = true)
{
    return ma_get_image_path_from_repository($img, $absolute);
}

/**
 * ritorna l'immagine solo se presente
 * nel file system
 *
 * @param $img
 * @param bool $absolute
 * @return string
 */
function ma_get_image_from_repository_if_exists($img, $absolute = true)
{
    return ($img!='')?ma_get_image_path_from_repository($img, $absolute):"";
}

/**
 *
 * generate img on the  fly
 * @param $asset
 * @param $w
 * @param $h
 * @param string $type
 * @return null|string
 */
function ma_get_image_on_the_fly($asset, $w, $h, $type = 'jpg')
{

    if ($asset != '') {
        $img = Image::make(ma_get_image_from_repository($asset, false))->fit($w, $h)->encode($type);
        return 'data:image/' . $type . ';base64,' . base64_encode($img);
    } else return null;
}

/**
 * get img  on  the  fly cached
 * @param $asset
 * @param $w
 * @param $h
 * @param string $type
 * @param int $fit
 * @return string
 */
function ma_get_image_on_the_fly_cached($asset, $w, $h, $type = 'jpg', $fit = 1)
{

    if (file_exists(ma_get_image_path_from_repository($asset))) {
        $dataImage = array();
        $dataImage['asset'] = $asset;

        $dataImage['w'] = $w;
        $dataImage['h'] = $h;
        $dataImage['type'] = $type;
        $dataImage['fit'] = $fit;
        $img = Image::cache(function ($image) use ($dataImage) {
            $image->make(ma_get_image_from_repository($dataImage['asset'], false));

            if ($dataImage['fit'] == 1) {
                $image->resize($dataImage['w'], $dataImage['h']);
            } else {
                $image->fit($dataImage['w'], $dataImage['h']);
            }

            $image->encode($dataImage['type']);
        });
        return 'data:image/' . $type . ';base64,' . base64_encode($img);
    } else return ma_get_image_path_from_repository($asset);
}
/*******************     USER UPLOAD    *****************/
function ma_get_upload_from_repository($doc)
{
    $path = config('maguttiCms.admin.path.user_upload');
    return asset($path . $doc);
}

/*
|--------------------------------------------------------------------------
|    PATH HELPERS / SHORTCUTS   FOR ADMIN
|--------------------------------------------------------------------------
*/
function ma_get_admin_list_url($model)
{
    $path = '/admin/list';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName));
}

function ma_get_admin_create_url($model)
{
    $path = '/admin/create';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName));
}

function ma_get_admin_edit_url($model)
{
    $path = '/admin/edit';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName) . '/' . $model->id);
}
function ma_get_admin_view_url($model)
{
    $path = '/admin/view';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName) . '/' . $model->id);
}

function ma_get_admin_editmodal_url($model)
{
    $path = '/admin/editmodal';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName) . '/' . $model->id);
}

function ma_get_admin_delete_url($model)
{
    $path = '/admin/delete';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName) . '/' . $model->id);
}

function ma_get_admin_preview_url($model)
{
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    $resourcePath = ($modelName != 'articles') ? Str::plural($modelName) . '/' . $model->slug : $model->slug;
    $path = LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), URL::to($resourcePath));
    return URL::to($path);
}

function ma_get_admin_copy_url($model)
{
    $path = '/admin/duplicate';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName) . '/' . $model->id);
}


function ma_get_admin_export_url($model)
{

    $path = '/admin/exportlist';
    $modelName = (!is_object($model)) ? strtolower($model) : strtolower(Str::plural(class_basename($model)));
    return URL::to($path . '/' . Str::plural($modelName));
}

/**
 * Is the mime type an image
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

if (!function_exists('flash')) {
    function flash($message = null)
    {
        $notifier = app('flash');
        if (!is_null($message)) {
            return $notifier->info($message);
        }
        return $notifier;
    }
}

/**
 * This method is used to pull a model out of the ioc container given its name as string.
 *
 * @param $string
 * @param string $namespace
 *
 * @return \Illuminate\Foundation\Application|mixed
 */
function getModelFromString($string, $namespace = "\\App\\")
{
    return app($namespace . ucfirst($string));
}

/**
 *
 * get the  real user IP
 * @return bool
 *
 */
function get_ip()  {
    $ip = FALSE;
    // If HTTP_CLIENT_IP is set, then give it priority
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }

    // User is behind a proxy and check that we discard RFC1918 IP addresses
    // if they are behind a proxy then only figure out which IP belongs to the
    // user.  Might not need any more hackin if there is a squid reverse proxy
    // infront of apache.
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        // Put the IP's into an array which we shall work with shortly.
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }

        for ($i = 0; $i < count($ips); $i++) {
            // Skip RFC 1918 IP's 10.0.0.0/8, 172.16.0.0/12 and 192.168.0.0/16
            if (!preg_match ("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
                if (version_compare(phpversion(), "5.0.0", ">=")) {
                    if (ip2long($ips[$i]) != false) {
                        $ip = $ips[$i];
                        break;
                    }
                } else {
                    if (ip2long($ips[$i]) != -1) {
                        $ip = $ips[$i];
                        break;
                    }
                }
            }
        }
    }
    $Ip=($ip)? $ip : $_SERVER['REMOTE_ADDR'];
    return $Ip;
}

/*
|--------------------------------------------------------------------------
|   String  & Sanitizer
|--------------------------------------------------------------------------
*/
function sanitizeParameter($parameter)
{
    return htmlspecialchars($parameter, ENT_QUOTES, 'utf-8');
}

function ma_sluggy($stringa,$separator='-',$locale='')
{
    $locale = ($locale) ? :app()->getLocale();
    if ($locale == 'zh') return $stringa;
    return Slugify::slugify($stringa, $separator);
}

/*
|--------------------------------------------------------------------------
|  PATH Localization
|--------------------------------------------------------------------------
*/

function ma_get_file_from_storage($file, $disk = '', $folder = '')
{
	if ($disk)
		$storage = Storage::disk($disk);
	else
		$storage = Storage::disk('media');
	if ($folder)
		$image = asset($storage->url($folder.'/'.$file));
	else
		$image = asset($storage->url('images/'.$file));

	return $image;
}

<?php namespace App\maguttiCms\Composer;
use App\Setting;
use Illuminate\View\View;

/**
 * Class ViewShareSettingComposer
 * @package App\maguttiCms\Composer
 */
class ViewShareSettingComposer
{
    protected  $site_settings;

    /**
     * Create a new ViewShareSettingComposer instance.
     */
    public function __construct()
    {
        $this->site_settings = Setting::select('value','key')->get()->pluck('value','key');
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('site_settings', $this->site_settings);
    }
}
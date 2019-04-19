<?php

namespace App\maguttiCms\Tools;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Stringable
{


    public static function truncate($string, $stringWidth = 10, $separator = '...')
    {
        if (in_array(LaravelLocalization::getCurrentLocale(), ['zh'])) {
            return mb_substr(strip_tags($string), 0, $stringWidth * 0.5) . $separator;
        } else {
            $parts = preg_split('/([\s\n\r]+)/', strip_tags($string), null, PREG_SPLIT_DELIM_CAPTURE);
            $parts_count = count($parts);
            $length = 0;
            $last_part = 0;
            for (; $last_part < $parts_count; ++$last_part) {
                $length += strlen($parts[$last_part]);

                if ($length > $stringWidth) {
                    break;
                }
            }
            return trim(implode(array_slice($parts, 0, $last_part))) . $separator;
        }
    }


    /**
     * This method is used to convert file sizes into human readable strings.
     *
     * @param $bytes
     *
     * @return string
     */
    public static function humanReadableFileSize($size)
    {
        $units = explode(' ', 'B KB MB GB TB PB');
        $mod = 1024;

        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        $endIndex = strpos($size, ".") + 3;
        return substr($size, 0, $endIndex) . ' ' . $units[$i];
    }


    public static function arrayToString($arrayData)
    {
        return implode(",", preg_replace('/^(.*?)$/', "'$1'", $arrayData));
    }


}

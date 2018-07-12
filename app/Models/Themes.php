<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    /**
     * @return string
     */
    public static function currentTheme()
    {
        $theme_id = get_option('site_theme');
        $theme = self::find($theme_id);

        if(!empty($theme)) return $theme->name;

        return 'default';

    }

    public static function rmdir($dir)
    {
        if(is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if($object != "." && $object != "..") {
                    if(filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}

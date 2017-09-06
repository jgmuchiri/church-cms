<?php
/**
 * @package     ccms
 * @copyright   2017 A&M Digital Technologies
 * @author      John Muchiri
 * @link        https://amdtllc.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
use Illuminate\Support\Facades\Auth;

class Theme
{
    protected $icons=0;

    function __construct()
    {
        $theme_id = App\Models\Settings::get_option('site_theme');
        if ($theme_id !== '') {
            $this->theme = \App\Models\Themes::whereId($theme_id)->first();
        } else {
            $this->theme = 'default';
        }
    }

    /**
     * @param $opt
     * @return null
     */
    function themeOpts($opt)
    {
        $theme = $this->theme;
        if ($theme == 'default' || $theme ==null)
            return null;
        return $theme->$opt;
    }

    /**
     * @param string|array $options
     * @return string
     */
    function menu($options=null)
    {
        if(is_array($options) && in_array('icons',$options)){
            $this->icons  = 1;
        }
        $html = '';
        $mainMenu = App\Models\MainMenu::whereActive(1)->whereParent(0)->orderBy('order', 'ASC')->get();

        foreach ($mainMenu as $m):
            if($this->icons ==1){
                $icon = self::fa($m->icon);
            }else{
                $icon ="";
            }
            if (Auth::check() && $m->path == '/login') {
                $m->path = '/logout';
                $m->title = 'Logout';
            }
            if (is_array($options) && in_array('no-submenu', $options)):
                $html .= '<li><a class="nav-item" href="' . url($m->path) . '">' .$icon. $m->title . '</a></li>';
            else:
                if (self::subMenu($m->id) !== '') {
                    $html .= self::subMenu($m->id);
                } else { //list only main items
                    $html .= '<li><a class="nav-item" href="' . url($m->path) . '">' .$icon. $m->title . '</a></li>';
                }
            endif;
        endforeach;

        return $html;
    }


    /**
     * @param $parent
     * @return string
     */
    function subMenu($parent)
    {
        $menu = App\Models\MainMenu::whereActive(1)->whereId($parent)->first();
        $sub_menu = $menu->subMenu()->whereActive(1)->orderBy('order', 'ASC')->get();

        $html = '';

        if (count($sub_menu)):
            $html .= '<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">' . $menu->title . '<span class="caret"></span></a>
    <ul class="dropdown-menu">';
            $html .= '<li><a class="nav-item" href="' . url($menu->path) . '">' . $menu->title . '</a></li>';

            foreach ($sub_menu as $s) {
                if($this->icons ==1){
                    $icon = self::fa($s->icon);
                }else{
                    $icon ="";
                }
                if (Auth::check() && $s->path == '/login') {
                    $s->path = '/logout';
                    $s->title = ' Logout';
                }
                $html .= '<li><a class="nav-item" href="' . url($s->path) . '">'.$icon . $s->title . '</a></li>';
            }
            $html .= '</ul></li>';
        endif;
        return $html;
    }

    function fa($icon="")
    {
        return '<i class="fa fa-'.$icon.'"></i> ';
    }
}

/**
 * @param string $opt
 * @return string|Theme
 */
function theme($opt = '')
{
    $theme = new Theme();
    if ($opt == '') {
        return $theme;
    } else {
        return $theme->themeOpts($opt);
    }

}

if (!function_exists('str_clean')) {
    function str_clean($string)
    {
        $string = str_replace(array('[\',\']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^A-Za-z0-9-.]/i', '/[-]+/'), '-', $string);
        $string = strip_tags($string);
        return strtolower(trim($string, '-'));
    }
}
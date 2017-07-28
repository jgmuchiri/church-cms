<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Tools extends Model
{
    public static function fa()
    {
        $icons= array('glass', 'music', 'search', 'envelope-o', 'heart', 'star', 'star-o', 'user', 'film', 'th-large', 'th', 'th-list', 'check', 'remove', 'close', 'times', 'search-plus', 'search-minus', 'power-off', 'signal', 'gear', 'cog', 'trash-o', 'home', 'file-o', 'clock-o', 'road', 'download', 'arrow-circle-o-down', 'arrow-circle-o-up', 'inbox', 'play-circle-o', 'rotate-right', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tag', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'dedent', 'outdent', 'indent', 'video-camera', 'photo', 'image', 'picture-o', 'pencil', 'map-marker', 'adjust', 'tint', 'edit', 'pencil-square-o', 'share-square-o', 'check-square-o', 'arrows', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-circle', 'minus-circle', 'times-circle', 'check-circle', 'question-circle', 'info-circle', 'crosshairs', 'times-circle-o', 'check-circle-o', 'ban', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'mail-forward', 'share', 'expand', 'compress', 'plus', 'minus', 'asterisk', 'exclamation-circle', 'gift', 'leaf', 'fire', 'eye', 'eye-slash', 'warning', 'exclamation-triangle', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder', 'folder-open', 'arrows-v', 'arrows-h', 'bar-chart-o', 'bar-chart', 'twitter-square', 'facebook-square', 'camera-retro', 'key', 'gears', 'cogs', 'comments', 'thumbs-o-up', 'thumbs-o-down', 'star-half', 'heart-o', 'sign-out', 'linkedin-square', 'thumb-tack', 'external-link', 'sign-in', 'trophy', 'github-square', 'upload', 'lemon-o', 'phone', 'square-o', 'bookmark-o', 'phone-square', 'twitter', 'facebook-f', 'facebook', 'github', 'unlock', 'credit-card', 'rss', 'hdd-o', 'bullhorn', 'bell', 'certificate', 'hand-o-right', 'hand-o-left', 'hand-o-up', 'hand-o-down', 'arrow-circle-left', 'arrow-circle-right', 'arrow-circle-up', 'arrow-circle-down', 'globe', 'wrench', 'tasks', 'filter', 'briefcase', 'arrows-alt', 'group', 'users', 'chain', 'link', 'cloud', 'flask', 'cut', 'scissors', 'copy', 'files-o', 'paperclip', 'save', 'floppy-o', 'square', 'navicon', 'reorder', 'bars', 'list-ul', 'list-ol', 'strikethrough', 'underline', 'table', 'magic', 'truck', 'pinterest', 'pinterest-square', 'google-plus-square', 'google-plus', 'money', 'caret-down', 'caret-up', 'caret-left', 'caret-right', 'columns', 'unsorted', 'sort', 'sort-down', 'sort-desc', 'sort-up', 'sort-asc', 'envelope', 'linkedin', 'rotate-left', 'undo', 'legal', 'gavel', 'dashboard', 'tachometer', 'comment-o', 'comments-o', 'flash', 'bolt', 'sitemap', 'umbrella', 'paste', 'clipboard', 'lightbulb-o', 'exchange', 'cloud-download', 'cloud-upload', 'user-md', 'stethoscope', 'suitcase', 'bell-o', 'coffee', 'cutlery', 'file-text-o', 'building-o', 'hospital-o', 'ambulance', 'medkit', 'fighter-jet', 'beer', 'h-square', 'plus-square', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-double-down', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'desktop', 'laptop', 'tablet', 'mobile-phone', 'mobile', 'circle-o', 'quote-left', 'quote-right', 'spinner', 'circle', 'mail-reply', 'reply', 'github-alt', 'folder-o', 'folder-open-o', 'smile-o', 'frown-o', 'meh-o', 'gamepad', 'keyboard-o', 'flag-o', 'flag-checkered', 'terminal', 'code', 'mail-reply-all', 'reply-all', 'star-half-empty', 'star-half-full', 'star-half-o', 'location-arrow', 'crop', 'code-fork', 'unlink', 'chain-broken', 'question', 'info', 'exclamation', 'superscript', 'subscript', 'eraser', 'puzzle-piece', 'microphone', 'microphone-slash', 'shield', 'calendar-o', 'fire-extinguisher', 'rocket', 'maxcdn', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-circle-down', 'html5', 'css3', 'anchor', 'unlock-alt', 'bullseye', 'ellipsis-h', 'ellipsis-v', 'rss-square', 'play-circle', 'ticket', 'minus-square', 'minus-square-o', 'level-up', 'level-down', 'check-square', 'pencil-square', 'external-link-square', 'share-square', 'compass', 'toggle-down', 'caret-square-o-down', 'toggle-up', 'caret-square-o-up', 'toggle-right', 'caret-square-o-right', 'euro', 'eur', 'gbp', 'dollar', 'usd', 'rupee', 'inr', 'cny', 'rmb', 'yen', 'jpy', 'ruble', 'rouble', 'rub', 'won', 'krw', 'bitcoin', 'btc', 'file', 'file-text', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-numeric-asc', 'sort-numeric-desc', 'thumbs-up', 'thumbs-down', 'youtube-square', 'youtube', 'xing', 'xing-square', 'youtube-play', 'dropbox', 'stack-overflow', 'instagram', 'flickr', 'adn', 'bitbucket', 'bitbucket-square', 'tumblr', 'tumblr-square', 'long-arrow-down', 'long-arrow-up', 'long-arrow-left', 'long-arrow-right', 'apple', 'windows', 'android', 'linux', 'dribbble', 'skype', 'foursquare', 'trello', 'female', 'male', 'gittip', 'gratipay', 'sun-o', 'moon-o', 'archive', 'bug', 'vk', 'weibo', 'renren', 'pagelines', 'stack-exchange', 'arrow-circle-o-right', 'arrow-circle-o-left', 'toggle-left', 'caret-square-o-left', 'dot-circle-o', 'wheelchair', 'vimeo-square', 'turkish-lira', 'try', 'plus-square-o', 'space-shuttle', 'slack', 'envelope-square', 'wordpress', 'openid', 'institution', 'bank', 'university', 'mortar-board', 'graduation-cap', 'yahoo', 'google', 'reddit', 'reddit-square', 'stumbleupon-circle', 'stumbleupon', 'delicious', 'digg', 'pied-piper', 'pied-piper-alt', 'drupal', 'joomla', 'language', 'fax', 'building', 'child', 'paw', 'spoon', 'cube', 'cubes', 'behance', 'behance-square', 'steam', 'steam-square', 'recycle', 'automobile', 'car', 'cab', 'taxi', 'tree', 'spotify', 'deviantart', 'soundcloud', 'database', 'file-pdf-o', 'file-word-o', 'file-excel-o', 'file-powerpoint-o', 'file-photo-o', 'file-picture-o', 'file-image-o', 'file-zip-o', 'file-archive-o', 'file-sound-o', 'file-audio-o', 'file-movie-o', 'file-video-o', 'file-code-o', 'vine', 'codepen', 'jsfiddle', 'life-bouy', 'life-buoy', 'life-saver', 'support', 'life-ring', 'circle-o-notch', 'ra', 'rebel', 'ge', 'empire', 'git-square', 'git', 'hacker-news', 'tencent-weibo', 'qq', 'wechat', 'weixin', 'send', 'paper-plane', 'send-o', 'paper-plane-o', 'history', 'genderless', 'circle-thin', 'header', 'paragraph', 'sliders', 'share-alt', 'share-alt-square', 'bomb', 'soccer-ball-o', 'futbol-o', 'tty', 'binoculars', 'plug', 'slideshare', 'twitch', 'yelp', 'newspaper-o', 'wifi', 'calculator', 'paypal', 'google-wallet', 'cc-visa', 'cc-mastercard', 'cc-discover', 'cc-amex', 'cc-paypal', 'cc-stripe', 'bell-slash', 'bell-slash-o', 'trash', 'copyright', 'at', 'eyedropper', 'paint-brush', 'birthday-cake', 'area-chart', 'pie-chart', 'line-chart', 'lastfm', 'lastfm-square', 'toggle-off', 'toggle-on', 'bicycle', 'bus', 'ioxhost', 'angellist', 'cc', 'shekel', 'sheqel', 'ils', 'meanpath', 'buysellads', 'connectdevelop', 'dashcube', 'forumbee', 'leanpub', 'sellsy', 'shirtsinbulk', 'simplybuilt', 'skyatlas', 'cart-plus', 'cart-arrow-down', 'diamond', 'ship', 'user-secret', 'motorcycle', 'street-view', 'heartbeat', 'venus', 'mars', 'mercury', 'transgender', 'transgender-alt', 'venus-double', 'mars-double', 'venus-mars', 'mars-stroke', 'mars-stroke-v', 'mars-stroke-h', 'neuter', 'facebook-official', 'pinterest-p', 'whatsapp', 'server', 'user-plus', 'user-times', 'hotel', 'bed', 'viacoin', 'train', 'subway', 'medium');
        return $icons;
    }

    /**
     * @param $file
     * @param $dir
     * @return bool|string
     */
    public static function uploadFile($file, $destination, $fileName = null)
    {
        if ($file == null) {
            return false;
        }
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 493, true);
        }

        $extension = $file->getClientOriginalExtension();
        if ($fileName == null)
            $fileName = $file->getClientOriginalName();
        else
            $fileName = $fileName . '.' . $extension;

        $file->move($destination, $fileName);
        return $fileName;
    }

    /**
     * @param $file
     * @param $destination
     * @param null $name
     * @return bool|string
     */
    public static function uploadImage($file, $destination, $name = null, $width = null, $height = null)
    {
        if ($file == null) {
            return false;
        }

        if ($file->isValid()) {
            $image = Image::make($file);

            if (!\File::isDirectory($destination)) {
                \File::makeDirectory($destination, 493, true);
            }

            $extension = $file->getClientOriginalExtension();
            if($name ==null)
                $fileName = time() . rand(11111, 99999) . '.' . $extension;
            else
                $fileName = $name.'.'.$extension;

            //resize
            if ($width !== null && $height !== null) {
                $image->resize($width, $height)->save($destination . $fileName);
            } else {
                $image->save($destination . $fileName);
            }

            return $fileName;
        }
        return false;
    }

    /**
     * Timezones list with GMT offset
     *
     * @return array
     * @link http://stackoverflow.com/a/9328760
     */
    public static function timezone()
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }

    /**
     * convert first image in posted text to fit theme
     * @param $content
     * @return mixed
     */
    public static function formatFirstImageInText($content)
    {
        //format top image
        $imgCount = (substr_count($content, "<img")); //find occurence
        if ($imgCount > 0)//there is image
        {
            $pos = strpos(trim($content), '<img');
            //check if is in the beginning
            if ($pos == 0 | $pos == 3)//after <p> or is first
            {
                $text = preg_replace('/<img/i', '<img style="height:300px;width:100%"', $content, 1);
            }else{
                $text=$content;
            }
        }else{
            $text=$content;
        }

        return $text;
    }

    /**
     * @param $base64_string
     * @param $output_file
     * @return mixed
     */
    public static function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);

        return $output_file;
    }

    /**
     * extract first image from post for thumbnail
     * @param $content
     * @return int|mixed|string
     */
    public static function postThumb($content,$width="100%",$height="100px"){
        $img = preg_match_all('/<img[^>]+>/i', $content, $result);
        if ($img > 0) {
            $img = preg_replace('/<img/i', '<img class="image-responsive" style="height:'.$height.';width:'.$width.'"', $result[0][0], 1);
            return $img;
        }
        //return no image photo
        return '<img class="image-responsive" style="height:'.$height.';width:'.$width.'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHoAAABjCAYAAABUgBS3AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AcSATM0Rr0JlAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAFPUlEQVR42u2dzWvyQBDGp6VmKwmBqAgJWihUvEQPfen/f+ypHsSLVCzUYCFgFhZD3fTge0rRNqax3SS7yTwXD0bMzo99MvuR2Yv9fr8HVOV1iSFA0KgK6SrLRYwxCMMQNpsNvL+/Y9QkUbPZhHa7Dbqug2maqddepD2jOefw/PwM6/Uaoyq5HMeBwWAAhJDzQDPGYDabwXa7xSgqIsMwwHXdxN6dCJoxBpPJBKIowugpJk3T4P7+/hvsyyS7ns1mCFlRRVEEs9kMOOfpoFerFdq14tput7BarU6D5pyD53kYqQrI87yjXn00vAqCINWyDcOAbreLUZREvu+fdN8oiiAIArBtO/s4On7I//v372T6jipe/X4fHh8fM+VTR9a92WxOXqjrOkKWTIQQ0HX95PeHPHEKtCZC0AgahaBRCBolp66K/kPOOXDOIQzDz0wes/mKgGaMge/7iQN8TdNA13WwLAv6/T5CVxE05xxWqxV4nndyUB9FEURRBJRS8DwPer0e3N3dIRlVQDPGYD6fA6U082+iKILlcgm73S51ER0lSTLGOYfJZHIW5EOt12uYTqdIR2bQ8fajv65nU0phsVggIVlBB0EgbI/ZcrkExhhSkg005xxeXl6E3uB8PkdKsoEOgkD47hRKKfZq2UCnLXP+Rb7vIymZQOfV83a7nXSBi2f4aj28Ei3Z3g7hnMN0OoXpdKoM7EuRja/DFuEYMqUUKKXKwBYGmhACmqblcpPNZlM6yIfJogqwhVp3o9HI5Savr6+lhKwSbKGgLcvK5SbL3mKcBlkV2JeigYi2b8MwSl3cyAJZBdhCQZumCb1eT+gN3t7elgb6HMiywxY+vOr3+2AYhrBHQfymgQqQZYYtHDQhBFzXFWLZ4/FYOciyws5lwsQ0TRiNRr/u2ZZlgeu6pVi2CMgyws5tZsy2bXBd9+xM3HEcGI/HP9bkkB2ybLBz3TNmmiY8PDzA29sbeJ4HYRgmzp5pmgadTgdubm5KAZwX5K+wx+NxaYllIbtAbdsG27aBcw5BEEAYhgAAny+ItVotZYZQqsIudF83IaS0LPqUiizKUybsWr+pERflKbKUR1nP7MygPz4+Kgm5jBW3MmBf1rknl7msWjTsI9B1KP8oUw21ImEfgZZl3bcOkIuGXRvrlrkaYhGwpbVukY1WoeRl3rCltO7FYiGs0SrVNc0TtnTWvVgsYLlcCmm0isVr84ItlXXHkEU0WuUKxXnAlsa6v0L+S6OrUIY6bnelrPsU5N/ArlKtcUqpsF5dunX/BPkc2PECBdYal8y6s0LOAruMBQplQcsMOQ02Hg0hqXX/FnISbIScTVdfrTvPXRYiIB/Cfnp6AgBAyOeClr0nfxU+jyW0btGQURJm3Qi5Blk3Qq6BdSPkGlg3Qq6BdSPkGlg3Qq6BdSPkGlg3Ywwh1zXrRtUg60bVIOtGoXWj0LpRaN0otG4UWjcKrRutGyNSUQnbHEgIgdFohBFNka7rn6fsZvmM4yoc9F8kY2kpGRUXzMv6idaNwqwbhVk3gkbrRutGVQ102rFDURThYaCSiTH2OQxLUrvdTh5exWWVT4GeTCbQ6XQwwgXpp/O+fN/P/IJhZtAxbFGHgKPylaZp0Gq1kq3bNE1wHAejVAF1Op2jWbVvw6vBYJDbGZOo4nrzYDBIH0cTQmA4HCJshSEPh8Nvc+SJEya2bSNshSEnrTlc7Pf7fVr6/vr6igmYAnIcJ/WUoVTQh8B93wdKaeWOXFBZjUYDLMuCbrf742pXJtAo9YWLGggaVSX9B3OPKDPN8n/wAAAAAElFTkSuQmCC"/>';
    }

}

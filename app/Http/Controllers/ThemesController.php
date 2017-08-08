<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Themes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class ThemesController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $themes = Themes::get();
        return view('themes.index', compact('themes'));
    }

    function upload(Request $request)
    {
        $rules = [
            'theme' => 'required'
        ];

        if ($request->theme == null) {
            flash()->error('No file selected');
            return redirect()->back()->withInput();
        }
        $extension = $request->theme->getClientOriginalExtension();

        if ($extension !== 'zip') {
            flash()->error('Zip file is required.');
            return redirect()->back()->withInput();
        }

        $dir = basename($request->theme->getClientOriginalName(), '.' . $extension);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $za = new ZipArchive();
        //validate zip file
        if ($za->open($request->theme) == true) {

            //validate required files
            for ($i = 0; $i < $za->numFiles; $i++) {
                $stat = $za->statIndex($i);
                echo "Extracted ". basename($stat['name']) . PHP_EOL;
                echo "<br/>";
                if (!in_array("screenshot.png", $stat) || !in_array("index.blade.php", $stat)) {
                    //flash()->error('Some required files are missing');
                    //return redirect()->back()->withInput();
                }

            }

            //unzip and save
            $theme_path = '../resources/views/themes/' . $dir;
            $files_path = 'themes/' . $dir;

            if (!\File::isDirectory($theme_path) || !\File::isDirectory($files_path)) {
                \File::makeDirectory($theme_path, 493, true);
                \File::makeDirectory($files_path, 493, true);
            }
            /*
            else {
                //todo this overwrites the current directory. Force user to confirm before doing so
                flash()->error('A theme directory with that name exists. Please delete it before proceeding');
                return redirect()->back()->withInput();
            }
            */

            $za->extractTo($files_path);
            copy($files_path . '/index.blade.php', $theme_path . '/index.blade.php');
            @unlink($files_path . '/index.blade.php');
            $za->close();

            //extract information about the theme
            $themeName = $extension;
            $themeDesc = "EMPTY: Unable to process";
            try{
                $data = file_get_contents(public_path('themes/'.$dir.'/info.txt'));
                $data = array_chunk(array_filter(array_map("trim",explode(chr(13).chr(10).chr(13), $data))),2);
                $lists = array();

                foreach ( $data as $value ) {
                    $list = array();
                    foreach ( explode("\n", implode("", $value)) as $item ) {
                        list($key, $value) = explode("=", $item);
                        $list[trim(strtolower($key))] = trim($value);
                    }
                    $lists[] = $list;

                    $themeName = $lists[0]['name'];
                    $themeDesc = $lists[0]['description'];
                    //todo add version, author, url, version date
                }
            }catch(Exception $e){
                flash()->warning('Theme uploaded with errors. Please verify.');
            }

            //check whether this name is used and over
            $installedTheme = Themes::whereLocation($dir)->first();
            if (count($installedTheme) > 0)
                $installedTheme->delete();

            //update db
            $theme = new Themes();
            $theme->name =$themeName;
            $theme->desc = $themeDesc;
            $theme->location = $dir;
            $theme->active = 1;
            $theme->created_at = date('Y-m-d H:i:s');
            $theme->save();

            flash()->success("Theme has been uploaed");
            return redirect()->back();

        } else {
            flash()->error('Unable to extract the zip file');
            return redirect()->back()->withInput();
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function selectTheme($id)
    {
        $theme = Settings::get_option('site_theme');
        if ($theme == $id) {
            Settings::update_option('site_theme', $id);
        } else {
            Settings::set_option('site_theme', $id);
        }

        flash()->success('Theme updated');
        return redirect()->back();
    }

    function browse()
    {
        return view('themes.browse');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function deleteTheme($id)
    {
        $theme = Themes::find($id);
        \File::deleteDirectory('../resources/views/themes/' . $theme->location);
        \File::deleteDirectory('themes/' . $theme->location);
        $theme->delete();
        flash()->success('Theme deleted');
        return redirect()->back();
    }

}

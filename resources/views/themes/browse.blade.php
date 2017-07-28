@extends('layouts.template')
@section('title')
    Browse themes
@endsection
@section('content')
    <div class="card">
        <div class="header">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="icon-plus"></i>
                Upload theme</a>

            <a href="/settings/themes/1/select" class="btn btn-info"><i
                        class="icon-check"></i> Set default theme</a>

            <a href="/themes/browse" target="_blank" class="btn btn-warning"><i class="icon-shopping-cart"></i>
                Browse themes</a>
        </div>
        <hr/>
        <div class="content">
            <?php
            /**
             * This program will read themes in remote locations and copy them over to your application
             * You create a private theme repository and provision it for your installation.
             * Themes should conform to the standards indicated
             */
            //url where the themes are located.
            $URL = env('THEMES_LOCATION');
            $base = '<base href="' . $URL . '">';
            $host = preg_replace('/^[^\/]+\/\//', '', $URL);
            $tarray = explode('/', $host);
            $host = array_shift($tarray);
            $URI = '/' . implode('/', $tarray);
            $content = '';
            $fp = fsockopen($host, 80, $errno, $errstr, 30);
            if (!$fp) {
                echo "Unable to open socked: $errstr ($errno)\n";
                exit;
            }
            fwrite($fp, "GET $URI HTTP/1.0\r\n");
            fwrite($fp, "Host: $host\r\n");
            if (isset($_SERVER["HTTP_USER_AGENT"])) {
                fwrite($fp, 'User-Agent: ' . $_SERVER

                    ["HTTP_USER_AGENT"] . "\r\n");
            }
            fwrite($fp, "Connection: Close\r\n");
            fwrite($fp, "\r\n");
            while (!feof($fp)) {
                $content .= fgets($fp, 128);
            }
            fclose($fp);
            if (strpos($content, "\r\n") > 0) {
                $eolchar = "\r\n";
            } else {
                $eolchar = "\n";
            }
            $eolpos = strpos($content, "$eolchar$eolchar");
            $content = substr($content, ($eolpos + strlen("$eolchar$eolchar")));
            if (preg_match('/<head\s*>/i', $content)) {
                echo(preg_replace('/<head\s*>/i', '<head>' .

                    $base, $content, 1));
            } else {
                echo(preg_replace('/<([a-z])([^>]+)>/i', "<\\1\\2>" . $base, $content, 1));
            }
            ?>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="it">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{env('COMPANY_NAME')}}</title><!--
COLORE INTENSE  #9C010F
COLORE LIGHT #EDE8DA
TESTO LIGHT #3F3D33
TESTO INTENSE #ffffff 

 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans);

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            font-size: 16px;
            margin: 0 auto;
            background: transparent;
            color: #332;
            font-family: 'Droid Sans', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            padding: 10px;
        }

        .callout {
            margin-bottom: 20px;
            padding: 20px;
            border-left: 3px solid #eeeeee;
        }

        .callout h4 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .callout p:last-child {
            margin-bottom: 0;
        }

        .callout-danger {
            background-color: #fdf7f7;
            border-color: #ebccd1;
        }

        .callout-danger h4 {
            color: #a94442;
        }

        .callout-warning {
            background-color: #faf8f0;
            border-color: #faebcc;
        }

        .callout-warning h4 {
            color: #8a6d3b;
        }

        .callout-info {
            background-color: #f4f8fa;
            border-color: #bce8f1;
        }

        .callout-info h4 {
            color: #31708f;
        }

        .callout-success {
            background-color: #f9fdf7;
            border-color: #d6e9c6;
        }

        .callout-success h4 {
            color: #3c763d;
        }

        #ko_onecolumnBlock_4 .textintenseStyle a, #ko_onecolumnBlock_4 .textintenseStyle a:link, #ko_onecolumnBlock_4 .textintenseStyle a:visited, #ko_onecolumnBlock_4 .textintenseStyle a:hover {
            color: #fff;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_onecolumnBlock_4 .textlightStyle a:visited, #ko_onecolumnBlock_4 .textlightStyle a:hover {
            color: #3f3d33;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_twocolumnBlock_8 .textsmallintenseStyle a, #ko_twocolumnBlock_8 .textsmallintenseStyle a:link, #ko_twocolumnBlock_8 .textsmallintenseStyle a:visited, #ko_twocolumnBlock_8 .textsmallintenseStyle a:hover {
            color: #fff;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_twocolumnBlock_8 .textsmalllightStyle a:visited, #ko_twocolumnBlock_8 .textsmalllightStyle a:hover {
            color: #3f3d33;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_compactarticleBlock_6 .articletextintenseStyle a:visited, #ko_compactarticleBlock_6 .articletextintenseStyle a:hover {
            color: #fff;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_compactarticleBlock_6 .articletextlightStyle a, #ko_compactarticleBlock_6 .articletextlightStyle a:link, #ko_compactarticleBlock_6 .articletextlightStyle a:visited, #ko_compactarticleBlock_6 .articletextlightStyle a:hover {
            color: #3f3d33;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }</style>
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        #outlook a {
            padding: 0;
        }

        /* Force Outlook to provide a "view in browser" message */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail to display normal line spacing */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        .appleBody a {
            color: #68440a;
            text-decoration: none;
        }

        .appleFooter a {
            color: #999999;
            text-decoration: none;
        }

        /* MOBILE STYLES */
        @media screen and (max-width: 525px) {

            /* ALLOWS FOR FLUID TABLES */
            table[class="wrapper"] {
                width: 100% !important;
                min-width: 0 !important;
            }

            /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            /* FULL-WIDTH TABLES */
            table[class="responsive-table"] {
                width: 100% !important;
            }

            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0 5% !important;
                text-align: center;
            }

            td[class="no-pad"] {
                padding: 0 0 0 0 !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding"] {
                padding: 10px 15px 10px 15px !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 10px 15px 0 15px !important;
            }

            /* ADJUST BUTTONS ON MOBILE */
            td[class="mobile-wrapper"] {
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }

        }
    </style>
</head>
<body style="margin: 0; padding: 0;" bgcolor="#ffffff" align="center">

<!-- PREHEADER -->

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 530px;" id="ko_preheaderBlock_1">
    <tbody>
    <tr>
        <td bgcolor="#3F3D33" class="mobile-hide">
            <div align="center" style="padding: 0 15px 0 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="500" style="min-width: 500px;" class="wrapper">
                    <!--Preheade/view on web TEXT -->
                    <tbody>
                    <tr>
                        <td style="padding: 10px 0 10px 0px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                <tr>
                                    <td bgcolor="#3F3D33" width="50%" align="left" class="mobile-hide">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td align="left"
                                                    style="padding: 0 0 5px 0; font-size: 12px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none;">

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td bgcolor="#3F3D33" width="50%" align="right" class="mobile-hide">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td align="right"
                                                    style="padding: 0 0 5px 0; font-size: 12px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none;">
                                                    <a href="{{url()->to('login')}}" style="color: #ffffff;"
                                                       target="_new"><span><span style="text-decoration: underline;">my account</span><br
                                                                    data-mce-bogus="1"></span></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_imageBlock_3">
    <tbody>
    <tr class="row-a">
        <td align="center" class="no-pad"
            style="padding-top: 0px; padding-left: 15px; padding-bottom: 0px; padding-right: 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tbody>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td>
                                    <!-- HERO IMAGE -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td class="no-padding">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <a style="color: #ffffff;text-decoration: none;"
                                                               target="_new" href="{{url()->to('/')}}">
                                                                <img width="auto"
                                                                     border="0"
                                                                     alt="my account"
                                                                     class="img-max"
                                                                     style="display: block; padding: 0; color: #3F3D33; text-decoration: none; font-family: Helvetica, Arial, sans-serif; font-size: 16px;"
                                                                     src="/img/logo.png">

                                                            </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_onecolumnBlock_4">
    <tbody>
    <tr class="row-a">
        <td bgcolor="#eeece1" align="center" class="section-padding"
            style="padding-top: 30px; padding-left: 15px; padding-bottom: 30px; padding-right: 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tbody>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td>
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td align="center" class="padding-copy"
                                                style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #3F3D33; padding-top: 0px;">
                                                @yield('header')
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="padding-copy textlightStyle"
                                                style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #3F3D33;">
                                                @yield('content')
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- BULLETPROOF BUTTON -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                           class="mobile-button-container">
                                        <tbody>
                                        <tr>
                                            <td align="center" style="padding: 25px 0 0 0;" class="padding-copy">
                                                <table border="0" cellspacing="0" cellpadding="0"
                                                       class="responsive-table">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center"><a target="_new" class="mobile-button"
                                                                              style="display: inline-block; font-size: 18px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #00b050; padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-bottom: 3px solid #007334;"
                                                                              href="{{url()->to('/')}}">Visit site</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_compactarticleBlock_6">
    <tbody>
    <tr class="row-a">
        <td bgcolor="#974806" align="center" class="section-padding" style="padding: 0 15px 0 15px;">
            <p></p>
        </td>
    </tr>
    </tbody>
</table>
<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 500px;" id="ko_footerBlock_2">
    <tbody>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td style="padding: 20px 0 20px 0px;">
                        <!-- UNSUBSCRIBE COPY -->
                        <table width="500" border="0" cellspacing="0" cellpadding="0" align="center"
                               class="responsive-table">
                            <tbody>
                            <tr>
                                <td align="center" valign="middle"
                                    style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #3F3D33;">
                                    {{--<span class="appleFooter" style="color: #3F3D33;">Main address and city</span><br><a--}}
                                    {{--class="original-only" href="%5Bprofile_link%5D"--}}
                                    {{--style="color: #3F3D33; text-decoration: none;" target="_new">Unsubscribe</a><span--}}
                                    {{--class="original-only"--}}
                                    {{--style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">���|���</span><a--}}
                                    {{--href="%5Bshow_link%5D" style="color: #3F3D33; text-decoration: none;"--}}
                                    {{--target="_new">View on web browser</a>--}}
                                </td>
                            </tr>
                            <tr style="text-align: center;">
                                <td>
                                    <a target="_new" href="{{url()->to('/')}}">
                                        <img border="0"
                                             hspace="0"
                                             vspace="0"
                                             src="/img/logo.png"
                                             alt=" {{env('COMPANY_NAME')}}"
                                             style="margin-top: 10px;"></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

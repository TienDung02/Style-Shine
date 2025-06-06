<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if (gte mso 9)|(IE)]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
    <meta name="format-detection" content="date=no"> <!-- disable auto date linking in iOS -->
    <meta name="format-detection" content="address=no"> <!-- disable auto address linking in iOS -->
    <meta name="format-detection" content="email=no"> <!-- disable auto email linking in iOS -->
    <meta name="author" content="Simple-Pleb.com">
    <title>{{ __('pleb.mail.Verify Title') }} | {{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style type="text/css">
        /*Basics*/
        body {display:block !important; -webkit-text-size-adjust:none;}
        table {border-spacing:0; mso-table-lspace:0pt; mso-table-rspace:0pt;}
        /*tbody {border: 1px solid #3c3c3c; border-radius: 5px}*/
        table td {border-collapse: collapse;mso-line-height-rule:exactly;}
        td img {-ms-interpolation-mode:bicubic; width:auto; max-width:auto; height:auto; margin:auto; display:block!important; border:0px;}
        td p {margin:0; padding:0;}
        td div {margin:0; padding:0;}
        td a {text-decoration:none; color: inherit;}
        /*Outlook*/
        .ExternalClass {width: 100%;}
        .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {line-height:inherit;}
        .ReadMsgBody {width:100%; background-color: #ffffff;}
        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {color:inherit !important; text-decoration:none !important; font-size:inherit !important; font-family:inherit !important; font-weight:inherit !important; line-height:inherit !important;}
        /*Gmail blue links*/
        u + #body a {color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit;}
        /*Buttons fix*/
        .undoreset a, .undoreset a:hover {text-decoration:none !important;}
        .yshortcuts a {border-bottom:none !important;}


        .ios-footer a {color:#aaaaaa !important;text-decoration:none;}
        /*Responsive*/
        @media screen and (max-width: 799px) {
            table.row {width: 100%!important;max-width: 100%!important;}
            td.row {width: 100%!important;max-width: 100%!important;}
            .img-responsive img {width:100%!important;max-width: 100%!important;height: auto!important;margin: auto;}
            .center-float {float: none!important;margin:auto!important;}
            .center-text{text-align: center!important;}
            .container-padding {width: 100%!important;padding-left: 15px!important;padding-right: 15px!important;}
            .container-padding10 {width: 100%!important;padding-left: 10px!important;padding-right: 10px!important;}
            .hide-mobile {display: none!important;}
            .menu-container {text-align: center !important;}
            .autoheight {height: auto!important;}
            .m-padding-10 {margin: 10px 0!important;}
            .m-padding-15 {margin: 15px 0!important;}
            .m-padding-20 {margin: 20px 0!important;}
            .m-padding-30 {margin: 30px 0!important;}
            .m-padding-40 {margin: 40px 0!important;}
            .m-padding-50 {margin: 50px 0!important;}
            .m-padding-60 {margin: 60px 0!important;}
            .m-padding-top10 {margin: 30px 0 0 0!important;}
            .m-padding-top15 {margin: 15px 0 0 0!important;}
            .m-padding-top20 {margin: 20px 0 0 0!important;}
            .m-padding-top30 {margin: 30px 0 0 0!important;}
            .m-padding-top40 {margin: 40px 0 0 0!important;}
            .m-padding-top50 {margin: 50px 0 0 0!important;}
            .m-padding-top60 {margin: 60px 0 0 0!important;}
            .m-height10 {font-size:10px!important;line-height:10px!important;height:10px!important;}
            .m-height15 {font-size:15px!important;line-height:15px!important;height:15px!important;}
            .m-height20 {font-size:20px!important;line-height:20px!important;height:20px!important;}
            .m-height25 {font-size:25px!important;line-height:25px!important;height:25px!important;}
            .m-height30 {font-size:30px!important;line-height:30px!important;height:30px!important;}
            .rwd-on-mobile {display: inline-block!important;padding: 5px;}
            .center-on-mobile {text-align: center!important;}
            .cursor-pointer {cursor: pointer}
            .justify-center {justify-content: center}
        }
    </style>

</head>

<body style="margin: auto; width: 600px">

<span class="preheader-text"  style="color: transparent; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; visibility: hidden; width: 0; display: none; mso-hide: all;"></span>

<div   style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;"></div>

<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="width:100%;max-width:100%; border: 1px solid #E0E0E0; border-radius: 5px">
    <tr><!-- Outer Table -->
        <td align="center"  data-composer>

            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;" >
                <!-- lotus-header-2 -->
                <tr>
                    <td align="center"  class="container-padding">

                        <!-- Content -->
                        <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="580" style="width: 100%; margin: 0; padding: 0">
                            <tr>
                                <td height="40" style="font-size:40px;line-height:40px;" >&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <!-- Logo & Webview -->
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
                                        <tr>
                                            <td align="center" class="container-padding justify-center" style="display: flex; justify-content: center;">

                                                <!-- column -->
                                                <table border="0" align="right" cellpadding="0" cellspacing="0" role="presentation" class="row" width="280" style="width:280px;max-width:280px;">
                                                    <tr  >
                                                        <td align="left" class="center-text" style="display: flex; justify-content: center">
                                                            <img style="display: inline!important;" src="cid:avatar_cid" width="72" border="0" alt="{{ config('app.name') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="40" style="font-size:40px;line-height:40px;" >&nbsp;</td>
                            </tr>

                        </table>
                        <!-- Content -->

                    </td>
                </tr>
            </table>

            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;" >
                <!-- lotus-footer-2 -->
                <tr>
                    <td align="center"  bgcolor="#f0f0f0" class="container-padding">

                        <!-- Content -->
                        <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="580" style="width:90%;">
                            <tr>
                                <td height="50" style="font-size:50px;line-height:50px;" >&nbsp;</td>
                            </tr>
                            <tr style="padding: 10px 0" >
                                <td height="50" style="font-size:1.5rem;line-height:30px;font-weight:bolder;margin-bottom: 1rem" >Password Reset Verification </td>
                            </tr>

                            <tr  >
                                <td height="50" style="font-size:1.25rem;line-height:30px;" >Your verification code: <span style="background-color: #f35d28;padding: 5px;border-radius: 5px;color: #fff;font-weight: 700;">{{$otp}}</span></td>
                            </tr>

                            <tr  >
                                <td height="50" style="font-size:1.25rem;line-height:30px;display: flex;" >This code is valid for 30 minutes. Please do not share this code with anyone. <p style="color: #2db2ea">&nbsp;</p></td>
                            </tr>
                            <tr  >
                                <td height="30" style="font-size:1.25rem;line-height:30px;font-style: italic;" >This is an automated message. Please do not reply.</td>
                            </tr>
                            <tr  >
                                <td height="30" style="font-size:1.25rem;line-height:30px;" >&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="50" style="font-size:50px;line-height:50px;" >&nbsp;</td>
                            </tr>
                        </table>
                        <!-- Content -->

                    </td>
                </tr>
            </table>

        </td>
    </tr><!-- Outer-Table -->
</table>

</body>
</html>

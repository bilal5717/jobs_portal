
<!DOCTYPE HTML>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

        <style>
            a, p a { text-decoration: none;font-weight: 600;color:#970000; }
            a:hover, p a:hover{text-decoration: underline;}
            h4{ margin: 10px 0; }
            p{ margin: 10px 0; line-height: 24px; }
        </style>
</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width: 100%!important;font-family: 'Montserrat', sans-serif;margin: 0;padding: 0;-webkit-text-size-adjust: none;">
    <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width: 100%!important;font-family: 'Montserrat', sans-serif;margin: 0;padding: 0;-webkit-text-size-adjust: none;">
        <center>
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
                <tr>
                    <td align="center" valign="top" style="padding-top:20px; border-collapse: collapse;">
                        <table bgcolor="#fdfdfd" style="   background-color: #fdfdfd;  border: 1px solid #DDDDDD;" border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                            <tr>
                                <td style="border-collapse: collapse;" align="center" valign="top">
                                    <table style="background-color: #fdfdfd;border-bottom: 0;" border="0" cellpadding="20" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent" style="border-collapse: collapse;color:#fff;font-family: 'Montserrat', sans-serif;-moz-background-clip: padding;-webkit-background-clip: padding-box;background-clip: padding-box; background-color:#fff; font-size:34px;font-weight:bold;line-height:100%;padding:10px 15px 10px 15px;text-align:center;vertical-align:middle;width: 100%;">
                                                <img style="max-width:270px; border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;" src="http://www.strongholdgroup.com.au/jobs_portal/public/frontend/assets/images/logo.png" alt="">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-collapse: collapse;" align="center" valign="top">
                                    <table border="0" cellpadding="20" cellspacing="0" width="600" id="templateBody">
                                        <tr>
                                            <td style="border-collapse: collapse;" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td>
                                                            <h4>Hello!</h4>
                                                        </td>
                                                    </tr>
                                                        <tr>
                                                            <td>
                                                                <p>You are receiving this email because we received a password reset request for your account.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                               {{-- Action Button --}}
                                                                @isset($actionText)
                                                                <?php
                                                                    switch ($level) {
                                                                        case 'success':
                                                                        case 'error':
                                                                            $color = $level;
                                                                            break;
                                                                        default:
                                                                            $color = 'primary';
                                                                    }
                                                                ?>
                                                                @component('mail::button', ['url' => $actionUrl, 'color' => $color])
                                                                {{ $actionText }}
                                                                @endcomponent
                                                                @endisset
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>This password reset link will expire in 60 minutes.

                                                                    If you did not request a password reset, no further action is required.
                                                                    
                                                                    <!--Regards,
                                                                    <img style="max-width:270px; border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;" src="http://h2oenvironmental.co.uk/wp-content/uploads/2018/02/logo.png" alt="">-->
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="display: block; margin-bottom: 50px;">
                                                                <p>Thank you very much and have a good day</p>
                                                            </td>
                                                        </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table bgcolor="#fdfdfd" style="background-color: #fdfdfd;border-top: 0;" border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter">
                                        <tr>
                                            <td style="border-collapse: collapse;background-color: #fdfdfd;" valign="top" class="footerContent">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <div class="box" style="text-align:center; padding:0 20px 10px;">
                                                        <div style="height: 4px;background-color: #d75a2f;margin-bottom: 20px;"></div>
                                                        <p style="font-weight: 400;font-size: 13px;margin:5px 5px 0;color: #000000;">
                                                        	13A /17A Amax Avenue Girraween 2145 NSW 2/203 Melrose Drive Tullamarine VIC 3043 <br />
															126 Lister Street Sunnybank QLD 4109</p>
                                                        <p style="margin:5px 5px 0;font-weight: 700;color: #68b6b7;"> <a href="mailto:Admin@shgroupinternational.com" style="margin:5px 0; text-decoration:none;"><span style="font-weight: 400;font-size: 13px;color: #000000;">Admin@shgroupinternational.com</span></a></p>
                                                        <p style="margin:5px 0 20px 0;font-weight: 700;color: #000;"> <a style="font-weight: 400;font-size: 13px;color: #000000;text-decoration: none;" href="tel:01527516000 ">1300-844-419 </a> </p>
                                                    </div>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="middle" style="border-collapse: collapse;text-align: center;    background-color: #970000;color: #FFFFFF;font-size: 13px;padding-top:0;padding-right:0;padding-left:0;padding-bottom:0;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="bottomFooter">
                                                    <tr>
                                                        <td style="border-collapse: collapse;padding-top:10px;padding-bottom:10px;">
                                                            &copy; Strong Hold Ltd. All rights reserved</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>


                            
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>

</html>
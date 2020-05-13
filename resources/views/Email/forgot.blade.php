<?php

$companyLogo = asset('heretoparty/images/logo-color.png');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0;">
    <div style="width: 100%; background:#e5ab16;padding: 15px 0;">
        <table style="width: 600px; margin: 0 auto; background-color: #ffffff">
            <thead>
                <tr style="width:100%">
                    <td style="background-color: #e5ab16;text-align: center;padding-top: 12px;padding-bottom: 6px; ">
                        <img src="{{ $companyLogo }}">
                    </td>
                </tr>
            </thead>
            <tbody style="padding-left: 20px">
                <tr>
                    <td><h2 style="font-family: Calibri; margin-left: 20px">Hi {{$name}},</h2></td>
                </tr>
                <tr>
                    <td >
                      
						<p style="font-family: Calibri; margin-left: 20px">Please Click here to reset your password.</p>
						<a style="font-family: Calibri; margin-left: 20px" href="{{url('reset/'.$Email.'/'.$token)}}"><button class="btn btn-dnager">Reset Password</button></a>
                        <p style="font-family: Calibri; margin-left: 20px"><small><strong>Best Regards,</strong></small></p>
                        <p style="font-family: Calibri; margin-left: 20px"><small><strong>Team {{$appname}}</strong></small></p>
                       
                    </td>
                </tr>
                <tr style="background-color: #e5ab16">
                    <td>
                        <div style="text-align: center; padding-left: 20px; padding-right: 20px; font-family: Calibri; color: #fff;font-size: 12px">
                            <p><br></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div style="padding:8px; box-sizing:border-box;font-family:sans-serif;">
            <h1 style="display:inline; color:#333; margin-top:40px;margin-bottom:40px; padding:3px 0px; text-transform:uppercase; font-weight:300;">Email Verification</h1>
            <p style="margin-bottom:0px;">Thanks for creating an account.<br>
                Simply click the big button below or follow the link below to verify your email address</p>
            <h4><a style="color:#15c;font-size:12px;"href="{{ URL::to('register/verify/' . $confirmation_code) }}">
                    {{ URL::to('register/verify/' . $confirmation_code) }}</a>
            </h4>
            <div style="margin-top:10px;">
                <a  href="{{ URL::to('register/verify/' . $confirmation_code) }}" style="display:inline;width:170px;height:40px; line-height:40px; text-align:center; background:#c6275f; color: #fff; padding:9px 25px; text-decoration:none; box-shadow:inset 0px 0px 3px #fefefe;">Verify Your Account</a>
            </div>
            <br>
            <div style="width:200px;margin-bottom:10px;"><a href="{{ URL::to('/') }}"><img src="{{asset('')}}/front/images/logo.png" alt="logo" style="width:100%"></a>
            </div>
            <h4 style="margin-bottom:0px">Stay In Touch with us</h4>
            <a href="https://www.facebook.com" target="_blank" style="display:inline-block;">
                <img style="width:38px;height:38px;border-radius:50%;" src="{{asset('')}}/front/images/emails/facebook.png"></a>
                <a href="https://twitter.com" target="_blank" style="display:inline-block;    vertical-align: sub;"><img style="width:47px;height:47px;border-radius:50%; " src="{{asset('')}}/front/images/emails/twitter.png"></a>
                <a href="https://www.instagram.com" target="_blank" style="display:inline-block;"><img style="width: 35px;height: 35px;border-radius: 50%;margin-bottom: 3px" src="{{asset('')}}/front/images/emails/instagram.png"></a>
                
        </div>
    </body>
</html>
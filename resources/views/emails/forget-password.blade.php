
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    {{-- <title>New Author Registered| {{ config('app.APP_NAME') }}</title> --}}
</head>

<body style="background-color:#f0f3fc;display: flex;min-height: 100vh;justify-content: center;align-items: center;margin: 0;">
    <div style="margin: 50px auto;width: 100%;">
        <table cellpadding="0" cellspacing="0" style="font-family: 'Hanken Grotesk', sans-serif;font-size: 15px; font-weight: 400; max-width: 600px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15); width:50%; ">
            <thead>
                <tr style="background-color: #161c2d; border: none; height: 70px; font-size: 32px;">
                    <th scope="col">
                        <img src="{{URL::asset('images/logo-light.png')}}" alt="{{ config('app.name'); }}" height="20">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:25px 25px 0; color: #161c2d;">
                        <p style="margin: 0;color: #718096;">Reset your password by clicking on link.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 25px 25px; color: #161c2d;text-align: center;">
                        <h6 style="margin: 0;color: #718096;">Account details</h6>
                        <p style="margin: 0;color: #718096;">Email : {{$email}}</p>
                        <p style="margin: 15px 0 0;color: #718096;font-size: 14px;"><b>Please click on link to reset password.</b></p>
                        <a href="{{$app_url}}view-update-password/{{ $token }}/{{ $email }}" target="_blank">Reset Password</a>

                        <p style="margin: 15px 0 0;color: #718096;font-size: 14px;">Get in touch if you have any questions regarding account. Feel free to <b>contact us 24/7</b>. We are here to help</p>
                        <p style="margin: 24px 0 0;color: #718096;font-size: 14px;">Thank you for your cooperative</p>
                        <p style="margin: 6px 0 0;color: #718096;font-size: 14px;font-weight: 600;">Best Regards</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 8px; color: #8492a6; background-color: #161c2d; text-align: center;">
                    {{ date('Y') }} @ <a href="#!" style="color: #cad2dd; text-decoration: none;">{{ config('app.name'); }}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>



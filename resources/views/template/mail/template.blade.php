<h1>👋 Hi {{ $mail_data['name'] }}, Please Verify Your Account !!!</h1>
<h3> Thanks for signing up to our Investment site.</h3>
<p>We hope to offer you the best investment experince yet!! <br> But before then, please confirm your email address to be able to login your account!</p>
<br>
Click this <a href="http://127.0.0.1:8000/verification?code={{$mail_data['verification_code']}}">here</a> to verify your account.
<p>Thank You.</p>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
 
<body>
<h2>Welcome to the LukaBapak, {{$user['name']}}</h2>
<br/>
Your registered email is {{$user['email']}}, please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>
</body>
 
</html>
 
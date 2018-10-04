<!DOCTYPE html>
<html>
<head>
    <title>Invitation Email</title>
</head>
 
<body>
<!-- <h2>Welcome to the LukaBapak, {{$user['name']}}</h2> -->
<h2>Hai! Anda telah diundang untuk menjadi Admin LukaBapak</h2>
<br/>
Klik link dibawah ini untuk menerima invitasi.
<br/>
<a href="{{url('users/verify', $user->verifyUser->token)}}">Become Admin</a>
</body>
 
</html>
 
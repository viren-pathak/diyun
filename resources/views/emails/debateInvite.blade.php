<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debate Invite</title>
</head>
<body>
    <h1>You have been invited to join a debate</h1>
    <p>{{ $invitedBy->username }} has invited you to join the following discussion:</p>
    <h2><a href="{{ $inviteUrl }}">{{ $debate->title }}</a></h2>
    <p>{{ $inviteMessage }}</p>
    <p><a href="{{ $inviteUrl }}">Click here to join the debate</a></p>
</body>
</html>

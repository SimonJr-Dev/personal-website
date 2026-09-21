<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin password changed</title>
</head>
<body style="margin:0; padding:24px; background:#111111; color:#f5f5f5; font-family:Arial, sans-serif;">
    <div style="max-width:560px; margin:0 auto; background:#171717; border:1px solid rgba(255,255,255,0.1); border-radius:16px; padding:24px;">
        <h2 style="margin-top:0; margin-bottom:16px; color:#b8ff55;">Admin password changed</h2>
        <p>The password for your portfolio admin account was changed successfully.</p>
        <p><strong>Account:</strong> {{ $email }}</p>
        <p><strong>Changed at:</strong> {{ $changedAt->format('F j, Y \a\t g:i A') }}</p>
        <p>The new password is not included in this email. If you did not make this change, sign in and change it immediately.</p>
    </div>
</body>
</html>

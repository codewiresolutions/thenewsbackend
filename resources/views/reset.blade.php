<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">

<div style="max-width: 600px; margin: 50px auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden;">
    <!-- Header Section -->
    <header style="background-color: #4CAF50; color: #ffffff; text-align: center; padding: 20px;">
        <h1 style="font-size: 24px; margin: 0;">Password Reset Request</h1>
    </header>

    <!-- Body Section -->
    <div style="padding: 30px;">
        <p style="font-size: 16px; color: #333333; line-height: 1.6; margin-bottom: 20px;">
            Hello,
        </p>
        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            We received a request to reset your password. Please use the code below to reset your password. If you didn’t request this, you can safely ignore this email.
        </p>

        <!-- Reset Code -->
        <div style="text-align: center; margin: 30px 0;">
            <h2 style="font-size: 32px; color: #4CAF50; background-color: #f7f7f7; padding: 15px 25px; display: inline-block; border-radius: 8px; border: 1px solid #ddd;">
                {{ $code }}
            </h2>
        </div>

        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            If you have any questions or need further assistance, please contact our support team. We're here to help!
        </p>
    </div>

    <!-- Footer Section -->
    <footer style="background-color: #f1f1f1; text-align: center; padding: 15px; border-top: 1px solid #e0e0e0;">
        <p style="font-size: 14px; color: #888888; margin: 0;">
            Thank you,<br>
            <strong>The Codewire Team</strong>
        </p>
        <p style="font-size: 12px; color: #aaaaaa; margin: 10px 0 0;">
            This email was sent from an unmonitored address. Please do not reply directly to this email.
        </p>
    </footer>
</div>

</body>

</html>

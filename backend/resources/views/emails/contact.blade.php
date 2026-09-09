<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <h2 style="margin-bottom: 4px;">New message from the FreelanceFlow contact form</h2>
    <p style="color: #64748b; margin-top: 0;">Someone reached out via the public Contact page.</p>

    <table style="margin: 16px 0;">
        <tr>
            <td style="padding: 4px 12px 4px 0; font-weight: bold;">Name</td>
            <td style="padding: 4px 0;">{{ $senderName }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 12px 4px 0; font-weight: bold;">Email</td>
            <td style="padding: 4px 0;">{{ $senderEmail }}</td>
        </tr>
    </table>

    <p style="font-weight: bold; margin-bottom: 4px;">Message</p>
    <p style="white-space: pre-wrap; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">{{ $messageBody }}</p>

    <p style="color: #94a3b8; font-size: 12px; margin-top: 24px;">Reply directly to this email to respond to {{ $senderName }}.</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Portfolio Inquiry</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0b1120; color: #e2e8f0; margin: 0; padding: 32px 16px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #1e293b; border-radius: 12px; border: 1px solid #334155; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%); padding: 28px 32px; color: #ffffff;">
                <h1 style="margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px;">New Portfolio Inquiry</h1>
                <p style="margin: 6px 0 0 0; font-size: 14px; opacity: 0.9;">Someone reached out through your portfolio contact form.</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px;">
                <!-- Sender Info Card -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #0f172a; border-radius: 8px; border: 1px solid #334155; margin-bottom: 24px;">
                    <tr>
                        <td style="padding: 16px 20px;">
                            <p style="margin: 0 0 8px 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; font-weight: 600;">Sender Details</p>
                            <p style="margin: 0 0 6px 0; font-size: 16px; color: #f8fafc; font-weight: 600;">{{ $inquiry->name }}</p>
                            <p style="margin: 0; font-size: 14px; color: #38bdf8;">
                                <a href="mailto:{{ $inquiry->email }}" style="color: #38bdf8; text-decoration: none;">{{ $inquiry->email }}</a>
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Message Card -->
                <div style="margin-bottom: 28px;">
                    <p style="margin: 0 0 10px 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; font-weight: 600;">Message</p>
                    <div style="background-color: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: 20px; font-size: 15px; line-height: 1.6; color: #cbd5e1; white-space: pre-wrap;">{{ $inquiry->message }}</div>
                </div>

                <!-- Call to action -->
                <div style="text-align: center; margin-top: 24px;">
                    <a href="mailto:{{ $inquiry->email }}?subject={{ rawurlencode('Re: Portfolio Inquiry') }}" style="display: inline-block; background-color: #0ea5e9; color: #ffffff; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);">
                        Reply to {{ $inquiry->name }}
                    </a>
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="border-top: 1px solid #334155; padding: 20px 32px; background-color: #0f172a; text-align: center; font-size: 12px; color: #64748b;">
                Sent automatically by your Portfolio Website &bull; {{ config('app.url') }}
            </td>
        </tr>
    </table>
</body>
</html>

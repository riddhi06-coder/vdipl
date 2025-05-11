<div style="font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; border-radius: 6px; max-width: 600px; margin: auto;">

    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ asset('frontend/assets/images/home/vdipl-logo.webp') }}" alt="VDIPL Logo" title="VDIPL Logo" style="width: 220px; height: auto;">
    </div>

    <p>Hi {{ $name ?? 'there' }},</p>

    <p>Thanks for contacting us! We’ve received your message and will get back to you soon.</p><br>

    <p>Best regards,<br>Team VDIPL</p>

    <hr>

    <div style="margin-top: 30px; text-align: center; color: #777;">
        <p style="font-size: 14px;">&copy; {{ date('Y') }} VDIPL - Vaibhav Deshmukh Infra Projects Pvt. Ltd.</p>
    </div>
</div>

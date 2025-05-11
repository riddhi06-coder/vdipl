<!-- resources/views/emails/job_application.blade.php -->
<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ asset('frontend/assets/images/home/vdipl-logo.webp') }}" alt="VDIPL Logo" title="VDIPL Logo" style="width: 220px; height: auto;">
    </div>

    <h2 style="text-align: center; color: #2c3e50;">New Job Application</h2>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 8px 0;"><strong>Full Name:</strong></td>
            <td>{{ $first_name }} {{ $last_name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Email:</strong></td>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Phone:</strong></td>
            <td>{{ $phone }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Job Role Applied For:</strong></td>
            <td>{{ $job_role }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; vertical-align: top;"><strong>Candidate Message:</strong></td>
            <td style="white-space: pre-wrap;">{{ e($user_message) }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px; text-align: center; color: #555;">
        The candidate's resume is attached with this email.
    </p>

    <hr>

    <div style="margin-top: 30px; text-align: center; color: #555;">
        <p style="font-size: 16px; color: #555; line-height: 18px; margin: 0;">
            &copy; {{ date('Y') }} VDIPL - Vaibhav Deshmukh Infra Projects Pvt. Ltd.
        </p>
    </div>
</div>

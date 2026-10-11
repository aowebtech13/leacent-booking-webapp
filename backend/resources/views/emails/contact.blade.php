<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Name:</div>
                <div class="value">{{ $name }}</div>
            </div>
            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $email }}</div>
            </div>
            @if($phone)
            <div class="field">
                <div class="label">Phone:</div>
                <div class="value">{{ $phone }}</div>
            </div>
            @endif
            @if($subject)
            <div class="field">
                <div class="label">Subject:</div>
                <div class="value">{{ $subject }}</div>
            </div>
            @endif
            <div class="field">
                <div class="label">Message:</div>
                <div class="value">{{ $message }}</div>
            </div>
        </div>
    </div>
</body>
</html>

@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send WhatsApp Notification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div style="max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2>Send WhatsApp Notification</h2>
        <form id="sendNotificationForm">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" style="width: 100%;" placeholder="Enter your message"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="no_wha">WhatsApp Number:</label>
                <input type="text" id="no_wha" name="no_wha" style="width: 100%;" placeholder="Enter WhatsApp number" />
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px;">
                Send Notification
            </button>
        </form>

        <div id="responseMessage" style="margin-top: 20px;"></div>
    </div>

    <script>
        document.getElementById('sendNotificationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let message = document.getElementById('message').value;
            let no_wha = document.getElementById('no_wha').value;

            fetch("{{ url('/send-notification') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message,
                    no_wha: no_wha
                })
            })
            .then(response => response.json())
            .then(data => {
                let responseMessage = document.getElementById('responseMessage');
                if (data.status === 'success') {
                    responseMessage.innerHTML = '<p style="color: green;">Notification sent successfully!</p>';
                } else {
                    responseMessage.innerHTML = '<p style="color: red;">Failed to send notification.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('responseMessage').innerHTML = '<p style="color: red;">An error occurred. Please try again later.</p>';
            });
        });
    </script>
</body>
</html>

@endsection
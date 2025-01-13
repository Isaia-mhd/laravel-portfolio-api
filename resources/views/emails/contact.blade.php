<!-- resources/views/emails/contact.blade.php -->

<html>
    <body>
        <h3>Message from {{$name}} <span style="font-size:14px;">{{ $email }}</span></h3>
        <p>{{ $messageContent }}</p>
    </body>
</html>

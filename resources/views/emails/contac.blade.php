<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body>
    <h1>{{ $subject }}</h1>
    <p><strong>De:</strong> {{ $name }} ({{ $email }})</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $messageContent }}</p>
</body>
</html>

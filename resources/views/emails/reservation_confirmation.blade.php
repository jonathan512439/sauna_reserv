<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            margin: 20px 0;
        }
        .content h2 {
            color: #0d6efd;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 12px;
        }
        .button {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .button:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con logo -->
        <div class="header">
            <img src="{{ asset('images/logo_sauna.png') }}" alt="Logo Sauna San Márquez">
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <h2>Confirmación de tu Reserva</h2>
            <p>Hola {{ $notifiable->name }},</p>
            <p>¡Tu reserva ha sido confirmada exitosamente! A continuación, te proporcionamos los detalles de tu reserva:</p>

            <ul>
                <li><strong>Ambiente:</strong> {{ $reservation->ambiente->name }}</li>
                <li><strong>Hora de Inicio:</strong> {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</li>
                <li><strong>Hora de Fin:</strong> {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</li>
                <li><strong>Método de Pago:</strong> {{ ucfirst($reservation->payment_method) }}</li>
                <li><strong>Estado de Pago:</strong> {{ ucfirst($reservation->payment_status) }}</li>
            </ul>

            <p>Para más detalles o gestionar tu reserva, haz clic en el siguiente botón:</p>
            <p><a href="{{ url('/reservas') }}" class="button">Ver Reserva</a></p>

            <p>Gracias por utilizar nuestro sistema de reservas. ¡Esperamos verte pronto en Sauna San Márquez!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Sauna San Márquez, Calle Ejemplo N° 123, Ciudad Ejemplo.</p>
            <p>&copy; {{ date('Y') }} Sauna San Márquez. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>

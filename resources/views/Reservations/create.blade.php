@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h1 class="mb-4">Crear Nueva Reserva</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="reservationForm" action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <!-- Selección de ambiente -->
        <div class="form-group mb-3">
            <label for="ambiente_id">Ambiente</label>
            <select name="ambiente_id" id="ambiente_id" class="form-control" required>
                <option value="">Seleccionar ambiente...</option>
                @foreach($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}" data-price="{{ $ambiente->price }}">
                        {{ $ambiente->name }} - Precio: Bs.{{ number_format($ambiente->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Selección de la hora de inicio (actualizado a select) -->
        <div class="form-group mb-3">
            <label for="start_time">Hora de Inicio</label>
            <select name="start_time" id="start_time" class="form-control" required>
                <option value="">Seleccionar hora...</option>
            </select>
            <small class="form-text text-muted">Selecciona una hora de inicio disponible.</small>
        </div>

        <!-- Selección de la hora de fin (generada automáticamente) -->
        <div class="form-group mb-3">
            <label for="end_time">Hora de Fin</label>
            <input type="time" name="end_time" id="end_time" class="form-control" readonly>
        </div>

        <!-- Mostrar el precio del ambiente -->
        <div class="form-group mb-3">
            <label for="price">Precio del Ambiente</label>
            <input type="text" id="price" class="form-control" readonly>
        </div>

        <!-- Selección del método de pago -->
        <div class="form-group mb-3">
            <label for="payment_method">Método de Pago</label>
            <select name="payment_method" id="payment_method" class="form-control" required onchange="showPaymentModal()">
                <option value="">Seleccionar método de pago...</option>
                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                <option value="qr">Pago con QR</option>
            </select>
        </div>

        <!-- Botón para confirmar la reserva -->
        <div class="form-group mt-3">
            <button type="button" class="btn btn-primary" onclick="submitReservation()">Confirmar y Pagar</button>
        </div>
    </form>
</div>

<!-- Modal para Pago con Tarjeta -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Pago con Tarjeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Número de Tarjeta</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" maxlength="16" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Fecha de Expiración (MM/YY)</label>
                        <input type="text" class="form-control" id="expiration_date" name="expiration_date" maxlength="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmPayment('tarjeta')">Pago Realizado</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Pago con QR -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Pago con QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Escanee el siguiente código QR para completar el pago.</p>
                <img src="{{ asset('images/qr_placeholder.png') }}" alt="QR de Pago" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmPayment('qr')">Pago Realizado</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('ambiente_id').addEventListener('change', function () {
        const ambienteId = this.value;
        const startTimeSelect = document.getElementById('start_time');
        const price = this.options[this.selectedIndex].getAttribute('data-price');

        // Actualizar el precio
        document.getElementById('price').value = 'Bs. ' + parseFloat(price).toFixed(2);

        // Limpiar opciones anteriores de la hora de inicio
        startTimeSelect.innerHTML = '<option value="">Seleccionar hora...</option>';

        if (ambienteId) {
            fetch(`/reservas/available-hours/${ambienteId}`)
                .then(response => response.json())
                .then(hours => {
                    hours.forEach(hour => {
                        const option = document.createElement('option');
                        option.value = hour;
                        option.textContent = hour;
                        startTimeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener horas:', error));
        }
    });

    document.getElementById('start_time').addEventListener('change', function () {
        const selectedTime = this.value;
        if (selectedTime) {
            const startTimeDate = new Date(`1970-01-01T${selectedTime}:00`);
            const endTimeDate = new Date(startTimeDate.getTime() + 60 * 60 * 1000); // Agregar una hora
            const endTimeFormatted = endTimeDate.toISOString().substr(11, 5); // Formato HH:mm
            document.getElementById('end_time').value = endTimeFormatted;
        }
    });

    function showPaymentModal() {
        const paymentMethod = document.getElementById('payment_method').value;
        if (paymentMethod === 'tarjeta') {
            new bootstrap.Modal(document.getElementById('cardModal')).show();
        } else if (paymentMethod === 'qr') {
            new bootstrap.Modal(document.getElementById('qrModal')).show();
        }
    }

    function confirmPayment(method) {
        document.getElementById('reservationForm').submit();
    }
</script>
@endsection

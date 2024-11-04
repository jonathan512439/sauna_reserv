@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 3%">
    <h1 class="mb-4">Tus Reservas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty($message))
        <div class="alert alert-info">{{ $message }}</div>
    @endif

    @if($reservations->isEmpty())
        <p>No tienes reservas actuales.</p>
        <section id="user-options" class="py-5 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-lg">
                            Crear una Reserva
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ambiente</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Método de Pago</th>
                    <th>Estado de Pago</th>
                    <th>Estado de Reserva</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->ambiente->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($reservation->payment_method) }}</td>
                        <td>
                            @switch($reservation->payment_status)
                                @case('pending')
                                    Pendiente
                                    @break
                                @case('paid')
                                    Pagado
                                    @break
                                @case('failed')
                                    Fallido
                                    @break
                                @default
                                    Desconocido
                            @endswitch
                        </td>
                        <td>
                            @if($reservation->end_time < now())
                                Expirado
                            @else
                                {{ ucfirst($reservation->status) }}
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-reservation-id="{{ $reservation->id }}">Cancelar</button>
                                </td>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Modal de confirmación para cancelar la reserva -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación requerida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas cancelar esta reserva?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<form id="deleteReservationForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        let formToSubmit = null;
        let reservationId = null;

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                reservationId = this.getAttribute('data-reservation-id');
                formToSubmit = document.getElementById('deleteReservationForm');
                formToSubmit.setAttribute('action', `/reservas/${reservationId}`);
                confirmModal.show();
            });
        });

        document.getElementById('confirmBtn').addEventListener('click', function () {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    });
</script>
@endsection

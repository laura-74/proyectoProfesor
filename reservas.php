<?php
class ColaReservas {
    private $reservas = [];

    // Agregar una reserva a la cola
    public function agregarReserva($nombre, $mesa, $fecha) {
        $reserva = [
            "nombre" => $nombre,
            "mesa" => $mesa,
            "fecha" => $fecha
        ];
        array_push($this->reservas, $reserva);
    }

    // Procesar la reserva más antigua
    public function atenderReserva() {
        return empty($this->reservas) ? "No hay reservas pendientes." : array_shift($this->reservas);
    }

    // Ver todas las reservas en la cola
    public function verReservas() {
        return $this->reservas;
    }
}

// Instanciar la cola
$colaReservas = new ColaReservas();
?>
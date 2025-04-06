<?php

class PilaMensajes {
    private $mensajes = [];

    // Agregar un mensaje a la pila
    public function agregarMensaje($nombre, $email, $telefono, $mensaje) {
        $nuevoMensaje = [
            "nombre" => $nombre,
            "email" => $email,
            "telefono" => $telefono,
            "mensaje" => $mensaje,
            "fecha" => date("Y-m-d H:i:s") // Se agrega la fecha/hora
        ];
        array_push($this->mensajes, $nuevoMensaje);
    }

    // Obtener el último mensaje ingresado (LIFO - Last In First Out)
    public function obtenerUltimoMensaje() {
        return array_pop($this->mensajes);
    }

    // Ver todos los mensajes en la pila
    public function verMensajes() {
        return $this->mensajes;
    }
}
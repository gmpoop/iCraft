<?php
class Mensaje {
    private $conn;

    public $id;
    public $remitente_id;
    public $destinatario_id;
    public $mensaje;
    public $fecha_envio;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo mensaje
    public function create() {
        $query = "CALL sp_insertar_mensaje(?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->remitente_id = htmlspecialchars(strip_tags($this->remitente_id));
        $this->destinatario_id = htmlspecialchars(strip_tags($this->destinatario_id));
        $this->mensaje = htmlspecialchars(strip_tags($this->mensaje));

        // Bind
        $stmt->bind_param('iis', $this->remitente_id, $this->destinatario_id, $this->mensaje);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener todos los mensajes
    public function getAll() {
        $query = "SELECT * FROM mensajes"; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un mensaje por ID
    public function getOne($id) {
        $query = "SELECT * FROM mensajes WHERE id = ?"; 
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar un mensaje
    public function update() {
        $query = "CALL sp_modificar_mensaje(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->remitente_id = htmlspecialchars(strip_tags($this->remitente_id));
        $this->destinatario_id = htmlspecialchars(strip_tags($this->destinatario_id));
        $this->mensaje = htmlspecialchars(strip_tags($this->mensaje));

        // Bind
        $stmt->bind_param('iisi', $this->id, $this->remitente_id, $this->destinatario_id, $this->mensaje); 

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar un mensaje
    public function delete() {
        $query = "CALL sp_borrar_mensaje(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

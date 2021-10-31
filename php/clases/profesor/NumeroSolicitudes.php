<?php 

class NumeroSolicitudes{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }
    /**
     * Obtiene el total de las solicitudes del profesor para mostrar en el navbar
     */
    public function obtenerNumeroSolicitudes($id_maestro){
        try {
            $sql = "SELECT count(amm.id_alumno)
                    FROM alumnos_materias_maestros amm
                    WHERE amm.id_maestro = ?
                    AND amm.estado = 'pendiente'";              
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_maestro]);
            $datos = $stmt->fetchColumn();
            return $datos;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las materias del profesor" .$e->getMessage();
            return "error";
        }
    }
}

?>
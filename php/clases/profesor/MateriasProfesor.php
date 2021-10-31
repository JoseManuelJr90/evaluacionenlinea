<?php 

class MateriasProfesor{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }
    /**
     * Obtiene los datos de la materia que imparte el profesor
     */
    public function obtenerDatosMateriasProfesor($id_maestro){
        try {
            $sql = "SELECT * FROM materias m 
                    JOIN materias_maestros mm 
                    ON m.id_materia = mm.id_materia 
                    WHERE mm.id_maestro = ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_maestro]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las materias del profesor" .$e->getMessage();
            return "error";
        }
    }

    
    
}

?>
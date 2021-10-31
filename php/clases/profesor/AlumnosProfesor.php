<?php 

class AlumnosProfesor{
    private $conn;


    public function __construct($db){
        $this->conn = $db;
    }


    /**
     * Obtiene los datos del alumno que envio la solicitud
     */
    public function obtenerSolicitudes($id_profesor){
        try {
            $sql = "SELECT m.nombre_materia,amm.id_materia,a.numero_cuenta, a.nombre_alumno, a.paterno_alumno, a.materno_alumno, amm.id_alumno, amm.estado
                    FROM alumnos_materias_maestros amm
                    JOIN materias m
                    ON m.id_materia = amm.id_materia
                    JOIN alumno a
                    ON a.id_alumno = amm.id_alumno
                    WHERE amm.id_maestro = ?
                    AND amm.estado <> 'inscrito'
                    ORDER by 1,4";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las solicitudes". $e->getMessage();
            return "Error";
        }
    }
    /**
     * Actualiza el estado de las solicitud
     */
    public function actualizarSolicitudes($id_materia, $id_profesor, $id_alumno, $accion){
        try {
            $sql = "UPDATE alumnos_materias_maestros SET estado = ? WHERE id_materia = ? AND id_maestro = ? AND id_alumno = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$accion, $id_materia, $id_profesor, $id_alumno]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al actualizar las solicitudes" , $e->getMessage();
            return "Error";
        }
    }

    /**
     * Obtiene la lista de alumnos inscritos a una materia del profesor
     */
    public function obtenerAlumnos($id_profesor){
        try {
            $sql = "SELECT m.nombre_materia,amm.id_materia,a.numero_cuenta, a.nombre_alumno, a.paterno_alumno, a.materno_alumno, amm.id_alumno
                    FROM alumnos_materias_maestros amm
                    JOIN materias m
                    ON m.id_materia = amm.id_materia
                    JOIN alumno a
                    ON a.id_alumno = amm.id_alumno
                    WHERE amm.id_maestro = ?
                    AND amm.estado = 'inscrito' 
                    ORDER by 1,7";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las solicitudes". $e->getMessage();
            return "Error";
        }
    }

    /**
     * Elimina a un alumno de la lista de la materia del profesor
     */
    public function eliminarAlumno($id_alumno, $id_materia, $id_profesor){
        try{
            $sql = "DELETE from alumnos_materias_maestros WHERE id_alumno = ? and id_materia = ? and id_maestro = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_alumno, $id_materia, $id_profesor]);
            return true;
        }catch(Exception $e){
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al borrar al alumno". $e.getMessage();
            return "Error";
        }
    }


  


}


?>
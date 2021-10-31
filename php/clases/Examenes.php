<?php 

class Examenes{
    
    private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

    /**
     * Obtiene las preguntas de un parcial
     */
    public function obtenerPreguntas($id_parcial){
        try {
            //code...
            $sql = "SELECT * from preguntas WHERE id_parcial = ? ORDER by numero_pregunta";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial]);
            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $preguntas;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las preguntas" .$e->getMessage();
            return "error";
        }
    }

    /**
     * Verifica si el alumno ya realizo el parcial o si confirmo y entro al parcial
     */
    public function validarParticipacion($id_alumno, $id_parcial){
        try {
            $sql = "SELECT * from alumno_parcial WHERE id_parcial = ? AND id_alumno =?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial, $id_alumno]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($datos) > 0 ) return 1;
            else return 0; //0 si no esta registrada la participacion
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener las preguntas" .$e->getMessage();
            return "error";
        }
    }

    /**
     * Registra las respuestas 
     */
    public function registrarRespuestas($id_alumno,$id_parcial, $id_pregunta, $numero_pregunta, $respuesta_alumno, $respuesta_correcta){
        try {
            $sql = "INSERT INTO respuestas_alumno (id_alumno, id_parcial, id_pregunta, numero_pregunta, respuesta_alumno, respuesta_correcta) VALUES (?, ? , ? , ? , ? , ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_alumno, $id_parcial, $id_pregunta,$numero_pregunta, $respuesta_alumno, $respuesta_correcta]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al insertar las respuestas". $e->getMessage();
            return "error";
        }
    }

    /**
     * Registra la participacion del alumno y su calificacion en el parcial
     */
    public function registrarAlumoParcial($id_parcial_alumno, $id_alumno, $id_parcial, $calificacion){
        try {
            $sql = "INSERT INTO alumno_parcial (id_parcial_alumno,id_alumno, id_parcial, calificacion) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial_alumno,$id_alumno, $id_parcial, $calificacion]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al registrar los datos en Alumno_parcial" .$e->getMessage();
            return "error"; 
        }
    }

    /**
     * Actualiza la calificacion del alumno al terminar el examen, ya que fue previamente registrado al ingresar al examen
     */
    public function actualizarAlumoParcial($calificacion, $id_parcial_alumno, $id_parcial){
        try {
            $sql = "UPDATE alumno_parcial SET calificacion= ? WHERE id_parcial_alumno = ? AND id_parcial = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$calificacion, $id_parcial_alumno, $id_parcial]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al registrar los datos en Alumno_parcial" .$e->getMessage();
            return "error"; 
        }
    }

    /**
     * Obtiene la calificacion de los alumnos 
     */
    public function obtenerCalificacion($id_profesor){
        try {
            $sql = "SELECT m.nombre_materia, pmm.id_materia, ap.id_alumno, ap.calificacion, ap.id_parcial, pmm.numero_parcial, ap.id_parcial_alumno
                    FROM alumno_parcial ap
                    join parciales_materias_maestros pmm
                    on ap.id_parcial=pmm.id_parcial
                    join alumno a
                    ON a.id_alumno=ap.id_alumno
                    JOIN materias m
                    on pmm.id_materia = m.id_materia
                    WHERE pmm.id_maestro = ? 
                    ORDER by 1,3";
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


}


?>
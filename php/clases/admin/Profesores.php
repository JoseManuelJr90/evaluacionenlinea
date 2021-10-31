<?php 

class Profesores{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Obtiene los profesores registrados y el total de materias que imparten
     */
    public function obtenerProfesores(){
        try {
            $sql = 
                    "SELECT p.id_maestro, p.nombre_maestro, p.paterno_maestro,p.numero_cuenta, p.email,p.fecha_creado,
                    count(m.nombre_materia) as materias
                    FROM maestros p
                    JOIN materias_maestros mm
                    ON p.id_maestro = mm.id_maestro
                    JOIN materias m
                    ON m.id_materia = mm.id_materia
                    group by 1
                    UNION
                    SELECT p.id_maestro, p.nombre_maestro, p.paterno_maestro,p.numero_cuenta, p.email,p.fecha_creado,
                     0 as materias
                    FROM maestros p
                    WHERE p.nombre_maestro <> 'Admin'
                    And id_maestro not in(SELECT id_maestro
                                          FROM materias_maestros)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([]);
            $profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $profesores;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los profesores" . $e->getMessage();
            return "error";
        }
    }

    /**
     * Obtiene las materias que el profesor imparte
     */
    public function obtenerMateriasDeProfesor($numero_cuenta){
        try {
            $sql = "SELECT m.nombre_materia, m.id_materia
                    from materias m
                    join materias_maestros mm
                    on mm.id_materia = m.id_materia
                    join maestros p
                    on mm.id_maestro = p.id_maestro
                    where p.numero_cuenta = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$numero_cuenta]);
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $materias;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los profesores" . $e->getMessage();
            return "error";
        }

    }

    /**
     * Obtiene los datos del profesor
     */
    public function obtenerDatosProfesor($numero_cuenta){
        try {
            $sql = "SELECT *
                    from maestros
                    where numero_cuenta = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$numero_cuenta]);
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $materias;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los profesores" . $e->getMessage();
            return "error";
        }

    }
            
    /**
     * Elimna a un profesor
     */
    public function eliminarProfesor($id_profesor){
        try {
            $sql = "DELETE FROM maestros WHERE id_maestro = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al eliminar al profesor" . $e->getMessage();
            return "error";
        }
    }

    /**
     * Remueve la materia que el profesor tiene asignada
     */
    public function removerMateria($id_materia, $id_profesor){
        try {
            $sql = "DELETE FROM materias_maestros WHERE id_maestro = ? and id_materia=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor, $id_materia]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al eliminar al profesor" . $e->getMessage();
            return "error";
        }
    }

    /**
     * Obtiene las materias a las cuales el profesor no ha sido asignado
     */
    public function materiasNoAsignadas($id_profesor){
        try {
            $sql = "SELECT * 
                    FROM materias 
                    WHERE id_materia not in (select id_materia 
                                             from materias_maestros 
                                             where id_maestro = ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor]);
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $materias;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los profesores" . $e->getMessage();
            return "error";
        }

    }

    /**
     * Asigna una materia al profesor
     */
    public function agregarMateria( $id_profesor, $id_materia){
        try {
            $sql = "INSERT INTO materias_maestros (id_maestro, id_materia) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor, $id_materia]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al eliminar al profesor" . $e->getMessage();
            return "error";
        }
    }

    /**
     * Actualiza los datos del profesor
     */
    public function actualizarProfesor( $id_profesor, $nombre, $paterno, $materno, $email, $cuenta){
        try {
            $sql = "UPDATE maestros SET nombre_maestro = ? , paterno_maestro = ? , materno_maestro = ? , email = ? , numero_cuenta = ?
                    WHERE id_maestro = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nombre, $paterno, $materno, $email, $cuenta, $id_profesor]);
            return true;
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al eliminar al profesor" . $e->getMessage();
            return "error";
        }
    }


}


?>
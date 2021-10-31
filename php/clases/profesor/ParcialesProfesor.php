<?php 

class ParcialesProfesor{
    private $conn;

    public function __construct($db){
        $this->conn = $db;

    }

    /**
     * Obtiene todos los parciales creados del profesor
     */
    public function obtenerParciales($id_profesor){
        try {
            $sql = "SELECT m.nombre_materia, mo.nombre_maestro, mo.paterno_maestro, pmm.id_materia, pmm.id_maestro, pmm.id_parcial,pmm.numero_parcial, pmm.nombre_parcial, pmm.estado
                FROM materias m
                join parciales_materias_maestros pmm
                on m.id_materia = pmm.id_materia
                join maestros mo
                on mo.id_maestro = pmm.id_maestro
                where mo.id_maestro = ?
                ORDER by 1,pmm.numero_parcial";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_profesor]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;

        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los parciales" .$e->getMessage();
            return "error";
        }
    }


    /**
     * Elimina un parcial
     */
    public function eliminarParcial($id_parcial){
        try{
            $sql = "DELETE from parciales_materias_maestros WHERE id_parcial = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial]);
            return true;
        }catch(Exception $e){
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al borrar el parcial".$e->getMessage();
            return "error";
        }
    }

    /**
     * Obtiene los datos de un parcial
     */
    public function obtenerDatosParciales($id_parcial){
        try {
            $sql = "SELECT m.nombre_materia, mo.nombre_maestro, mo.paterno_maestro, pmm.id_materia, pmm.id_maestro, pmm.id_parcial,pmm.numero_parcial, pmm.nombre_parcial,pmm.duracion_parcial
                FROM materias m
                join parciales_materias_maestros pmm
                on m.id_materia = pmm.id_materia
                join maestros mo
                on mo.id_maestro = pmm.id_maestro
                where pmm.id_parcial = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial]);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;

        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al obtener los parciales" .$e->getMessage();
            return "error";
        }
    }

    /**
     * Actualiza los datos de un parcial
     */
    public function actualizarParcial($id_parcial, $id_profesor, $nombre_parcial, $numero_parcial, $duracion_parcial){
        try{
            $sql = "UPDATE parciales_materias_maestros SET nombre_parcial = ?, numero_parcial = ?, duracion_parcial = ?
             WHERE id_parcial= ? AND id_maestro = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nombre_parcial, $numero_parcial, $duracion_parcial, $id_parcial,$id_profesor]);
            return true;
        }catch(Exception $e){
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al actualizar el parcial".$e->getMessage();
            return "error";
        }
    }

    /**
     * Crea un nuevo parcial
     */
    public function crearParcial($id_parcial, $id_profesor, $id_nombre_materia ,$numero_parcial,$nombre_parcial,$estado, $duracion_parcial ){
        try{
            $sql = "INSERT INTO parciales_materias_maestros(id_parcial, id_maestro, id_materia, numero_parcial, nombre_parcial, estado, duracion_parcial)
                    VALUES( ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id_parcial, $id_profesor, $id_nombre_materia,$numero_parcial,$nombre_parcial,$estado, $duracion_parcial ]);
            return true;
        }catch(Exception $e){
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al actualizar el parcial".$e->getMessage();
            return "error";
        }
    }

    /**
     * Actualiza el estado de un parcial (Publicado, oculto)
     */
    public function actualizarEstadoParcial($id_parcial, $estado){
        try{
            $sql = "UPDATE parciales_materias_maestros SET estado = ? WHERE id_parcial= ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$estado, $id_parcial]);
            return true;
        }catch(Exception $e){
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo "Error al actualizar el parcial".$e->getMessage();
            return "error";
        }
    }



}



?>
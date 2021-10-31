<?php 

    class Examenes{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        /**
         * Obtiene las preguntas y respuestas del parcial
         */
        public function obtenerPreguntasyRespuestas($id_parcial){
            try {
                $sql = "SELECT * FROM preguntas WHERE id_parcial = ? ORDER by numero_pregunta";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id_parcial]);
                $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al obtener las preguntas" .$e->getMessage();
                return "error";
            }
        }

        /**
         * Actualiza los datos de las preguntas y respuestas del parcial
         */
        public function actualizarPreguntasyRespuestas($id_parcial, $id_pregunta, $pregunta,$numero_pregunta, $a, $b,$c,$d,$e,$respuesta_correcta){
            try {
                $sql = "UPDATE preguntas SET pregunta = ?, numero_pregunta = ? ,a = ?, b = ?, c = ? ,d = ?, e = ? , respuesta_correcta = ? WHERE id_parcial = ? AND id_pregunta = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$pregunta,$numero_pregunta, $a,$b,$c,$d,$e,$respuesta_correcta,$id_parcial,$id_pregunta]);
                return true;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al obtener las preguntas" .$e->getMessage();
                return "error";
            }
        }

        /**
         * Agrega una nueva pregunta 
         */
        public function agregarPregunta($id_parcial,$pregunta,$numero_pregunta, $a, $b,$c,$d,$e,$respuesta_correcta){
            try {
                $sql = "INSERT into preguntas (id_parcial, pregunta, numero_pregunta,a , b , c ,d , e , respuesta_correcta) VALUES (?,?,?,?,?,?,?,?,?) ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id_parcial, $pregunta,$numero_pregunta, $a,$b,$c,$d,$e,$respuesta_correcta]);
                return true;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al obtener las preguntas" .$e->getMessage();
                return "error";
            }
        }

        
        /**
         * Elimina una pregunta
         */

        public function borrarPregunta($id_parcial, $id_pregunta){
            try{
                $sql = "DELETE from preguntas WHERE id_parcial= ? AND id_pregunta = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id_parcial,$id_pregunta]);
                return true;
            }catch(Exception $e){
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al borrar la pregunta".$e->getMessage();
                return "error";
            }
        }


    }



?>
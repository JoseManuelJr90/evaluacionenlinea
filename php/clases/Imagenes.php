<?php 

    class Imagenes {
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        /**
         * Obtiene los datos de las imagenes de la tabla imagenes
         */
        public function obtenerImagenes($tipo){
            try {
                $sql = "SELECT * from imagenes WHERE tipo = ? ORDER BY id_imagen";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$tipo]);
                $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $imagenes;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al obtener imagenes del header" . $e->getMessage();
                return "error";
            }
        }

        /**
         * Actualiza los datos de las imagenes
         */
        public function editarImagen($id_imagen, $archivo, $titulo, $descripcion, $color_fondo, $color_texto){
            try {
                $sql = "UPDATE imagenes set ruta = ? , titulo = ? , descripcion = ? , color_fondo = ? , color_texto = ? where id_imagen = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$archivo, $titulo, $descripcion,$color_fondo, $color_texto, $id_imagen]);
                return true;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al guardar datos del encabezado" . $e->getMessage();
                return "error";
            }        
        }

        /**
         * guarda una nueva imagen
         */
        public function guardarImagen($archivo, $titulo, $descripcion, $tipo){
            try {
                $sql = "INSERT INTO imagenes (ruta, titulo, descripcion, tipo) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$archivo, $titulo, $descripcion, $tipo]);
                return true;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al guardar el nuevo banner" . $e->getMessage();
                return "error";
            }
        }

        /**
         * Elimina los datos de una imagen
         */
        public function eliminarBanner($id_imagen){
            try {
                $sql = "DELETE from imagenes WHERE id_imagen = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id_imagen]);
                return true;
            } catch (Exception $e) {
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al eliminar banner" . $e->getMessage();
                return "error";
            }
        }





    }


?>
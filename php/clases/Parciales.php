<?php 


    class Parciales{
        private $conn;
        public function __construct($db){
            $this->conn = $db;
        }
        /**Obtiene los parciales de las materias a las que esta inscrito, tanto los que ya realizo y
         * sus resultados estan en la tabla alumno_parcial asi como los que no ha realizado
         */
        public function obtenerParciales($id_alumno, $estado){
            try{
                $sql = "SELECT m.nombre_materia, mo.nombre_maestro, mo.paterno_maestro, pmm.id_materia, pmm.id_maestro, pmm.id_parcial,pmm.numero_parcial, pmm.nombre_parcial, ap.calificacion, pmm.duracion_parcial
                FROM materias m
                join parciales_materias_maestros pmm
                on m.id_materia = pmm.id_materia
                join maestros mo
                on mo.id_maestro = pmm.id_maestro
                join alumnos_materias_maestros amm
                on amm.id_materia = pmm.id_materia
                join alumno_parcial ap
                on (pmm.id_parcial = ap.id_parcial
                    and amm.id_alumno = ap.id_alumno)
                where amm.id_alumno= ?
                and amm.estado=  ?

                UNION

                SELECT m.nombre_materia, mo.nombre_maestro, mo.paterno_maestro, pmm.id_materia, pmm.id_maestro, pmm.id_parcial, pmm.numero_parcial, pmm.nombre_parcial, '' as calificacion, pmm.duracion_parcial
                FROM materias m
                join parciales_materias_maestros pmm
                on m.id_materia = pmm.id_materia
                join maestros mo
                on mo.id_maestro = pmm.id_maestro
                join alumnos_materias_maestros amm
                on (amm.id_materia = pmm.id_materia
                    and amm.id_maestro = pmm.id_maestro)
                where amm.id_alumno= ?
                and amm.estado=  ?
                and pmm.estado = 'Publicado'
                and pmm.id_parcial not in(SELECT pmm.id_parcial
                                            FROM materias m
                                            join parciales_materias_maestros pmm
                                            on m.id_materia = pmm.id_materia
                                            join alumnos_materias_maestros amm
                                            on amm.id_materia = pmm.id_materia
                                            join alumno_parcial ap
                                            on (pmm.id_parcial = ap.id_parcial
                                                and amm.id_alumno = ap.id_alumno)
                                            where amm.id_alumno= ?
                                            and amm.estado= ?) 
                ORDER by 1,7;";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id_alumno, $estado, $id_alumno, $estado, $id_alumno, $estado  ]);
                $datos = $stmt->fetchall(PDO::FETCH_ASSOC);
                return $datos;
            }catch(Exception $e){
                if($this->conn->inTransaction()) $this->conn->rollBack();
                echo "Error al obtener los datos de los parciales" .$e->getMessage();
                return "error";
            }

        }
    }


?>
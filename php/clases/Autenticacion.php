<?php 

class Autenticacion{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }


    /**
     * Obtenemos el numero de cuenta, password y email de la tabla alumno y verificamos si esta registrado
     * Cuando ingresan los datos en nuevo registro
     */
    public function validarAutenticacionRegistro($tabla,$numero_cuenta, $password, $email){
        try {
            if($tabla=="alumno")$sql ="SELECT  numero_cuenta FROM alumno where numero_cuenta = ?";
            if($tabla=="maestros")$sql ="SELECT  numero_cuenta FROM maestros where numero_cuenta = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$numero_cuenta]);
            $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($cuenta)){
                return 1; //Se encontro el numero de cuenta registrado
            //Si la consulta anterior no obtuvo datos
            }else{
                if($tabla=="alumno")$sql="SELECT  email FROM alumno where email = ?";
                if($tabla=="maestros")$sql="SELECT  email FROM maestros where email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$email]);
                $email = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!empty($email)){
                    return 0; // Se encontro el email registrado
                }else{
                    return 2;
                }
            }
            
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo 'Error en la consulta:' .$e->getMessage();
            return 'error';
        }

    }
   


    
	/**
	 * Guarda un registro en la tabla alumno
	 *
	 */
	public function guardarRegistro($tabla,$id, $numero_cuenta, $nombre,$paterno,$materno,$email, $password) {
		try {
            if($tabla == "alumno") $sql = "INSERT INTO alumno (id_alumno, numero_cuenta, nombre_alumno, paterno_alumno, materno_alumno, email, password_alumno) VALUES (?, ?, ?, ?,?,? , ?)";
            if($tabla == "maestros") $sql = "INSERT INTO maestros (id_maestro, numero_cuenta, nombre_maestro, paterno_maestro, materno_maestro, email, password_maestro) VALUES (?, ?, ?, ?,?,? , ?)";
            $stmt = $this->conn->prepare($sql);
			$stmt->execute([$id, $numero_cuenta, $nombre,$paterno,$materno,$email, $password]);
			return true;
		} catch(Exception $e) {
			if ($this->conn->inTransaction()) $this->conn->rollBack();
			echo 'Error en la consulta: ' . $e->getMessage();
			return 'error';
		}
	}



     /**
     * Obtenemos el numero de cuenta, password y email de la tabla alumno y verificamos si esta registrado
     */
    public function validarAutenticacionAlumno($numero_cuenta, $password_alumno){
        try {
            $sql ="SELECT id_alumno, numero_cuenta,password_alumno, nombre_alumno, paterno_alumno
                  FROM alumno where numero_cuenta = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$numero_cuenta]);
            $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($alumno)){
                if(password_verify($password_alumno, $alumno["password_alumno"])){
                    return $alumno;
                }else{
                    return 1;
                }
            }else{
                return NULL;
            }
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo 'Error en la consulta:' .$e->getMessage();
            return 'error';
        }

    }


    /**
     * Obtenemos el numero de cuenta, password y email de la tabla maestro y verificamos si esta registrado
     */
    public function validarAutenticacionProfesor($numero_cuenta, $password_profesor){
        try {
            $sql ="SELECT id_maestro, numero_cuenta,password_maestro, nombre_maestro, paterno_maestro
                  FROM maestros where numero_cuenta = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$numero_cuenta]);
            $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($profesor)){
                if(password_verify($password_profesor, $profesor["password_maestro"])){
                    return $profesor;
                }else{
                    return 1;
                }
            }else{
                return NULL;
            }
        } catch (Exception $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            echo 'Error en la consulta:' .$e->getMessage();
            return 'error';
        }

    }




}


?>
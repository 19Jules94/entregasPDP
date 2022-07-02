<?php
class Usuarios_model extends Base_model{
    function __construct()
    {
        parent::__construct();
    }


    public function modificarPasswordEmail($dni,$email,$pass){
        $sql = "UPDATE usuario SET email=?,password=? WHERE dni=?";
        
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss",$email,$pass, $dni);

        $resultado = $stmt->execute();

        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if($stmt->affected_rows==0){
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el usuario");
        }

        $stmt->close();

        return $resultado;
    }
}
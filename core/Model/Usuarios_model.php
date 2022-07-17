<?php
class Usuarios_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function mostrarTodos()
    {
        $sql = "SELECT dni,nombre,apellidos,email,password from usuario";
        $resultado = $this->db->query($sql);
        return array("usuarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    public function addUsuario($dni, $nombre, $apellidos, $email, $password)
    {
        $sql = "INSERT into usuario (dni,nombre,apellidos,email,password,borrado) values(?,?,?,?,?,0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssss', $dni, $nombre, $apellidos, $email, $password);
        $stmt->execute();
        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        $stmt->close();

        return $dni;
    }

    public function editUsuario($dni, $nombre, $apellidos, $email)
    {
        $sql = "UPDATE usuario set nombre=?,apellidos=?,email=?,borrado=0 where dni=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssss', $nombre, $apellidos, $email, $dni);
        $resultado = $stmt->execute();
        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el usuario");
        }

        $stmt->close();

        return $resultado;
    }

    public function deleteUsuario($dni){
        $sql = "DELETE from usuario where dni=?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("s", $dni);

        $resultado = $stmt->execute();

                
        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar ese edificio");
        }
        
        if ($stmt->errno==1062) {
            $stmt->close();
            throw new DBException("4002");
        }


        $stmt->close();

        return $resultado;
    }

    function show($dni)
    {
        $sql = "SELECT * FROM usuario WHERE dni = '".$dni."'";
        $resultado = $this->db->query($sql);

        return array("usuarios" => $resultado->fetch_all(MYSQLI_ASSOC));
    }

    function getUsuarios()
    {
        $sql = "SELECT dni, nombre, apellidos FROM usuario";

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function modificarPasswordEmail($dni, $email, $pass)
    {
        $sql = "UPDATE usuario SET email=?,password=? WHERE dni=?";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss", $email, $pass, $dni);

        $resultado = $stmt->execute();

        if ($stmt->errno == 1062) {
            $stmt->close();
            throw new DBException("4002");
        }

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            throw new ResourceNotFound("No se ha podido encontrar el usuario");
        }

        $stmt->close();

        return $resultado;
    }
 
}

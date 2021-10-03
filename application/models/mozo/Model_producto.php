<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_producto extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

    public function getListProductos($data){
        $buscar_sp = "CALL sp_productos_listar(?)";
        $resultado = $this->db->query($buscar_sp,$data);
        $res = $resultado->result();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }

    public function getProductoID($data){
        $buscar_sp = "CALL sp_producto_buscarxid(?)";
        $resultado = $this->db->query($buscar_sp,$data);
        $res = $resultado->row_array();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }

}

?>
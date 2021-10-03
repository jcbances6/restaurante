<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_mesa extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

    public function getMesas(){
        $select_sp = "CALL sp_mesas_listar()";
        $resultado = $this->db->query($select_sp);
        $res = $resultado->result();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }

    public function getMesaID($data){
        $buscar_sp = "CALL sp_mesa_buscarxid(?)";
        $resultado = $this->db->query($buscar_sp,$data);
        $res = $resultado->row_array();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }




}

?>
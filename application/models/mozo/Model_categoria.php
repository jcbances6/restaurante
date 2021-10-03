<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_categoria extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

    public function getCategorias(){
        $select_sp = "CALL sp_categorias_listar()";
        $resultado = $this->db->query($select_sp);
        $res = $resultado->result();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }





}

?>
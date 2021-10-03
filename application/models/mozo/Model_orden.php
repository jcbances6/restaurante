<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_orden extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

    public function save_orden($data){
            
        $this->db->trans_start();

        $resultado = $this->db->query("CALL sp_orden_grabar(?, ?, ?, ?, ?);", $data['datos']);
        $ordenid_ = $resultado->row_array()['LAST_INSERT_ID()'];
        $resultado->next_result(); 
        $resultado->free_result(); 

        foreach ($data['detalle'] as $value) {
            $ordenDetalle = array(
                'idorden_' => $ordenid_,
                'idproducto_' => $value['idproducto'],
                'cantidad_' => $value['cantidad']
            );
            $resultado = $this->db->query("CALL sp_orden_detalle_grabar(?, ?, ?);", $ordenDetalle);

        }
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function getOrdenUltimaActiva($data){
            
        $buscar_sp = "CALL sp_orden_ultima_buscarxidmesa(?)";
        $resultado = $this->db->query($buscar_sp,$data);
        $res = $resultado->row_array();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;

    }

    public function getOrdenDetallexID($data){
            
        $buscar_sp = "CALL sp_orden_detalle_buscarxid(?)";
        $resultado = $this->db->query($buscar_sp,$data);
        $res = $resultado->result();
        $resultado->next_result(); 
        $resultado->free_result(); 
        return $res;


    }

    public function update_orden($data){
            
        $this->db->trans_start();

        $this->db->query("CALL sp_orden_actualizar(?, ?, ?);", $data['datos']);
        $this->db->query("CALL sp_orden_detalle_eliminar(?);", $data['datos']['idorden_']);

        foreach ($data['detalle'] as $value) {
            $ordenDetalle = array(
                'idorden_' => $data['datos']['idorden_'],
                'idproducto_' => $value['idproducto'],
                'cantidad_' => $value['cantidad']
            );
            $resultado = $this->db->query("CALL sp_orden_detalle_grabar(?, ?, ?);", $ordenDetalle);

        }
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }


    public function finalizar_orden($data){
            
        $this->db->trans_start();

        $this->db->query("CALL sp_orden_finalizar(?, ?);", $data);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }


}

?>
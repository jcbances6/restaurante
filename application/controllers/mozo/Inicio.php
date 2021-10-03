<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function __construct(){
		parent::__construct();


        if(!$this->session->userdata('login')  ){
            redirect(base_url().'inicio');
        }


        $this->dataview['cssh'] = '
        <!-- DataTables -->
        <link rel="stylesheet" href="'.base_url('assets/datatables-bs4/css/dataTables.bootstrap4.min.css').'">
        <link rel="stylesheet" href="'.base_url('assets/datatables-responsive/css/responsive.bootstrap4.min.css').'">        
        <link rel="stylesheet" href="'.base_url('assets/datatables-buttons/css/buttons.bootstrap4.min.css').'">

        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="'.base_url('assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css').'">';

        $this->dataview['jsf'] = '
        <!-- DataTables -->

        <script src="'.base_url('assets/datatables/jquery.dataTables.min.js').'"></script>
        <script src="'.base_url('assets/datatables-bs4/js/dataTables.bootstrap4.min.js').'"></script>
        <script src="'.base_url('assets/datatables-responsive/js/dataTables.responsive.min.js').'"></script>
        <script src="'.base_url('assets/datatables-responsive/js/responsive.bootstrap4.min.js').'"></script>

        <!-- InputMask -->
        <script src="'.base_url('/assets/moment/moment-with-locales.min.js').'"></script>
        <script src="'.base_url('/assets/inputmask/min/jquery.inputmask.bundle.min.js').'"></script>

        <!-- Tempusdominus Bootstrap 4 -->
        <script src="'.base_url('assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js">').'</script>';

        // $this->load->model('mozo/model_dashboard');

        $this->load->model('mozo/model_mesa');
        $this->load->model('mozo/model_categoria');
        $this->load->model('mozo/model_producto');
        $this->load->model('mozo/model_orden');
        
    }



    public function index(){

        $data = array(
            'mesas' => $this->model_mesa->getMesas(),
        );

        $this->load->view('layouts/header',$this->dataview);
        $this->load->view('mozo/inicio/listar',$data);
        $this->load->view('layouts/footer',$this->dataview);

    }

    public function orden()
    {

        $var = $this->uri->segment(4);

        if (isset($var)) {

            if ($var == "nueva") {

                $dataParam = $this->session->flashdata('param_');
                $this->session->set_flashdata('param_', $dataParam);

                if(isset($dataParam)){

                    $data = array(
                        'mesa' => $this->model_mesa->getMesaID($dataParam),
                        'categorias' => $this->model_categoria->getCategorias(),
                    );

                    if(isset($data['mesa'])){
                        if($data['mesa']['Disponible']){
                            $this->load->view('layouts/header',$this->dataview);
                            $this->load->view('mozo/orden/inicio',$data);
                            $this->load->view('layouts/footer',$this->dataview);    
                        }else{
                            redirect(base_url("mozo/inicio/orden/editar"));       
                        }
                        
                    }else{
                        $this->session->set_flashdata('orden', 'error');
                        redirect(base_url("mozo/inicio"));   
                    }

                }else{
                    $this->session->set_flashdata('orden', 'error');
                    redirect(base_url("mozo/inicio"));   
                }
            }else if($var == "editar"){
                $dataParam = $this->session->flashdata('param_');
                $this->session->set_flashdata('param_', $dataParam);

                if(isset($dataParam)){

                    $data = array(
                        'mesa' => $this->model_mesa->getMesaID($dataParam),
                        'categorias' => $this->model_categoria->getCategorias(),
                        'ordendata' => $this->model_orden->getOrdenUltimaActiva($dataParam)
                    );
                    $data['odendetalle'] = $this->model_orden->getOrdenDetallexID($data['ordendata']['IDOrden']);

                    if(isset($data['mesa'])){
                        if(!$data['mesa']['Disponible']){
                            $this->load->view('layouts/header',$this->dataview);
                            $this->load->view('mozo/orden/editar',$data);
                            $this->load->view('layouts/footer',$this->dataview);    
                        }else{
                            redirect(base_url("mozo/inicio/orden/nueva"));       
                        }
                        
                    }else{
                        $this->session->set_flashdata('orden', 'error');
                        redirect(base_url("mozo/inicio"));   
                    }
                }

            }else{
                $this->session->set_flashdata('orden', 'error');
                redirect(base_url("mozo/inicio"));   
            }

        }else{
            $this->session->set_flashdata('orden', 'error');
            redirect(base_url("mozo/inicio"));
        }
    }


    public function fill_table_productos(){
        $dataParam = $this->session->flashdata('param_');
        $this->session->set_flashdata('param_', $dataParam);

        $cat_ = $this->input->post('param');


        if($cat_  ) {
            $parameter = array(
                'idcategoria_' => $cat_
            );

            // $found =  array('data' => $this->model_dashboard->getZonasTotales_usuario_zona($parameter) ); 
            $found = array('data' => $this->model_producto->getListProductos($parameter) ); //$this->model_dashboard->getZonasTotales_usuario_zona($parameter);
            echo json_encode( $found );
        }

    }


    public function getDatosProducto(){
        $dataParam = $this->session->flashdata('param_');
        $this->session->set_flashdata('param_', $dataParam);
                
        $idprod_ = $this->input->post('idp');


        if($idprod_ ) {
            $parameter = array(
                'idproducto_' => $idprod_
            );

            $found = array('data' => $this->model_producto->getProductoID($parameter) ); 
            echo json_encode( $found );
        }

    }


    public function saveOrden(){
        
        $dataTable = $this->input->post('jsonData');

        if(!isset($dataTable)){ redirect(base_url("mozo/inicio")); }

        $array = json_decode($dataTable, true);

        $dataOrden = array(
            'idmesa_' => $array ['idmesa'],
            "nomcliente_" => mb_strtoupper($array ['nomcliente']),
            'fecha_' => date('Y-m-d H:i:s'),
            'idusuario_' => $this->session->userdata('idusuario'),
            'observacion' => mb_strtoupper($array['observacion'])
        );

        $completeOrden = array(
            'datos' => $dataOrden,
            'detalle' => $array['detalle']
        );
        
        if($this->model_orden->save_orden($completeOrden)){
            echo 'ok';
            $this->session->set_flashdata('orden', 'guardado');
        }else{
            echo 'error';
        }

    }

    public function updateOrden(){
        
        $dataTable = $this->input->post('jsonData');

        if(!isset($dataTable)){ redirect(base_url("mozo/inicio")); }

        $array = json_decode($dataTable, true);

        $dataOrden = array(
            'idorden_' => $array ['idorden'], 
            'nomcliente_' => mb_strtoupper($array['nomcliente']),
            'observacion' => mb_strtoupper($array['observacion'])
        );

        $completeOrden = array(
            'datos' => $dataOrden,
            'detalle' => $array['detalle']
        );
        
        if($this->model_orden->update_orden($completeOrden)){
            echo 'ok';
            $this->session->set_flashdata('orden', 'actualizado');
        }else{
            echo 'error';
        }

    }


    public function finalOrden(){
        
        $dataTable = $this->input->post('jsonData');

        if(!isset($dataTable)){ redirect(base_url("mozo/inicio")); }

        $array = json_decode($dataTable, true);

        $dataOrden = array(
            'idorden_' => $array['idorden'],
            'idmesa_' => $array['idmesa']
        );
        
        if($this->model_orden->finalizar_orden($dataOrden)){
            echo 'ok';
            $this->session->set_flashdata('orden', 'final');
        }else{
            echo 'error';
        }

    }


    public function pasarela(){

        if ($this->input->post('param')) {
            $param_ = $this->input->post('param');
            $this->session->set_flashdata('param_', $param_);
        } else {
            redirect(base_url("mozo/inicio"));
        }
    }



}
?>
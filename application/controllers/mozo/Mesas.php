<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesas extends CI_Controller {
	public function __construct(){
		parent::__construct();
		

		if(!$this->session->userdata('login') ){
            redirect(base_url().'inicio');
        }


        $this->dataview['cssh'] = '
        <!-- DataTables -->
        <link rel="stylesheet" href="'.base_url('assets/datatables-bs4/css/dataTables.bootstrap4.min.css').'">
        <link rel="stylesheet" href="'.base_url('assets/datatables-responsive/css/responsive.bootstrap4.min.css').'">        
        <link rel="stylesheet" href="'.base_url('assets/datatables-buttons/css/buttons.bootstrap4.min.css').'">

        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="'.base_url('assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css').'">

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="'.base_url('assets/icheck-bootstrap/icheck-bootstrap.min.css').'">

        <!-- Select2 -->
        <link rel="stylesheet" href="'.base_url('assets/select2/css/select2.min.css').'">

        <!-- daterange picker -->
        <link rel="stylesheet" href="'.base_url('assets/daterangepicker/daterangepicker.css').'">';

        $this->dataview['jsf'] = '
        <!-- DataTables -->
        <script src="'.base_url('assets/datatables/jquery.dataTables.min.js').'"></script>
        <script src="'.base_url('assets/datatables-bs4/js/dataTables.bootstrap4.min.js').'"></script>
        <script src="'.base_url('assets/datatables-responsive/js/dataTables.responsive.min.js').'"></script>
        <script src="'.base_url('assets/datatables-responsive/js/responsive.bootstrap4.min.js').'"></script>

        <script src="'.base_url('assets/datatables-buttons/js/dataTables.buttons.min.js').'"></script>
        <script src="'.base_url('assets/datatables-buttons/js/buttons.print.min.js').'"></script>
        <script src="'.base_url('assets/datatables-buttons/js/buttons.html5.min.js').'"></script>
        
        <!-- InputMask -->
        <script src="'.base_url('assets/moment/moment-with-locales.min.js').'"></script>
        <script src="'.base_url('assets/inputmask/min/jquery.inputmask.bundle.min.js').'"></script>

        <!-- Tempusdominus Bootstrap 4 -->
        <script src="'.base_url('assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js">').'</script>

        <!-- Select2 -->
        <script src="'.base_url('assets/select2/js/select2.full.min.js').'"></script>
        <!-- lang select2 -->
        <script src="'.base_url('assets/select2/js/i18n/es.js').'"></script>

        <!-- date-range-picker -->
        <script src="'.base_url('assets/daterangepicker/daterangepicker.js').'"></script>

        <!-- autocomplete -->
        <script src="'.base_url('assets/devbridge-autocomplete/dist/jquery.autocomplete.min.js').'"></script>';


        // $this->load->library('email');

        // $this->load->model('admin/model_personas_user');
        // $this->load->model('admin/model_provincia');
        // $this->load->model('admin/model_distrito');
        // $this->load->model('admin/model_cpoblado');
        // $this->load->model('admin/model_partidos');
        // $this->load->model('admin/model_ginstruccion');

        // $this->load->model('admin/model_mesa');
        // $this->load->model('admin/model_local');
        // $this->load->model('admin/model_fcm');
        
	}
	
	public function index(){
		$this->load->view('layouts/header',$this->dataview);
        $this->load->view('layouts/menu');
        // $this->load->view('admin/personero/nuevo',$data);
        $this->load->view('layouts/footer',$this->dataview);
	}

	public function nuevo(){    

        $parameter = array(
            'idusuario_' => $this->session->userdata('idusuario')
         );
        

        $data = array(
            'provincias' => $this->model_provincia->getProvinciasUsuario($parameter),
            'partidos' => $this->model_partidos->getPartidos(),
            'ginstrucciones' => $this->model_ginstruccion->getGradosInstruccion()

        );

        $this->load->view('layouts/header',$this->dataview);
        $this->load->view('layouts/menu_admin');
        $this->load->view('admin/personero/nuevo',$data);
        $this->load->view('layouts/footer',$this->dataview);


		

    }

    public function listar(){


        $var = $this->uri->segment(4);

        if (isset($var)) {

            if ($var == "editar") {

               $dataParam = $this->session->flashdata('param_');
               //$this->session->set_flashdata('param_', $dataParam);

               if(!empty($dataParam)){
                    $data = array(
                        'idpersona_' => $dataParam,
                    );

                    $datas = array(
                        'partidos' => $this->model_partidos->getPartidos(),
                        'persona' => $this->model_personas_user->getPersona_user($dataParam)
                    );

                    // var_dump($datas['persona']);
                    $this->load->view('layouts/header', $this->dataview);
                    $this->load->view('layouts/menu_admin');
                    $this->load->view('admin/personero/editar', $datas);
                    $this->load->view('layouts/footer', $this->dataview);

                }else{
                    redirect(base_url('admin/personeros/listar'));
                }

            }else{

                redirect(base_url('admin/personeros/listar'));
            }
        }else{


            $this->load->view('layouts/header',$this->dataview);
            $this->load->view('layouts/menu_admin');
            $this->load->view('admin/personero/listar');
            $this->load->view('layouts/footer',$this->dataview);

        } 

    }

    public function fill_table_personas(){

        $op_ = $this->input->post('opcion');
       


        if($op_ ) {
            $parameter = array(
                'op_' => $op_
            );

            // $found =  array('data' => $this->model_dashboard->getZonasTotales_usuario_zona($parameter) ); 
            $found = array('data' => $this->model_personas_user->getPersonas_user_opciones($parameter) ); //$this->model_dashboard->getZonasTotales_usuario_zona($parameter);
            echo json_encode( $found );
        }

    }

    public function list_distrito(){

        $param_ = $this->input->post('param');

        if($param_) {
            $parameter = array(
                'idusuario_' => $this->session->userdata('idusuario'),
                'idprovincia_' => $param_
            );

            $found = $this->model_distrito->getDistritoUsuario($parameter);
            $json = [];
            foreach($found as $row) {
                $json[] =  [ 'ubigeo'=>$row->Ubigeo, 'nomdistrito'=>$row->NomDistrito ];
            }

            echo json_encode( $json );
        }

    }

    public function list_cpoblado(){

        $param_ = $this->input->post('param');

        if($param_) {
            $parameter = array(
                'idusuario_' => $this->session->userdata('idusuario'),
                'ubigeo_' => $param_
            );

            $found = $this->model_cpoblado->getCPobladoUsuario($parameter);
            $json = [];
            foreach($found as $row) {
                $json[] =  [ 'idcpoblado'=>$row->IDCPoblado, 'nomcpoblado'=>$row->NomCPoblado ];
            }

            echo json_encode( $json );
        }

    }

    public function busqueda_persona(){ 

        if($this->input->post('param')){
            $param_ = $this->input->post('param');
            $consulta = str_replace(" ","",str_replace("_","",$param_));
            

            if(strlen($consulta) == 8 ){
                echo json_encode($this->model_personas_user->getPersonas_user_dni( array('dni_' => $consulta) ) );

            }
        }
        
    }

    public function consulta_datos(){ 

        if($this->input->post('param')){
            $param_ = $this->input->post('param');
            $consulta = str_replace(" ","",str_replace("_","",$param_));
            

            if(strlen($consulta) == 8 ){

                //http://www.enlacesframework.info/vfpsapirenic/vfpsdni.php?dni=71105868&token=JC9647BAN71VFP3&format=json


                $url = "https://dniruc.apisperu.com/api/v1/dni/";

                $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImtybG9zMTkzMUBnbWFpbC5jb20ifQ.H3wv09rG2aEJDIwUH8kUavWzHCP9vZi84lj3pSGnXWE";

                $url .= $consulta.'?token='.$token;

                $json_get = file_get_contents($url);

                $json_get = json_decode($json_get);

                echo json_encode($json_get);


                // $url = "http://www.enlacesframework.info/vfpsapirenic/vfpsdni.php?dni=";

                // $token = "JC9647BAN71VFP3";

                // $url .= $consulta.'&token='.$token.'&format=json';

                // $json_get = file_get_contents($url);

                // $json_get = json_decode($json_get);

                // echo json_encode($json_get);



            }
        }
        
    }


    public function grabar(){
       if( $this->input->post('txtDNI') && $this->input->post('txtApPaterno') && $this->input->post('txtApMaterno') && $this->input->post('txtNombres') && $this->input->post('opDistrito') ){


           $str_fechaing = $this->input->post('fnacimiento') == '' ? date('d/m/Y') : $this->input->post('fnacimiento');
           $date_ingresada = DateTime::createFromFormat('d/m/Y', $str_fechaing);

            $data = array(
                'dni_' => $this->input->post('txtDNI'),
                'appaterno_' => mb_strtoupper($this->input->post('txtApPaterno')),
                'apmaterno_' => mb_strtoupper($this->input->post('txtApMaterno')),
                'nombres_' => mb_strtoupper($this->input->post('txtNombres')),
                'direccion_' => mb_strtoupper($this->input->post('txtDireccion')),

                'email_' => $this->input->post('txtEmail'),
                'celular1_' => $this->input->post('txtCelular1'),
                'celular2_' => $this->input->post('txtCelular2'),
                'celular3_' => $this->input->post('txtCelular3'),
                'sexo_' => $this->input->post('rb_sexo'),
                'fnacimiento_' => $date_ingresada->format('Y-m-d'),
                
                'ginstruccion_' => $this->input->post('opGradoInstruccion') == '' ? '7' : $this->input->post('opGradoInstruccion') ,
                'profesion_' => mb_strtoupper($this->input->post('txtProfesion')),
                'partidario_' => $this->input->post('opPartidiario'),
                'provincia_' => $this->input->post('opProvincia'),
                
                'ubigeo_' => $this->input->post('opDistrito'),
                'localvotacion_' => $this->input->post('opLVotacion'),
                'mesavotacion_' => $this->input->post('opMesaVotacion'),
                'asignar_' => $this->input->post('opAsignar'),

                'obs_' => $this->input->post('txtObs'),
                'idusuario_' => $this->session->userdata('idusuario'),
                'fecharegistro_' => date('Y-m-d H:i:s')

            );




            if( empty($this->model_personas_user->getPersonas_user_dni( array('dni_' => $data['dni_']) ) ) ) {
                if($this->model_personas_user->save($data)){
                    $this->session->set_flashdata('personeros', 'guardado');

                    $persona = $this->model_personas_user->getPersonas_user_dni( array('dni_' => $data['dni_']) );

                    if($data['asignar_'] == 1){

                        $parameter = array(
                            'param_' => $data['mesavotacion_'].';'.$persona['IDPersona'],
                            'idusuario_' => $this->session->userdata('idusuario'),
                            'fecharegistro_' => date('Y-m-d H:i:s')
                        );

                        if($this->model_mesa->save_personero_mesa($parameter)){
                            $this->session->set_flashdata('reg_personero', 'guardado');
                        }else{
                            $this->session->set_flashdata('reg_personero', 'error');
                        }
                    }elseif($data['asignar_'] == 2){
                        $parameter = array(
                            'param_' => $data['localvotacion_'].';'.$persona['IDPersona'],
                            'idusuario_' => $this->session->userdata('idusuario'),
                            'fecharegistro_' => date('Y-m-d H:i:s')
                        );

                        if($this->model_local->save_coordinador_local($parameter)){
                            $this->session->set_flashdata('reg_coordinador', 'guardado');
                        }else{
                            $this->session->set_flashdata('reg_coordinador', 'error');
                        }
                    }

                    
                }else{
                    $this->session->set_flashdata('personeros', 'error');
                }
            }else{
                $this->session->set_flashdata('personeros', 'existe');
            }

        }else{
            $this->session->set_flashdata('personeros', 'error');
        }

        redirect(base_url('admin/personeros/nuevo'));
        
    }



    public function view_data(){
        $dataParam = $this->session->flashdata('param_');
        $this->session->set_flashdata('param_', $dataParam);
        if ($this->input->post('param')) {

            $param = $this->input->post('param');

            $dataParam = array(
                'param_' => $param
            );

            $data = array(
                'persona' => $this->model_personas_user->getPersona_user($dataParam),
                'local_votacion' => $this->model_personas_user->getPersonas_user_local_asignado($dataParam),
                'mesa_votacion' => $this->model_personas_user->getPersonas_user_mesa_asignado($dataParam)
            );
            $this->load->view('admin/personero/view_data', $data);
        }
    }


    public function actualizar(){
       


           $str_fechaing = $this->input->post('fnacimiento') == '' ? date('d/m/Y') : $this->input->post('fnacimiento');
           $date_ingresada = DateTime::createFromFormat('d/m/Y', $str_fechaing);

            $data = array(
                'idpersona_' => $this->input->post('txtIDPersona'),
                'direccion_' => mb_strtoupper($this->input->post('txtDireccion')),
                'email_' => $this->input->post('txtEmail'),
                'celular1_' => $this->input->post('txtCelular1'),
                'celular2_' => $this->input->post('txtCelular2'),
                'celular3_' => $this->input->post('txtCelular3'),

                'sexo_' => $this->input->post('rb_sexo'),
                'fnacimiento_' => $date_ingresada->format('Y-m-d'),
                'partidario_' => $this->input->post('opPartidiario'),
                'obs_' => $this->input->post('txtObs'),
                'idusuario_' => $this->session->userdata('idusuario'),
                
                'fecharegistro_' => date('Y-m-d H:i:s')

            );


            //var_dump($data);


            if($this->model_personas_user->update($data)){

                $this->session->set_flashdata('personeros', 'actualizado');

            }else{
                $this->session->set_flashdata('personeros', 'error');
            }
       

        redirect(base_url('admin/personeros/listar'));
        
    }

    // public function asign_personero_mesa(){
    //     $param = $this->input->post('param');


    //     $parameter = array(
    //         'param_' => $param, //$data['mesavotacion_'].';'.$persona['IDPersona'],
    //         'idusuario_' => $this->session->userdata('idusuario'),
    //         'fecharegistro_' => date('Y-m-d H:i:s')
    //     );

    //     if($this->model_mesa->personero_mesa_asignar($parameter)){
    //         echo true;
    //     }else{
    //         echo false;
    //     }

        
    // }

    public function personeros(){

        if($this->input->post('param')){

            $param_ = $this->input->post('param');
            $this->session->set_flashdata('param_',$param_);
            
        }else{
            redirect(base_url("admin/personeros/listar"));
        }
    }


    private function my_encrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    private function my_decrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

	


}
?>
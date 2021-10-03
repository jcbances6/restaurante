  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Listado de Mesas</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <?php if(!empty($mesas)): ?>
                    <?php foreach ($mesas as $mesa): ?>
                      <div class="col-xs-12 col-md-4 col-lg-4">
                        <div class="card">
                          <button type="button" class="btn card-body text-center btn-mesa <?php echo ($mesa->Estado ? ($mesa->Disponible ? 'bg-primary' : 'bg-success' ) : 'bg-danger'); ?>" <?php echo ($mesa->Estado == false ? 'disabled' : ''); ?> value="<?php echo $mesa->IDMesa; ?>" >
                            <h1>Mesa <?php echo $mesa->NroMesa; ?></h1>
                            <small class="text-bold"><?php echo ($mesa->Estado ? ($mesa->Disponible ? 'Disponible' : 'En curso' ) : 'Inactiva'); ?></small>
                          </button>
                        </div>
                      </div>
                    <?php endforeach; ?>

                  <?php endif; ?>

                </div>

              </div>
            </div>
          </div>
        </div>

        

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <script type="text/javascript">
    window.onload = function() {

      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });


    <?php

      if($this->session->flashdata('orden')){
        
        if($this->session->flashdata('orden')=="guardado"){
          echo "Toast.fire({ icon: 'success', title: 'Orden generada satisfactoriamente' });";
        }elseif($this->session->flashdata('orden')=="actualizado"){
          echo "Toast.fire({ icon: 'success', title: 'Orden actualizada satisfactoriamente' });";
        }elseif($this->session->flashdata('orden')=="final"){
          echo "Toast.fire({ icon: 'success', title: 'Orden finalizada satisfactoriamente' });";
        }elseif($this->session->flashdata('orden')=="error"){
          echo "Toast.fire({ icon: 'error', title: 'Error al procesar la operación.' });";
        }
                        
      }
      
    ?>
    }
  </script>


  <?php



  ?>
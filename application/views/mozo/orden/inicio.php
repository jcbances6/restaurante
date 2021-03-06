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
                <h5 class="card-title">Datos de la Mesa</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <?php if(!empty($mesa)): ?>
                  <div class="row justify-content-center">

                    <div class="col-xs-12 col-md-4 col-lg-3 col-xl-2">
                      <div class="card">
                        <div class="card-body text-center <?php echo ($mesa['Estado'] ? ($mesa['Disponible'] ? 'bg-primary' : 'bg-success' ) : 'bg-danger'); ?>" >
                          <h3>Mesa <?php echo $mesa['NroMesa']; ?></h3>
                          <input type="hidden" id="idmesa" style="text-transform: uppercase;" class="form-control" value="<?php echo $mesa['IDMesa']; ?>" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-xs-12 col-md-5 col-lg-4 col-xl-2">
                      <div class="card">
                        <button type="button" class="btn card-body text-center bg-warning" onclick="location.href='<?php echo base_url('mozo/inicio'); ?>'">
                          <h3><i class="fas fa-chevron-circle-left"></i> Regresar</h3>
                        </button>
                      </div>
                    </div>

                  </div>
                  <div class="form-group row justify-content-center">
                    <label class="col-xs-12 col-md-3 col-lg-3 col-xl-3 col-form-label text-right ">Nombre del Cliente:*</label>
                    <div class="col-xs-12 col-md-5 col-lg-5 col-xl-5">
                      <input type="text" id="nomcliente" style="text-transform: uppercase;" class="form-control" />
                    </div>
                  </div>
                <?php endif; ?>


              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Listado de Productos</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-md-3 col-lg-4 col-xl-2 mb-3" style="max-height: 350px; overflow-y: auto;">
                    <?php if(!empty($categorias)): ?>
                      <div class="col-12">
                          <div class="card">
                            <button type="button" class="btn btn-block card-body text-center btn-filter-categoria bg-blue" value="C00">
                              <h5 class="text-lg">TODOS</h5>
                            </button>
                          </div>
                        </div>
                      <?php foreach ($categorias as $categoria): ?>
                        <div class="col-12">
                          <div class="card">
                            <button type="button" class="btn btn-block card-body text-center btn-filter-categoria bg-<?php echo $categoria->Color; ?>" value="<?php echo $categoria->IDCategoria; ?>" >
                              <h5 class="text-md"><?php echo $categoria->NomCategoria; ?></h5>
                            </button>
                          </div>
                        </div>
                      <?php endforeach; ?>

                    <?php endif; ?>
                  </div>
                  <div class="col-xs-12 col-md-9 col-lg-8 col-xl-10" style="max-height: 350px; overflow-y: auto;">
                    <table id="listProductos" class="table table-striped table-valign-middle " width="100%">
                      <thead>
                        <tr>
                          <th width="70%">Producto</th>
                          <th width="10%">Precio</th>
                          <th width="10%">Opci??n</th>
                        </tr>

                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  

                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Productos seleccionados</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row justify-content-center">
                  
                  <div class="col-xs-12 col-md-12 col-lg-12" style="max-height: 400px; overflow-y: auto;">
                    <table id="selectProductos" class="table table-striped table-valign-middle " width="100%">
                      <thead>
                        <tr>
                          <th width="5%">Eliminar</th>
                          <th width="50%">Producto</th>
                          <th width="10%">Cantidad</th>
                          <th width="10%">P. Unidad</th>
                          <th width="10%">P. Total</th>
                          
                        </tr>

                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>


                <div class="row mb-3 mt-3">
                  <div class="col-9 text-right" >
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Observaci??n:*</label>
                      <div class="col-sm-9">
                        <textarea id="observ" name="observ" class="form-control" maxlength="200" style="margin: 0px -20.5px 0px 0px; height: 112px; text-transform: uppercase;"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-3 text-right" >
                    <h2 class="text-bold  pt-3 mr-2" id="ptotalventa">Total S/ 0.00 </h2>
                  </div>

                </div>

                <div class="row justify-content-center mb-3">
                  <div class="col-xs-12 col-md-4 col-lg-3 col-xl-2">
                    <button type="button" class="btn btn-block text-center bg-success btn-guardar-orden" >
                      <h3><i class="fas fa-save"></i> Guardar</h3>
                    </button>
                  </div>
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
          echo "Toast.fire({ icon: 'success', title: 'Orden generado satisfactoriamente' });";
        }elseif($this->session->flashdata('orden')=="actualizado"){
          echo "Toast.fire({ icon: 'success', title: 'Orden actualizada satisfactoriamente' });";
        }elseif($this->session->flashdata('orden')=="error"){
          echo "Toast.fire({ icon: 'error', title: 'Error al procesar la operaci??n.' });";
        }
                        
      }
      
    ?>
    }
  </script>


  <?php



  ?>
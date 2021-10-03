

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  
<!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4-->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- pace-progress -->
<script src="<?php echo base_url('assets/pace-progress/pace.min.js'); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<!-- Dropzone -->
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url('assets/sweetalert2/sweetalert2.min.js'); ?>"></script>



<?php 
if(isset($jsf)){
  echo $jsf;
} 
?>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>

<!-- cusom -->
<script src="<?php echo base_url('assets/custom/custom.js'); ?>"></script>

</body>
</html>

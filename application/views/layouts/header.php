<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="<?php echo base_url('assets/dist/img/logo.png'); ?>" type="image/png">
  <title>Mozo | Restaurante</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="<?php echo base_url('assets/pace-progress/themes/blue/pace-theme-flat-top.css'); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url('assets/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
  <!-- Dropzone -->
  <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">

  <?php 
  if(isset($cssh)){
    echo $cssh;
  }
?>

<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css'); ?>"> 
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<style type="text/css">
  $custom-file-text: (
    en: "Browse",
    es: "Elegir"
    );
</style>

</head>



<body class="layout-top-nav" style="height: auto;">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-white">
      <div class="container">

        <a href="<?php echo base_url('mozo/inicio'); ?>"  class="navbar-brand">
          <img src="<?php echo base_url('assets/dist/img/logo.png') ?>" alt="Restaurante Logo" class="brand-image img-circle elevation-2">
          <span class="brand-text text-bold">RESTAURANTE</span>
        </a>

        <!-- Right navbar links -->
        <div class="order-1 navbar-nav navbar-no-expand ml-auto">
          <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="image">
              <img src="<?php echo base_url('assets/dist/img/perfil.png') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <!-- <a href="#" class="d-block">Alexander Pierce</a> -->
              <a class="d-block text-bold"><?php echo $this->session->userdata('nomcorto'); ?></a>
            </div>
          </div>
        </div>


      </div>
    </nav>
    <!-- /.navbar -->

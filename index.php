<!DOCTYPE html>
<html lang="tr" >
<head>
  <meta charset="UTF-8">
  <title>Vergi Kimlik Numarası Doğrulama Sistemi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Vergi Kimlik Numarası Doğrulama Sistemi">
  <meta name="keywords" content="Vergi Kimlik Numarası Doğrulama Sistemi, Vergi, Kimlik, Sorgulama">
  <meta name="author" content="Süleyman Ekici">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css'>
  <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
<style>
   .container {
      margin: 100px auto;
   }
</style>
<form method="POST">
<div class="container">
<center> <h1>Vergi Kimlik Numarası Doğrulama Sistemi</h1></center><br>

<?php  require 'processing.php'; ?>
<input type="number" class="form-control" placeholder="Vergi Kimlik Numarası"  id="vkn" name="vkn" autocomplete="off" required/>
<br>
   <select class="form-control form-control-xs selectpicker" name="vd" data-size="25" data-live-search="true" data-title="Vergi Dairesi Seç" id="vd" data-width="100%">
   <?php
        $get = curl_get('https://www.my-api.co/vd.php');
        $decode = json_decode($get, true);

        foreach ($decode['vd'] as $fetch) {

            echo '<option value="' . $fetch . '">' . $fetch . '</option>';

        }
        ?>
    </select>
    <br><br>
    <input type="hidden" name="jeton" value="<?=$token?>">
   <center> <button type="submit" class="btn btn-primary  btn-inline waves-effect waves-light" name="sorgula">Sorgula</button> </center>
    <br>
</div>
</form>

<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
<script  src="./asset/js/scripts.js"></script>
</body>
</html>



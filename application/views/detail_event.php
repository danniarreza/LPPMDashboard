<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LPPM | UB</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      *{
        font-family: 'Montserrat', sans-serif;
      }
    </style>
  </head>
  <body>
    <!-- <button class="btn btn-default" data-toggle="modal"  data-target=".bs-example-modal-lg">Large modal</button> </center> -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id="onload">

    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <a href="<?php echo site_url('AppointmentController/') ?>"><button type="button" class="close">×</button></a>
          <h2 class="modal-title" style="text-align: center;"><i class="fa fa-exclamation-circle"></i><?php echo $event[0]['undangan'] ?></h2>
        </div>
        <div class="modal-body">
         <?php foreach ($event as $key) { ?>
         <h4>Nama Event : <?php echo $key['TITLE']; ?></h4>
         <h4>Tanggal : <?php echo date('d/m/Y', strtotime($key['tanggal_mulai'])); ?> - <?php echo date('d/m/Y', strtotime($key['tanggal_end'])); ?></h4>
         <h4>Jam : <?php echo date('H:i', strtotime($key['tanggal_mulai'])); ?> - <?php echo date('H:i', strtotime($key['tanggal_end'])); ?></h4>
         <h4>Deskripsi : <?php echo $key['DESCRIPTION']; ?></h4>
         <h4>Lokasi : <a href="<?php $kata = explode(" ",$key['LOCATION']); if($kata[0]=="Ruang"){echo "https://maps.google.com/maps?q=".($key['LOCATION'])." LPPM UB";}else{echo "https://maps.google.com/maps?q=".($key['LOCATION']);} ?>"><?php echo $key['LOCATION']; ?></a></h4>
         <?php } ?>
        </div>
        <div class="modal-footer">
          <?php if ($_SESSION['level']==1) { ?>
          <a href="<?php echo site_url('AppointmentController/confirm_agenda/'.$key['ID_AGENDA']) ?>">
            <button class="btn btn-success pull-left" style="margin-right: 5px;">Confirm</button>
          </a>
          <a href="<?php echo site_url('AppointmentController/tolak_agenda/'.$key['ID_AGENDA']) ?>">
            <button class="btn btn-danger pull-left">Tolak</button>
          </a>
          <?php } ?>
          <!-- <?php if ($_SESSION['level']==2 && $key->STATUS == "Request" && $key->ID_ACARA == 0) { ?>
          <a href="<?php echo site_url('AppointmentController/form_edit_agenda/'.$key->ID_AGENDA) ?>">
            <button class="btn btn-primary">Edit</button>
          </a>
          <?php } ?> -->
          <a href="<?php echo site_url('AppointmentController/') ?>"><button type="button" class="btn btn-default" >Back</button></a>
        </div>
      </div>


    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
         $(window).load(function(){
                $('#onload').modal('show');
            });
    </script>
  </body>
</html>
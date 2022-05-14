<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php 
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    if ($d && $d->format('Y-m-d')==$tanggal) {
     ?>
    <title>Laporan Jadwal Acara Tanggal <?php echo date('d F Y', strtotime($tanggal)) ?></title>
    <?php }else{ ?>
    <title>Laporan Jadwal Acara Bulan <?php echo date('F Y', strtotime($tanggal)) ?></title>
    <?php } ?>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
  
    <!-- <style>
      @media print {
        p { page-break-after: always; }
      }
    </style> -->
  </head>
  <body onload="window.print()">
      <div class="col-lg-12 table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th style="text-align: center;">No.</th>
              <th style="text-align: center;">Tanggal</th>
              <th style="text-align: center;">Penanggung Jawab</th>
              <th style="text-align: center;">Nama Event</th>
              <th style="text-align: center;">Lokasi</th>
              <th style="text-align: center;">Pukul</th>
              <th style="text-align: center;">Deskripsi</th>
              <th style="text-align: center;">Jumlah Peserta</th>
            </tr>
          </thead>
          <tbody>
            <?php $bil=1; foreach ($acara as $key) { ?>
                  <tr>
                    <td><?php echo $bil++ ?></td>
                    <td><?php echo date('d-m-Y', strtotime($key['TIME_START'])) ?></td>
                    <td><?php echo $key['EVENTINITIATOR'] ?></td>
                    <td><?php echo $key['EVENTNAME'] ?></td>
                    <td><?php if ($key['EVENTLOCATION']=="") {
                      echo $key['ROOMNAME'];
                    }else{
                      echo $key['EVENTLOCATION'];
                    } ?></td>
                    <td><?php echo date('H:i', strtotime($key['TIME_START']))." - ".date('H:i', strtotime($key['TIME_END'])) ?></td>
                    <td><?php echo $key['EVENTDESCRIPTION'] ?></td>
                    <td style="text-align: center;"><?php echo $key['ATTENDANCE'] ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="7" style="text-align: center;">Jumlah</td>
                    <td style="text-align: center;"><?php echo $total[0]['jumlah'] ?></td>
                  </tr>
            </tr>
          </tbody>
        </table>
      </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
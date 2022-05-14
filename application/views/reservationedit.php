  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-family: 'Montserrat', sans-serif">
        Form Ubah Peminjaman Ruang
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Advanced Elements</li>
      </ol>
    </section>

    <!-- Main content -->

    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Data Diri Pemohon</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" name="reservationaddform" action="<?php echo site_url('ReservationController/reservationEditHandler/'.$reservation[0]['ID_RESERVATION'].'/'.$idevent[0]['ID_EVENT']);?>" method ="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Pemohon</label>
                  <input type="text" class="form-control" name="applicantname" id="exampleInputEmail1" value="<?php echo $reservation[0]['APPLICANTNAME'];?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Afiliasi Pemohon</label>
                  <input type="text" class="form-control" name="applicantaffiliation" id="exampleInputEmail1" value="<?php echo $reservation[0]['APPLICANTAFFILIATION'];?>" required>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Pemohon</label>
                  <input type="text" class="form-control" name="applicantemail" id="exampleInputEmail1" value="<?php echo $reservation[0]['APPLICANTEMAIL'];?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nomor Telepon Pemohon</label>
                  <input type="text" class="form-control" name="applicantnotelp" id="exampleInputEmail1" value="<?php echo $reservation[0]['APPLICANTNOTELP'];?>" required>
                </div>
              </div>
              <!-- /.col -->
              <!-- <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputFile">Upload Surat Pengantar</label>
                  <input type="file" name="referenceletterpath" id="exampleInputFile" required>

                  <p class="help-block">Biasanya ditulisin upload pdf atau docx.</p>
                </div>
              </div> -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Peminjaman Ruang</h3>

          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Keperluan Peminjaman</label>
                  <input type="text" class="form-control" name="eventname" id="exampleInputEmail1" value="<?php echo $reservation[0]['EVENTNAME'];?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Ruangan</label>
                  <select class="form-control select2" name="room" style="width: 100%;" required>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option <?php if($row['ID_ROOM'] == $reservation[0]['ID_ROOM']){ echo 'selected="selected"'; }?> value="<?php echo $row['ID_ROOM'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                    <option value="Lainnya">5. Lainnya</option>
                  </select>
                  <!-- <input type="text" class="form-control" name="eventlocationlain" id="lain" value="" style="visibility: hidden;"> -->
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Keterangan Tambahan</label>
                  <input type="text" class="form-control" name="additionalinfo" id="exampleInputEmail1" value="<?php echo $reservation[0]['ADDITIONALINFO'];?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <!-- Date and time range -->
                <div class="form-group">
                  <label>Tanggal dan Waktu Dimulai:</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="reservationtimestart" class="form-control pull-right" id="reservationtimestart" value="<?php if(isset($timeinput)!=null){ echo $timeinput; } ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>

              <div class="col-md-6">
                <!-- Date and time range -->
                <div class="form-group">
                  <label>Tanggal dan Waktu Berakhir:</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="reservationtimeend" class="form-control pull-right" id="reservationtimeend" value="<?php if(isset($timeinput)!=null){ echo $timeinput; } ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>



              <div class="col-md-12">
                <center>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </center>
              </div>
            </form>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

 <!-- ./wrapper -->

 <!-- jQuery 3 -->
 <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>

 <!-- Bootstrap 3.3.7 -->
 <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>

 <!-- Select2 -->
 <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js');?>"></script>

 <!-- InputMask -->
 <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js');?>"></script>

 <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js');?>"></script>

 <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js');?>"></script>

 <!-- date-range-picker -->
 <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js');?>"></script>

 <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>

 <!-- bootstrap datepicker -->
 <script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>

 <!-- bootstrap color picker -->
 <script src="<?php echo base_url('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js');?>"></script>

 <!-- bootstrap time picker -->
 <script src="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js');?>"></script>

 <!-- SlimScroll -->
 <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>

 <!-- iCheck 1.0.1 -->
 <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>

 <!-- FastClick -->
 <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>

 <!-- AdminLTE App -->
 <script src="<?php echo base_url('assets/dist/js/adminlte.min.js');?>"></script>

 <!-- AdminLTE for demo purposes -->
 <script src="<?php echo base_url('assets/dist/js/demo.js');?>"></script>

 <!-- Page script -->
 <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtimestart').daterangepicker({ 
      singleDatePicker: true, 
      timePicker: true, 
      timePickerIncrement: 10, 
      timePicker24Hour : true ,
      startDate: moment('<?php echo $reservation[0]['TIME_START'];?>'),
      locale:{
        format: 'DD/MM/YYYY h:mm A'} 
      })
    $('#reservationtimeend').daterangepicker({ 
      singleDatePicker: true, 
      timePicker: true, 
      timePickerIncrement: 10, 
      timePicker24Hour : true ,
      startDate: moment('<?php echo $reservation[0]['TIME_END'];?>'),
      locale:{
        format: 'DD/MM/YYYY h:mm A'} 
      })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>

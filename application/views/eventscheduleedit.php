  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-family: 'Montserrat', sans-serif;">
        Ubah Jadwal Acara
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
          <h3 class="box-title">Data Jadwal Acara</h3>
        </div>
        <!-- /.box-header -->
        <?php if (isset($reservedroom[0]['ID_RESERVATION'])) { ?>
        <form role="form" name="reservationaddform" action="<?php echo site_url('EventScheduleController/eventScheduleEditHandler/'.$event[0]['ID_EVENT'].'/'.$reservedroom[0]['ID_RESERVATION']);?>" method ="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Acara</label>
                  <input type="text" class="form-control" name="eventname" id="eventname" value="<?php echo $event[0]['EVENTNAME'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Penanggung Jawab</label>
                  <input type="text" class="form-control" name="eventinitiator" id="eventname" value="<?php echo $event[0]['EVENTINITIATOR'];?>">
                </div>

                <div class="form-group">
                  <label>Undangan Pimpinan</label>
                  <input type="hidden" class="form-control" name="" id="daftarundangan">
                  <select class="form-control select2" multiple="multiple" value="" style="width: 100%;" name="pimpinan[]">
                    <?php foreach ($pimpinan as $key) { ?>
                      <option <?php foreach ($undangan as $row) {if($key['id'] == $row['id']){ echo 'selected="selected"';}}?> value="<?php echo $key['id'] ?>"><?php echo $key['nama']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Nomor Telepon Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatornotelp" id="initiatornotelp" value="<?php echo $event[0]['INITIATORNOTELP'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatoremail" id="initiatoremail" value="<?php echo $event[0]['INITIATOREMAIL'];?>">
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Lokasi Acara</label>
                  <select class="form-control select2" name="eventlocation" style="width: 100%;" id="room" onchange="fungsiku()">
                    <option value="Lainnya">Lainnya</option>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option <?php if($row['ID_ROOM'] == $event[0]['ID_ROOM']){ echo 'selected="selected"'; }?> value="<?php echo $row['ID_ROOM'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <input type="text" class="form-control" name="eventlocationlain" id="lain" value="" style="visibility: hidden;">
                </div>

                <!-- <div class="form-group">
                  <label>Lokasi Acara</label>
                  <select class="form-control select2" name="eventlocation" style="width: 100%;">
                    <option selected="selected">-- Pilih Lokasi Acara --</option>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option value="<?php echo $row['ID_ROOM'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div> -->

                <div class="form-group">
                  <label>Deskripsi Acara</label>
                  <textarea class="form-control" name="eventdescription" rows="4" style="resize: none"><?php echo $event[0]['EVENTDESCRIPTION'];?></textarea>
                </div>

                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Keterangan Tambahan</label>
                  <input type="text" class="form-control" name="additionalinfo" id="exampleInputEmail1" placeholder="Masukkan Keterangan Tambahan">
                </div> -->
                
                <div class="form-group">
                  <label>Tanggal dan Waktu Dimulai</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="eventtimestart" class="form-control pull-right" id="reservationtimestart">
                  </div>
                </div>

                <div class="form-group">
                  <label>Tanggal dan Waktu Berakhir</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="eventtimeend" class="form-control pull-right" id="reservationtimeend">
                  </div>
                </div> 

              </div>
              <!-- /.col -->
<!--               <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputFile">Upload Surat Pengantar</label>
                  <input type="file" name="referenceletterpath" id="exampleInputFile">

                  <p class="help-block">Biasanya ditulisin upload pdf atau docx.</p>
                </div>
              </div> -->
              <div class="col-md-12">
                <center>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </center>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
        </form>
        <?php }else{ ?>
        <form role="form" name="reservationaddform" action="<?php echo site_url('EventScheduleController/eventEditHandler/'.$event[0]['ID_EVENT']);?>" method ="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Acara</label>
                  <input type="text" class="form-control" name="eventname" id="eventname" value="<?php echo $event[0]['EVENTNAME'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Penanggung Jawab</label>
                  <input type="text" class="form-control" name="eventinitiator" id="eventname" value="<?php echo $event[0]['EVENTINITIATOR'];?>">
                </div>

                <div class="form-group">
                  <label>Undangan Pimpinan</label>
                  <input type="hidden" class="form-control" name="" id="daftarundangan">
                  <select class="form-control select2" multiple="multiple" value="" style="width: 100%;" name="pimpinan[]">
                    <?php foreach ($pimpinan as $key) { ?>
                      <option <?php foreach ($undangan as $row) {if($key['id'] == $row['id']){ echo 'selected="selected"';}}?> value="<?php echo $key['id'] ?>"><?php echo $key['nama']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Nomor Telepon Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatornotelp" id="initiatornotelp" value="<?php echo $event[0]['INITIATORNOTELP'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatoremail" id="initiatoremail" value="<?php echo $event[0]['INITIATOREMAIL'];?>">
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Lokasi Acara</label>
                  <select class="form-control select2" name="eventlocation" style="width: 100%;" id="room" onchange="fungsiku()">
                    <option value="Lainnya">Lainnya</option>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option <?php if($row['ID_ROOM'] == $event[0]['ID_ROOM']){ echo 'selected="selected"'; }?> value="<?php echo $row['ID_ROOM'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <input type="text" class="form-control" name="eventlocationlain" id="lain" value="" style="visibility: hidden;">
                </div>

                <!-- <div class="form-group">
                  <label>Lokasi Acara</label>
                  <select class="form-control select2" name="eventlocation" style="width: 100%;">
                    <option selected="selected">-- Pilih Lokasi Acara --</option>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option value="<?php echo $row['ID_ROOM'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div> -->

                <div class="form-group">
                  <label>Deskripsi Acara</label>
                  <textarea class="form-control" name="eventdescription" rows="4" style="resize: none"><?php echo $event[0]['EVENTDESCRIPTION'];?></textarea>
                </div>

                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Keterangan Tambahan</label>
                  <input type="text" class="form-control" name="additionalinfo" id="exampleInputEmail1" placeholder="Masukkan Keterangan Tambahan">
                </div> -->
                
                <div class="form-group">
                  <label>Tanggal dan Waktu Dimulai</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="eventtimestart" class="form-control pull-right" id="reservationtimestart">
                  </div>
                </div>

                <div class="form-group">
                  <label>Tanggal dan Waktu Berakhir</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="eventtimeend" class="form-control pull-right" id="reservationtimeend">
                  </div>
                </div> 

              </div>
              <!-- /.col -->
<!--               <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputFile">Upload Surat Pengantar</label>
                  <input type="file" name="referenceletterpath" id="exampleInputFile">

                  <p class="help-block">Biasanya ditulisin upload pdf atau docx.</p>
                </div>
              </div> -->
              <div class="col-md-12">
                <center>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </center>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
        </form>
        <?php } ?>
      </div>
      <!-- /.box -->
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

  
  <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
   <div class="control-sidebar-bg"></div>
 </div>
 <!-- ./wrapper -->
 <script type="text/javascript">
  function fungsiku(){
    var x = document.getElementById("room").value;
    if (x=="Lainnya") {
      document.getElementById("lain").style.visibility="visible";
    }else{
      document.getElementById("lain").style.visibility="hidden";
      document.getElementById("lain").value="";
    }
  }
</script>
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js');?>"></script>

<!-- date-range-picker -->
<script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js');?>"></script>

<script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>

<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>

<!-- bootstrap time picker -->
<script src="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js');?>"></script>

<!-- SlimScroll -->
<script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>

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
      startDate: moment('<?php echo $event[0]['TIME_START'];?>'),
      locale:{
        format: 'DD/MM/YYYY h:mm A'} 
    })
    $('#reservationtimeend').daterangepicker({ 
      singleDatePicker: true, 
      timePicker: true, 
      timePickerIncrement: 10, 
      timePicker24Hour : true ,
      startDate: moment('<?php echo $event[0]['TIME_END'];?>'),
      locale:{
        format: 'DD/MM/YYYY h:mm A'} 
    })

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
</html>

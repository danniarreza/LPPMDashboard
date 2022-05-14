  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-family: 'Montserrat', sans-serif;">
        Tambah Jadwal Acara
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
      <?php if (isset($previousevent)) { ?>
      <!-- <div class="box box-danger">
        <div class="box-header with-border"><h3 style="color: red;">Pinjam Ruang Gagal!</h3></div>
        <div class="box-body">
          <p><?php echo $gagal; ?></p>
          <p>Untuk keperluan acara <?php echo $event ?> !</p>
        </div>
      </div> -->
      <div class="box-body">
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i>Tambah Event Gagal !</h4>
          <?php foreach ($previousevent as $row) {
            ?>
            <p><?php echo "Ruang telah digunakan pada : <br>Tanggal : ".date('d M Y', strtotime($row['TIME_START']))." <br>Jam : ".date('H:i', strtotime($row['TIME_START']))." - ".date('H:i', strtotime($row['TIME_END']))." !"; ?></p>
            <p>Acara : <?php echo $row['EVENTNAME'] ?> !</p>
            <br>
            <?php
          }?>
        </div>
      </div>
    <?php } ?>
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Data Diri Pemohon</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" name="reservationaddform" action="<?php echo site_url('EventScheduleController/eventScheduleAddHandler');?>" method ="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Acara</label>
                  <input type="text" class="form-control" name="eventname" id="eventname" placeholder="Masukkan Nama Acara" value="<?php if(isset($proposedevent)!=null){ echo $proposedevent['eventname']; } ?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Penanggung Jawab</label>
                  <input type="text" class="form-control" name="eventinitiator" id="eventname" placeholder="Masukkan Penanggung Jawab Acara" value="<?php if(isset($proposedevent)!=null){ echo $proposedevent['eventinitiator']; } ?>" required>
                </div>
                <div class="form-group">
                <label>Undang Pimpinan</label>
                <select class="form-control select2" multiple="multiple" data-placeholder="Pimpinan" style="width: 100%;" name="pimpinan[]" required>
                  <?php foreach ($pimpinan as $key) { ?>
                    <option value="<?php echo $key['id'] ?>"><?php echo $key['nama']; ?></option>
                  <?php } ?>
                </select>
              </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nomor Telepon Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatornotelp" id="initiatornotelp" placeholder="Masukkan Nomor Telepon Penanggung Jawab" value="<?php if(isset($proposedevent)!=null){ echo $proposedevent['initiatornotelp']; } ?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Penanggung Jawab Acara</label>
                  <input type="text" class="form-control" name="initiatoremail" id="initiatoremail" placeholder="Masukkan Email Penanggung Jawab" value="<?php if(isset($proposedevent)!=null){ echo $proposedevent['initiatoremail']; } ?>" required>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Lokasi Acara</label>
                  <select class="form-control select2" name="eventlocation[]" multiple="multiple" data-placeholde="Tempat" style="width: 100%;" id="room" onchange="fungsiku()" required>
                    <!-- <option selected="selected">-- Pilih Ruangan yang Diajukan --</option> -->
                    <option value="Lainnya">Lainnya</option>
                    <?php 
                    foreach ($room as $row) {
                      ?>
                      <option value="<?php echo $row['ID_ROOM'];?>" <?php if(isset($proposedevent)!=null){
                        if ($proposedevent['eventlocation']==$row['ID_ROOM']) {
                          echo "selected";
                        }
                      } ?>><?php echo ucwords(strtolower($row['ROOMNAME']));?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <input type="text" class="form-control" name="eventlocationlain" id="lain" placeholder="Masukkan Lokasi Acara" style="visibility: hidden;">
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
                  <label for="">Jumlah Peserta</label>
                  <input type="text" name="attend" class="form-control" value="<?php if(isset($proposedevent)!=null){
                    echo $proposedevent['attend'];
                  } ?>" placeholder="Masukkan Jumlah Peserta" required>
                </div>
                <div class="form-group">
                  <label>Deskripsi Acara</label>
                  <textarea class="form-control" name="eventdescription" rows="4" placeholder="Masukkan Deskripsi Acara" style="resize: none" required></textarea>
                </div>

                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Keterangan Tambahan</label>
                  <input type="text" class="form-control" name="additionalinfo" id="exampleInputEmail1" placeholder="Masukkan Keterangan Tambahan">
                </div> -->
                
                <div class="form-group">
                  <label>Tanggal dan Waktu Pelaksanaan:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="eventtime" class="form-control pull-right" id="reservationtime">
                  </div>
                </div>                
              </div>
              <!-- /.col -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputFile">Upload Surat Pengantar</label>
                  <input type="file" name="referenceletterpath" id="exampleInputFile">

                  <p class="help-block">Biasanya ditulisin upload pdf atau docx.</p>
                </div>
              </div>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
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

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 10, timePicker24Hour : true ,locale:{format: 'DD/MM/YYYY h:mm A'} })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
</html>

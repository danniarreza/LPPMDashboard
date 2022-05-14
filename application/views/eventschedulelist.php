  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-family: 'Montserrat', sans-serif;">
        Daftar Jadwal Acara
        <!-- <small><?php echo $date;?></small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Event</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
                <div class="box-body">
                  <!-- Date -->
                  <div class="form-group">
                    <?php 
                    $d = DateTime::createFromFormat('d F Y', $date);
                    if ($d && $d->format('d F Y')==$date) {
                    ?>
                    <h3 class="col-sm-4">
                      <a href="<?php echo site_url('EventScheduleController/eventScheduleListPage/'.date('Y-m-d', strtotime('-1 day'.$date)))?>">
                        <button class="btn btn-default"><i class="fa fa-angle-left"></i></button>
                      </a>
                      <span style="padding-left: 10px; padding-right: 10px;"><?php echo $date;?></span>
                      <a href="<?php echo site_url('EventScheduleController/eventScheduleListPage/'.date('Y-m-d', strtotime('+1 day'.$date)))?>">
                        <button class="btn btn-default"><i class="fa fa-angle-right"></i></button>
                      </a>
                    </h3>
                    <?php }else{ ?>
                    <h3 class="col-sm-4">
                      <a href="<?php echo site_url('EventScheduleController/eventScheduleListPage/'.date('Y-m', strtotime($date.'-1 month')))?>">
                        <button class="btn btn-default"><i class="fa fa-angle-left"></i></button>
                      </a>
                      <span style="padding-left: 10px; padding-right: 10px;"><?php echo $date;?></span>
                      <a href="<?php echo site_url('EventScheduleController/eventScheduleListPage/'.date('Y-m', strtotime($date.'+1 month')))?>">
                        <button class="btn btn-default"><i class="fa fa-angle-right"></i></button>
                      </a>
                    </h3>
                    <?php } ?>
                    <label class="col-sm-5 control-label" align="right" style="padding-bottom: 5px;">Lihat Jadwal Acara pada Tanggal:</label>
                    <form class="form-horizontal" action="<?php echo site_url('EventScheduleController/eventScheduleListPage/').'searchdate';?>" method ="post">
                    <div class="col-sm-3" style="padding-bottom: 5px;">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="date" class="form-control pull-right" id="datepicker" required>
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                      <!-- /.input group -->
                    </div>
                    </form>
                    <label class="col-sm-5 control-label" align="right">Lihat Jadwal Acara pada Bulan:</label>
                    <form class="form-horizontal" action="<?php echo site_url('EventScheduleController/eventScheduleListPage/').'searchmonth';?>" method ="post">
                    <div class="col-sm-3">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="month" class="form-control pull-right" id="datepickermonth" required>
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                      <!-- /.input group -->
                    </div>
                    </form>
                  </div>
                  <!-- /.form group -->
                  <div class="col-lg-12" style="padding-top: 30px;">
                    <a href="<?php echo site_url('EventScheduleController/printLaporan/'.$printdate) ?>" class="btn btn-success pull-right">Print</a>
                  </div>
                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding table-responsive">
              <!-- <table class="table table-striped table-bordered">
                <tr>
                  <th>Event</th>
                  <?php 
                  $d = DateTime::createFromFormat('F Y', $date);
                  if ($d && $d->format('F Y')==$date) { ?>
                  <th>Tanggal</th>
                  <?php } ?>
                  <?php
                  foreach ($time as $row) {
                    echo "<th>$row</th>";
                  }
                  ?>
                </tr>
                <?php
                if (isset($event)) {
                  foreach ($event as $row) {
                    ?>
                    <tr>
                      <td style="display: none"><?php echo $row['ID_EVENT'];?></td>
                      <th><?php echo $row['EVENTNAME'];?></th>
                      <?php 
                      $d = DateTime::createFromFormat('F Y', $date);
                      if ($d && $d->format('F Y')==$date) { ?>
                      <td><b><?php echo date('d-m-Y', strtotime($row['TIME_START'])) ?></b></td>
                      <?php } ?>
                      <?php
                      for ($i=0; $i < 23; $i++) { 

                        $evTimeBegin = date('H:i', strtotime($row['TIME_START']));
                        $evTimeEnd = date('H:i', strtotime($row['TIME_END']));

                        if (($time[$i] >= $evTimeBegin) && ($time[$i] <= $evTimeEnd)) {
                          echo '<td style="text-align:center"><a title="Lokasi Acara : ';
                          if ($row['ROOMNAME']==null) {
                            echo $row['EVENTLOCATION'];
                          }else{
                            echo $row['ROOMNAME'];
                          }
                          echo ' - Inisiator : '.$row['EVENTINITIATOR'].'" class="label label-danger bg-red" data-toggle="modal" data-target="#modalku'.$row['ID_EVENT'].'">X</a></td>';
                          echo '
                          <div class="modal fade" id="modalku'.$row['ID_EVENT'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">'.$row['EVENTNAME'].'</h4>
                                </div>
                                <div class="modal-body">
                                  <h4>Penanggung Jawab : '.$row['EVENTINITIATOR'].'</h4>
                                  <h4>Lokasi : '.(($row['EVENTLOCATION']==null)?$row['ROOMNAME']:$row['EVENTLOCATION']).'</h4>
                                  <h4>Tanggal : '.date('d-m-Y', strtotime($row['TIME_START'])).'</h4>
                                  <h4>Pukul : '.date('H:i', strtotime($row['TIME_START'])).' - '.date('H:i', strtotime($row['TIME_END'])).'</h4>
                                  <h4>Deskripsi : '.$row['EVENTDESCRIPTION'].'</h4>
                                  <h4>Jumlah Peserta : '.$row['ATTENDANCE'].'</h4>
                                  <h4>File Surat : <a href="'.site_url('EventScheduleController/previewUndangan/'.$row['REFERENCELETTERPATH']).'">download</a></h4><br><br>
                                  <h4>Undangan : <br></h4>';
                                  foreach ($row['UNDANGAN'] as $undangan) {
                                    echo "<h4><i style='margin-right:10px;' class='fa fa-dot-circle-o'></i>".$undangan['nama']."</h4>";
                                  }
                                  echo '
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
                                  if ($_SESSION['level']==2) {
                                   echo '<a href="'.site_url('EventScheduleController/eventScheduleEditPage/'.$row['ID_EVENT']).'" class="btn btn-primary">Ubah</a>';
                                  }
                                echo '</div>
                              </div>
                            </div>
                          </div>';
                        } else {
                          echo '<td style="text-align:center"><a title="" class="label bg-green">V</a></td>';
                        }
                      }
                      ?>
                    </tr>
                    <?php
                  }
                }
                ?>
              </table> -->
              <div class="col-lg-12 table-responsive">
              <table id="listevent" class="display">
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
                    <th style="text-align: center;">Arsip</th>
                    <th style="text-align: center;">Surat</th>
                    <th style="text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $bil=1; foreach ($event as $key) { ?>
                  <tr>
                    <td style="text-align: center;"><?php echo $bil++ ?></td>
                    <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($key['TIME_START'])) ?></td>
                    <td style="text-align: center;"><?php echo $key['EVENTINITIATOR'] ?></td>
                    <td style="text-align: center;"><?php echo $key['EVENTNAME'] ?></td>
                    <td style="text-align: center;"><a href="<?php if($key['EVENTLOCATION']==""){
                      echo "https://maps.google.com/maps?q=".$key['ROOMNAME']." LPPM UB";
                    }else {
                      echo "https://maps.google.com/maps?q=".$key['EVENTLOCATION'];
                    } ?>"><?php if ($key['EVENTLOCATION']=="") {
                      echo $key['ROOMNAME'];
                    }else{
                      echo $key['EVENTLOCATION'];
                    } ?></a></td>
                    <td style="text-align: center;"><?php echo date('H:i', strtotime($key['TIME_START']))." - ".date('H:i', strtotime($key['TIME_END'])) ?></td>
                    <td><?php echo $key['EVENTDESCRIPTION'] ?></td>
                    <td style="text-align: center;"><?php echo $key['ATTENDANCE'] ?></td>
                    <td style="text-align: center;"><a href="<?php echo site_url('EventScheduleController/uploadArchive/'.$key['ID_EVENT']) ?>">Upload</a></td>
                    <td style="text-align: center;"><a href="<?php echo site_url('EventScheduleController/previewUndangan/'.$key['REFERENCELETTERPATH']) ?>">Download</a></td>
                    <td style="text-align: center;"><a href="<?php echo site_url('EventScheduleController/eventScheduleEditPage/'.$key['ID_EVENT'])?>" class="btn btn-primary">Ubah</a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    X.
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

 <!-- jQuery 3 -->
 <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
 <!-- Bootstrap 3.3.7 -->
 <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
 <<!-- Select2 -->
 <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js');?>"></script>
<script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
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

 <!-- iCheck 1.0.1 -->
 <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
 <!-- Slimscroll -->
 <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
 <!-- FastClick -->
 <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>
 <!-- AdminLTE App -->
 <script src="<?php echo base_url('assets/dist/js/adminlte.min.js');?>"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="<?php echo base_url('assets/dist/js/demo.js');?>"></script>

 <script>
      //Date picker
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd MM yyyy'
      });

      $('#datepickermonth').datepicker({
        autoclose: true,
        format : 'MM yyyy'
      });

      $(document).ready(function() {
         $('#listevent').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
              extend: 'excel',
              text: 'Export ke excel',
              title: 'Laporan Jadwal Acara'
            },
            {
              extend: 'pdf',
              text: 'Export ke pdf',
              title: 'Laporan Jadwal Acara'
            }
        ]
         });
       });
    </script>
  </body>
  </html>
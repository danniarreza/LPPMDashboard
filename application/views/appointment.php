
  <style type="text/css">
    .fc-event {
      color: #fff;               /* default TEXT color */
      cursor: default;
      font-weight: bold;
      font-family: 'Nunito', sans-serif;
    }
    #calendar{
      border-radius: 20px;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-family: 'Montserrat', sans-serif; color: #111">
        Agenda
        <small style="color: #111">Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#" style="color: #111"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active" style="color: #111">Calendar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if (isset($cek)) { ?>
      <div class="box-body">
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i>Konfirmasi Agenda Gagal !</h4>
          <?php foreach ($cek as $row) {
            ?>
            <p><?php echo "Pada : <br>Tanggal : ".date('d M Y', strtotime($row['TIME_START']))." ! <br>Jam : ".date('H:i', strtotime($row['TIME_START']))." - ".date('H:i', strtotime($row['TIME_END']))." !"; ?></p>
            <p>Terdapat Agenda</p>
            <p>Agenda : <?php echo $row['TITLE'] ?> !</p>
            <br>
            <?php
          }?>
        </div>
      </div>
    <?php } ?>
      <div class="row">
        <?php if ($_SESSION['level']==1 || $_SESSION['level']==2) { ?>
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title">Tambah Events</h4>
            </div>
            <div class="box-body">
              <!-- the events -->
              <div id="external-events">
                <?php 
                foreach ($listevent->result() as $key) {
                  if ($key->NAME != "Undangan") {
                 ?>
                <div class="btn" style="width: 100%; margin-bottom: 5px; font-weight: bold; font-family: 'Nunito', sans-serif; <?php echo "background-color: ".$key->COLOR.";"; ?> color: #fff;" data-toggle="modal" data-target="<?php echo "#".$key->ID ?>"><?php echo $key->NAME; ?><?php if ($_SESSION['level']==2) { ?><a href="<?php echo site_url('AppointmentController/delete_data_event/'.$key->ID) ?>" style="text-decoration: none; color: #fff;"><button class="btn pull-right" style="background-color: transparent;"><i class="fa fa-times pull-right"></i></button></a>
                <?php 
                }
               ?></div>
                <!-- <div class="btn bg-blue" style="width: 100%; margin-bottom: 5px;" data-toggle="modal" data-target="#ModalRapat4" onclick="<?php $event = "LainLain" ?>">Lain-Lain</div> -->
                <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo $key->ID ?>">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $key->NAME; ?></h4>
                      </div>
                      <div class="modal-body">
                        <form action="<?php echo site_url('AppointmentController/add_event') ?>" method="post">
                        <input type="hidden" name="agenda" value="<?php echo $key->ID ?>">
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" name="agendatitle" class="form-control" placeholder="Masukkan Title">
                        </div>
                        <?php if($_SESSION['level']==2){ ?>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pimpinan</label>
                          <select class="form-control select2" name="pimpinan" style="width: 100%;" id="pimpinan">
                            <option selected="selected">-- Pilih Pimpinan --</option>
                            <?php 
                            foreach ($pimpinan as $row) {
                              ?>
                              <option value="<?php echo $row['id'] ?>"><?php echo $row['nama']; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                          <label>Tanggal:</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" name="agendatime" class="form-control" id="<?php echo "jamevent".$key->ID ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea type="text" name="agendadesc" class="form-control" style="resize: none; text-align: justify;" rows="5" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Lokasi Acara</label>
                          <select class="form-control select2" name="agendalocation" style="width: 100%;" id="room" onchange="<?php $value = "lain" ?>">
                            <option selected="selected">-- Pilih Lokasi --</option>
                            <?php 
                            foreach ($room as $row) {
                              ?>
                              <option value="<?php echo $row['ROOMNAME'];?>"><?php echo $row['ID_ROOM'].'. '.ucwords(strtolower($row['ROOMNAME']));?></option>
                              <?php
                            }
                            ?>
                            <option value="Lainnya">5. Lainnya</option>
                          </select>
                          <input type="text" class="form-control" name="eventlocationlain" id="lain" placeholder="isi jika pilih yang lainnya" style="">
                        </div>
                        <div class="form-group">
                          <label>Repeat</label>
                          <input type="number" min="1" name="repeat" class="form-control" placeholder="Minimal satu">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                      </form>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <?php }} ?>
              </div>
            </div>
          <!-- /.box-body -->
          <!-- /. box -->
          <?php if($_SESSION['level']==2){ ?>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Create Event</h3>
            </div>
            <div class="box-body">
              <form action="<?php echo site_url('AppointmentController/add_data_event') ?>" method="POST">
              <div class="form-group">
                <label>Color picker:</label>
                <input type="text" class="form-control my-colorpicker1" name="color">
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Event Title" name="title">

                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-flat">Add</button>
                </div>
                <!-- /btn-group -->
                </div>
                <!-- /input-group -->
                </form>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
          <!-- /.col -->
          <div class="<?php if($_SESSION['level']==3){ echo "col-md-12"; } else { echo "col-md-9"; } ?>">
            <div class="box box-primary">
              <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /. box -->
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
      reserved.
    </footer>


  <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
   <div class="control-sidebar-bg"></div>
 </div>
 <!-- ./wrapper -->
 <!-- jQuery 3 -->
 <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>

 <!-- Bootstrap 3.3.7 -->
 <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="<?php echo base_url('assets/bower_components/jquery-ui/jquery-ui.min.js');?>"></script>

 <script src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
 <!-- Slimscroll -->
 <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
 <!-- FastClick -->
 <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>
 <script src="<?php echo base_url('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'); ?>"></script>
 <!-- AdminLTE App -->
 <script src="<?php echo base_url('assets/dist/js/adminlte.min.js');?>"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="<?php echo base_url('assets/dist/js/demo.js');?>"></script>
 <!-- fullCalendar -->
 <script src="<?php echo base_url('assets/bower_components/moment/moment.js');?>"></script>
 <script src="<?php echo base_url('assets/bower_components/fullcalendar/dist/fullcalendar.min.js');?>"></script>
 <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js');?>"></script>
 <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
 <script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>

 <script>
  $(function () {
    $('.select2').select2()
      //Date picker
      $('#datepicker').datepicker({
        autoclose: false,
        format: 'dd MM yyyy'
      });

      $('.my-colorpicker1').colorpicker();

      $('#datepickera').datepicker({
        autoclose: false,
        format: 'dd MM yyyy'
      });

      <?php foreach ($listevent->result() as $key) { ?>
      $('<?php echo "#jamevent".$key->ID ?>').daterangepicker({ timePicker: true, timePickerIncrement: 10, timePicker24Hour : true ,locale:{format: 'DD/MM/YYYY h:mm A'} })
      <?php } ?>
    })
  </script>
  <script>
    $(function () {

    /* initialize the external events
    -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
    -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
    $m    = date.getMonth(),
    $y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : [
      <?php foreach ($schedule as $key) { ?>
        {
          title          : '<?php if($key->STATUS=="Ditolak"){ echo "Agenda Ditolak";}else{echo $key->TITLE;} ?>',
          start          : '<?php echo $key->tanggal_mulai ?>',
          end            : '<?php 
          echo $key->tanggal_end;
          ?>',
          allDay : false,
          backgroundColor: '<?php if ($key->STATUS=="Request") { echo "grey"; } else if ($key->STATUS=="Confirmed") {
            echo $key->WARNA;
          }else{ echo "black";} ?>',
          url            : '<?php echo site_url("AppointmentController/detailEvent/").$key->ID_AGENDA ?>'
        },
        <?php } ?>
        ],
        editable  : false,
        droppable : false, // this allows things to be dropped onto the calendar !!!
      })

    // eventDrop: function(event, delta, revertFunc) {
    //   alert(event.title + " - " + event.tanggal_mulai.format());
    // }
    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
<script type="text/javascript">
  function fungsiku(){
    var x = document.getElementById("room").value;
    if (x=="Lainnya") {
      document.getElementById("lain").style.visibility="visible";
    }else{
      document.getElementById("lain").style.visibility="hidden";
    }
  }
</script>
<script>
  function fetchdata(){
   $.ajax({
    url: '<?php echo site_url('AppointmentController/reminder') ?>',
    type: 'post',
    success: function(response){
     if (response=="ada") {
      alert(response);
     }
    }
   });
  }

$(document).ready(function(){
 setInterval(fetchdata,60000);
});
</script>
</body>
</html>

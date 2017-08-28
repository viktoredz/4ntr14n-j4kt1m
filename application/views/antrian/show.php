<!-- Info boxes -->
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <a href="<?php echo base_url();?>antrian/pasien">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Data Pasien</span>
        <span class="info-box-number">{pbk}</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-4 col-sm-6 col-xs-12">
    <a href="#" onclick="window.open('<?php echo base_url();?>antrian/tv', 'newwindow', 'menubar=no,location=no,resizable=no,scrollbars=no,fullscreen=yes, scrollbars=auto'); return false;">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-sort-numeric-asc"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">ANTRIAN</span>
        <span class="info-box-number">TV<BR>Screen</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-4 col-sm-6 col-xs-12">
    <a href="#" onclick="window.open('<?php echo base_url();?>antrian/kiosk', 'newwindow', 'menubar=no,location=no,resizable=no,scrollbars=no,fullscreen=yes, scrollbars=auto'); return false;">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fa fa-tv"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">KIOSK</span>
        <span class="info-box-number">Full<BR>Screen</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-4 col-sm-6 col-xs-12">
    <a href="<?php echo base_url();?>poli">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-qrcode"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">POLI LAYANAN</span>
        <span class="info-box-number"><?php echo count($poli)?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-4 col-sm-6 col-xs-12">
    <a href="#" onclick="window.open('<?php echo base_url();?>testimoni/fullscreen', 'newwindow', 'menubar=no,location=no,resizable=no,scrollbars=no,fullscreen=yes, scrollbars=auto'); return false;">
    <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-comments"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">TESTIMONI PASIEN</span>
        <span class="info-box-number"><i class="fa fa-thumbs-up"></i> {testimoni_up}</span>
        <span class="info-box-number"><i class="fa fa-thumbs-o-down"></i> {testimoni_down}</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-4 col-sm-6 col-xs-12">
    <input type="hidden" name="status_panggilan" value="0">
    <input type="hidden" name="status_panggilan_interval">
    <input type="hidden" name="status_loket" value="0">
    <input type="hidden" name="status_loket_interval">
    <input type="hidden" name="last_no" value="0">
    <a href="#" id="toogle_sound">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-bullhorn"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">PANGGILAN</span>
        <span class="info-box-number">Auto<BR>Sound</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Panggilan </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body" id="panggilan" style="text-align:center;min-height:245px">
          <div style="font-size:70px;margin-top:20px;color:red">
            <i class="fa fa-volume-off"></i>
          </div>
          <label>Auto Sound<br>Not Running</label>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->

  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Antrian Loket </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
        <div class="box-body" id="loket" style="text-align:center;min-height:245px">
          <div style="font-size:70px;margin-top:20px;color:red">
            <i class="fa fa-volume-off"></i>
          </div>
          <label>Antrian Loket<br>Not Running</label>
        </div><!-- /.box-body -->
    </div>
  </div><!-- /.row -->

  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Antrian Pasien </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body" id="antrian">
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->

<div id="popup_info" style="display:none;">
  <div id="popup_info_title">eClinic</div>
  <div id="popup_info_content">
    <div style='text-align:center'><br>
      <br>
      <div id="info-res"></div>
      <br>
      <button class='btn btn-md btn-success' id="btn-reset-ok"><i class="fa fa-thumbs-up"></i> OK</button>
    </div>
  </div>
</div>

<div id="popup" style="display:none;">
  <div id="popup_title">eClinic</div>
  <div id="popup_content">
    <div style='text-align:center'><br>
      <button class='btn btn-md btn-success' id="btn-on"><i class="fa fa-volume-up"></i> Panggilan On</button>
      <button class='btn btn-md btn-warning' id="btn-off"><i class="fa fa-volume-off"></i> Panggilan Off</button>
      <br>
      <br>
      <button class='btn btn-md btn-danger' id="btn-reset-call"><i class="fa fa-recycle"></i> Reset Panggilan</button>
      <hr>
      <button class='btn btn-md btn-success' id="btn-loketon"><i class="fa fa-volume-up"></i> Loket On</button>
      <button class='btn btn-md btn-warning' id="btn-loketoff"><i class="fa fa-volume-off"></i> Loket Off</button>
    </div>
  </div>
</div>

<div id="popup_loket" style="display:none;">
  <div id="popuploket_title">eClinic</div>
  <div id="popuploket_content">
    <div style='text-align:center;font-weight:bold;font-size:18px;color:#555555;padding:10px' id="nomor_loket"></div>
    <input type='hidden' name='nomor_loket'>
    <div style='text-align:center;padding-top:10px'>
      <button class='btn btn-md btn-success' name="btn-loket-call" id="1"><i class="fa fa-volume-up"></i> Panggil Loket <b>1</b></button>
      <button class='btn btn-md btn-success' name="btn-loket-call" id="2"><i class="fa fa-volume-up"></i> Panggil Loket <b>2</b></button>
    </div>
    <div style='text-align:center;padding-top:10px'>
      <button class='btn btn-md btn-success' name="btn-loket-call" id="3"><i class="fa fa-volume-up"></i> Panggil Loket <b>3</b></button>
      <button class='btn btn-md btn-success' name="btn-loket-call" id="4"><i class="fa fa-volume-up"></i> Panggil Loket <b>4</b></button>
    </div>
    <div style='text-align:center;padding-top:10px'>
      <button class='btn btn-md btn-success' name="btn-loket-call" id="5"><i class="fa fa-volume-up"></i> Panggil Loket <b>5</b></button>
      <button class='btn btn-md btn-danger' id="btn-loket-done"><i class="fa fa-stop"></i> Selesai</button>
    </div>
  </div>
</div>

<!-- Main row -->
<script>
  // request permission on page load
  document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
      alert('Desktop notifications not available in your browser. Try Chromium.'); 
      return;
    }

    if (Notification.permission !== "granted")
      Notification.requestPermission();
  });

  function notifyMe(nomor) {
    if (Notification.permission !== "granted")
      Notification.requestPermission();
    else {
      var notification = new Notification('infoKes - eAntrian', {
        icon: '<?php echo base_url()?>public/themes/sik/dist/img/logo.png',
        body: "Antrian loket pasien baru ! \nNomor : "+nomor,
      });

      var audioElement = document.createElement('audio');
      audioElement.setAttribute('src', "<?php echo base_url()?>public/sound/notif.wav");
      audioElement.setAttribute('autoplay', 'autoplay');
      audioElement.play();


      notification.onclick = function () {
        window.focus();
      };

    }

  }



  $(function () { 
    $("#menu_dashboard").addClass("active");
    $("#menu_morganisasi").addClass("active");

    $("#popup_info").jqxWindow({
      theme: theme, resizable: false,
      width: 300,
      height: 150,
      isModal: true, autoOpen: false, modalOpacity: 0.4
    });

    $("#popup").jqxWindow({
      theme: theme, resizable: false,
      width: 300,
      height: 240,
      isModal: true, autoOpen: false, modalOpacity: 0.4
    });

    $("#popup_loket").jqxWindow({
      theme: theme, resizable: false,
      width: 320,
      height: 240,
      isModal: true, autoOpen: false, modalOpacity: 0.4
    });

    $("#toogle_sound").click(function(){
      $("#popup").jqxWindow('open');
    });

    $("#btn-on").click(function(){
        panggilan(1);
        $("[name='status_panggilan']").val(1);
        close_popup();
    });

    $("#btn-off").click(function(){
        panggilan(0);
        $("[name='status_panggilan']").val(0);
        close_popup();
    });

    $("#btn-loketon").click(function(){
        loket(1);
        close_popup();
    });

    $("#btn-loketoff").click(function(){
        loket(0);
        close_popup();
    });

    $("#btn-reset-ok").click(function(){
        $("#popup_info").jqxWindow('close');
        panggilan(1);
        $("[name='status_panggilan']").val(1);
    });

    $("#btn-reset-call").click(function(){
        close_popup();

        $.get("<?php echo base_url()?>morganisasi/panggilan_reset", function(res){
          $("#info-res").html(res);
          $("#popup_info").jqxWindow('open');
        });
    });

    $.get("<?php echo base_url()?>morganisasi/antrian", function(res){
      $("#antrian").html(res);
    });

    setInterval( function() {
      $.get("<?php echo base_url()?>morganisasi/antrian", function(res){
        $("#antrian").html(res);
      });
     },5000);

  });

  $("[name='btn-loket-call']").click(function(){
    var loket = $(this).attr('id');

    $(this).attr('class','btn btn-warning');
    $(this).html("<i class='fa fa-volume-down'></i> Memanggil");
    var no = $("[name='nomor_loket']").val();
    $.get("<?php echo base_url()?>morganisasi/loket_call/"+no+"/"+loket, function(res){
      setTimeout("return_text("+loket+")",3000);
    });
  });
  
  $("#btn-loket-done").click(function(){
    $.get("<?php echo base_url()?>morganisasi/loket/1", function(res){
      $("#loket").html(res);
    });

    var no = $("[name='nomor_loket']").val();
    $.get("<?php echo base_url()?>morganisasi/loket_done/"+no, function(res){
      close_popup_loket();
    });


  });

  function return_text(no){
    var text  = "<i class='fa fa-volume-up'></i> Panggil Loket <b>"+ no +"</b>";

    $("[name='btn-loket-call']").each(function(){
      if($(this).attr('id') == no){
        $(this).html(text);
      }
    });
  }

  function panggilan(status){
    if(status==1){
      $.get("<?php echo base_url()?>morganisasi/panggilan/1", function(res){
        $("#panggilan").html(res);
      });

      var panggilanLoop = setInterval( function() {
        $.get("<?php echo base_url()?>morganisasi/panggilan/1", function(res){
          $("#panggilan").html(res);
        });
       },6000);
      $("[name='status_panggilan_interval']").val(panggilanLoop);

    }else{
      clearInterval($("[name='status_panggilan_interval']").val());
      $.get("<?php echo base_url()?>morganisasi/panggilan/0", function(res){
        $("#panggilan").html(res);
      });
    }
  }

  function loket(status){
    if(status==1){
      $.get("<?php echo base_url()?>morganisasi/loket/1", function(res){
        $("#loket").html(res);
      });

      var loketLoop = setInterval( function() {
        $.get("<?php echo base_url()?>morganisasi/loket_last_no", function(res){
          var last_no = $("[name='last_no']").val();
          if(res > last_no){
            notifyMe(res);
          }
          $("[name='last_no']").val(res);
        });

        $.get("<?php echo base_url()?>morganisasi/loket/1", function(res){
          $("#loket").html(res);
        });

       },3000);
      $("[name='status_loket_interval']").val(loketLoop);

    }else{
      clearInterval($("[name='status_loket_interval']").val());
      $.get("<?php echo base_url()?>morganisasi/loket/0", function(res){
        $("#loket").html(res);
      });
    }
  }

  function popup_loket(no){
    $("#nomor_loket").html('Antrian Loket : '+no);
    $("[name='nomor_loket']").val(no);
    $("#popup_loket").jqxWindow('open');
  }

  function close_popup_loket(){
    $("#popup_loket").jqxWindow('close');
  }  

  function close_popup(){
    $("#popup").jqxWindow('close');
  }  
</script>

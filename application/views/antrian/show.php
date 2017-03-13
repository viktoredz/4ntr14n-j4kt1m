<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
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
  <div class="col-md-3 col-sm-6 col-xs-12">
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

  <div class="col-md-3 col-sm-6 col-xs-12">
    <input type="hidden" name="status_panggilan" value="0">
    <input type="hidden" name="status_panggilan_interval">
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
  <div class="col-md-3 col-sm-6 col-xs-12">
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
</div><!-- /.row -->

<div class="row">
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
        <h3 class="box-title">Daftar Poli </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
          <?php foreach ($poli as $rows) {
          ?>
            <div class="col-md-12">
              <label><?php echo $rows['value']?></label> 
            </div>
          <?php
          }?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->

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

    </div>
  </div>
</div>
<!-- Main row -->
<script>
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
      height: 150,
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

  function close_popup(){
    $("#popup").jqxWindow('close');
  }  
</script>

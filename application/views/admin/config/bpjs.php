<section class="content">
<form method="POST" name="frmUsers">
  <div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="alert alert-warning alert-dismissable" style="margin:15px;display:none" id="result">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4>  <i class="icon fa fa-check"></i> Information!</h4>
            <span id="result_content"></span>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" name="bpjs_username" id="bpjs_username" placeholder="Username" value="<?php 
            if(set_value('bpjs_username')=="" && isset($bpjs_username)){
              echo $bpjs_username;
            }else{
              echo  set_value('bpjs_username');
            }
            ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="password" class="form-control" name="bpjs_password"  id="bpjs_password" placeholder="Password" value="<?php 
            if(set_value('bpjs_password')=="" && isset($bpjs_password)){
              echo $bpjs_password;
            }else{
              echo  set_value('bpjs_password');
            }
            ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Cons ID</label>
              <input type="text" class="form-control" name="bpjs_consid" id="bpjs_consid" placeholder="Cons ID" value="<?php 
            if(set_value('bpjs_consid')=="" && isset($bpjs_consid)){
              echo $bpjs_consid;
            }else{
              echo  set_value('bpjs_consid');
            }
            ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Secret Key</label>
              <input type="text" class="form-control" name="bpjs_secret" id="bpjs_secret" placeholder="Secret Key" value="<?php 
            if(set_value('bpjs_secret')=="" && isset($bpjs_secret)){
              echo $bpjs_secret;
            }else{
              echo  set_value('bpjs_secret');
            }
            ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Status Cek BPJS</label>
              <select  name="bpjs_status" id="bpjs_status" class="form-control">
                    <option value="0" <?php echo ($bpjs_status==0 ? "selected":"") ?>>Tidak</option>
                    <option value="1" <?php echo ($bpjs_status==1 ? "selected":"") ?>>Ya</option>
              </select>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <div style="float: right;">
            <button type="button" id="btn-adds" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Reset</button>
            </div>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>

<script>
	$(function () {	
		$("#menu_bpjs").addClass("active");
		$("#menu_admin_panel").addClass("active");

    function saved (){
      var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('bpjs_username', $("[name='bpjs_username']").val());
        data.append('bpjs_password', $("[name='bpjs_password']").val());
        data.append('bpjs_consid', $("[name='bpjs_consid']").val());
        data.append('bpjs_secret', $("[name='bpjs_secret']").val());
        data.append('bpjs_status', $("[name='bpjs_status']").val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()?>bpjs/update',
            data : data,
            success : function(response){
                $('#result').show();
                $('#result_content').html(response);
            }
        });

        return false;
    }
    
  $('#btn-adds').click(function(){
     saved();
  });
});
</script>

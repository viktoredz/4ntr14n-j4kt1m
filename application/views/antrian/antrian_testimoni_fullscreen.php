
<section  style="padding:50px">
	<div class="box-header">
	  <h3 class="box-title"><i class="fa fa-comments"></i>  {title_form}</h3>
	</div><!-- /.box-header -->
	<div id="notice-content" >
		<div style="text-align:center; margin-bottom: 40px;color:white;font-size:20px " id="notice"></div>
	</div>
<form method="POST" id="form-ss">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
          <div class="box-body">
            <div class="form-group">
              <label>- SILAHKAN TULISKAN KESAN DAN PESAN ATAU KRITIK DAN SARAN ANDA -</label>
              <textarea class="form-control" placeholder="Konten" name="content" style="height: 180px;font-size:22px" id="konten"></textarea>
            </div>
          </div>
          <div class="box-footer pull-center">
          	<input type="hidden" name="status" id="status">
            <button type="button" name="puas" class="btn-lg btn-warning" style="width:200px"><i class="fa fa-thumbs-up"></i> PUAS</button>
            <button type="button" name="tidak" class="btn-lg btn-danger" style="width:200px">TIDAK PUAS <i class="fa fa-thumbs-o-down"></i> </button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>
<script type="text/javascript">
  $(function () {
		$('#notice').hide();
    	$("[name='puas']").click(function(){
			$('#status').val('puas');
			$('#form-ss').submit();
    	});

    	$("[name='tidak']").click(function(){
			$('#status').val('tidak');
			$('#form-ss').submit();
    	});

		$('#form-ss').submit(function(f){
			  f.preventDefault();
				var x = $('#konten').val();
				if(x == ''){
					$('#konten').css('border','1px red solid');
					return false;
				}else{
					$('#konten').css('border','none');
				}
        		var data = $(this).serialize();
				var url = '<?php echo base_url() . "testimoni/submit_testimoni/"; ?>';
				$.post(url, data, function(res){
					console.log(res);
					if(res == "OK"){
						$('#notice').html('<img width="50" src="<?php echo base_url();?>media/images/sign-check.png" alt="loading content.. "><br>Terimakasih, pesan anda telah kami terima!');
					}else{
						$('#notice').html('<img width="50" src="<?php echo base_url();?>media/images/sign-error.png" alt="loading content.. "><br>Error!');
					}
					$('#form-ss').hide();
					$('#konten').val('');
					$('#notice').show('fade');
					setTimeout(function(){ $('#notice').hide(); }, 1300);
					setTimeout(function(){ $('#form-ss').show('fade'); }, 1300);
				});
    	});

  });
</script>

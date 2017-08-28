<section class="content">
	<div id="notice-content">
		<div id="notice"></div>
	</div>
<form method="POST" id="form-ss">
  <div class="row">
    <!-- left column -->

    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div><!-- /.box-header -->
          <div class="box-body">
            <input type="hidden" value="{id}" name="id">
            <div class="form-group">
              <b>Tanggal :</b> {waktu}
            </div>
            <div class="form-group">
              <b>Status :</b> <?php echo ($status == 'puas') ? 'Puas':'Tidak Puas'; ?>
            </div>
            <div class="form-group">
              <textarea readonly class="form-control" placeholder="Konten" name="content" style="height: 140px;">{content}</textarea>
            </div>
          </div>
          <div class="box-footer pull-right">
            <button id="btn-close" class="btn btn-warning">Tutup</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>
<script type="text/javascript">
  $(function () {

    $("#btn-close").click(function(e){
			e.preventDefault();
      close_popup();
    });

  });
</script>

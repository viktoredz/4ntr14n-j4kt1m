<div id="popup" style="display:none;">
  <div id="popup_title">eClinic</div><div id="popup_content">{popup}</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>mst/agama/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			</div>
	    </div>
	  </div>
	</div>
  </div>
</form>
</section>

<script type="text/javascript">
	$(function () {	
		$("#menu_hot_antrian").addClass("active");
		$("#menu_dashboard").addClass("active");
		$("#popup").jqxWindow({
			theme: theme, resizable: false,
			width: 250,
			height: 150,
			isModal: true, autoOpen: false, modalOpacity: 0.4
		});
	});

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_kunjungan', type: 'string'},
			{ name: 'urut', type: 'string'},
			{ name: 'tgl', type: 'string'},
			{ name: 'waktu', type: 'string'},
			{ name: 'username', type: 'string'},
			{ name: 'jk', type: 'string'},
			{ name: 'usia', type: 'int'},
			{ name: 'nama', type: 'string'},
			{ name: 'phone_number', type: 'string'},
			{ name: 'status_antri', type: 'string'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('hot/antrian/json_pasien'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$('#btn-refresh').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});

		$("#jqxgrid").jqxGrid(
		{		
			width: '100%', autoheight: true,autorowheight: true,
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: false, filterable: false, sortable: false, autoheight: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'No', align: 'center', width: '25%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					return "<div style='width:100%;padding:7px;text-align:center'><br>"+dataRecord.urut+"<br></div>";
                 }
                },				

                { text: 'Nama', datafield: 'nama', align: 'center', width: '75%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					return "<div style='width:100%;padding:7px;'>"+dataRecord.nama+" / "+dataRecord.jk+" / "+dataRecord.usia+" Tahun"+"</div>";
                 }
                }
            ]
		});

	function close_popup(){
        $("#popup").jqxWindow('close');
        $("#jqxgrid").jqxGrid('clearselection');
    }
</script>

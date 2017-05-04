<div style="font-size:70px;color:green">
	<i class="fa fa-volume-up"></i>
</div>

<?php 
foreach ($loket as $dt) {
?>
	<div style="text-align:center;padding-bottom:4px">
	  <button onClick="popup_loket('<?php echo $dt['no']?>')" class="btn <?php echo ($dt['status']==0) ? "btn-success" : "btn-warning" ?>"> <i class="fa fa-volume-up"></i> &nbsp; Antrian : <b><?php echo $dt['no']?></b></button>
	</div>
<?php }?>

<?php
	$Company = $this->Company_model->GetByID(array('company_id' => $_GET['company_id']));
	$WidgetType = (isset($_GET['widget_type'])) ? $_GET['widget_type'] : 'rental';
	if (count($Company) == 0) {
		echo 'Perusahaan tidak ditemukan.';
		exit;
	}
?>

<?php $this->load->view( 'common/meta' ); ?>

<body class="ptrn_e menu_hover">
	<div id="loading_layer" style="display:none"><img src="<?php echo $this->config->item('base_url'); ?>/static/img/ajax_loader.gif" alt="" /></div>
	
	<div id="WindowWidget" class="modal" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header"><h3>Reservasi <?php echo ucfirst($WidgetType); ?> Online</h3></div>
		<div class="modal-body" style="max-height: 600px;">
			<form class="form-horizontal">
				<input type="hidden" name="company_id" value="<?php echo $Company['company_id']; ?>" />
				<input type="hidden" name="jenis" value="<?php echo $WidgetType; ?>" />
				<div class="control-group">
					<label class="control-label">Tujuan Reservasi</label>
					<div class="controls"><input type="text" name="tujuan" placeholder="Tujuan Reservasi" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Tanggal Reservasi</label>
					<div class="controls"><input type="text" name="tanggal" placeholder="Tanggal Reservasi" class="datepicker" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Nama Pelanggan</label>
					<div class="controls"><input type="text" name="nama" placeholder="Nama Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Mobile</label>
					<div class="controls"><input type="text" name="mobile" placeholder="No HP" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls"><input type="text" name="email" placeholder="Email" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Alamat</label>
					<div class="controls"><input type="text" name="alamat" placeholder="Alamat" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Catatan</label>
					<div class="controls"><input type="text" name="catatan" placeholder="Catatan" /></div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn WindowWidgetClose">Batal</a>
			<a href="#" class="btn WindowWidgetSave btn-primary">OK</a>
		</div>
	</div>
	
	<?php $this->load->view( 'common/js' ); ?>
	
	<script>
		$(function () {
			setTimeout('$("html").removeClass("js")', 100);
			
			$('.WindowWidgetClose').click(function() {
				$('#WindowWidget form').each(function(){ this.reset(); });
			});
			$('.WindowWidgetSave').click(function() {
				if (! $('#WindowWidget form').valid()) {
					return;
				}
				
				var ParamAjax = Site.Form.GetValue('WindowWidget form');
				ParamAjax.Action = 'UpdateWidgetReservasi';
				ParamAjax.tanggal = Func.SwapDate(ParamAjax.tanggal);
				
				$.ajax({
					type: "POST", url: Web.HOST + '/index.php/widget/reservasi/action', data: ParamAjax
				}).done(function( RawResult ) {
					eval('var Result = ' + RawResult);
					
					if (Result.QueryStatus == 1) {
						$('#WindowWidget form').each(function(){ this.reset(); });
					}
					
					// Update Result
					$('.alert').remove();
					var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>' + Result.Message + '</div>';
					$('#WindowWidget form').prepend(Content);
				});	
			});
			
			Func.InitForm({
				Container: '#WindowWidget',
				rule: {
					jenis: { required: true }, tujuan: { required: true }, tanggal: { required: true }, nama: { required: true },
					mobile: { required: true }, alamat: { required: true }
				}
			});
		})
	</script>
</body>
</html>
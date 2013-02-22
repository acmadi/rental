<div id="CntTravelReport" class="row-fluid">
	<button class="btn btn-large btn-block ShowSummaryReport" type="button">Laporan Umum</button>
	<button class="btn btn-large btn-block ShowDetailReport" type="button">Laporan Detail</button>
	
	<div id="SummaryReport" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Laporan Umum</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="input_date_start">Tanggal Mulai</label>
					<div class="controls"><input type="text" id="input_date_start" class="datepicker" name="date_start" placeholder="Tanggal Mulai" rel="twipsy" data-placement="right" data-original-title="Tanggal Mulai" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_date_end">Tanggal Selesai</label>
					<div class="controls"><input type="text" id="input_date_end" class="datepicker" name="date_end" placeholder="Tanggal Selesai" rel="twipsy" data-placement="right" data-original-title="Tanggal Selesai" /></div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large SummaryReportClose">Cancel</a>
			<a href="#" class="btn btn-large SummaryReportSave btn-primary">Ok</a>
		</div>
	</div>
	
	<div id="DetailReport" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Laporan Detail</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="input_date_start">Tanggal Mulai</label>
					<div class="controls"><input type="text" id="input_date_start" class="datepicker" name="date_start" placeholder="Tanggal Mulai" rel="twipsy" data-placement="right" data-original-title="Tanggal Mulai" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_date_end">Tanggal Selesai</label>
					<div class="controls"><input type="text" id="input_date_end" class="datepicker" name="date_end" placeholder="Tanggal Selesai" rel="twipsy" data-placement="right" data-original-title="Tanggal Selesai" /></div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large DetailReportClose">Cancel</a>
			<a href="#" class="btn btn-large DetailReportSave btn-primary">Ok</a>
		</div>
	</div>
</div>

<script>
	// Summary Report
	$('#CntTravelReport .ShowSummaryReport').click(function() {
		$('#CntTravelReport #SummaryReport').modal();
	});
	$('#CntTravelReport .SummaryReportSave').click(function() {
		if (! $('#CntTravelReport #SummaryReport form').valid()) {
			return;
		}
		
		var date_start = $('#CntTravelReport #SummaryReport input[name="date_start"]').val();
		var date_end = $('#CntTravelReport #SummaryReport input[name="date_end"]').val();
		window.open(Web.HOST + '/index.php/rental/view/travel_summary/?date_start=' + date_start + '&date_end=' + date_end);
	});
	$('#CntTravelReport .SummaryReportClose').click(function() {
		$('#CntTravelReport #SummaryReport').modal('hide');
	});
	Func.InitForm({
		Container: '#CntTravelReport #SummaryReport',
		rule: { date_start: { required: true }, date_end: { required: true } }
	});
	
	// Detail Report
	$('#CntTravelReport .ShowDetailReport').click(function() {
		$('#CntTravelReport #DetailReport').modal();
	});
	$('#CntTravelReport .DetailReportSave').click(function() {
		if (! $('#CntTravelReport #DetailReport form').valid()) {
			return;
		}
		
		var date_start = $('#CntTravelReport #DetailReport input[name="date_start"]').val();
		var date_end = $('#CntTravelReport #DetailReport input[name="date_end"]').val();
		window.open(Web.HOST + '/index.php/rental/view/travel_detail/?date_start=' + date_start + '&date_end=' + date_end);
	});
	$('#CntTravelReport .DetailReportClose').click(function() {
		$('#CntTravelReport #DetailReport').modal('hide');
	});
	Func.InitForm({
		Container: '#CntTravelReport #DetailReport',
		rule: { date_start: { required: true }, date_end: { required: true } }
	});
</script>
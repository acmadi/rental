<?php
	$company_id = $this->User_model->GetCompanyID();
	
	$ParamSchedule = array(
		'limit' => 1000, 'company_id' => $company_id,
		'filter' => '[{"type":"date","comparison":"gt","value":"' . date("m/d/Y", strtotime('-7 day')) . '","field":"Schedule.schedule_date"}]',
		'sort' => '[{"property":"schedule_date","direction":"ASC"},{"property":"roster_dest","direction":"ASC"},{"property":"schedule_depature","direction":"ASC"}]'
	);
	$ArraySchedule = $this->Schedule_model->GetArray($ParamSchedule);
	$ArrayReservasiStatus = $this->Reservasi_Status_model->GetArray(array('limit' => 1000));
?>
<div id="CntReservasi" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="roster_dest">Tujuan</option>
				<option value="schedule_depature">Berangkat</option>
				<option value="customer_name">Pelanggan</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-sprocket_dark"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		
		<button class="btn btn-large WindowReservasiAdd">Tambah Reservasi</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowReservasi" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Reservasi</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="reservasi_id" value="0" />
				<div class="control-group">
					<label class="control-label">Jadwal</label>
					<div class="controls">
						<select name="schedule_id" class="span10" rel="twipsy" data-placement="right" data-original-title="Jadwal Keberangkatan">
							<?php echo ShowOption(array('Array' => $ArraySchedule, 'ArrayID' => 'schedule_id', 'ArrayTitle' => 'schedule_title')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_name">Nama Pelanggan</label>
					<div class="controls"><input type="text" id="input_customer_name" name="customer_name" placeholder="Nama Pelanggan" class="span10" rel="twipsy" data-placement="right" data-original-title="Nama Lengkap Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_address">Alamat</label>
					<div class="controls">
						<textarea id="input_customer_address" name="customer_address" placeholder="Alamat" rows="3" cols="30" class="span10" rel="twipsy" data-placement="right" data-original-title="Alamat Pelanggan"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_phone">Telepon</label>
					<div class="controls"><input type="text" id="input_customer_phone" name="customer_phone" placeholder="Telepon" class="span10" rel="twipsy" data-placement="right" data-original-title="Telepon Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_reservasi_capacity">Kapasitas</label>
					<div class="controls"><input type="text" id="input_reservasi_capacity" name="reservasi_capacity" placeholder="Kapasitas" class="span10" rel="twipsy" data-placement="right" data-original-title="Jumlah Kapasitas yang dipesan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_reservasi_price">Harga</label>
					<div class="controls"><input type="text" id="input_reservasi_price" name="reservasi_price" placeholder="Harga" class="span10" rel="twipsy" data-placement="right" data-original-title="Harga Satuan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_reservasi_total">Total</label>
					<div class="controls"><input type="text" id="input_reservasi_total" name="reservasi_total" placeholder="Total" class="span10" rel="twipsy" data-placement="right" data-original-title="Harga Total" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_reservasi_note">Catatan</label>
					<div class="controls"><input type="text" id="input_reservasi_note" name="reservasi_note" placeholder="Catatan" class="span10" rel="twipsy" data-placement="right" data-original-title="Catatan Reservasi" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Status</label>
					<div class="controls">
						<select name="reservasi_status_id">
							<?php echo ShowOption(array('Array' => $ArrayReservasiStatus, 'ArrayID' => 'reservasi_status_id', 'ArrayTitle' => 'reservasi_status_name')); ?>
						</select>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowReservasiClose">Cancel</a>
			<a href="#" class="btn btn-large WindowReservasiSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntReservasi input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntReservasi input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntReservasi input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"customer_name","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/reservasi/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntReservasi .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntReservasi .WindowReservasiEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowReservasi input[name="reservasi_id"]').val(Record.reservasi_id);
				$('#WindowReservasi input[name="customer_name"]').val(Record.customer_name);
				$('#WindowReservasi input[name="customer_phone"]').val(Record.customer_phone);
				$('#WindowReservasi input[name="reservasi_capacity"]').val(Record.reservasi_capacity);
				$('#WindowReservasi input[name="reservasi_price"]').val(Record.reservasi_price);
				$('#WindowReservasi input[name="reservasi_total"]').val(Record.reservasi_total);
				$('#WindowReservasi input[name="reservasi_note"]').val(Record.reservasi_note);
				$('#WindowReservasi select[name="schedule_id"]').val(Record.schedule_id);
				$('#WindowReservasi select[name="reservasi_status_id"]').val(Record.reservasi_status_id);
				$('#WindowReservasi textarea[name="customer_address"]').val(Record.customer_address);
				$('#WindowReservasi').modal();
			});
			$('#CntReservasi .WindowReservasiDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleReservasiByID', reservasi_id: Record.reservasi_id },
					Url: '/reservasi/action', Container: 'CntReservasi', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntReservasi .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntReservasi input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Reservasi
	$('#CntReservasi .WindowReservasiAdd').click(function() {
		$('#WindowReservasi').modal();
		$('#WindowReservasi input[name="reservasi_id"]').val(0);
		$('#WindowReservasi form').each(function(){ this.reset(); });
	});
	$('#CntReservasi .WindowReservasiSave').click(function() {
		if (! $('#WindowReservasi form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowReservasi form');
		ParamAjax.Action = 'UpdateReservasi';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/reservasi/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntReservasi').prepend(Content);
				
				$('#WindowReservasi').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowReservasi form').prepend(Content);
			}
		});
	});
	$('#CntReservasi .WindowReservasiClose').click(function() {
		$('#WindowReservasi').modal('hide');
	});
	Func.InitForm({
		Container: '#CntReservasi',
		rule: { schedule_id: { required: true }, customer_name: { required: true }, customer_address: { required: true }, customer_phone: { required: true }, reservasi_capacity: { required: true }, reservasi_price: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntReservasi', FirstValue: 'roster_dest', LoadGrid: Local.LoadGrid });
});
</script>
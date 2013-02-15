<?php
	$ArrayCompany = $this->Company_model->GetArray(array('limit' => 1000));
	$ArrayOfficer = $this->Officer_model->GetArray(array('limit' => 1000));
	$ArrayDeviceCategory = $this->Device_Category_model->GetArray(array('limit' => 1000));
?>
<div id="CntDevice" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike">
			<select class="select-large GridFilter">
				<option value="nopol">No Polisi</option>
				<option value="deviceid">Device ID</option>
				<option value="nolambung">No Lambung</option>
				<option value="msisdn">Msisdn</option>
			</select>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowDeviceAdd">Tambah Alat</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowDevice" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Alat</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="device_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_nopol">No Polisi</label>
					<div class="controls"><input type="text" id="input_nopol" name="nopol" placeholder="No Polisi" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_deviceid">ID Alat</label>
					<div class="controls"><input type="text" id="input_deviceid" name="deviceid" placeholder="ID Alat" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Kategori</label>
					<div class="controls">
						<select name="idkategori">
							<?php echo ShowOption(array('Array' => $ArrayDeviceCategory, 'ArrayID' => 'jeniskejadianId', 'ArrayTitle' => 'jeniskejadianName')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Petugas</label>
					<div class="controls">
						<select name="idpetugas">
							<?php echo ShowOption(array('Array' => $ArrayOfficer, 'ArrayID' => 'id', 'ArrayTitle' => 'nama')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_nolambung">No Lambung</label>
					<div class="controls"><input type="text" id="input_nolambung" name="nolambung" placeholder="No Lambung" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_msisdn">Msisdn</label>
					<div class="controls"><input type="text" id="input_msisdn" name="msisdn" placeholder="Msisdn" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_passgps">Password GPS</label>
					<div class="controls"><input type="text" id="input_passgps" name="passgps" placeholder="Password GPS" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Perusahaan</label>
					<div class="controls">
						<select name="company_id">
							<?php echo ShowOption(array('Array' => $ArrayCompany, 'ArrayID' => 'company_id', 'ArrayTitle' => 'company_name')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="disabled" value="1" /> Tidak Aktif
						</label>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowDeviceClose">Cancel</a>
			<a href="#" class="btn btn-large WindowDeviceSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntDevice input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntDevice input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntDevice input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"nopol","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/device/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntDevice .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntDevice .WindowDeviceEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowDevice input[name="device_id"]').val(Record.device_id);
				$('#WindowDevice input[name="nopol"]').val(Record.nopol);
				$('#WindowDevice input[name="deviceid"]').val(Record.deviceid);
				$('#WindowDevice input[name="nolambung"]').val(Record.nolambung);
				$('#WindowDevice input[name="msisdn"]').val(Record.msisdn);
				$('#WindowDevice input[name="passgps"]').val(Record.passgps);
				$('#WindowDevice select[name="idkategori"]').val(Record.idkategori);
				$('#WindowDevice select[name="idpetugas"]').val(Record.idpetugas);
				$('#WindowDevice select[name="company_id"]').val((Record.company_id == null) ? '' : Record.company_id);
				$('#WindowDevice input[name="disabled"]').attr('checked', (Record.disabled == 1));
				$('#WindowDevice').modal();
			});
			$('#CntDevice .WindowDeviceDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleDeviceByID', device_id: Record.device_id },
					Url: '/device/action', Container: 'CntDevice', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntDevice .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntDevice input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Device
	$('#CntDevice .WindowDeviceAdd').click(function() {
		$('#WindowDevice').modal();
		$('#WindowDevice input[name="device_id"]').val(0);
		$('#WindowDevice form').each(function(){ this.reset(); });
	});
	$('#CntDevice .WindowDeviceSave').click(function() {
		if (! $('#WindowDevice form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowDevice form');
		ParamAjax.Action = 'UpdateDevice';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/device/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntDevice').prepend(Content);
				
				$('#WindowDevice').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowDevice .modal-body').prepend(Content);
			}
		});
	});
	$('#CntDevice .WindowDeviceClose').click(function() {
		$('#WindowDevice').modal('hide');
	});
	$('#WindowDevice form').validate({
		onkeyup: false, errorClass: 'error', validClass: 'valid',
		highlight: function(element) { $(element).closest('div').addClass("f_error"); },
		unhighlight: function(element) { $(element).closest('div').removeClass("f_error"); },
		errorPlacement: function(error, element) { $(element).closest('div').append(error); },
		rules: {
			nopol: { required: true },
			deviceid: { required: true },
			msisdn: { required: true },
			passgps: { required: true }
		}
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntDevice', FirstValue: 'nopol', LoadGrid: Local.LoadGrid });
});
</script>
<?php
	$ArrayCompany = $this->Company_model->GetArray(array('limit' => 1000));
?>
<div id="CntDevice" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike">
			<select class="select-large GridFilter">
				<option value="deviceid">Device ID</option>
				<option value="device">Nama Alat</option>
				<option value="msisdn">Msisdn</option>
				<option value="company_name">Perusahaan</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
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
					<label class="control-label" for="input_deviceid">ID Alat</label>
					<div class="controls"><input type="text" id="input_deviceid" name="deviceid" placeholder="ID Alat" rel="twipsy" data-placement="right" data-original-title="ID Alat / Device" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_device">Nama Alat</label>
					<div class="controls"><input type="text" id="input_device" name="device" placeholder="Nama Alat" rel="twipsy" data-placement="right" data-original-title="Nama Alat / Device" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_msisdn">Msisdn</label>
					<div class="controls"><input type="text" id="input_msisdn" name="msisdn" placeholder="Msisdn" rel="twipsy" data-placement="right" data-original-title="Msisdn Alat / Device " /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Perusahaan</label>
					<div class="controls">
						<select name="company_id" rel="twipsy" data-placement="right" data-original-title="Nama Perusahaan">
							<?php echo ShowOption(array('Array' => $ArrayCompany, 'ArrayID' => 'company_id', 'ArrayTitle' => 'company_name')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="active" value="1" /> Aktif
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
				sort: '[{"property":"deviceid","direction":"ASC"}]'
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
				$('#WindowDevice input[name="device"]').val(Record.device);
				$('#WindowDevice input[name="deviceid"]').val(Record.deviceid);
				$('#WindowDevice input[name="msisdn"]').val(Record.msisdn);
				$('#WindowDevice select[name="company_id"]').val((Record.company_id == null) ? '' : Record.company_id);
				$('#WindowDevice input[name="active"]').attr('checked', (Record.active == 1));
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
	Func.InitForm({
		Container: '#WindowDevice',
		rule: { device: { required: true }, deviceid: { required: true }, msisdn: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntDevice', FirstValue: 'deviceid', LoadGrid: Local.LoadGrid });
});
</script>
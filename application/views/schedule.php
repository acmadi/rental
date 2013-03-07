<?php
	$company_id = $this->User_model->GetCompanyID();
	$ArrayDevice = $this->Device_model->GetArray(array('limit' => 1000, 'company_id' => $company_id));
	
	$ParamRoster = array(
		'limit' => 1000, 'company_id' => $company_id,
		'filter' => '[{"type":"numeric","comparison":"eq","value":1,"field":"Roster.roster_active"}]'
	);
	$ArrayRoster = $this->Roster_model->GetArray($ParamRoster);
	$ArrayDriver = $this->Driver_model->GetArray(array('limit' => 1000, 'company_id' => $company_id));
?>
<div id="CntSchedule" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="roster_dest">Tujuan</option>
				<option value="driver_name">Sopir</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowScheduleAdd">Tambah Jadwal</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowSchedule" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Jadwal</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="schedule_id" value="0" />
				<div class="control-group">
					<label class="control-label">Roster</label>
					<div class="controls">
						<select name="roster_id">
							<?php echo ShowOption(array('Array' => $ArrayRoster, 'ArrayID' => 'roster_id', 'ArrayTitle' => 'roster_dest')); ?>
						</select>
					</div>
				</div>
					<div class="control-group">
						<label class="control-label">Mobil</label>
						<div class="controls">
							<select name="car_id">
								<?php echo ShowOption(array('Array' => $ArrayDevice, 'ArrayID' => 'id', 'ArrayTitle' => 'device')); ?>
							</select>
						</div>
					</div>
				<div class="control-group">
					<label class="control-label">Sopir</label>
					<div class="controls">
						<select name="driver_id">
							<?php echo ShowOption(array('Array' => $ArrayDriver, 'ArrayID' => 'driver_id', 'ArrayTitle' => 'driver_name')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_schedule_date">Tanggal</label>
					<div class="controls"><input type="text" id="input_schedule_date" name="schedule_date" placeholder="Tanggal" class="datepicker" rel="twipsy" data-placement="right" data-original-title="Tanggal Jadwal" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_schedule_depature">Berangkat</label>
					<div class="controls"><input type="text" id="input_schedule_depature" name="schedule_depature" placeholder="Berangkat" rel="twipsy" data-placement="right" data-original-title="Jam Berangkat" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_schedule_arrival">Sampai</label>
					<div class="controls"><input type="text" id="input_schedule_arrival" name="schedule_arrival" placeholder="Sampai" rel="twipsy" data-placement="right" data-original-title="Jam Sampai" /></div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowScheduleClose">Cancel</a>
			<a href="#" class="btn btn-large WindowScheduleSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		ShowMessage: function(Message) {
			$('#CntSchedule .alert').remove();
			var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Message + '</div>';
			$('#CntSchedule').prepend(Content);
		},
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntSchedule input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntSchedule input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntSchedule input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"schedule_date","direction":"DESC"},{"property":"roster_dest","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/schedule/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntSchedule .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntSchedule .WindowScheduleEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowSchedule input[name="schedule_id"]').val(Record.schedule_id);
				$('#WindowSchedule input[name="schedule_date"]').val(Func.SwapDate(Record.schedule_date));
				$('#WindowSchedule input[name="schedule_depature"]').val(Record.schedule_depature);
				$('#WindowSchedule input[name="schedule_arrival"]').val(Record.schedule_arrival);
				$('#WindowSchedule select[name="roster_id"]').val(Record.roster_id);
				$('#WindowSchedule select[name="car_id"]').val(Record.car_id);
				$('#WindowSchedule select[name="driver_id"]').val(Record.driver_id);
				$('#WindowSchedule').modal();
			});
			$('#CntSchedule .WindowScheduleReport').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				window.open(Web.HOST + '/index.php/schedule/view/report/' + Record.schedule_id);
			});
			$('#CntSchedule .WindowScheduleDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleScheduleByID', schedule_id: Record.schedule_id },
					Url: '/schedule/action', Container: 'CntSchedule', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntSchedule .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#WindowSchedule input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Schedule
	$('#CntSchedule .WindowScheduleAdd').click(function() {
		$('#WindowSchedule').modal();
		$('#WindowSchedule input[name="schedule_id"]').val(0);
		$('#WindowSchedule form').each(function(){ this.reset(); });
	});
	$('#CntSchedule .WindowScheduleSave').click(function() {
		if (! $('#WindowSchedule form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowSchedule form');
		ParamAjax.Action = 'UpdateSchedule';
		ParamAjax.schedule_date = Func.SwapDate(ParamAjax.schedule_date);
		ParamAjax.schedule_arrival = ParamAjax.schedule_arrival;
		ParamAjax.schedule_depature = ParamAjax.schedule_depature;
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/schedule/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('#WindowSchedule').modal('hide');
				Local.LoadGrid({});
				Local.ShowMessage(Result.Message);
			} else {
				$('#CntSchedule .alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowSchedule .modal-body').prepend(Content);
			}
		});
	});
	$('#CntSchedule .WindowScheduleClose').click(function() {
		$('#WindowSchedule').modal('hide');
	});
	Func.InitForm({
		Container: '#WindowSchedule',
		rule: { roster_id: { required: true }, car_id: { required: true }, car_id: { required: true }, schedule_date: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntSchedule', FirstValue: 'roster_dest', LoadGrid: Local.LoadGrid });
});
</script>
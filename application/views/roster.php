<?php
	$ArrayDay = $this->Day_model->GetArray(array('limit' => 1000));
?>
<div id="CntRoster" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="roster_time">Waktu</option>
				<option value="roster_dest">Tujuan</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowRosterAdd">Tambah Trayek</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowRoster" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Trayek</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="roster_id" value="0" />
				<div class="control-group">
					<label class="control-label">Hari</label>
					<div class="controls">
						<?php foreach ($ArrayDay as $Day) { ?>
							<label class="checkbox"><input type="checkbox" name="roster_day" value="<?php echo $Day['id']; ?>" /> <?php echo $Day['title']; ?></label>
						<?php } ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_roster_time">Waktu</label>
					<div class="controls"><input type="text" id="input_roster_time" name="roster_time" placeholder="Waktu" rel="twipsy" data-placement="right" data-original-title="Waktu Roster" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_roster_dest">Tujuan</label>
					<div class="controls"><input type="text" id="input_roster_dest" name="roster_dest" placeholder="Tujuan" rel="twipsy" data-placement="right" data-original-title="Tujuan Roster" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_roster_capacity">Kapasitas</label>
					<div class="controls"><input type="text" id="input_roster_capacity" name="roster_capacity" placeholder="Kapasitas" rel="twipsy" data-placement="right" data-original-title="Kapasitas Roster" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_roster_price">Harga</label>
					<div class="controls"><input type="text" id="input_roster_price" name="roster_price" placeholder="Harga" rel="twipsy" data-placement="right" data-original-title="Harga Roster / Orang" /></div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="roster_active" value="1" /> Aktif
						</label>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowRosterClose">Cancel</a>
			<a href="#" class="btn btn-large WindowRosterSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntRoster input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntRoster input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntRoster input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"roster_day","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/roster/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntRoster .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntRoster .WindowRosterEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowRoster input[name="roster_id"]').val(Record.roster_id);
				$('#WindowRoster input[name="roster_time"]').val(Record.roster_time);
				$('#WindowRoster input[name="roster_dest"]').val(Record.roster_dest);
				$('#WindowRoster input[name="roster_capacity"]').val(Record.roster_capacity);
				$('#WindowRoster input[name="roster_price"]').val(Record.roster_price);
				$('#WindowRoster input[name="roster_active"]').attr('checked', (Record.roster_active == 1));
				
				a = Record;
				Record = a;
				console.log(a);
				
				// Populate Roster Day
				var ArrayDay = Record.roster_day.split(',');
				var InputDay = $('#WindowRoster input[name="roster_day"]');
				$('#WindowRoster input[name="roster_day"]').attr('checked', false);
				for (var i = 0; i < InputDay.length; i++) {
					var value = InputDay.eq(i).val();
					InputDay.eq(i).attr('checked', Func.InArray(value, ArrayDay));
				}
				
				$('#WindowRoster').modal();
			});
			$('#CntRoster .WindowRosterDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleRosterByID', roster_id: Record.roster_id },
					Url: '/roster/action', Container: 'CntRoster', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntRoster .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntRoster input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Roster
	$('#CntRoster .WindowRosterAdd').click(function() {
		$('#WindowRoster').modal();
		$('#WindowRoster input[name="roster_id"]').val(0);
		$('#WindowRoster input[name="roster_day"]').attr('checked', false);
		$('#WindowRoster form').each(function(){ this.reset(); });
	});
	$('#CntRoster .WindowRosterSave').click(function() {
		if (! $('#WindowRoster form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowRoster form');
		ParamAjax.Action = 'UpdateRoster';
		
		// Collect Roster Day
		ParamAjax.roster_day = '';
		var InputDay = $('#WindowRoster input[name="roster_day"]');
		for (var i = 0; i < InputDay.length; i++) {
			var Checked = InputDay.eq(i).attr('checked');
			if (Checked == 'checked') {
				ParamAjax.roster_day += (ParamAjax.roster_day.length == 0) ? InputDay.eq(i).val() : ',' + InputDay.eq(i).val();
			}
		}
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/roster/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntRoster').prepend(Content);
				
				$('#WindowRoster').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowRoster form').prepend(Content);
			}
		});
	});
	$('#CntRoster .WindowRosterClose').click(function() {
		$('#WindowRoster').modal('hide');
	});
	Func.InitForm({
		Container: '#WindowRoster',
		rule: { roster_day: { required: true }, roster_time: { required: true }, roster_dest: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntRoster', FirstValue: 'roster_time', LoadGrid: Local.LoadGrid });
});
</script>
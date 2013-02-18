<div id="CntDriver" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" />
			<select class="select-large GridFilter">
				<option value="driver_name">Nama</option>
				<option value="driver_address">Alamat</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-sprocket_dark"></i></button>
			<button class="btn btn-large Search" type="button"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowDriverAdd">Tambah Sopir</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowDriver" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Sopir</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="driver_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_driver_name">Nama</label>
					<div class="controls"><input type="text" id="input_driver_name" name="driver_name" placeholder="Nama" rel="twipsy" data-placement="right" data-original-title="Nama Lengkap Sopir" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_driver_address">Alamat</label>
					<div class="controls"><input type="text" id="input_driver_address" name="driver_address" placeholder="Alamat" rel="twipsy" data-placement="right" data-original-title="Alamat Sopir" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_driver_phone">Telepon</label>
					<div class="controls"><input type="text" id="input_driver_phone" name="driver_phone" placeholder="Telepon" rel="twipsy" data-placement="right" data-original-title="Telepon Sopir" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_driver_mobile">HP</label>
					<div class="controls"><input type="text" id="input_driver_mobile" name="driver_mobile" placeholder="HP" rel="twipsy" data-placement="right" data-original-title="HP Sopir" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_driver_fee">Biaya</label>
					<div class="controls"><input type="text" id="input_driver_fee" name="driver_fee" placeholder="Biaya" rel="twipsy" data-placement="right" data-original-title="Biaya Sopir" /></div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowDriverClose">Cancel</a>
			<a href="#" class="btn btn-large WindowDriverSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntDriver input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntDriver input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntDriver input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"driver_name","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/driver/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntDriver .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntDriver .WindowDriverEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowDriver input[name="driver_id"]').val(Record.driver_id);
				$('#WindowDriver input[name="driver_name"]').val(Record.driver_name);
				$('#WindowDriver input[name="driver_address"]').val(Record.driver_address);
				$('#WindowDriver input[name="driver_phone"]').val(Record.driver_phone);
				$('#WindowDriver input[name="driver_mobile"]').val(Record.driver_mobile);
				$('#WindowDriver input[name="driver_fee"]').val(Record.driver_fee);
				$('#WindowDriver').modal();
			});
			$('#CntDriver .WindowDriverDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleDriverByID', driver_id: Record.driver_id },
					Url: '/driver/action', Container: 'CntDriver', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntDriver .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntDriver input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Driver
	$('#CntDriver .WindowDriverAdd').click(function() {
		$('#WindowDriver').modal();
		$('#WindowDriver input[name="driver_id"]').val(0);
		$('#WindowDriver form').each(function(){ this.reset(); });
	});
	$('#CntDriver .WindowDriverSave').click(function() {
		if (! $('#WindowDriver form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowDriver form');
		ParamAjax.Action = 'UpdateDriver';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/driver/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntDriver').prepend(Content);
				
				$('#WindowDriver').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowDriver form').prepend(Content);
			}
		});
	});
	$('#CntDriver .WindowDriverClose').click(function() {
		$('#WindowDriver').modal('hide');
	});
	Func.InitForm({
		Container: '#WindowDriver',
		rule: { driver_name: { required: true }, driver_address: { required: true }, driver_phone: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntDriver', FirstValue: 'driver_name', LoadGrid: Local.LoadGrid });
});
</script>
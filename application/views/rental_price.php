<?php
	$company_id = $this->User_model->GetCompanyID();
	
	$ArrayRentalDurasi = $this->Rental_Durasi_model->GetArray();
	$ArrayDevice = $this->Device_model->GetArray(array('limit' => 1000, 'company_id' => $company_id));
?>
<div id="CntRentalPrice" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" />
			<select class="select-large GridFilter">
				<option value="device">Device</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
			<button class="btn btn-large Search" type="button"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowRentalPriceAdd">Tambah Price List</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowRentalPrice" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Price List</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="rental_price_id" value="0" />
				<div class="control-group">
					<label class="control-label">Mobil</label>
					<div class="controls">
						<select name="car_id">
							<?php echo ShowOption(array('Array' => $ArrayDevice, 'ArrayID' => 'id', 'ArrayTitle' => 'device')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Durasi Sewa</label>
					<div class="controls">
						<select name="rental_durasi_id">
							<?php echo ShowOption(array('Array' => $ArrayRentalDurasi, 'ArrayID' => 'rental_durasi_id', 'ArrayTitle' => 'rental_durasi_name')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_rental_price_value">Harga Sewa</label>
					<div class="controls"><input type="text" id="input_rental_price_value" name="rental_price_value" placeholder="Harga Sewa" rel="twipsy" data-placement="right" data-original-title="Harga Sewa" /></div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowRentalPriceClose">Cancel</a>
			<a href="#" class="btn btn-large WindowRentalPriceSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntRentalPrice input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntRentalPrice input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntRentalPrice input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"Device.device","direction":"ASC"},{"property":"RentalDurasi.rental_durasi_order","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/rental_price/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntRentalPrice .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntRentalPrice .WindowRentalPriceEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowRentalPrice input[name="rental_price_id"]').val(Record.rental_price_id);
				$('#WindowRentalPrice input[name="rental_price_value"]').val(Record.rental_price_value);
				$('#WindowRentalPrice select[name="rental_durasi_id"]').val(Record.rental_durasi_id);
				$('#WindowRentalPrice select[name="car_id"]').val(Record.car_id);
				$('#WindowRentalPrice').modal();
			});
			$('#CntRentalPrice .WindowRentalPriceDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleRentalPriceByID', rental_price_id: Record.rental_price_id },
					Url: '/rental_price/action', Container: 'CntRentalPrice', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntRentalPrice .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntRentalPrice input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry RentalPrice
	$('#CntRentalPrice .WindowRentalPriceAdd').click(function() {
		$('#WindowRentalPrice').modal();
		$('#WindowRentalPrice input[name="rental_price_id"]').val(0);
		$('#WindowRentalPrice form').each(function(){ this.reset(); });
	});
	$('#CntRentalPrice .WindowRentalPriceSave').click(function() {
		if (! $('#WindowRentalPrice form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowRentalPrice form');
		ParamAjax.Action = 'UpdateRentalPrice';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/rental_price/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntRentalPrice').prepend(Content);
				
				$('#WindowRentalPrice').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowRentalPrice form').prepend(Content);
			}
		});
	});
	$('#CntRentalPrice .WindowRentalPriceClose').click(function() {
		$('#WindowRentalPrice').modal('hide');
	});
	Func.InitForm({
		Container: '#WindowRentalPrice',
		rule: { rental_durasi_id: { required: true }, car_id: { required: true }, rental_price_value: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntRentalPrice', FirstValue: 'device', LoadGrid: Local.LoadGrid });
});
</script>
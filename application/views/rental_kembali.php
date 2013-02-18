<?php
	$ArrayRentalStatus = $this->Rental_Status_model->GetArray(array('limit' => 200));
?>
<div id="CntRentalKembali" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="rental_no">No Sewa</option>
				<option value="customer_name">Nama Pelanggan</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-sprocket_dark"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowRentalKembali" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Rental Kembali</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="rental_id" value="0" />
				<input type="hidden" name="rental_detail_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_rental_no">No</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_rental_no" name="rental_no" placeholder="No" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_name">Customer</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_customer_name" name="customer_name" placeholder="Customer" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_order_date">Order Date</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_order_date" name="order_date" placeholder="Order Date" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_uang_muka">Uang Muka</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_uang_muka" name="uang_muka" placeholder="Uang Muka" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_total_price">Total Biaya</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_total_price" name="total_price" placeholder="Total Biaya" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_nopol">No Pol</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_nopol" name="nopol" placeholder="No Pol" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_rental_desc">Catatan</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_rental_desc" name="rental_desc" placeholder="Catatan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_rental_guarantee">Jaminan</label>
					<div class="controls"><input type="text" disabled="disabled" id="input_rental_guarantee" name="rental_guarantee" placeholder="Jaminan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Status</label>
					<div class="controls">
						<select name="rental_status_id">
							<?php echo ShowOption(array('Array' => $ArrayRentalStatus, 'ArrayID' => 'rental_status_id', 'ArrayTitle' => 'rental_status_name')); ?>
						</select>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowRentalKembaliClose">Cancel</a>
			<a href="#" class="btn btn-large WindowRentalKembaliSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntRentalKembali input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntRentalKembali input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntRentalKembali input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"rental_no","direction":"DESC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/rental/grid/rental_kembali', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntRentalKembali .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntRentalKembali .WindowRentalEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowRentalKembali input[name="rental_id"]').val(Record.rental_id);
				$('#WindowRentalKembali input[name="rental_detail_id"]').val(Record.rental_detail_id);
				$('#WindowRentalKembali input[name="rental_no"]').val(Record.rental_no);
				$('#WindowRentalKembali input[name="customer_name"]').val(Record.customer_name);
				$('#WindowRentalKembali input[name="order_date"]').val(Func.SwapDate(Record.order_date));
				$('#WindowRentalKembali input[name="uang_muka"]').val(Record.uang_muka);
				$('#WindowRentalKembali input[name="total_price"]').val(Record.total_price);
				$('#WindowRentalKembali input[name="rental_desc"]').val(Record.rental_desc);
				$('#WindowRentalKembali input[name="nopol"]').val(Record.nopol);
				$('#WindowRentalKembali input[name="rental_guarantee"]').val(Record.rental_guarantee);
				$('#WindowRentalKembali select[name="rental_status_id"]').val(Record.rental_status_id);
				$('#WindowRentalKembali').modal();
			});
			$('#CntRentalKembali .WindowRentalDelete').remove();
			$('#CntRentalKembali .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntRentalKembali input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry RentalKembali
	$('#CntRentalKembali .WindowRentalKembaliSave').click(function() {
		var ParamAjax = {
			Action: 'UpdateRentalDetail',
			rental_detail_id: $('#WindowRentalKembali input[name="rental_detail_id"]').val(),
			rental_status_id: $('#WindowRentalKembali select[name="rental_status_id"]').val(),
		}
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/rental_detail/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntRentalKembali').prepend(Content);
				
				$('#WindowRentalKembali').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowRentalKembali form').prepend(Content);
			}
		});
	});
	$('#CntRentalKembali .WindowRentalKembaliClose').click(function() {
		$('#WindowRentalKembali').modal('hide');
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntRentalKembali', FirstValue: 'rental_no', LoadGrid: Local.LoadGrid });
});
</script>
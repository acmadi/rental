<div id="CntCustomer" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="customer_name">Nama</option>
				<option value="customer_address">Alamat</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowCustomerAdd">Tambah Pelanggan</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowCustomer" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Pelanggan</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="customer_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_customer_name">Nama</label>
					<div class="controls"><input type="text" id="input_customer_name" name="customer_name" placeholder="Nama" rel="twipsy" data-placement="right" data-original-title="Nama Lengkap Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_address">Alamat</label>
					<div class="controls"><input type="text" id="input_customer_address" name="customer_address" placeholder="Alamat" rel="twipsy" data-placement="right" data-original-title="Alamat Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_phone">Telepon</label>
					<div class="controls"><input type="text" id="input_customer_phone" name="customer_phone" placeholder="Telepon" rel="twipsy" data-placement="right" data-original-title="Telepon Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_mobile">HP</label>
					<div class="controls"><input type="text" id="input_customer_mobile" name="customer_mobile" placeholder="HP" rel="twipsy" data-placement="right" data-original-title="HP Pelanggan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_customer_gender">Kelamin</label>
					<div class="controls">
						<select id="input_customer_gender" name="customer_gender">
							<option value="Laki - Laki">Laki - Laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowCustomerClose">Cancel</a>
			<a href="#" class="btn btn-large WindowCustomerSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntCustomer input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntCustomer input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntCustomer input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"customer_name","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/customer/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntCustomer .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntCustomer .WindowCustomerEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowCustomer input[name="customer_id"]').val(Record.customer_id);
				$('#WindowCustomer input[name="customer_name"]').val(Record.customer_name);
				$('#WindowCustomer input[name="customer_address"]').val(Record.customer_address);
				$('#WindowCustomer input[name="customer_phone"]').val(Record.customer_phone);
				$('#WindowCustomer input[name="customer_mobile"]').val(Record.customer_mobile);
				$('#WindowCustomer select[name="customer_gender"]').val(Record.customer_gender);
				$('#WindowCustomer').modal();
			});
			$('#CntCustomer .WindowCustomerDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleCustomerByID', customer_id: Record.customer_id },
					Url: '/customer/action', Container: 'CntCustomer', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntCustomer .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntCustomer input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Customer
	$('.WindowCustomerAdd').click(function() {
		$('#WindowCustomer').modal();
		$('#CntCustomer input[name="customer_id"]').val(0);
		$('#WindowCustomer form').each(function(){ this.reset(); });
	})
	$('#CntCustomer .WindowCustomerSave').click(function() {
		if (! $('#WindowCustomer form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowCustomer form');
		ParamAjax.Action = 'UpdateCustomer';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/customer/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntCustomer').prepend(Content);
				
				$('#WindowCustomer').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowCustomer form').prepend(Content);
			}
		});
	});
	$('#CntCustomer .WindowCustomerClose').click(function() {
		$('#WindowCustomer').modal('hide');
	});
	Func.InitForm({
		Container: '#CntCustomer',
		rule: { customer_name: { required: true }, customer_address: { required: true }, customer_phone: { required: true } }
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntCustomer', FirstValue: 'customer_name', LoadGrid: Local.LoadGrid });
});
</script>
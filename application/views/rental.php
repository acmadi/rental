<?php
	$company_id = $this->User_model->GetCompanyID();
	
	$ArrayCustomer = $this->Customer_model->GetArray(array('limit' => 200, 'company_id' => $company_id));
	$ArrayDriver = $this->Driver_model->GetArray(array('limit' => 200, 'company_id' => $company_id));
	$ArrayDevice = $this->Device_model->GetArray(array('limit' => 1000, 'company_id' => $company_id));
	$ArrayRentalStatus = $this->Rental_Status_model->GetArray(array('limit' => 200));
	$ArrayCarCondition = $this->Car_Condition_model->GetArray(array('limit' => 200));
	$ArrayMonth = GetArrayMonth();
?>

<div id="CntRental" class="row-fluid">
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
		
		<button class="btn btn-large WindowRentalAdd">Tambah Sewa</button>
	</div>
	
	<div class="datagrid" style="margin: 0 0 40px 0;"></div>
	
	<div class="cnt-window hidden">
		<div class="pad">
			<input type="hidden" name="rental_id" value="0" />
			<input type="hidden" name="customer_id" value="0" />
			
			<div class="message"></div>
			
			<form>
			<div class="row-fluid form-horizontal">
				<div class="span6">
					<div class="control-group">
						<label for="input_rental_no" class="control-label">No Sewa</label>
						<div class="controls"><input type="text" placeholder="No Sewa" name="rental_no" id="input_rental_no" rel="twipsy" data-placement="right" data-original-title="No Sewa Rental" /></div>
					</div>
					<div class="control-group">
						<label class="control-label">Pelanggan</label>
					</div>
					<div class="control-group">
						<label class="control-label">Nama</label>
						<div class="controls">
							<select name="customer_id" rel="twipsy" data-placement="right" data-original-title="Nama Pelanggan">
								<?php echo ShowOption(array('Array' => $ArrayCustomer, 'ArrayID' => 'customer_id', 'ArrayTitle' => 'customer_name')); ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Alamat</label>
						<div class="controls"><input type="text" placeholder="Alamat" name="customer_address" disabled="disabled" /></div>
					</div>
					<div class="control-group">
						<label class="control-label">Telepon</label>
						<div class="controls"><input type="text" placeholder="Telepon" name="customer_phone" disabled="disabled" /></div>
					</div>
				</div>
				
				<div class="span6">
					<div class="control-group">
						<label class="control-label">Tanggal</label>
						<div class="controls"><input type="text" placeholder="Tanggal" name="order_date" class="datepicker" rel="twipsy" data-placement="right" data-original-title="Tanggal Order"></div>
					</div>
				</div>
			</div>
			</form>
			
			<div class="btn-group sepH_b">
				<button class="btn btn-large WindowRentalDetailAdd">Add</button>
			</div>
			<div class="datagrid" style="margin-bottom: 30px;"></div>
			
			<div class="row-fluid form-horizontal">
				<div class="span6">
					<div class="control-group">
						<label for="input_rental_desc" class="control-label">Catatan</label>
						<div class="controls"><input type="text" placeholder="Catatan" name="rental_desc" id="input_rental_desc" rel="twipsy" data-placement="right" data-original-title="Catatan Sewa" /></div>
					</div>
					<div class="control-group">
						<label for="input_rental_guarantee" class="control-label">Jaminan</label>
						<div class="controls"><input type="text" placeholder="Jaminan" name="rental_guarantee" id="input_rental_guarantee" rel="twipsy" data-placement="right" data-original-title="Jaminan Sewa" /></div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label for="input_total_price" class="control-label">Total Biaya</label>
						<div class="controls"><input type="text" placeholder="Total Biaya" name="total_price" id="input_total_price" rel="twipsy" data-placement="right" data-original-title="Total Biaya Sewa" /></div>
					</div>
					<div class="control-group">
						<label for="input_uang_muka" class="control-label">Uang Muka</label>
						<div class="controls"><input type="text" placeholder="Uang Muka" name="uang_muka" id="input_uang_muka" rel="twipsy" data-placement="right" data-original-title="Uang Muka Sewa" /></div>
					</div>
					<div class="control-group">
						<label for="input_sisa" class="control-label">Belum Terbayar</label>
						<div class="controls"><input type="text" placeholder="Belum Terbayar" name="sisa" id="input_sisa" rel="twipsy" data-placement="right" data-original-title="Biaya yang belum terbayar" /></div>
					</div>
				</div>
			</div>
			
			<div class="btn-group-warp" style="width: 100%; text-align: center; padding-bottom: 20px;">
				<a class="btn btn-large EditorRentalCancel">Tutup</a>
				<a class="btn btn-large EditorRentalSave btn-primary">Simpan</a>
			</div>
		</div>
		
		<div class="WindowRentalDetail modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
			<div class="modal-header">
				<a href="#" class="close" data-dismiss="modal">&times;</a>
				<h3>Form Detail Sewa</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<input type="hidden" name="rental_detail_id" value="0" />
					<div class="control-group">
						<label class="control-label" for="input_date_out">Tanggal Keluar</label>
						<div class="controls"><input type="text" id="input_date_out" name="date_out" class="datepicker" placeholder="Tanggal Keluar" rel="twipsy" data-placement="right" data-original-title="Tanggal Keluar" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_rental_duration">Lama Sewa</label>
						<div class="controls"><input type="text" id="input_rental_duration" name="rental_duration" placeholder="Lama Sewa dalam Hari" rel="twipsy" data-placement="right" data-original-title="Lama Sewa dalam Hari" /></div>
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
						<label class="control-label" for="input_destination">Tujuan</label>
						<div class="controls"><input type="text" id="input_destination" name="destination" placeholder="Tujuan" rel="twipsy" data-placement="right" data-original-title="Tujuan" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_price_per_day">Harga Sewa / Hari</label>
						<div class="controls"><input type="text" id="input_price_per_day" name="price_per_day" placeholder="Harga Sewa / Hari" rel="twipsy" data-placement="right" data-original-title="Harga Sewa / Hari" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_date_in">Tanggal Kembali</label>
						<div class="controls"><input type="text" disabled="disabled" id="input_date_in" name="date_in" class="datepicker" placeholder="Tanggal Kembali" rel="twipsy" data-placement="right" data-original-title="Tanggal Kembali" /></div>
					</div>
					<div class="control-group">
						<label class="control-label">Status</label>
						<div class="controls">
							<select name="rental_status_id">
								<?php echo ShowOption(array('Array' => $ArrayRentalStatus, 'ArrayID' => 'rental_status_id', 'ArrayTitle' => 'rental_status_name')); ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Kondisi Mobil</label>
						<div class="controls">
							<select name="car_condition_id">
								<?php echo ShowOption(array('Array' => $ArrayCarCondition, 'ArrayID' => 'car_condition_id', 'ArrayTitle' => 'car_condition_name')); ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_driver_fee">Biaya Sopir</label>
						<div class="controls"><input type="text" id="input_driver_fee" name="driver_fee" placeholder="Biaya Sopir" rel="twipsy" data-placement="right" data-original-title="Biaya Sopir" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_driver_duration">Durasi Sopir</label>
						<div class="controls"><input type="text" id="input_driver_duration" name="driver_duration" placeholder="Durasi Sopir" rel="twipsy" data-placement="right" data-original-title="Durasi Sopir" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_car_condition_out">Kondisi Mobil Keluar</label>
						<div class="controls"><input type="text" id="input_car_condition_out" name="car_condition_out" placeholder="Kondisi Mobil Keluar" rel="twipsy" data-placement="right" data-original-title="Kondisi Mobil Keluar" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_car_condition_in">Kondisi Mobil Kembali</label>
						<div class="controls"><input type="text" id="input_car_condition_in" name="car_condition_in" placeholder="Kondisi Mobil Kembali" rel="twipsy" data-placement="right" data-original-title="Kondisi Mobil Kembali" /></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_guaranty">Jaminan</label>
						<div class="controls"><input type="text" id="input_guaranty" name="guaranty" placeholder="Jaminan" rel="twipsy" data-placement="right" data-original-title="Jaminan" /></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-large WindowRentalDetailClose">Cancel</a>
				<a href="#" class="btn btn-large WindowRentalDetailSave btn-primary">OK</a>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntRental input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntRental input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntRental input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"order_date","direction":"DESC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/rental/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntRental .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		LoadDetailGrid: function(Param) {
			var GridParam = {
				start: 0, limit: 100, page: 1,
				sort: '[{"property":"date_out","direction":"ASC"}]',
				rental_id: $('.form-rental input[name="rental_id"]').val()
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/rental_detail/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('.form-rental .datagrid').html(ResponseHtml);
				
				$('.WindowRentalDetailEdit').click(function() {
					var RawRecord = $(this).parent('td').children('span.hidden').text();
					eval('var Record = ' + RawRecord);
					
					$('.form-rental input[name="rental_detail_id"]').val(Record.rental_detail_id)
					$('.form-rental input[name="date_out"]').val(Func.SwapDate(Record.date_out))
					$('.form-rental input[name="date_in"]').val(Func.SwapDate(Record.date_in))
					$('.form-rental input[name="price_per_day"]').val(Record.price_per_day)
					$('.form-rental input[name="destination"]').val(Record.destination)
					$('.form-rental input[name="rental_duration"]').val(Record.rental_duration)
					$('.form-rental input[name="car_condition_out"]').val(Record.car_condition_out)
					$('.form-rental input[name="car_condition_in"]').val(Record.car_condition_in)
					$('.form-rental input[name="guaranty"]').val(Record.guaranty)
					$('.form-rental select[name="car_id"]').val(Record.car_id)
					$('.form-rental select[name="driver_id"]').val(Record.driver_id)
					$('.form-rental select[name="rental_status_id"]').val(Record.rental_status_id)
					$('.form-rental select[name="car_condition_id"]').val(Record.car_condition_id)
					
					// Set Record Value
					$('.form-rental .WindowRentalDetail').modal();
				});
				
				$('.WindowRentalDetailDelete').click(function() {
					var RawRecord = $(this).parent('td').children('span.hidden').text();
					eval('var Record = ' + RawRecord);
					
					$.ajax({
						type: "POST", url: Web.HOST + '/index.php/rental_detail/action',
						data: { Action: 'DeteleRentalDetailByID', rental_id: Record.rental_id, rental_detail_id: Record.rental_detail_id }
					}).done(function( RawResult ) {
						eval('var Result = ' + RawResult);
						
						Local.MessageEditor('<strong>Notification! </strong>' + Result.Message);
						if (Result.QueryStatus == 1) {
							Local.LoadGrid({});
							Local.LoadDetailGrid({});
							$('.form-rental input[name="total_price"]').val(Result.TotalCost);
						}
					});
				});
			});		},
		InitGrid: function() {
			$('#CntRental .WindowRentalEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Local.ShowEditor(Record);
			});
			$('#CntRental .WindowRentalDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleRentalByID', rental_id: Record.rental_id },
					Url: '/rental/action', Container: 'CntRental', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntRental .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntRental input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		},
		ShowEditor: function(Record) {
			$('.cnt-body').children('div').hide();
			
			var Content = $('.cnt-window').html();
			$('.cnt-body').append('<div class="cnt-window form-rental">' + Content + '</div>');
			
			if (Record.rental_id != null) {
				$('.form-rental input[name="rental_id"]').val(Record.rental_id);
				$('.form-rental input[name="rental_no"]').val(Record.rental_no);
				$('.form-rental input[name="order_date"]').val(Func.SwapDate(Record.order_date));
				$('.form-rental input[name="customer_address"]').val(Record.customer_address);
				$('.form-rental input[name="customer_phone"]').val(Record.customer_phone);
				$('.form-rental input[name="rental_desc"]').val(Record.rental_desc);
				$('.form-rental input[name="rental_guarantee"]').val(Record.rental_guarantee);
				$('.form-rental input[name="total_price"]').val(Record.total_price);
				$('.form-rental input[name="uang_muka"]').val(Record.uang_muka);
				$('.form-rental input[name="sisa"]').val(Record.sisa);
				$('.form-rental select[name="customer_id"]').val(Record.customer_id);
			} else {
				$.ajax({
					type: "POST", url: Web.HOST + '/index.php/rental/action',
					data: { Action: 'GetRentalNo' }
				}).done(function( RawResult ) {
					eval('var Result = ' + RawResult);
					$('.form-rental input[name="rental_no"]').val(Result.config_content);
					$('.form-rental input[name="order_date"]').val(Func.GetStringFromDate(new Date()));
				});
			}
			
			Local.InitEditor();
			Local.LoadDetailGrid();
		},
		CloseEditor: function() {
			$('.cnt-body').children('.cnt-window').remove();
			$('.cnt-body').children('div').show();
		},
		InitEditor: function() {
			// Set Listeners
			$('.form-rental input[name="date_out"]').blur(function() { Local.SetDateIn() });
			$('.form-rental input[name="rental_duration"]').blur(function() { Local.SetDateIn() });
			$('.form-rental select[name="customer_id"]').change(function() {
				$.ajax({
					type: "POST", url: Web.HOST + '/index.php/customer/action',
					data: {
						Action: 'GetCustomerByID',
						customer_id: $(this).val()
					}
				}).done(function( RawResult ) {
					eval('var Result = ' + RawResult);
					
					$('.form-rental input[name="customer_address"]').val(Result.customer_address);
					$('.form-rental input[name="customer_phone"]').val(Result.customer_phone);
				});
			});
			
			// Init Form
			Func.InitForm({
				Container: '.form-rental .pad',
				rule: { rental_no: { required: true }, order_date: { required: true }, customer_id: { required: true } }
			});
			Func.InitForm({
				Container: '.form-rental .WindowRentalDetail',
				rule: { date_out: { required: true }, rental_duration: { required: true }, car_id: { required: true }, driver_id: { required: true }, destination: { required: true }, price_per_day: { required: true } }
			});
			
			// Form Entry Master
			$('.form-rental .EditorRentalCancel').click(function() { Local.CloseEditor(); });
			$('.form-rental .EditorRentalSave').click(function() { Local.SaveEntryMaster({}); });
			
			// Form Entry Detail
			$('.form-rental .WindowRentalDetailAdd').click(function() {
				var FuncCallback = function() {
					$('.form-rental .WindowRentalDetail').modal();
					$('.form-rental input[name="rental_detail_id"]').val(0);
					$('.form-rental .WindowRentalDetail form').each(function(){ this.reset(); });
				}
				
				var rental_id = $('.form-rental input[name="rental_id"]').val();
				if (rental_id == 0) {
					Local.SaveEntryMaster({ Callback: FuncCallback });
				} else {
					FuncCallback();
				}
			});
			$('.form-rental .WindowRentalDetailSave').click(function() {
				if (! $('.form-rental .WindowRentalDetail form').valid()) {
					return;
				}
				
				var ParamAjax = Site.Form.GetValue('.form-rental .WindowRentalDetail form');
				ParamAjax.Action = 'UpdateRentalDetail';
				ParamAjax.rental_id = $('.form-rental input[name="rental_id"]').val();
				ParamAjax.date_in = Func.SwapDate(ParamAjax.date_in);
				ParamAjax.date_out = Func.SwapDate(ParamAjax.date_out);
				
				$.ajax({
					type: "POST", url: Web.HOST + '/index.php/rental_detail/action', data: ParamAjax
				}).done(function( RawResult ) {
					eval('var Result = ' + RawResult);
					Local.MessageEditor('<strong>Notification! </strong>' + Result.Message);
					
					if (Result.QueryStatus == 1) {
						$('.form-rental input[name="total_price"]').val(Result.TotalCost);
						
						$('.form-rental .WindowRentalDetail').modal('hide');
						Local.LoadGrid({});
						Local.LoadDetailGrid({});
					}
				});
			});
			$('.form-rental .WindowRentalDetailClose').click(function() {
				$('.form-rental .WindowRentalDetail').modal('hide');
			});
		},
		MessageEditor: function(Message) {
			$('.form-rental .pad .alert').remove();
			var Content = ''
			Content += '<div class="alert">'
			Content += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
			Content += Message
			Content += '</div>';
			
			$('.form-rental .pad').append(Content);
		},
		SetDateIn: function() {
			var ArrayDate = $('.form-rental input[name="date_out"]').val().split('-');
			var RentalDuration = parseInt($('.form-rental input[name="rental_duration"]').val(), 10);
			
			if (ArrayDate.length == 3 && RentalDuration > 0) {
				var DateOut = new Date(ArrayDate[2], ArrayDate[1] - 1, ArrayDate[0]);
				var DateInUnix = DateOut.getTime() + (24 * 60 * 60 * 1000 * RentalDuration);
				var DateIn = new Date(DateInUnix);
				var DateInText = Func.GetStringFromDate(DateIn);
				
				$('.form-rental input[name="date_in"]').val(DateInText);
			}
		},
		SaveEntryMaster: function(Param) {
			if (! $('.form-rental .pad form').valid()) {
				return;
			}
			
			var ParamAjax = Site.Form.GetValue('.form-rental .pad');
			ParamAjax.Action = 'UpdateRental';
			ParamAjax.order_date = Func.SwapDate(ParamAjax.order_date);
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/rental/action', data: ParamAjax
			}).done(function( RawResult ) {
				eval('var Result = ' + RawResult);
				Local.MessageEditor('<strong>Notification! </strong>' + Result.Message);
				
				if (Result.QueryStatus == 1) {
					$('.form-rental input[name="rental_id"]').val(Result.rental_id);
					Local.LoadGrid({});
					
					if (Param.Callback != null) {
						Param.Callback();
					}
				}
			});
		}
	}
	
	// Form Entry Rental
	$('#CntRental .WindowRentalAdd').click(function() {
		Local.ShowEditor({});
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntRental', FirstValue: 'rental_no', LoadGrid: Local.LoadGrid });
});
</script>
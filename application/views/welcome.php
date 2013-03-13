<?php
	$company_id = $this->User_model->GetCompanyID();
	$ArrayConfig = array(
		'CurrentDate' => GetFormatDateCommon($this->config->item('current_time'), array('FormatDate' => 'm/d/Y'))
	);
	
	// Get Menu
	$ParamCompany = array('filter' => '[{"type":"numeric","comparison":"eq","value":' . $company_id . ',"field":"company_id"},{"type":"numeric","comparison":"eq","value":1,"field":"menu_company_active"}]');
	$MenuCompany = $this->Menu_Item_model->GetTree($ParamCompany);
	
	// Get Array Merge
	$ArrayCalender = $this->Merge_model->GetArray(array('month' => date("m")));
	$ArrayConfig['Calender'] = $ArrayCalender;
?>

<?php $this->load->view( 'common/meta' ); ?>

<body class="ptrn_e menu_hover">
	<div id="Config" class="hidden"><?php echo json_encode($ArrayConfig); ?></div>
	<div id="loading_layer" style="display:none"><img src="<?php echo $this->config->item('base_url'); ?>/static/img/ajax_loader.gif" alt="" /></div>
	
	<?php $this->load->view( 'common/header' ); ?>
	
	<div class="cnt-body">
		<div class="cnt-left">
			<div class="accordion pad" id="accordion2">
				<?php $Collapse = true; ?>
				<?php foreach ($MenuCompany as $Key => $Array) { ?>
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion_<?php echo $Key; ?>"><?php echo $Key; ?></a>
						</div>
						<div id="accordion_<?php echo $Key; ?>" class="accordion-body collapse <?php echo ($Collapse) ? 'in' : ''; ?>">
							<div class="accordion-inner">
								<?php foreach ($Array as $Item) { ?>
										<button class="btn btn-large btn-block" type="submit" value='<?php echo json_encode($Item); ?>'><?php echo $Item['menu_item_name']; ?></button>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php $Collapse = false; ?>
				<?php } ?>
				<?php if (COMPANY_ID_SIMETRI == $company_id) { ?>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">Administrasi</a>
					</div>
					<div id="collapseFour" class="accordion-body collapse">
						<div class="accordion-inner">
							<button class="btn btn-large btn-block" type="submit" value='{"menu_item_name":"Alat","menu_item_link":"device"}'>Alat</button>
							<button class="btn btn-large btn-block" type="submit" value='{"menu_item_name":"Pengguna","menu_item_link":"user"}'>Pengguna</button>
							<button class="btn btn-large btn-block" type="submit" value='{"menu_item_name":"Perusahaan","menu_item_link":"company"}'>Perusahaan</button>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="cnt-right">
			<div class="pad">
				<div id="ContentRight" class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1" data-toggle="tab">Dashboard</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="row-fluid">
								<h2 class="heading">Kalender</h2>
								<div style="margin: 0 0 50px 0;" id="calendar"></div>
								
								<div id="WidgetReservasi">
									<h2>Reservasi Online</h2>
									<div class="widget_reservasi" style="margin: 0 0 50px 0;"><div class="datagrid"></div></div>
								<div>
				
								<h2>Mobil Kembali</h2>
								<div class="rental" style="margin: 0 0 50px 0;"><div class="datagrid"></div></div>
								
								<h2>Pemesanan Reservasi</h2>
								<div class="reservasi"><div class="datagrid"></div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="WindowCalenderRental" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Rental</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label">Rental No</label>
					<div class="controls"><input type="text" name="rental_no" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Tanggal Keluar</label>
					<div class="controls"><input type="text" name="date_out" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Tanggal Kembali</label>
					<div class="controls"><input type="text" name="date_in" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Sopir</label>
					<div class="controls"><input type="text" name="driver_name" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Nama Pelanggan</label>
					<div class="controls"><input type="text" name="customer_name" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">No Telepon</label>
					<div class="controls"><input type="text" name="customer_phone" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Tujuan</label>
					<div class="controls"><input type="text" name="destination" readonly="readonly" /></div>
				</div>
			</form>
		</div>
	</div>
	<div id="WindowCalenderTravel" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Travel</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label">Tanggal Jadwal</label>
					<div class="controls"><input type="text" name="schedule_date" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Tujuan</label>
					<div class="controls"><input type="text" name="roster_dest" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Sopir</label>
					<div class="controls"><input type="text" name="driver_name" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Berangkat</label>
					<div class="controls"><input type="text" name="schedule_depature" readonly="readonly" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Sampai</label>
					<div class="controls"><input type="text" name="schedule_arrival" readonly="readonly" /></div>
				</div>
			</form>
		</div>
	</div>
	
	<?php $this->load->view( 'common/js' ); ?>
	
	<script>
		$(function () {
			setTimeout('$("html").removeClass("js")', 100);
			var ConfigRaw = $('#Config').text();
			eval('Config = ' + ConfigRaw);
			
			var Local = {
				LoadGridWidgetReservasi: function(Param) {
					var GridParam = {
						start: 0, limit: 10, page: 1,
						sort: '[{"property":"tanggal","direction":"DESC"}]',
						filter: '[{"type":"numeric","comparison":"eq","value":"pending","field":"status"}]'
					}
					
					$.ajax({
						type: "POST", url: Web.HOST + '/index.php/widget/reservasi/grid', data: GridParam
					}).done(function( ResponseHtml ) {
						$('#tab1 .widget_reservasi .datagrid').html(ResponseHtml);
						
						$('#WidgetReservasi .WindowWidgetDelete').click(function() {
							var RawRecord = $(this).parent('td').children('span.hidden').text();
							eval('var Record = ' + RawRecord);
							
							Func.ConfirmDelete({
								Data: { Action: 'Update', widget_reservasi_id: Record.widget_reservasi_id, status: 'done' },
								Url: '/widget/reservasi/action', Container: 'WidgetReservasi', LoadGrid: Local.LoadGridWidgetReservasi
							});
						});
					});
				},
				LoadGridRental: function(Param) {
					var GridParam = {
						start: 0, limit: 10, page: 1, NoPaging: 1,
						sort: '[{"property":"date_in","direction":"ASC"}]',
						filter: '[{"type":"date","comparison":"lt","value":"' + Config.CurrentDate + '","field":"RentalDetail.date_in"},{"type":"numeric","comparison":"eq","value":2,"field":"RentalDetail.rental_status_id"}]'
					}
					
					$.ajax({
						type: "POST", url: Web.HOST + '/index.php/rental_detail/grid_dash', data: GridParam
					}).done(function( ResponseHtml ) {
						$('#tab1 .rental .datagrid').html(ResponseHtml);
					});
				},
				LoadGridReservasi: function(Param) {
					var GridParam = {
						start: 0, limit: 10, page: 1, NoPaging: 1,
						sort: '[{"property":"customer_name","direction":"ASC"}]',
						filter: '[{"type":"numeric","comparison":"eq","value":1,"field":"Reservasi.reservasi_status_id"}]'
					}
					
					$.ajax({
						type: "POST", url: Web.HOST + '/index.php/reservasi/grid', data: GridParam
					}).done(function( ResponseHtml ) {
						$('#tab1 .reservasi .datagrid').html(ResponseHtml);
						$('#tab1 .reservasi .datagrid .action').hide();
					});
				},
				Calender: function() {
					for (var i = 0; i < Config.Calender.length; i++) {
						Config.Calender[i].start = eval(Config.Calender[i].start_text);
					}
					
					var calendar = $('#calendar').fullCalendar({
						aspectRatio: 2, selectable: true, selectHelper: true,
						editable: false, theme: false, eventColor: '#bcdeee',
						header: { left: 'prev next', center: 'title,today', right: 'month' },
						buttonText: { prev: '<i class="icon-chevron-left cal_prev" />', next: '<i class="icon-chevron-right cal_next" />' },
						events: Config.Calender,
						eventClick: function(event) {
							eval('var record = ' + event.desc);
							if (event.is_rental) {
								$('#WindowCalenderRental input[name="rental_no"]').val(record.rental_no);
								$('#WindowCalenderRental input[name="date_out"]').val(Func.SwapDate(record.date_out));
								$('#WindowCalenderRental input[name="date_in"]').val(Func.SwapDate(record.date_in));
								$('#WindowCalenderRental input[name="driver_name"]').val(record.driver_name);
								$('#WindowCalenderRental input[name="customer_name"]').val(record.customer_name);
								$('#WindowCalenderRental input[name="customer_phone"]').val(record.customer_phone);
								$('#WindowCalenderRental input[name="destination"]').val(record.destination);
								$('#WindowCalenderRental').modal();
							} else if (event.is_travel) {
								$('#WindowCalenderTravel input[name="schedule_date"]').val(Func.SwapDate(record.schedule_date));
								$('#WindowCalenderTravel input[name="roster_dest"]').val(record.roster_dest);
								$('#WindowCalenderTravel input[name="driver_name"]').val(record.driver_name);
								$('#WindowCalenderTravel input[name="schedule_depature"]').val(record.schedule_depature);
								$('#WindowCalenderTravel input[name="schedule_arrival"]').val(record.schedule_arrival);
								$('#WindowCalenderTravel').modal();
							}
							
							return false;
						}
					})
				}
			}
			Local.Calender();
			Local.LoadGridWidgetReservasi();
			Local.LoadGridRental({});
			Local.LoadGridReservasi({});
			
			// Log out
			$('#mainnav .Logout').click(function() {
				window.location.href = Site.Host + '/index.php/dashboard/logout';
			});
			
			$('.accordion-inner .btn-block').click(function() {
				$('.accordion-inner .btn-block').removeClass('btn-primary');
				$(this).addClass('btn-primary');
				
				var RawModul = $(this).val();
				eval("var Modul = " + RawModul);
				
				var ModulID = 'Tab' + Modul.menu_item_name.replace(/ /g, "");;
				if ($('a[href="#' + ModulID + '"]').length > 0) {
					$('a[href="#' + ModulID + '"]').click();
				} else {
					$('#ContentRight .nav-tabs li.active').removeClass('active').removeClass('in');
					$('#ContentRight .nav-tabs').append('<li><a href="#' + ModulID  + '" data-toggle="tab">' + Modul.menu_item_name + ' <button class="close" type="button">&times;</button></a></li>');
					$('#ContentRight .tab-content').append('<div class="tab-pane in active" id="' + ModulID  + '"> Loading ... </div>');
					$('#ContentRight .nav-tabs a:last').tab('show');
					
					// Init Closeable Tab
					$('#ContentRight .nav-tabs li.active a button').click(function() {
						var ListTab = $(this).parent('a').parent('li');
						var ContainerID = $(this).parent('a').attr('href').replace('#', '');
						$('#' + ContainerID).remove();
						$(this).parent('a').parent('li').remove();
						if (ListTab.hasClass('active')) {
							$('#ContentRight .nav-tabs li').eq(0).children('a').click();
						}
					});
					
					$.ajax({
						type: "POST", url: Web.HOST + '/index.php/' + Modul.menu_item_link,
					}).done(function( msg ) {
						$('#' + ModulID).html(msg);
					});
				}
			});
		})
	</script>
</body>
</html>
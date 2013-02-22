<?php
	$company_id = $this->User_model->GetCompanyID();
	$ArrayConfig = array(
		'CurrentDate' => GetFormatDateCommon($this->config->item('current_time'), array('FormatDate' => 'm/d/Y'))
	);
	
	// Get Menu
	$ParamCompany = array('filter' => '[{"type":"numeric","comparison":"eq","value":' . $company_id . ',"field":"company_id"},{"type":"numeric","comparison":"eq","value":1,"field":"menu_company_active"}]');
	$MenuCompany = $this->Menu_Item_model->GetTree($ParamCompany);
?>

<?php $this->load->view( 'common/meta' ); ?>

<body class="ptrn_e menu_hover">
	<div id="Config"><?php echo json_encode($ArrayConfig); ?></div>
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
	
	<?php $this->load->view( 'common/js' ); ?>
	
	<script>
		$(function () {
			setTimeout('$("html").removeClass("js")', 100);
			var ConfigRaw = $('#Config').text();
			eval('Config = ' + ConfigRaw);
			
			var Local = {
				LoadGridDriver: function(Param) {
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
				}
			}
			Local.LoadGridDriver({});
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
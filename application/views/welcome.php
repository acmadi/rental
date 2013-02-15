<?php
	$company_id = $this->User_model->GetCompanyID();
	$ArrayConfig = array(
		'CurrentDate' => GetFormatDateCommon($this->config->item('current_time'), array('FormatDate' => 'm/d/Y'))
	);
?>

<?php $this->load->view( 'common/meta' ); ?>

<body class="ptrn_e menu_hover">
	<div id="Config"><?php echo json_encode($ArrayConfig); ?></div>
	<div id="loading_layer" style="display:none"><img src="<?php echo $this->config->item('base_url'); ?>/static/img/ajax_loader.gif" alt="" /></div>
	
	<?php $this->load->view( 'common/header' ); ?>
	
	<div class="cnt-body">
		<div class="cnt-left">
			<div class="accordion pad" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Master</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse in">
						<div class="accordion-inner">
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Sopir","TabLink":"driver"}'>Sopir</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Pelanggan","TabLink":"customer"}'>Pelanggan</button>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">Rental</a>
					</div>
					<div id="collapseTwo" class="accordion-body collapse">
						<div class="accordion-inner">
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Sewa","TabLink":"rental"}'>Sewa</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Rental Kembali","TabLink":"rental_kembali"}'>Rental Kembali</button>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">Travel</a>
					</div>
					<div id="collapseThree" class="accordion-body collapse">
						<div class="accordion-inner">
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Roster","TabLink":"roster"}'>Roster</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Jadwal","TabLink":"schedule"}'>Jadwal</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Reservasi","TabLink":"reservasi"}'>Reservasi</button>
						</div>
					</div>
				</div>
				<?php if (COMPANY_ID_SIMETRI == $company_id) { ?>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">Administrasi</a>
					</div>
					<div id="collapseFour" class="accordion-body collapse">
						<div class="accordion-inner">
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Alat","TabLink":"device"}'>Alat</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Pengguna","TabLink":"user"}'>Pengguna</button>
							<button class="btn btn-large btn-block" type="submit" value='{"TabTitle":"Perusahaan","TabLink":"company"}'>Perusahaan</button>
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
				
				var ModulID = 'Tab' + Modul.TabTitle.replace(/ /g, "");;
				if ($('a[href="#' + ModulID + '"]').length > 0) {
					$('a[href="#' + ModulID + '"]').click();
				} else {
					$('#ContentRight .nav-tabs li.active').removeClass('active').removeClass('in');
					$('#ContentRight .nav-tabs').append('<li><a href="#' + ModulID  + '" data-toggle="tab">' + Modul.TabTitle + ' <button class="close" type="button">&times;</button></a></li>');
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
						type: "POST", url: Web.HOST + '/index.php/' + Modul.TabLink,
					}).done(function( msg ) {
						$('#' + ModulID).html(msg);
					});
				}
			});
		})
	</script>
</body>
</html>
<?php
	$date_start = (isset($_GET['date_start'])) ? $_GET['date_start'] : '';
	$date_end = (isset($_GET['date_end'])) ? $_GET['date_end'] : '';
	if (empty($date_start) || empty($date_end)) {
		exit;
	}
	
	$company_id = $this->User_model->GetCompanyID();
	$Company = $this->Company_model->GetByID(array('company_id' => $company_id ));
	
	$ParamTravel = array(
		'company_id' => $company_id,
		'filter' => '[' .
			'{"type":"date","comparison":"lt","value":"' . GetFormatDateCommon($date_end, array('FormatDate' => 'm/d/Y')) . '","field":"Schedule.schedule_date"},' . 
			'{"type":"date","comparison":"gt","value":"' . GetFormatDateCommon($date_start, array('FormatDate' => 'm/d/Y')) . '","field":"Schedule.schedule_date"}' .
		']',
		'sort' => '[{"property":"Schedule.schedule_date","direction":"ASC"}]',
		'limit' => 1000
	);
	$ArrayTravel = $this->Schedule_model->GetSummary($ParamTravel);
?>
<title>Laporan Travel - Umum</title>
<style>
table { border-collapse: collapse; }
td, tr { border: 1px solid #000000; padding: 2px 5px; }
.clear { clear: both; }
.center { text-align: center; }
.right { text-align: right; }
</style>

<div>
	<div style="text-align: center; padding: 0 0 20px 0;">
		<div style="font-size: 28px;">Laporan Travel Umum</div>
		<div style="font-size: 24px;"><?php echo $Company['company_name']; ?></div>
		<div style="font-size: 22px;"><?php echo $Company['company_address']; ?></div>
	</div>
	
	<div style="padding: 10px 0 20px 0;">
		<div style="float: left; width: 50%;">
			<div style="float: left; width: 150px;">Periode</div>
			<div style="float: left; width: 350px;">: <?php echo $date_start . ' s/d ' . $date_end; ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div>
		<?php if (count($ArrayTravel) > 0) { ?>
			<table style="width: 100%;">
				<tr class="center">
					<td>Tanggal</td>
					<td>Roster</td>
					<td>Sopir</td>
					<td>Total</td>
				</tr>
				<?php $Total = 0; ?>
				<?php foreach ($ArrayTravel as $Array) { ?>
					<?php $Total += $Array['total']; ?>
					<tr>
						<td class="center"><?php echo GetFormatDateCommon($Array['schedule_date']); ?></td>
						<td><?php echo $Array['roster_dest']; ?></td>
						<td><?php echo $Array['driver_name']; ?></td>
						<td class="right"><?php echo MoneyFormat($Array['total']); ?></td>
					</tr>
				<?php } ?>
					<tr>
						<td colspan="3" class="center">Total</td>
						<td class="right"><?php echo MoneyFormat($Total); ?></td>
					</tr>
			</table>
		<?php } else { ?>
			<div>Tidak ada data sewa.</div>
		<?php } ?>
	</div>
</div>
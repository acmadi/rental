<?php
	preg_match('/keuangan\/(\d+)\/(\d+)/i', $_SERVER['REQUEST_URI'], $Match);
	if (empty($Match[1]) && empty($Match[2])) {
		exit;
	} else {
		$Year = $Match[1];
		$Month = $Match[2];
	}
	
	$company_id = $this->User_model->GetCompanyID();
	$Company = $this->Company_model->GetByID(array('company_id' => $company_id ));
	$ArrayMonth = GetArrayMonth();
	
	
	$ParamRental = array(
		'company_id' => $company_id,
		'StringCustom' => "AND MONTH(Rental.order_date) = '$Month' AND YEAR(Rental.order_date) = '$Year'",
		'sort' => '[{"property":"order_date","direction":"ASC"}]',
		'limit' => 1000
	);
	$ArrayRental = $this->Rental_model->GetArray($ParamRental);
?>
<style>
table { border-collapse: collapse; }
td, tr { border: 1px solid #000000; padding: 2px 5px; }
.clear { clear: both; }
.center { text-align: center; }
.right { text-align: right; }
</style>

<div>
	<div style="text-align: center; padding: 0 0 20px 0;">
		<div style="font-size: 28px;">Laporan Keuangan</div>
		<div style="font-size: 24px;"><?php echo $Company['company_name']; ?></div>
		<div style="font-size: 22px;"><?php echo $Company['company_address']; ?></div>
	</div>
	
	<div style="padding: 10px 0 20px 0;">
		<div style="float: left; width: 50%;">
			<div style="float: left; width: 150px;">Periode</div>
			<div style="float: left; width: 150px;">: <?php echo $ArrayMonth[$Month] . ' ' . $Year; ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div>
		<?php if (count($ArrayRental) > 0) { ?>
			<table style="width: 100%;">
				<tr class="center">
					<td>No Sewa</td>
					<td>Tanggal Order</td>
					<td>Total</td>
				</tr>
				<?php $Total = 0; ?>
				<?php foreach ($ArrayRental as $Array) { ?>
					<?php $Total += $Array['total_price']; ?>
					<tr>
						<td><?php echo $Array['rental_no']; ?></td>
						<td class="center"><?php echo GetFormatDateCommon($Array['order_date']); ?></td>
						<td class="right"><?php echo $Array['total_price']; ?></td>
				<?php } ?>
					<tr>
						<td colspan="2" class="center">Total</td>
						<td class="right"><?php echo $Total; ?></td>
			</table>
		<?php } else { ?>
			<div>Tidak ada data sewa.</div>
		<?php } ?>
	</div>
</div>
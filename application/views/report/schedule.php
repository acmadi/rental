<?php
	preg_match('/report\/(\d+)/i', $_SERVER['REQUEST_URI'], $Match);
	if (empty($Match[1])) {
		exit;
	}
	
	$schedule_id = $Match[1];
	$Schedule = $this->Schedule_model->GetByID(array('schedule_id' => $schedule_id));
	
	$ParamReservasi = array(
		'filter' => '[{"type":"numeric","comparison":"eq","value":"' . $schedule_id . '","field":"Schedule.schedule_id"}]',
		'sort' => '[{"property":"customer_name","direction":"ASC"}]'
	);
	$ArrayReservasi = $this->Reservasi_model->GetArray($ParamReservasi);
?>
<style>
table { border-collapse: collapse; }
td, tr { border: 1px solid #000000; padding: 2px 5px; }
.clear { clear: both; }
.center { text-align: center; }
</style>

<div>
	<div style="text-align: center; padding: 0 0 20px 0;">
		<div style="font-size: 28px;">Laporan Jadwal</div>
		<div style="font-size: 24px;"><?php echo $Schedule['company_name']; ?></div>
		<div style="font-size: 22px;"><?php echo $Schedule['company_address']; ?></div>
	</div>
	
	<div style="padding: 10px 0 20px 0;">
		<div style="float: left; width: 50%;">
			<div style="float: left; width: 150px;">Roster</div>
			<div style="float: left; width: 150px;">: <?php echo $Schedule['roster_dest']; ?></div>
			<div class="clear"></div>
			<div style="float: left; width: 150px;">Hari</div>
			<div style="float: left; width: 150px;">: <?php echo $Schedule['schedule_day_title']; ?></div>
			<div class="clear"></div>
			<div style="float: left; width: 150px;">Tanggal</div>
			<div style="float: left; width: 150px;">: <?php echo GetFormatDateCommon($Schedule['schedule_date']); ?></div>
			<div class="clear"></div>
			<div style="float: left; width: 150px;">Sopir</div>
			<div style="float: left; width: 150px;">: <?php echo $Schedule['driver_name']; ?></div>
			<div class="clear"></div>
		</div>
		<div style="float: left; width: 50%;">
			<div style="float: left; width: 150px;">Berangkat</div>
			<div style="float: left; width: 150px;">: <?php echo $Schedule['schedule_depature']; ?></div>
			<div class="clear"></div>
			<div style="float: left; width: 150px;">Sampai</div>
			<div style="float: left; width: 150px;">: <?php echo $Schedule['schedule_arrival']; ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div>
		<?php if (count($ArrayReservasi) > 0) { ?>
			<table style="width: 100%;">
				<tr class="center">
					<td>Nama Pelanggan</td>
					<td>Alamat</td>
					<td>Telepon</td>
					<td>Status</td>
					<td>Kapasitas</td>
					<td>Harga</td>
					<td>Total</td>
					<td>Catatan</td>
				</tr>
				<?php foreach ($ArrayReservasi as $Array) { ?>
					<tr>
						<td><?php echo $Array['customer_name']; ?></td>
						<td><?php echo $Array['customer_address']; ?></td>
						<td><?php echo $Array['customer_phone']; ?></td>
						<td><?php echo $Array['reservasi_status_name']; ?></td>
						<td><?php echo $Array['reservasi_capacity']; ?></td>
						<td><?php echo $Array['reservasi_price']; ?></td>
						<td><?php echo $Array['reservasi_total']; ?></td>
						<td><?php echo $Array['reservasi_note']; ?></td>
				<?php } ?>
			</table>
		<?php } else { ?>
			<div>Penumpang kosong</div>
		<?php } ?>
	</div>
</div>
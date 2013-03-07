<?php
	$result['rows'] = $this->Rental_Detail_model->GetArray($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Mobil</th>
			<th>Sopir</th>
			<th>Keluar</th>
			<th>Kembali</th>
			<th>Tujuan</th>
			<th>Durasi</th>
			<th>Total Biaya</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['device']; ?></td>
				<td><?php echo $Array['driver_name']; ?></td>
				<td><?php echo GetFormatDateCommon($Array['date_out']); ?></td>
				<td><?php echo GetFormatDateCommon($Array['date_in']); ?></td>
				<td><?php echo $Array['destination']; ?></td>
				<td><?php echo $Array['rental_detail_jumlah'].' x '.$Array['rental_durasi_name']; ?></td>
				<td><?php echo $Array['rental_detail_cost']; ?></td>
				<td class="center">
					<a class="cursor WindowRentalDetailEdit"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_edit.png'; ?>" /></a>
					<a class="cursor WindowRentalDetailDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
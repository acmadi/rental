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
			<th>Harga / Hari</th>
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
				<td><?php echo $Array['rental_duration']; ?></td>
				<td><?php echo $Array['price_per_day']; ?></td>
				<td>
					<a class="btn-edit WindowRentalDetailEdit"></a>
					<a class="btn-del WindowRentalDetailDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
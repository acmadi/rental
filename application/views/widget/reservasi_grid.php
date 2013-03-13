<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Widget_Reservasi_model->GetArray($_POST);
	$result['totalCount'] = $this->Widget_Reservasi_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Jenis</th>
			<th>Tujuan</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Telepon</th>
			<th>Email</th>
			<th>Alamat</th>
			<th>Catatan</th>
			<th>Status</th>
			<th>Validasi</th>
			<th style="text-align: center; width: 70px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['jenis']; ?></td>
				<td><?php echo $Array['tujuan']; ?></td>
				<td><?php echo $Array['tanggal']; ?></td>
				<td><?php echo $Array['nama']; ?></td>
				<td><?php echo $Array['telepon']; ?></td>
				<td><?php echo $Array['email']; ?></td>
				<td><?php echo $Array['alamat']; ?></td>
				<td><?php echo $Array['catatan']; ?></td>
				<td><?php echo $Array['status']; ?></td>
				<td><?php echo $Array['validate_status']; ?></td>
				<td class="center">
					<a class="cursor WindowWidgetDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
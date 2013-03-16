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
			<th>Mobile</th>
			<th>Email</th>
			<th>Status</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['jenis']; ?></td>
				<td><?php echo $Array['tujuan']; ?></td>
				<td><?php echo $Array['tanggal']; ?></td>
				<td><?php echo $Array['nama']; ?></td>
				<td><?php echo $Array['mobile']; ?></td>
				<td><?php echo $Array['email']; ?></td>
				<td><?php echo $Array['status']; ?></td>
				<td class="center">
					<a class="cursor WindowWidgetCheck"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_check.png'; ?>" /></a>
					<a class="cursor WindowWidgetDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
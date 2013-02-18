<?php
	$result['rows'] = $this->Device_model->GetArray($_POST);
	$result['totalCount'] = $this->Device_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ID Alat</th>
			<th>Nama Alat</th>
			<th>Msisdn</th>
			<th>Tanggal Register</th>
			<th>Tanggal Aktif</th>
			<th>Perusahaan</th>
			<th>Aktif</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['deviceid']; ?></td>
				<td><?php echo $Array['device']; ?></td>
				<td><?php echo $Array['msisdn']; ?></td>
				<td><?php echo $Array['register_date']; ?></td>
				<td><?php echo $Array['active_date']; ?></td>
				<td><?php echo $Array['company_name']; ?></td>
				<td><?php echo ($Array['active'] == 1) ? 'Ya' : 'Tidak'; ?></td>
				<td>
					<a class="btn-edit WindowDeviceEdit"></a>
					<a class="btn-del WindowDeviceDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
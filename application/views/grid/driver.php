<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Driver_model->GetArray($_POST);
	$result['totalCount'] = $this->Driver_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>HP</th>
			<th>Biaya</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['driver_name']; ?></td>
				<td><?php echo $Array['driver_address']; ?></td>
				<td><?php echo $Array['driver_phone']; ?></td>
				<td><?php echo $Array['driver_mobile']; ?></td>
				<td><?php echo $Array['driver_fee']; ?></td>
				<td>
					<a class="btn-edit WindowDriverEdit"></a>
					<a class="btn-del WindowDriverDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
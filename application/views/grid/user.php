<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$_POST['company_id'] = ($_POST['company_id'] == COMPANY_ID_SIMETRI) ? 0 : $_POST['company_id'];
	$result['rows'] = $this->User_model->GetArray($_POST);
	$result['totalCount'] = $this->User_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Username</th>
			<th>Nama</th>
			<th>Email</th>
			<th>HP</th>
			<th>Premium</th>
			<th>Perusahaan</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['username']; ?></td>
				<td><?php echo $Array['name']; ?></td>
				<td><?php echo $Array['email']; ?></td>
				<td><?php echo $Array['msisdn']; ?></td>
				<td><?php echo ($Array['ispremium'] == 1) ? 'Ya' : 'Tidak'; ?></td>
				<td><?php echo $Array['company_name']; ?></td>
				<td>
					<a class="btn-edit WindowUserEdit"></a>
					<a class="btn-del WindowUserDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
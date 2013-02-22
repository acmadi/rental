<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Customer_model->GetArray($_POST);
	$result['totalCount'] = $this->Customer_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>HP</th>
			<th>Kelamin</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['customer_name']; ?></td>
				<td><?php echo $Array['customer_address']; ?></td>
				<td><?php echo $Array['customer_phone']; ?></td>
				<td><?php echo $Array['customer_mobile']; ?></td>
				<td><?php echo $Array['customer_gender']; ?></td>
				<td class="center">
					<a class="cursor WindowCustomerEdit"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_edit.png'; ?>" /></a>
					<a class="cursor WindowCustomerDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
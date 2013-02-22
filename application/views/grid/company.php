<?php
	$result['rows'] = $this->Company_model->GetArray($_POST);
	$result['totalCount'] = $this->Company_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th style="text-align: center; width: 210px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['company_name']; ?></td>
				<td><?php echo $Array['company_address']; ?></td>
				<td><?php echo $Array['company_phone']; ?></td>
				<td class="center">
					<a class="cursor WindowCompanyEdit"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_edit.png'; ?>" /></a>
					<a class="cursor WindowMenu"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_menu.png'; ?>" /></a>
					<a class="cursor WindowCompanyDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
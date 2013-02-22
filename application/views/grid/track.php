<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	
	// Hack only for Simetri
	$_POST['company_id'] = ($_POST['company_id'] == COMPANY_ID_SIMETRI) ? 0 : $_POST['company_id'];
	
	$result['rows'] = $this->Device_model->GetArray($_POST);
	$result['totalCount'] = $this->Device_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ID Alat</th>
			<th>Nama Alat</th>
			<th>Msisdn</th>
			<th>Tanggal Aktif</th>
			<th>Aktif</th>
			<th class="center">Tracking</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['deviceid']; ?></td>
				<td><?php echo $Array['device']; ?></td>
				<td><?php echo $Array['msisdn']; ?></td>
				<td><?php echo $Array['active_date']; ?></td>
				<td><?php echo ($Array['active'] == 1) ? 'Ya' : 'Tidak'; ?></td>
				<td class="center">
					<a href="<?php echo $Array['lintas_url']; ?>" target="_blank" style="text-decoration: none;">
						<img src="<?php echo $this->config->item('base_url') . '/static/img/btn_report.png'; ?>" />
					</a>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Roster_model->GetArray($_POST);
	$result['totalCount'] = $this->Roster_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Hari</th>
			<th>Waktu</th>
			<th>Tujuan</th>
			<th>Kapasitas</th>
			<th>Harga</th>
			<th>Status</th>
			<th style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['roster_day_title']; ?></td>
				<td><?php echo $Array['roster_time']; ?></td>
				<td><?php echo $Array['roster_dest']; ?></td>
				<td><?php echo $Array['roster_capacity']; ?></td>
				<td><?php echo $Array['roster_price']; ?></td>
				<td><?php echo ($Array['roster_active'] == 1) ? 'Aktif' : 'Tidak Aktif'; ?></td>
				<td class="center">
					<a class="cursor WindowRosterEdit"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_edit.png'; ?>" /></a>
					<a class="cursor WindowRosterDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
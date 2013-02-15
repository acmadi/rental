<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Schedule_model->GetArray($_POST);
	$result['totalCount'] = $this->Schedule_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Tujuan</th>
			<th>Sopir</th>
			<th>Hari</th>
			<th>Tanggal</th>
			<th>Berangkat</th>
			<th>Sampai</th>
			<th style="text-align: center; width: 210px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['roster_dest']; ?></td>
				<td><?php echo $Array['driver_name']; ?></td>
				<td><?php echo $Array['schedule_day_title']; ?></td>
				<td><?php echo GetFormatDateCommon($Array['schedule_date']); ?></td>
				<td><?php echo $Array['schedule_depature']; ?></td>
				<td><?php echo $Array['schedule_arrival']; ?></td>
				<td>
					<a class="btn-edit WindowScheduleEdit"></a>
					<a class="btn-report WindowScheduleReport"></a>
					<a class="btn-del WindowScheduleDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
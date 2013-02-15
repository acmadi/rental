<?php
	$NoPaging = (isset($_POST['NoPaging'])) ? $_POST['NoPaging'] : 0;
	
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Reservasi_model->GetArray($_POST);
	$result['totalCount'] = $this->Reservasi_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Tujuan</th>
			<th>Berangkat</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Kapasitas</th>
			<th>Total</th>
			<th>Catatan</th>
			<th>Status</th>
			<th class="action" style="text-align: center; width: 140px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo GetFormatDateCommon($Array['schedule_date']); ?></td>
				<td><?php echo $Array['roster_dest']; ?></td>
				<td><?php echo $Array['schedule_depature']; ?></td>
				<td><?php echo $Array['customer_name']; ?></td>
				<td><?php echo $Array['customer_address']; ?></td>
				<td><?php echo $Array['customer_phone']; ?></td>
				<td><?php echo $Array['reservasi_capacity']; ?></td>
				<td><?php echo $Array['reservasi_total']; ?></td>
				<td><?php echo $Array['reservasi_note']; ?></td>
				<td><?php echo $Array['reservasi_status_name']; ?></td>
				<td class="action">
					<a class="btn-edit WindowReservasiEdit"></a>
					<a class="btn-del WindowReservasiDelete"></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php if ($NoPaging == 0) { ?>
	<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
<?php } ?>
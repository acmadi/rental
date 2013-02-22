<?php
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Rental_Detail_model->GetArray($_POST);
	$result['totalCount'] = $this->Rental_Detail_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>No Sewa</th>
			<th>Pelanggan</th>
			<th>Tanggal Pesan</th>
			<th>Tanggal Kembali</th>
			<th>Total</th>
			<th>Mobil</th>
			<th>Status</th>
			<th style="text-align: center; width: 70px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['rental_no']; ?></td>
				<td><?php echo $Array['customer_name']; ?></td>
				<td><?php echo GetFormatDateCommon($Array['order_date']); ?></td>
				<td><?php echo GetFormatDateCommon($Array['date_in']); ?></td>
				<td><?php echo $Array['total_price']; ?></td>
				<td><?php echo $Array['device']; ?></td>
				<td><?php echo $Array['rental_status_name']; ?></td>
				<td class="center">
					<a class="cursor WindowRentalEdit"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_edit.png'; ?>" /></a>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
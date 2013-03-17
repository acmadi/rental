<?php
	$is_modul = (isset($_POST['is_modul'])) ? $_POST['is_modul'] : 0;
	$_POST['company_id'] = $this->User_model->GetCompanyID();
	$result['rows'] = $this->Widget_Reservasi_model->GetArray($_POST);
	$result['totalCount'] = $this->Widget_Reservasi_model->GetCount($_POST);
?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Jenis</th>
			<th>Tujuan</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Mobile</th>
			<th>Alamat</th>
			<th>Email</th>
			<th>Status</th>
			<?php if ($is_modul == 1) { ?>
				<th style="text-align: center; width: 70px;">Aksi</th>
			<?php } else { ?>
				<th style="text-align: center; width: 210px;">Aksi</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result['rows'] as $Array) { ?>
			<tr>
				<td><?php echo $Array['jenis']; ?></td>
				<td><?php echo $Array['tujuan']; ?></td>
				<td><?php echo $Array['tanggal']; ?></td>
				<td><?php echo $Array['nama']; ?></td>
				<td><?php echo $Array['mobile']; ?></td>
				<td><?php echo $Array['alamat']; ?></td>
				<td><?php echo $Array['email']; ?></td>
				<td><?php echo $Array['status']; ?></td>
				<td class="center">
					<?php if ($is_modul == 1) { ?>
						<a class="cursor WindowWidgetDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<?php } else { ?>
						<a class="cursor WindowWidgetCheck"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_check.png'; ?>" /></a>
						<a class="cursor WindowWidgetShortcut"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_shortcut.png'; ?>" /></a>
						<a class="cursor WindowWidgetDelete"><img src="<?php echo $this->config->item('base_url') . '/static/img/btn_del.png'; ?>" /></a>
					<?php } ?>
					<span class="hidden"><?php echo json_encode($Array); ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php if ($is_modul == 1) { ?>
	<?php $this->load->view( 'common/paging', array( 'PageActive' => $_POST['page'], 'PageTotal' => ceil($result['totalCount'] / PAGE_COUNT) ) ); ?>
<?php } ?>
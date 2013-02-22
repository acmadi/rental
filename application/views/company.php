<?php
	$Menu = $this->Menu_Item_model->GetTree();
?>
<div id="CntCompany" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="company_name">Nama</option>
				<option value="company_address">Alamat</option>
				<option value="company_phone">Telepon</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-sprocket_dark"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowCompanyAdd">Tambah Perusahaan</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowCompany" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Perusahaan</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="company_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_company_name">Nama</label>
					<div class="controls"><input type="text" id="input_company_name" name="company_name" placeholder="Nama" rel="twipsy" data-placement="right" data-original-title="Nama Perusahaan" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_company_address">Alamat</label>
					<div class="controls"><textarea id="input_company_address" name="company_address" placeholder="Alamat" rows="3" cols="30" rel="twipsy" data-placement="right" data-original-title="Alamat Perusahaan"></textarea></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_company_phone">Telepon</label>
					<div class="controls"><input type="text" id="input_company_phone" name="company_phone" placeholder="Telepon" rel="twipsy" data-placement="right" data-original-title="Telepon Perusahaan" /></div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowCompanyClose">Cancel</a>
			<a href="#" class="btn btn-large WindowCompanySave btn-primary">OK</a>
		</div>
	</div>
	
	<div id="WindowMenu" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Menu</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="company_id" value="0" />
				<div class="accordion pad" id="accordion_form">
					
					<?php $Collapse = true; ?>
					<?php foreach ($Menu as $Key => $Array) { ?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_form" href="#win_acc_<?php echo $Key; ?>"><?php echo $Key; ?></a>
							</div>
							<div id="win_acc_<?php echo $Key; ?>" class="accordion-body collapse <?php echo ($Collapse) ? 'in' : ''; ?>">
								<div class="accordion-inner">
									<table class="table table-bordered table-striped">
										<thead><tr><th>Nama Menu</th><th class="center">Aktif</th></tr></thead>
										<tbody>
											<?php foreach ($Array as $Item) { ?>
												<tr>
													<td><?php echo $Item['menu_item_name']; ?></td>
													<td class="center"><input type="checkbox" class="menu_item" name="ItemID_<?php echo $Item['menu_item_id']; ?>" value="1" /></td></tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php $Collapse = false; ?>
					<?php } ?>
					
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowMenuClose">Cancel</a>
			<a href="#" class="btn btn-large WindowMenuSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntCompany input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntCompany input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntCompany input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"company_name","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/company/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntCompany .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntCompany .WindowMenu').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowMenu input[name="company_id"]').val(Record.company_id);
				$('#WindowMenu .menu_item').attr('checked', false);
				$('#WindowMenu').modal();
				
				$('#WindowMenu .form-horizontal').hide();
				$.ajax({
					type: "POST", url: Web.HOST + '/index.php/company/action',
					data: { Action: 'GetMenu', company_id: Record.company_id }
				}).done(function( RawResult ) {
					eval('var Menu = ' + RawResult);
					
					for (var i = 0; i < Menu.length; i++) {
						if (Menu[i].menu_company_active != null) {
							$('#WindowMenu input[name="ItemID_' + Menu[i].menu_item_id + '"]').attr('checked', (Menu[i].menu_company_active == 1));
						}
					}
					$('#WindowMenu .form-horizontal').show();
				});
			});
			$('#CntCompany .WindowCompanyEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowCompany input[name="company_id"]').val(Record.company_id);
				$('#WindowCompany input[name="company_name"]').val(Record.company_name);
				$('#WindowCompany input[name="company_address"]').val(Record.company_address);
				$('#WindowCompany input[name="company_phone"]').val(Record.company_phone);
				$('#WindowCompany').modal();
			});
			$('#CntCompany .WindowCompanyDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleCompanyByID', company_id: Record.company_id },
					Url: '/company/action', Container: 'CntCompany', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntCompany .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntCompany input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry Company
	$('#CntCompany .WindowCompanyAdd').click(function() {
		$('#WindowCompany').modal();
		$('#WindowCompany input[name="company_id"]').val(0);
		$('#WindowCompany form').each(function(){ this.reset(); });
	});
	$('#CntCompany .WindowCompanySave').click(function() {
		if (! $('#WindowCompany form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowCompany form');
		ParamAjax.Action = 'UpdateCompany';
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/company/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntCompany').prepend(Content);
				
				$('#WindowCompany').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowCompany form').prepend(Content);
			}
		});
	});
	$('#CntCompany .WindowCompanyClose').click(function() {
		$('#CntCompany #WindowCompany').modal('hide');
	});
	Func.InitForm({
		Container: '#WindowCompany',
		rule: { company_name: { required: true }, company_address: { required: true }, company_phone: { required: true } }
	});
	
	// Form Menu
	$('#CntCompany .WindowMenuSave').click(function() {
		var FormRaw = Site.Form.GetValue('#CntCompany #WindowMenu');
		var ArrayItem = [];
		for (var i = 0; i < 50; i++) {
			if (FormRaw['ItemID_' + i] != null) {
				ArrayItem.push({ menu_item_id: i, menu_company_active: FormRaw['ItemID_' + i] });
			}
		}
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/company/action',
			data: { Action: 'UpdateMenu', company_id: FormRaw.company_id, menu_item: Func.ArrayToJson(ArrayItem) }
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntCompany').prepend(Content);
				
				$('#WindowMenu').modal('hide');
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowCompany form').prepend(Content);
			}
		});
	});
	$('#CntCompany .WindowMenuClose').click(function() {
		$('#CntCompany #WindowMenu').modal('hide');
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntCompany', FirstValue: 'company_name', LoadGrid: Local.LoadGrid });
});
</script>
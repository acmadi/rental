<?php
	$ArrayCompany = $this->Company_model->GetArray(array('limit' => 1000));
?>
<div id="CntUser" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="username">Username</option>
				<option value="name">Nama</option>
				<option value="email">Email</option>
				<option value="msisdn">HP</option>
				<option value="company_name">Perusahaan</option>
			</select>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
		
		<button class="btn btn-large WindowUserAdd">Tambah Pengguna</button>
	</div>
	
	<div class="datagrid"></div>
	
	<div id="WindowUser" class="modal modal-big hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h3>Form Pengguna</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<input type="hidden" name="user_id" value="0" />
				<div class="control-group">
					<label class="control-label" for="input_username">Username</label>
					<div class="controls"><input type="text" id="input_username" name="username" placeholder="Username" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_name">Nama</label>
					<div class="controls"><input type="text" id="input_name" name="name" placeholder="Nama" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_password">Password</label>
					<div class="controls"><input type="password" id="input_password" name="password" placeholder="Password" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_password_confirm">Password Konfirmasi</label>
					<div class="controls"><input type="password" id="input_password_confirm" name="password_confirm" placeholder="Password Konfirmasi" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_email">Email</label>
					<div class="controls"><input type="text" id="input_email" name="email" placeholder="Email" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input_msisdn">Telepon</label>
					<div class="controls"><input type="text" id="input_msisdn" name="msisdn" placeholder="Telepon" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Perusahaan</label>
					<div class="controls">
						<select name="company_id">
							<?php echo ShowOption(array('Array' => $ArrayCompany, 'ArrayID' => 'company_id', 'ArrayTitle' => 'company_name')); ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="ispremium" value="1" /> Premium
						</label>
						<label class="checkbox">
							<input type="checkbox" name="confirmed" value="1" /> Konfirmasi
						</label>
					</div>
				</div>
				<div class="hidden"><input type="submit" name="Submit" value="Submit" /></div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-large WindowUserClose">Cancel</a>
			<a href="#" class="btn btn-large WindowUserSave btn-primary">OK</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntUser input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntUser input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntUser input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"username","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/user/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntUser .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntUser .WindowUserEdit').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				$('#WindowUser input[name="password"]').val('');
				$('#WindowUser input[name="password_confirm"]').val('');
				
				$('#WindowUser input[name="user_id"]').val(Record.user_id);
				$('#WindowUser input[name="username"]').val(Record.username);
				$('#WindowUser input[name="email"]').val(Record.email);
				$('#WindowUser input[name="name"]').val(Record.name);
				$('#WindowUser input[name="msisdn"]').val(Record.msisdn);
				$('#WindowUser input[name="ispremium"]').attr('checked', (Record.ispremium == 1));
				$('#WindowUser input[name="confirmed"]').attr('checked', (Record.confirmed == 1));
				$('#WindowUser select[name="company_id"]').val(Record.company_id);
				$('#WindowUser').modal();
			});
			$('#CntUser .WindowUserDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'DeteleUserByID', user_id: Record.user_id },
					Url: '/user/action', Container: 'CntUser', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntUser .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntUser input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Form Entry User
	$('#CntUser .WindowUserAdd').click(function() {
		$('#WindowUser').modal();
		$('#WindowUser input[name="user_id"]').val(0);
		$('#WindowUser form').each(function(){ this.reset(); });
	});
	$('#CntUser .WindowUserSave').click(function() {
		if (! $('#WindowUser form').valid()) {
			return;
		}
		
		var ParamAjax = Site.Form.GetValue('WindowUser form');
		ParamAjax.Action = 'UpdateUser';
		ParamAjax.id = ParamAjax.user_id;
		
		if (ParamAjax.password.length == 0) {
			delete ParamAjax.password;
		}
		
		$.ajax({
			type: "POST", url: Web.HOST + '/index.php/user/action', data: ParamAjax
		}).done(function( RawResult ) {
			eval('var Result = ' + RawResult);
			
			if (Result.QueryStatus == 1) {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Notification! </strong>' + Result.Message + '</div>';
				$('#CntUser').prepend(Content);
				
				$('#WindowUser').modal('hide');
				Local.LoadGrid({});
			} else {
				$('.alert').remove();
				var Content = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning! </strong>' + Result.Message + '</div>';
				$('#WindowUser .modal-body').prepend(Content);
			}
		});
	});
	$('#CntUser .WindowUserClose').click(function() {
		$('#WindowUser').modal('hide');
	});
	$('#WindowUser form').validate({
		onkeyup: false, errorClass: 'error', validClass: 'valid',
		highlight: function(element) { $(element).closest('div').addClass("f_error"); },
		unhighlight: function(element) { $(element).closest('div').removeClass("f_error"); },
		errorPlacement: function(error, element) { $(element).closest('div').append(error); },
		rules: {
			name: { required: true },
			username: { required: true },
			email: { required: true },
			msisdn: { required: true },
			password: { first_user: true },
			password_confirm: { password_confirm: true }
		}
	});
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntUser', FirstValue: 'username', LoadGrid: Local.LoadGrid });
});
</script>
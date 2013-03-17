<div id="CntReservasiOnline" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike" autocomplete="off">
			<select class="select-large GridFilter">
				<option value="nama">Nama</option>
				<option value="mobile">Mobile</option>
				<option value="alamat">Alamat</option>
			</select>
			<button class="btn btn-large Reset" type="button"><i class="splashy-refresh"></i></button>
			<button class="btn btn-large Search" type="submit"><i class="icon-search"></i></button>
		</div>
	</div>
	
	<div class="datagrid"></div>
</div>

<script>
$(document).ready(function() {
	var Local = {
		LoadGrid: function(Param) {
			Param.PageNo = (Param.PageNo == null) ? $('#CntReservasiOnline input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntReservasiOnline input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntReservasiOnline input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"tanggal","direction":"DESC"}]',
				is_modul: 1
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/widget/reservasi/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntReservasiOnline .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntReservasiOnline .WindowWidgetDelete').click(function() {
				var RawRecord = $(this).parent('td').children('span.hidden').text();
				eval('var Record = ' + RawRecord);
				
				Func.ConfirmDelete({
					Data: { Action: 'Delete', widget_reservasi_id: Record.widget_reservasi_id },
					Url: '/widget/reservasi/action', Container: 'CntReservasiOnline', LoadGrid: Local.LoadGrid
				});
			});
			$('#CntReservasiOnline .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntReservasiOnline input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntReservasiOnline', FirstValue: 'nama', LoadGrid: Local.LoadGrid });
});
</script>
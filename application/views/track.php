<div id="CntTrack" class="row-fluid">
	<input type="hidden" name="PAGE_COUNT" value="<?php echo PAGE_COUNT; ?>" />
	<input type="hidden" name="PAGE_ACTIVE" value="1" />
	<input type="hidden" name="PAGE_FILTER" value="" />
	
	<div class="btn-group" style="width: 100%;">
		<div class="input-append right" style="float: right;">
			<input type="text" placeholder="Cari..." size="16" class="input-large" name="namelike">
			<select class="select-large GridFilter">
				<option value="deviceid">Device ID</option>
				<option value="device">Nama Alat</option>
				<option value="msisdn">Msisdn</option>
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
			Param.PageNo = (Param.PageNo == null) ? $('#CntTrack input[name="PAGE_ACTIVE"]').val() : Param.PageNo;
			var PageCount = $('#CntTrack input[name="PAGE_COUNT"]').val();
			var PageFilter = $('#CntTrack input[name="PAGE_FILTER"]').val();
			
			var GridParam = {
				start: (Param.PageNo - 1) * PageCount,
				limit: PageCount, page: Param.PageNo, filter: PageFilter,
				sort: '[{"property":"deviceid","direction":"ASC"}]'
			}
			
			$.ajax({
				type: "POST", url: Web.HOST + '/index.php/track/grid', data: GridParam
			}).done(function( ResponseHtml ) {
				$('#CntTrack .datagrid').html(ResponseHtml);
				Local.InitGrid();
			});
		},
		InitGrid: function() {
			$('#CntTrack .pagination a').click(function() {
				var PageNo = $(this).children('span.hidden').text();
				
				Local.LoadGrid({ PageNo: PageNo });
				$('#CntTrack input[name="PAGE_ACTIVE"]').val(PageNo);
			});
		}
	}
	
	// Load Feature Grid
	Func.Feature({ Container: 'CntTrack', FirstValue: 'deviceid', LoadGrid: Local.LoadGrid });
});
</script>
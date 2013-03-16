<?php
	$company_id = $this->User_model->GetCompanyID();
?>
<div id="CntSewaReport" class="row-fluid">
	<h2>Reservasi Rental Online</h2>
	<pre>&lt;script type="text/javascript"&gt;var company_id = <?php echo $company_id; ?>;var widget_type = 'rental';&lt;/script&gt;
&lt;script type="text/javascript" src="http://lintasgps.com/rental/static/js/widget/reservasi.js"&gt;&lt;/script&gt;</pre>
	
	<h2>Reservasi Travel Online</h2>
	<pre>&lt;script type="text/javascript"&gt;var company_id = <?php echo $company_id; ?>;var widget_type = 'travel';&lt;/script&gt;
&lt;script type="text/javascript" src="http://lintasgps.com/rental/static/js/widget/reservasi.js"&gt;&lt;/script&gt;</pre>
</div>
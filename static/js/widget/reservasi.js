(function(){
	var h = 600; var w = 500;
	var company = (typeof company_id=='number') ? company_id : 1;
	var url = 'http://lintasgps.com/rental/index.php/widget/reservasi/?company_id=' + escape(company);
	document.write("<iframe src='" + url + "' height='" + h + "' width='" + w + "' frameborder='0' scrolling='no'></iframe>");
})();
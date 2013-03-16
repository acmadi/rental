(function(){
	var h = 635; var w = 500;
	var company = (typeof company_id=='number') ? company_id : 1;
	var url = 'http://localhost:8666/rental/trunk//index.php/widget/reservasi/?company_id=' + escape(company);
	document.write("<iframe src='" + url + "' height='" + h + "' width='" + w + "' frameborder='0' scrolling='no'></iframe>");
})();
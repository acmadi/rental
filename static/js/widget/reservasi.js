function init_widget(param) {
	var h = 635; var w = 500;
	var url = 'http://localhost/rental/trunk/index.php/widget/reservasi/?company_id=' + escape(param.company_id) + '&widget_type=' + escape(param.widget_type);
	document.write("<iframe src='" + url + "' height='" + h + "' width='" + w + "' frameborder='0' scrolling='no'></iframe>");
}

init_widget({ company_id: company_id, widget_type: widget_type });
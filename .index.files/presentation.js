jQuery(document).ready( function() {

	PURCHASEABLE_nationalMetrics.processData();
	BODY = jQuery(document.body);
	MAINFRAME = jQuery('#mainFrame');

	jQuery('#csv').text(PURCHASEABLE_nationalMetrics.exportToCsv());

	jQuery('.highlight').on('click', function(event) {
		var node = jQuery(event.delegateTarget);
		var name = node[0].className.replace('highlight', '').replace('active','').trim();
		jQuery('.highlight.'+name).toggleClass('active');
		BODY.toggleClass(name);
	});

	jQuery('.sort').on('click', function(event) {
		jQuery('.sort').removeClass('active');
		var node = jQuery(event.delegateTarget);
		var name = node[0].className.substring('sort '.length);
		jQuery('.sort.'+name).addClass('active');
		
		var nations = jQuery('.nation');
		
		var nationsAsArray = [];
		nations.each(function() {nationsAsArray.push(jQuery(this));});
		
		nationsAsArray.sort(function(l,r) {
			var lWidth = l.find('.'+ name).width();
			var rWidth = r.find('.'+ name).width();
			
			if (lWidth == rWidth) {
				lWidth = l.find('._aggregated_exponential').width();
				rWidth = r.find('._aggregated_exponential').width();
			}
			if (lWidth != rWidth) {
				return lWidth- rWidth;
			}
			
			return l.text().localeCompare(r.text());
		} );
		
		nationsAsArray.forEach(function(item) { 
			item.appendTo(MAINFRAME);
		});
	});

	var data = PURCHASEABLE_nationalMetrics.data;
	var metrics = {
		'_aggregated_exponential': 'exponential of average'
		, '_normalized_nationmaster_localPurchasingPower': 'nationmaster_localPurchasingPower'
		, '_normalized_numbeo_localPurchasingPower': 'numbeo_localPurchasingPower'
		, '_normalized_wikipedia_economicFreedom': 'wikipedia_economicFreedom'
		, '_normalized_wikipedia_humanDevelopmentIndex': 'wikipedia_humanDevelopmentIndex'
	};

	for (var isoCode in data) {
		var each = data[isoCode];
		each.html = {};
		
		container = jQuery(jQuery.parseHTML(''
			+ '<div class="nation">'
				+ '<div class="name">'+ each.isoName+ '</div>'
				+ '<div class="metrics input"></div>'
				+ '<div class="metrics output"></div>'
			+ '</div>'
			))
			.appendTo(MAINFRAME)
			;
		
		for (var m in metrics) {
			var html = jQuery(jQuery.parseHTML('<div class="'+m+'"></div>'));
			var width = (m == '_aggregated_exponential')
				? each.metrics[m]* 15
				: each.metrics[m]* 100
				;
			width = Math.round(width);
			
			var selector = (m == '_aggregated_exponential')
				? '.metrics.output'
				: '.metrics.input'
				;
			
			html.css({
					'width': width+ '%'
					, 'z-index': 1000-width
				})
				.appendTo(container.find(selector))
				;
			
			each.html[m] = html;
		} //for
		
		each.html.container = container;
	} //for
});

jQuery(document).ready( function() {

	PURCHASEABLE_nationalMetrics.processData();
	WINDOW = jQuery(window);
	BODY = jQuery(document.body);
	MAINFRAME = jQuery('#mainFrame');
	OPTIONS = jQuery('#options');

	jQuery('#csv').text(PURCHASEABLE_nationalMetrics.exportToCsv());

	OPTIONS.find('.highlight').on('change', function(event) {
		var node = jQuery(event.delegateTarget);
		var value = node.prop('checked')
		var name = node[0].className.replace('highlight', '').replace('active','').trim();
		OPTIONS.find('.highlight.'+name).prop('checked', value);
		if (value) {
			BODY.addClass(name);
		} else {
			BODY.removeClass(name);
		}
	});

	OPTIONS.find('.sort').on('change', function(event) {
		var node = jQuery(event.delegateTarget);
		value = node.children('option:selected').val();
		//var name = node[0].className.replace('sort '.length);
		jQuery('.sort').children('[value="'+value+'"]').prop('selected', true);
		
		resort(value);
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
			
		if (each.code == "-") {
			container.addClass("writeBold");
		}
		container.attr('data-continent', each.continent);
		
		for (var m in metrics) {
			var html = jQuery(jQuery.parseHTML('<div class="'+m+'"></div>'));
			var width = (m == '_aggregated_exponential')
				? each.metrics[m]* (100/6)
				: each.metrics[m]* 100
				;
			width = Math.round(width);
			
			var selector = (m == '_aggregated_exponential')
				? '.metrics.output'
				: '.metrics.input'
				;
			
			html.css({
					'width': width+ '%'
				})
				.appendTo(container.find(selector))
				;
			
			each.html[m] = html;
		} //for
		
		each.html.container = container;
	} //for

	WINDOW.on('scroll', function() {
		var scrollTop = WINDOW.scrollTop();
		var position = MAINFRAME.offset().top;
		if (position < scrollTop && !OPTIONS.hasClass('dettached')) {
			OPTIONS.addClass('dettached');
		} else if (position >= scrollTop && OPTIONS.hasClass('dettached')) {
			OPTIONS.removeClass('dettached');
		}
	});

	var height = resort();
	MAINFRAME
		.height(height+ 'px')
		;
});

function resort(ofType) {
	currentSort = ofType || "_lexicographical_name";
	
	OPTIONS
		.find('.sort option[value="'+currentSort+'"]')
		.prop('selected', true)
		;
	OPTIONS
		.find('.highlight')
		.prop('checked', false)
		.filter('.'+currentSort)
		.prop('checked', true)
		;
	BODY
		.removeClass('_normalized_nationmaster_localPurchasingPower _normalized_numbeo_localPurchasingPower _normalized_wikipedia_economicFreedom _normalized_wikipedia_humanDevelopmentIndex')
		.addClass(currentSort)
		;
	
	var nations = jQuery('.nation');
	
	var nationsAsArray = [];
	nations.each(function() {nationsAsArray.push(jQuery(this));});
	
	if (currentSort !== "_lexicographical_name") {
		nationsAsArray.sort(function(l,r) {
			if (currentSort !== "_lexicographical_continent") {
				var lWidth = l.find('.'+ ofType).width();
				var rWidth = r.find('.'+ ofType).width();
				
				if (lWidth == rWidth) {
					lWidth = l.find('._aggregated_exponential').width();
					rWidth = r.find('._aggregated_exponential').width();
				}
				if (lWidth != rWidth) {
					return lWidth- rWidth;
				}
			} else {
				var cmpContinent = l.attr('data-continent').localeCompare(r.attr('data-continent'));
				if (cmpContinent == 0) {
					lWidth = l.find('._aggregated_exponential').width();
					rWidth = r.find('._aggregated_exponential').width();
					if (lWidth != rWidth) {
						return lWidth- rWidth;
					}
				} else {
					return cmpContinent;
				}
			}
			
			return l.text().localeCompare(r.text());
		});
	}
	
	var top = OPTIONS.height();
	nationsAsArray.forEach(function(item) { 
		item.css('top', top+ 'px');
		top += item.height();
	});
	
	return top;
}; //routine


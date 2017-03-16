/*******************************************************************************************/
PURCHASEABLE_nationalMetrics.processData = function() {
	var data = PURCHASEABLE_nationalMetrics.data;
	
	var min = {};
	var max = {};
	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		for (var column in nationData.metrics) {
			min[column] = Infinity;
			max[column] = -Infinity;
		}
		
		break; //first only
	} //establish bounds: min & max base

	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		for (var metricsName in nationData.metrics) {
			var value = nationData.metrics[metricsName];
			if (value === null) {
				continue;
			}
			if (min[metricsName] > value) {
				min[metricsName] = value;
			}
			if (max[metricsName] < value) {
				max[metricsName] = value;
			}
		}
	} //establish bounds: process
	
	PURCHASEABLE_nationalMetrics.min = min;
	PURCHASEABLE_nationalMetrics.max = max;
	
	var bottom = {
		'numbeo_localPurchasingPower': 0.1
		, 'nationmaster_localPurchasingPower': 0.15
		, 'wikipedia_economicFreedom': 0.5
		, 'wikipedia_humanDevelopmentIndex': 0.5
	};
	//some countries received uncommon substitutions - Lichtenstein, Monaco and Vatican
	
	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		for (var metricsName in nationData.metrics) {
			 
			var value = nationData.metrics[metricsName];
			if (value === null) {
				nationData.metrics['_normalized_'+ metricsName] = bottom[metricsName];
			} else {
				
				var eachMin = min[metricsName];
				var eachMax = max[metricsName];
				nationData.metrics['_normalized_'+ metricsName] = (value- eachMin)/ (eachMax- eachMin);
			}
		}
	} //normalize to <0,1>
	
	var weightening = {
		'_normalized_numbeo_localPurchasingPower': 1
		, '_normalized_nationmaster_localPurchasingPower': 1
		, '_normalized_wikipedia_economicFreedom': 1
		, '_normalized_wikipedia_humanDevelopmentIndex': 1
	};
	
	var minAvg = Infinity;
	var maxAvg = -Infinity;
	
	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		var sum = 0;
		var count = 0;
		for (var metricsName in nationData.metrics) {
			if (metricsName.indexOf('_normalized_') !== 0) {
				continue;
			}
			var value = nationData.metrics[metricsName];
			if (value === null) {
				continue;
			}
			count += weightening[metricsName];
			sum += value* weightening[metricsName];
		}
		
		//var average = count!=0? sum/count: 0.2
		var average = sum/count;
		
		minAvg = Math.min(minAvg, average);
		maxAvg = Math.max(maxAvg, average);
		
//		var sin = (-Math.cos(average*Math.PI)+1)/2;
		var exponential = 0.2* Math.exp(3.4* average);
		
		nationData.metrics["_aggregated_average"] = average;
//		nationData.metrics["_aggregated_sin"] = sin;
		nationData.metrics["_aggregated_exponential"] = exponential;
	} //aggregated metrics
	
	PURCHASEABLE_nationalMetrics.min.avg = minAvg;
	PURCHASEABLE_nationalMetrics.max.avg = maxAvg;
	
	var minExp = 0.2* Math.exp(3.4* minAvg);
	var maxExp = 0.2* Math.exp(3.4* maxAvg);
	
	//console.log(minAvg, maxAvg);
	//console.log(minExp, maxExp);
	//console.log(maxExp/minExp);
	
}; //routine

/*******************************************************************************************/
PURCHASEABLE_nationalMetrics.exportToCsv = function() {
	var data = PURCHASEABLE_nationalMetrics.data;
	
	var columns = [];
	var exportedLines = [];
	
	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		for (var column in nationData) {
			if (column === 'metrics') {
				continue;
			}
			columns.push('"'+column+'"');
		}
		for (var column in nationData.metrics) {
			columns.push('"'+column+'"');
		}
		
		break; //first only
	}
	
	exportedLines.push(columns);
	
	for (var nationCode in data) {
		var nationData = data[nationCode];
		
		var line = [];
		
		for (var column in nationData) {
			if (column === 'metrics') {
				continue;
			}
			line.push('"'+nationData[column]+'"');
		}
		for (var column in nationData.metrics) {
			var value = nationData.metrics[column];
			line.push(value===null?"":value);
		}
		
		exportedLines.push(line);
	}

	exportedLines.map(function(v) {return v.join(',');});
	exportedLines = exportedLines.join('\r\n');

	return exportedLines;
}; //routine

/*******************************************************************************************/

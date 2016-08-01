
"use strict";
(function() {
    var morisChartModule = angular.module('angular.morris-chart', []);
	
	morisChartModule.factory('morrisChartService', function($injector) {
		var s = {
			keyToAttr: function(prefix, key) {
				return prefix + key.substring(0, 1).toUpperCase() + key.substring(1);
			},
			populateScopeDefinition: function(scopeDefinition, prefix, optionKeys, atKey) {
				angular.forEach(optionKeys, function(key) {
					scopeDefinition[s.keyToAttr(prefix, key)] = key === atKey ? '@' : '=';
				});
				return scopeDefinition;
			},
			populateOptions: function(options, optionKeys, prefix, scope) {
				angular.forEach(optionKeys, function(key) {
					var attrKey = s.keyToAttr(prefix, key);
					if (scope.hasOwnProperty(attrKey) && typeof scope[attrKey] !== 'undefined') {
						options[key] = scope[attrKey];
					}
				});
				return options;
			},
			processFilterOptions: function(filterKeys, options) {
				angular.forEach(filterKeys, function(key) {
					if (typeof options[key] === 'string' && $injector.has(options[key] + 'Filter')) {
						var filter = $injector.get(options[key] + 'Filter');
						options[key] = function (input) {
							return filter.call(this, input);
						};
					}
				});
			}
		};
		return s;
	});

    morisChartModule.directive('areaChart', function(morrisChartService) {
		var OPTION_KEYS = [
			'data', 'xkey', 'ykeys', 'labels', 'lineColors', 'lineWidth', 'pointSize',
			'pointFillColors', 'pointStrokeColors', 'ymax', 'ymin', 'smooth', 'hideHover',
			'hoverCallback', 'parseTime', 'units', 'postUnits', 'preUnits', 'dateFormat',
			'xLabels', 'xLabelFormat', 'xLabelAngle', 'yLabelFormat', 'goals', 'goalStrokeWidth',
			'goalLineColors', 'events', 'eventStrokeWidth', 'eventLineColors', 'continuousLine',
			'axes', 'grid', 'gridTextColor', 'gridTextSize', 'gridTextFamily', 'gridTextWeight',
			'fillOpacity', 'resize', 'behaveLikeLine'
		];

		return {
			restrict: 'A',
			scope: morrisChartService.populateScopeDefinition({lineColors: '='}, 'area', OPTION_KEYS, 'xkey'),
			link: function(scope, elem) {
				scope.$watch('areaData', function() {
					if (scope.areaData) {
						if (typeof scope.areaData === 'string')
							scope.areaData = JSON.parse(scope.areaData);
						if (typeof scope.areaYkeys === 'string')
							scope.areaYkeys = JSON.parse(scope.areaYkeys);
						if (typeof scope.areaLabels === 'string')
							scope.areaLabels = JSON.parse(scope.areaLabels);
						if (typeof scope.lineColors === 'string')
							scope.lineColors = JSON.parse(scope.lineColors);

						if (!scope.areaInstance) {
							var options = morrisChartService.populateOptions({
								element: elem,
								lineColors: scope.lineColors || ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed']
							}, OPTION_KEYS, 'area', scope);
							morrisChartService.processFilterOptions(['dateFormat', 'xLabelFormat', 'yLabelFormat'], options);

							scope.areaInstance = new Morris.Area(options);
						} else {
							scope.areaInstance.setData(scope.areaData);
						}
					}
				});
			}
		}
	});

    /* morisChartModule.directive('barChart', function(morrisChartService) {
        var OPTION_KEYS = [
            'data', 'xkey', 'ykeys', 'labels', 'barColors', 'stacked', 'hideHover',
            'hoverCallback', 'axes', 'grid', 'gridTextColor', 'gridTextSize', 'gridTextFamily',
            'gridTextWeight', 'resize'
        ];

        return {
            restrict: 'A',
            scope: morrisChartService.populateScopeDefinition({barColors: '=', barX: '@', barY: '='}, 'bar', OPTION_KEYS),
            link: function(scope, elem) {
                scope.$watch('barData', function() {
                    if (scope.barData) {
                        if (typeof scope.barY === 'string')
                            scope.barY = JSON.parse(scope.barY);
                        if (typeof scope.barLabels === 'string')
                            scope.barLabels = JSON.parse(scope.barLabels);
                        if (typeof scope.barData === 'string')
                            scope.barData = JSON.parse(scope.barData);
                        if (typeof scope.barColors === 'string')
                            scope.barColors = JSON.parse(scope.barColors);
                        if (typeof scope.barStacked === 'string')
                            scope.barStacked = JSON.parse(scope.barStacked);
                        if (typeof scope.barResize === 'string')
                            scope.barResize = JSON.parse(scope.barResize);


                        if (!scope.barInstance) {
                            var options = morrisChartService.populateOptions({
                                element: elem,
                                barColors: scope.barColors || ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'],
                                stacked: false,
                                resize: false,
                                xkey: scope.barX,
                                ykeys: scope.barY,
                                xLabelMargin: 2
                            }, OPTION_KEYS, 'bar', scope);

                            scope.barInstance = new Morris.Bar(options);
                        } else {
                            scope.barInstance.setData(scope.barData);
                        }
                    }
                })
            }
        }
    });

    morisChartModule.directive('donutChart', function(morrisChartService) {
        var OPTION_KEYS = ['data', 'colors', 'formatter', 'resize'];
        return {
            restrict: 'A',
            scope: morrisChartService.populateScopeDefinition({}, 'donut', OPTION_KEYS),
            link: function(scope, elem) {
                scope.$watch('donutData', function() {
                    if (scope.donutData) {
                        if (typeof scope.donutData === 'string')
                            scope.donutData = JSON.parse(scope.donutData);

                        if (typeof scope.donutColors === 'string')
                            scope.donutColors = JSON.parse(scope.donutColors);

                        if (!scope.donutInstance) {
                            var options = morrisChartService.populateOptions({
                                element: elem,
                                colors: ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed']
                            }, OPTION_KEYS, 'donut', scope);
                            morrisChartService.processFilterOptions(['formatter'], options);

                            scope.donutInstance = new Morris.Donut(options);
                        } else {
                            scope.donutInstance.setData(scope.donutData);
                        }
                    }
                })
            }
        }
    });

    morisChartModule.directive('lineChart',	function(morrisChartService) {
		var OPTION_KEYS = [
			'data', 'xkey', 'ykeys', 'labels', 'lineColors', 'lineWidth', 'pointSize',
			'pointFillColors', 'pointStrokeColors', 'ymax', 'ymin', 'smooth', 'hideHover',
			'hoverCallback', 'parseTime', 'units', 'postUnits', 'preUnits', 'dateFormat',
			'xLabels', 'xLabelFormat', 'xLabelAngle', 'yLabelFormat', 'goals', 'goalStrokeWidth',
			'goalLineColors', 'events', 'eventStrokeWidth', 'eventLineColors', 'continuousLine',
			'axes', 'grid', 'gridTextColor', 'gridTextSize', 'gridTextFamily', 'gridTextWeight',
			'fillOpacity', 'resize'
		];

		return {
			restrict: 'A',
			scope: morrisChartService.populateScopeDefinition({lineColors: '=', parseTime: '='}, 'line', OPTION_KEYS, 'xkey'),
			link: function(scope, elem) {
				scope.$watch('lineData', function() {
					if (scope.lineData) {
						if (typeof scope.lineData === 'string')
							scope.lineData = JSON.parse(scope.lineData);
						if (typeof scope.lineYkeys === 'string')
							scope.lineYkeys = JSON.parse(scope.lineYkeys);
						if (typeof scope.lineYkeys === 'string')
							scope.lineYkeys = JSON.parse(scope.lineYkeys);
						if (typeof scope.lineLabels === 'string')
							scope.lineLabels = JSON.parse(scope.lineLabels);
						if (typeof scope.lineColors === 'string')
							scope.lineColors = JSON.parse(scope.lineColors);
						if (typeof scope.parseTime === 'boolean')
							scope.parseTime = JSON.parse(scope.parseTime);

						if (!scope.lineInstance) {
							// Default options
							var options = morrisChartService.populateOptions({
								element: elem,
								lineColors: scope.lineColors || ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'],
								parseTime: scope.parseTime
							}, OPTION_KEYS, 'line', scope);

							// Checks if there are angular filters available for certain options
							morrisChartService.processFilterOptions(['dateFormat', 'xLabelFormat', 'yLabelFormat'], options);

							scope.lineInstance = new Morris.Line(options);
						} else {
							scope.lineInstance.options.xkey = scope.lineXkey;
							scope.lineInstance.options.ykeys = scope.lineYkeys;
							scope.lineInstance.options.labels = scope.lineLabels;
							scope.lineInstance.options.parseTime = scope.parseTime;
							scope.lineInstance.options.lineColors = scope.lineColors || ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'];
							scope.lineInstance.setData(scope.lineData);
						}
					}
				});
			}
		}
	});
 */
})();
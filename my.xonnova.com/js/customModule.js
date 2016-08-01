
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

})();
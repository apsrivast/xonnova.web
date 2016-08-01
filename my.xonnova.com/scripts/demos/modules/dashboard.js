angular.module('theme.demos.dashboard', [
    'angular-skycons',
    'theme.demos.forms'
  ])
  .controller('DashboardController', ['$scope', '$timeout', '$window', function($scope, $timeout, $window) {
    'use strict';
    var moment = $window.moment;
    var _ = $window._;
    $scope.loadingChartData = false;
    $scope.refreshAction = function() {
      $scope.loadingChartData = true;
      $timeout(function() {
        $scope.loadingChartData = false;
      }, 2000);
    };

  }]);
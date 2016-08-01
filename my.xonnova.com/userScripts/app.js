function wsloader(isloading){
  if(isloading){
      $('#wsloader').modal('show');
  }else{       
    $('#wsloader').modal('hide');
  }
}


var myApp = angular.module('themesApp', ['theme','theme.demos','pickadate','angular.morris-chart']);
  myApp.controller('homeCtr', function ($scope, $http, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;

      $http.get(BASE_URL+'user/getTotalHoldingTankSB').success(function(data) {
        $scope.totalHoldingTankSB = data;
      });
	  
	    $http.get(BASE_URL+'news_section_ctr/getNewsTotalCount').success(function(data) {
        $scope.newsTotalCount = data;
      });

      $http.get(BASE_URL+'news_section_ctr/getNewsUserList').success(function(data) {
        $scope.newsList = data;
      });

      $http.get(BASE_URL+'user_leads/userPackage').success(function(data) {
        $scope.user_package_name = data;
      });

      $http.get(BASE_URL+'user/getMember').success(function(data) {
        $scope.totalMember = data;
      });

      $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
        $scope.totalEarning = data;
      });

      $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
        $scope.totalRewards = data;
      });

      $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
        $scope.totalFacebook = data;
      });

      $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
        $scope.totalTwitter = data;
      });
	  
	   $http.get(BASE_URL+'user/usernewOrderTab').success(function(data) {
          $scope.usernewOrderTabList = data;
		});
	  $http.get(BASE_URL+'userEvent/eventStatus').success(function(data) {
		$scope.eventStatus = data.status;
	  });
    $http.get(BASE_URL+'user/getTotalHoldingTank').success(function(data) {
        $scope.totalHoldingTank = data;
    });
	$http.get(BASE_URL+'order/totalOrders').success(function(data) {
        $scope.totalOrders = data.total;
    });
  $http.get(BASE_URL + 'recent_users/getRecentUsers').success(function(data){
      $scope.recentUsersList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.recentUsersList.length;   
      $scope.totalItems = $scope.recentUsersList.length;    
    });
    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
    };
    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    };

    //calling controller for morris chart in index page
    $http.get(BASE_URL+ 'count_children/getChartValue').success(function(result){
      $scope.chartData = result;
    });

  });

  myApp.config(['$provide', '$routeProvider', function($provide, $routeProvider) {
    'use strict';
    $routeProvider
      .when('/', {
        templateUrl: 'application/views/user/index.html',
        resolve: {
          loadCalendar: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/fullcalendar/fullcalendar.js',
            ]);
          }]
        },
        controller: 'homeCtr'
      })
      .when('/:templateFile', {
        templateUrl: function(param) {
          return 'application/views/user/' + param.templateFile + '.html';
        }
      })
      .when('#', {
        templateUrl: 'application/views/user/index.html',
      })
      .otherwise({
        redirectTo: '/'
      });
  }]);
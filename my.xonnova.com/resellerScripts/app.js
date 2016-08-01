var myApp = angular.module('themesApp', ['theme','theme.demos','pickadate']);
  
  myApp.controller('homeCtr', function ($scope, $http, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;
	  
	  $http.get(BASE_URL+'product_reseller/getTotalActive').success(function(data) {
        $scope.totalMember = data;
      });
	  
	   $http.get(BASE_URL+'product_reseller/usernewOrderTab').success(function(data) {
          $scope.usernewOrderTabList = data;
		});
		
		$http.get(BASE_URL+'product_reseller/storeCredit').success(function(data) {
          $scope.totalStoreCredit = data;
		});

      $http.get(BASE_URL+'mxtopup_bonus').success(function(data) {
        $scope.totalMXBonus = data;
      });
      $http.get(BASE_URL+'wallet2').success(function(data) {
        $scope.totalMXWallet = data;
      });

  //     $http.get(BASE_URL+'news_section_ctr/getNewsUserList').success(function(data) {
  //       $scope.newsList = data;
  //     });

  //     $http.get(BASE_URL+'member/FounderMemberListShow').success(function(data) {
  //       $scope.founder_member = data;
  //     });

  //     $http.get(BASE_URL+'user/getMember').success(function(data) {
  //       $scope.totalMember = data;
  //     });

  //     $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
  //       $scope.totalEarning = data;
  //     });

  //     $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
  //       $scope.totalRewards = data;
  //     });

  //     $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
  //       $scope.totalFacebook = data;
  //     });

  //     $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
  //       $scope.totalTwitter = data;
  //     });
	  
	 //   $http.get(BASE_URL+'user/usernewOrderTab').success(function(data) {
  //         $scope.usernewOrderTabList = data;
		// });

  //   $http.get(BASE_URL+'user/getTotalHoldingTank').success(function(data) {
  //       $scope.totalHoldingTank = data;
  //   });

  });

  myApp.config(['$provide', '$routeProvider', function($provide, $routeProvider) {
    'use strict';
    $routeProvider
      .when('/', {
        templateUrl: 'application/views/reseller/index.html',
        resolve: {
          loadCalendar: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/fullcalendar/fullcalendar.js',
            ]);  
          }]
        },
        controller: 'homeCtr'
      })
        .when('#', {
         templateUrl: 'application/views/reseller/index.html',
       }) 
      .otherwise({
        redirectTo: '/'
      });
  }]);
function wsloader(isloading){
  if(isloading){
      $('#wsloader').modal('show');
  }else{       
    $('#wsloader').modal('hide');
  }
}


var myApp = angular.module('themesApp', ['theme','pickadate','theme.demos']);
  
  myApp.controller('homeCtr', function ($scope, $http, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;

      $http.get(BASE_URL+'user/getTotalHoldingTankSB').success(function(data) {
        $scope.totalHoldingTankSB = data;
      });
	  
	    $http.get(BASE_URL+'admin/getActivationTotal').success(function(data) {
        $scope.newActivationTotal = data;
      });

      $http.get(BASE_URL+'admin/getStoreTotal').success(function(data) {
        $scope.newStoreTotal = data;
      });

      $http.get(BASE_URL+'admin/getMember').success(function(data) {
        $scope.totalMember = data;
      });

      $http.get(BASE_URL+'admin/getTotalEarning').success(function(data) {
        $scope.totalEarning = data;
      });
	
      $http.get(BASE_URL+'admin/getTotalEarning').success(function(data) {
        $scope.totalRewards = data;
      });

      $http.get(BASE_URL+'admin/getTotalEarning').success(function(data) {
        $scope.totalFacebook = data;
      });

      $http.get(BASE_URL+'admin/getTotalEarning').success(function(data) {
        $scope.totalTwitter = data;
      });
	  
	  $http.get(BASE_URL + 'admin/getTotal').success(function(data){
          $scope.totalList = data;
      });
      $http.get(BASE_URL + 'admin/getPendingTotal').success(function(data){
          $scope.totalPendingList = data;
      });
      $http.get(BASE_URL + 'admin/getApproveTotal').success(function(data){
          $scope.totalApproveList = data;
      });
	  
	  $http.get(BASE_URL+'admin/newOrderTab').success(function(data) {
          $scope.newOrderTabList = data;
      });
	  
	   $http.get(BASE_URL+'admin/getNewDeposits').success(function(data) {
        $scope.newDeposits = data;
      });

      $http.get(BASE_URL+'admin/getNewPlatformRequest').success(function(data) {
        $scope.newPlatformRequest = data;
      });
    
      $http.get(BASE_URL + 'admin/getNewUserSignups').success(function(data){
          $scope.newUserSignups = data;
      });
      $http.get(BASE_URL + 'admin/getNewRank').success(function(data){
          $scope.newRank = data;
      });
      $http.get(BASE_URL + 'admin/getNewReferral').success(function(data){
          $scope.newReferral = data;
      });
	  $http.get(BASE_URL + 'upgrade/getTotalUpgradeUser').success(function(data){
          $scope.newUpgradeUserTotal = data;
      });
	  $http.get(BASE_URL + 'addEvent/eventCount').success(function(data){
          $scope.newEventReg = data.eventRegCount;
      });
      $http.get(BASE_URL + 'pendingEarningReport/getPendingBalance').success(function(data){
          $scope.totalPendingBlance = data;
      });
      $http.get(BASE_URL + 'ether/getEtherWallet').success(function(data){
          $scope.totalEtherWallet = data;
      });
  });

  myApp.config(['$provide', '$routeProvider', function($provide, $routeProvider) {
    'use strict';
	if(LOGIN_TYPE == "admin"){
    $routeProvider
      .when('/', {
        templateUrl: 'application/views/admin/views/index.html',
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
          return 'application/views/admin/' + param.templateFile + '.html';
        }
      })
      .when('#', {
        templateUrl: 'application/views/admin/views/index.html',
      })
      .otherwise({
        redirectTo: '/'
      });
	}else if(LOGIN_TYPE == "emp"){
      $routeProvider
      .when('/', {
        templateUrl: 'application/views/admin/followup-new-leads2.html',
        
        controller: 'homeCtr'
      })
      .when('#', {
        templateUrl: 'application/views/admin/followup-new-leads2.html',
      })
      .otherwise({
        redirectTo: '/'
      });
   }else if(LOGIN_TYPE == "employee"){
      $routeProvider
      .when('/', {
        templateUrl: 'application/views/admin/followup-new-leads2.html',
        
        controller: 'homeCtr'
      })
      .when('#', {
        templateUrl: 'application/views/admin/followup-new-leads2.html',
      })
      .otherwise({
        redirectTo: '/'
      });    

    }else{
      $routeProvider
      .when('/', {
        templateUrl: 'application/views/admin/notification-report.html',
        
        controller: 'homeCtr'
      })
      .when('#', {
        templateUrl: 'application/views/admin/notification-report.html',
      })
      .otherwise({
        redirectTo: '/'
      });

    }
  }]);
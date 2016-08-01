var myReferrals = angular.module('theme.demos.referral', ['ngRoute','ui.bootstrap']);
  
  myReferrals.factory("Referrals", ['$http', function($http) {
    var base_url = BASE_URL
      var obj = {};
      var sortingOrder = 'name';
      obj.getReferrals = function(){
          return $http.get(base_url + 'referrals/getReferrals');
      };

      obj.insertUser = function (user) {
        return $http.post(base_url + 'referrals/insertUser', user).then(function (results) {
            return results;
        });
      };

      obj.updateUser = function (id,user) {
          return $http.post(base_url + 'getReferrals/updateUser', {id:id, user:user}).then(function (status) {
              return status.data;
          });
      };

      obj.deleteUser = function (id) {
          return $http.delete(base_url + 'getReferrals/deleteUser?id=' + id).then(function (status) {
              return status.data;
          });
      };

      return obj;   
  }]);

  myReferrals.filter('startFrom', function() {
      return function(input, start) {
          if(input) {
              start = +start; //parse to int
              return input.slice(start);
          }
          return [];
      }
  });

  myReferrals.controller('referralsCtr', function ($scope, $rootScope, $location, $routeParams, Referrals) {
      Referrals.getReferrals().then(function(data){
          $scope.referralsList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.referralsList.length; //Initially for no filter  
          $scope.totalItems = $scope.referralsList.length;
      });  

      $scope.setPage = function(pageNo) {
          $scope.currentPage = pageNo;
      };
      $scope.filter = function() {
          $timeout(function() { 
              $scope.filteredItems = $scope.filtered.length;
          }, 10);
      };
      $scope.sort_by = function(predicate) {
          $scope.predicate = predicate;
          $scope.reverse = !$scope.reverse;
      }; 
  });

  myReferrals.controller('referralEditCtr', function ($scope, $http, $location, $routeParams) {
        var id = $routeParams.userID;
        $scope.activePath = null;

        $http.get(BASE_URL+'referrals/editReferrals/'+id).success(function(data) {
          $scope.users = data;
        });

        $scope.update = function(user){
            $location.path('/personal-referrals');
            $http.put(BASE_URL+'referrals/updateReferrals/'+id, user).success(function(data) {
              $scope.users = data;
              $scope.activePath = $location.path('/personal-referrals');
            });
        };

        $scope.delete = function(user) {
          console.log(user);

          var deleteUser = confirm('Are you absolutely sure you want to delete?');
          if (deleteUser) {
            $http.delete(BASE_URL+'referrals/deleteReferrals/'+id);
            $scope.activePath = $location.path('/personal-referrals');
          }
        };
  });

  myReferrals.config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider
      .when('/personal-referrals', {
        templateUrl: '/application/views/admin/personal-referrals.html',
        controller: 'referralsCtr'
      })
      .when('/edit-person-referrals/:userID',{
        templateUrl:'/application/views/edit-personal-referrals.html',
        controller:'referralEditCtr'
      });
  }]);
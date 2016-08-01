//var myAppForm = angular.module('theme.demos.forms', ['flow','angular-meditor','xeditable','theme.core.directives','theme.core.services']);
var myAppForm = angular.module('theme.demos.forms', ['ngRoute','ngDialog']);
  
  myAppForm.factory("services", ['$http', function($http) {
    var base_url = BASE_URL
      var obj = {};
      var sortingOrder = 'name';
      obj.getPackage = function(){
          return $http.get(base_url + 'admin');
      };

      obj.getUser = function(userID){
          return $http.get(base_url + 'getUser?id=' + userID);
      };

      obj.insertUser = function (user) {
        return $http.post(base_url + 'admin/insertUser', user).success(function(data) {
            //return results;
            //$scope.results;
            //alert(data.message);
			return data;
        });
      };

      obj.updateUser = function (id,user) {
          return $http.post(base_url + 'updateUser', {id:id, user:user}).then(function (status) {
              return status.data;
          });
      };

      obj.deleteUser = function (id) {
          return $http.delete(base_url + 'deleteUser?id=' + id).then(function (status) {
              return status.data;
          });
      };

      return obj;   
  }]);
  
//validate Voucher code
  myAppForm.directive('ngVouchercode', ['$http', function ($http) {
      return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
      
        elem.on('blur', function (evt) {
        scope.$apply(function () {
          $http({ 
          type: 'json',
          method: 'POST', 
          url: BASE_URL+'admin/isVoucherCode', 
          data: { 
            voucher:elem.val(), 
           
          } 
          }).success(function(data) {
          ctrl.$setValidity('vouchercode', data.status);
         });
        });
        });
      }
      }
    }
  ]);
  
  myAppForm.controller('dateCtr', function($scope, $http){
     var $input = $( '.datepicker' ).pickadate({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',

            
            min: new Date(1900,1,01),
            max: -6570,
            
            container: '.container',
            
            closeOnSelect: true,
            
            today: '',
            clear: '',
            close: '',
            
            selectYears: 100,
            
        });
  });
//validate Date of Birth for 18
  myAppForm.directive('wizValDateOfBirth', function () {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        wizValDateOfBirth: '=wizValDateOfBirth'
      },
      link: function (scope, elem, attrs, ngModel) {

        //For DOM -> model validation
        ngModel.$parsers.unshift(function (value) {
          return validate(value);
        });

        //For model -> DOM validation
        ngModel.$formatters.unshift(function (value) {
          return validate(value);
        });

        function validate(value) {
          var valid = true;
          if (angular.isDefined(value) && value.length > 0) {
            if (value && /^\d+$/.test(scope.wizValDateOfBirth)) {
              // If positive integer used for age then use to check input value
              var today = new Date();
              var birthDate = new Date(value);
              var age = today.getFullYear() - birthDate.getFullYear();
              var m = today.getMonth() - birthDate.getMonth();
              if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
              }
              if (age < scope.wizValDateOfBirth) {
                valid = false;
                
              }
            }
          }

          ngModel.$setValidity('wizValDateOfBirth', valid);
          return value;
        }
      }
    };
  });

myAppForm.directive('ngUnique', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'admin/isUniqueValue', 
        data: { 
          username:elem.val(), 
          dbField:attrs.ngUnique
        } 
        }).success(function(data) {
        ctrl.$setValidity('unique', data.status);
       });
      });
      });
    }
    }
  }
]);

myAppForm.directive('ngUnique1', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'admin/isUniqueValue1', 
        data: { 
          username:elem.val(), 
          dbField:attrs.ngUnique1
        } 
        }).success(function(data) {
        ctrl.$setValidity('unique1', data.status);
       });
      });
      });
    }
    }
  }
]);

myAppForm.directive('ngUnique2', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'admin/isUniqueValue2', 
        data: { 
          username:elem.val(), 
          dbField:attrs.ngUnique2
        } 
        }).success(function(data) {
        ctrl.$setValidity('unique2', data.status);
       });
      });
      });
    }
    }
  }
]);

  myAppForm.controller('listPkge', function ($scope, $rootScope, $location, $routeParams, services, ngDialog,$http) {
     $scope.onchangepackage = function(id) {
      $http.get(BASE_URL + 'product/getPackageDescriptionById/'+id).success(function(data){
        $scope.incriptionDiscription = data;
      });
      if(id==null){
        $scope.incriptionDiscription = '';
      }
    };  
    /*  var y = new Date().getFullYear()-18;
      var m = new Date().getMonth();
      var d = new Date().getDate();
      $scope.minDate = '1940-01-01';
      $scope.maxDate = new Date(y, m, d);
      $scope.presetDate = new Date(y, m, d); */
	  
		services.getPackage().then(function(data){
			$scope.packages = data.data;
		});
		
		$http.get("packageCtr/getMexPackage").success(function(data){
            $scope.mxpackages = data;
		});
      $scope.example = { value: new Date(2013, 9, 22)};

      $scope.addUser = function(user){
                wsloader(true);
		services.insertUser(user).success(function (data) {
			if(data.message != null){
                         wsloader(false);
			 ngDialog.open({ template: 'firstDialogId', data: {foo: data.message} });
			 $location.path('/personal-referrals');				
			}else{
				var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
                wsloader(false);
                $('#error-message').html(message);
			}
		});
        //services.insertUser(user);
        //$location.path('/personal-referrals');
      };    
	  
	  $http.get("admin/getSponserNameAutoSuggest").success(function(data){
            $scope.sponserNameAutoSuggest = data;
      });
  });

  myAppForm.controller('editUser', function ($scope, $rootScope, $location, $routeParams, services, user) {
      var userID = ($routeParams.userID) ? parseInt($routeParams.userID) : 0;
      $rootScope.title = (userID > 0) ? 'Edit User' : 'Add Member';
      $scope.buttonText = (userID > 0) ? 'Update User' : 'Add New Member';
        var original = user.data;
        original._id = userID;
        $scope.user = angular.copy(original);
        $scope.user._id = userID;

        $scope.isClean = function() {
          return angular.equals(original, $scope.user);
        }

        $scope.deleteUser = function(user) {
          $location.path('/');
          if(confirm("Are you sure to delete user number: "+$scope.user._id)==true)
          services.deleteUser(user.userNumber);
        };

        $scope.saveCustomer = function(user) {
          $location.path('/');
          if (customerID <= 0) {
              services.insertUser(user);
          }
          else {
              services.updateCustomer(customerID, customer);
          }
        };        
  });

  myAppForm.config(['$routeProvider', function($routeProvider) {
    $routeProvider
      .when('/form-imagecrop', {
        templateUrl: 'application/views/admin/views/form-imagecrop.html',
        resolve: {
          loadJcrop: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'assets/plugins/jcrop/js/jquery.Jcrop.min.js'
            ]);
          }]
        }
      })
      .when('/form-wizard', {
        templateUrl: 'application/views/admin/views/form-wizard.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        }
      })
      .when('/add-new-member', {
        templateUrl: 'application/views/add-new-member.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        },
        controller: 'listPkge'
      })
      .when('/inscription-systems', {
        templateUrl: 'application/views/inscription-systems.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        }
      })
      .when('/form-masks', {
        templateUrl: 'application/views/admin/views/form-masks.html',
        resolve: {
          loadMasks: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js'
            ]);
          }]
        }
      });
  }]);

  myAppForm.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
  }]);
//var myAppForm = angular.module('theme.demos.forms', ['flow','angular-meditor','xeditable','theme.core.directives','theme.core.services']);
var myAppForm = angular.module('theme.demos.forms', ['ngRoute','ngFileUpload','ngDialog']);
  
  myAppForm.factory("services", ['$http', function($http) {
    var base_url = BASE_URL
      var obj = {};
      var sortingOrder = 'name';
      obj.getPackage = function(){
          return $http.get(base_url + 'user');
      };

      obj.insertUser = function (user) {
        return $http.post(base_url + 'user/insertUser', user).success(function(data) {
            //return results;
           // $scope.results;
            //alert(data.message);
			return data;
        });
      };

      obj.getProfile = function(){
          return $http.get(base_url + 'profile');
      };
	  
	  obj.getPlatformsList = function(){
        return $http.get(base_url + 'user/platformsList');
      };
	  
	   obj.getLeadsList = function(){
        return $http.get(base_url + 'user/leadsList');
      };
      return obj;   
  }]);
  


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
          url: BASE_URL+'user/isVoucherCode', 
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
  
  myAppForm.controller('dateCtr', function($scope){
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

//AddUser Controller
  myAppForm.controller('listPkge', function ($scope, $rootScope, $location, $routeParams, services, ngDialog,$http) {
      
		/* var y = new Date().getFullYear()-18;
		var m = new Date().getMonth();
		var d = new Date().getDate();
		$scope.minDate = '1940-01-01';
		$scope.maxDate = new Date(y, m, d);
		$scope.presetDate = new Date(y, m, d); */
		
		services.getPackage().then(function(data){
			$scope.packages = data.data;
		});

		$scope.example = { value: new Date(2013, 9, 22)};

		$scope.addUser = function(user){
			services.insertUser(user).success(function (data) {
				if(data.message != null){
					 ngDialog.open({ template: 'firstDialogId', data: {foo: data.message} });
					 $location.path('/personal-referrals');					
				}else{
					 var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
					$('#error-message').html(message);
				}
			});
			//services.insertUser(user);
			//$location.path('/personal-referrals');
		};    
		
		$http.get("user/getSponserNameAutoSuggest").success(function(data){
            $scope.sponserNameAutoSuggest = data;
		});
  });
//New Leads controllers
  myAppForm.controller('newLeadsCtr', function ($scope, $rootScope, $location, $routeParams, services) {
      
  });
  myAppForm.controller('MyCtrlLead',  function ($scope, Upload, $route, $location,$http) {
		$scope.user = {
			type_lead: 'Hot',
      questionnaireans: 'YES',
      q_home: 'YES',
      q_electricity: 'YES',
      q_mortgage: 'YES',
      q_mortgage_resolved: 'YES',
      q_bankruptcy: 'YES',
      q_bankruptcy_resolved: 'YES',
      q_late_payments: 'YES',
      q_late_payments_upto: 'YES',
      q_property_taxes: 'YES',
      q_property_taxes_fallen: 'YES',
      q_property_taxes_mortgage: 'YES',
      q_credit: 'YES',
      q_roof: 'Comp Shingles',

      
		};


    $http.post(BASE_URL + 'user_leads/userName').success(function (data) {
        $scope.user.q_agent = data;

      }); 



		$scope.newleadtwo = function(user){
			$http.post(BASE_URL + 'user_leads/leads', user).success(function (data) {
        if(data.mess == null){
			  var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
        $('#message').html(message);
        }else{
          alert(data.mess);
           $route.reload();
        }
			});
		};  



     $scope.uploadQuestionnaire = function (files) {
        Upload.upload({
            url: BASE_URL+'user_leads/uploadQuestionnaireProof',
            file: files
        }).success(function (dataa) {
              $scope.user.user_questionnaire = dataa.file_name;
        });
    };


    $scope.uploadElectricity = function (files) {
        Upload.upload({
            url: BASE_URL+'user_leads/uploadQuestionnaireProof',
            file: files
        }).success(function (dataa) {
              $scope.user.q_electricity_bill = dataa.file_name;
        });
    };




   
  });
//New platform controllers
  myAppForm.controller('newPlatformsCtr', function ($scope, $rootScope, $location, $routeParams, $http, services) {
    services.getProfile().then(function(data){
          $scope.profileList = data.data;
      }); 

       $http.post(BASE_URL + 'user/platformstwo2').success(function (data) {
        $scope.submited = data;
      }); 

      $http.get(BASE_URL + 'platform/getPlatformsListForUser').success(function(data){
        $scope.List = data;
      });


  });

  myAppForm.controller('MyCtrlPlat', ['$scope', 'Upload','$location','$http', function ($scope, Upload, $location,$http) {
 		  $scope.newplatformtwo = function(user){
               $http.post(BASE_URL + 'user/platformstwo', user).success(function (data) {
                   alert(data.message);
                    $location.path('/');
                });
          };  


          $scope.uploadIdProof = function (files) {
                    Upload.upload({
                        url: BASE_URL+'user/uploadPlatformsIdProof',
                        file: files
                    }).success(function (data) {
                    $scope.user.picID=data.file_name;
                    });
        };
        $scope.uploadCardProof = function (files) {
                    Upload.upload({
                        url: BASE_URL+'user/uploadPlatformsIdProof',
                        file: files
                    }).success(function (data) {
                    $scope.user.picCard=data.file_name;
                    });
        };
        $scope.uploadIdProofBack = function (files) {
                    Upload.upload({
                        url: BASE_URL+'user/uploadPlatformsIdProof',
                        file: files
                    }).success(function (data) {
                    $scope.user.picIDBack=data.file_name;
                    });
        };
        $scope.uploadCardProofBack = function (files) {
                    Upload.upload({
                        url: BASE_URL+'user/uploadPlatformsIdProof',
                        file: files
                    }).success(function (data) {
                    $scope.user.picCardBack=data.file_name;
                    });
        };
        $scope.uploadAddressProof = function (files) {
                    Upload.upload({
                        url: BASE_URL+'user/uploadPlatformsIdProof',
                        file: files
                    }).success(function (data) {
                    $scope.user.picAddress=data.file_name;
                    });
        };
  }]);  
	myAppForm.controller('userPlatformsListCtr', function ($scope, $rootScope, $location, $routeParams, services) {
		  services.getPlatformsList().then(function(data){
			  $scope.cashoutList = data.data;
			  $scope.currentPage = 1; //current page
			  $scope.entryLimit = 10; //max no of items to display in a page
			  $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
			  $scope.totalItems = $scope.cashoutList.length;
		  });  
	  });
  
  myAppForm.controller('MyCtrlLeadlist', function ($scope, $rootScope, $location, $routeParams, services) {
      services.getLeadsList().then(function(data){
          $scope.cashoutList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
          $scope.totalItems = $scope.cashoutList.length;
      });  
  });
  myAppForm.controller('viewLeadsCommentHistoryCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      $scope.activePath = null;

        $http.get(BASE_URL +'user/viewLeadsCommentHistory/'+ID).success(function(data){
          $scope.leadCommentHistory = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 5; //max no of items to display in a page
          $scope.filteredItems = $scope.leadCommentHistory.length; //Initially for no filter  
          $scope.totalItems = $scope.leadCommentHistory.length;
        
        });
        $scope.leads = {
            id: ID
        };

        $scope.update = function(user){
               $http.post(BASE_URL + 'user/leadtwoUpdatecomment', user).success(function () {
                   alert('Success!');
                    $location.path('/');
                });
        };  
  });
  
//Router configuration 
  myAppForm.config(['$routeProvider', function($routeProvider) {
    $routeProvider
    .when('/add-new-member', {
      templateUrl: 'application/views/user/add-new-member.html',
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
    .when('/new-platforms', {
      templateUrl: 'application/views/user/new-platforms.html',
      controller: 'newPlatformsCtr'
    })
	  .when('/user-platforms-list', {
        templateUrl: 'application/views/user/user-platforms-list.html',
        controller: 'userPlatformsListCtr'
      })
	  .when('/user-leads-list', {
        templateUrl: 'application/views/user/leads-list.html',
        controller: 'MyCtrlLeadlist'
      })
	  .when('/view-leads-comments_history/:id',{ 
        templateUrl: 'application/views/user/view-leads-comments_history.html',
        controller: 'viewLeadsCommentHistoryCtr'
      })
      .when('/new-leads', {
        templateUrl: 'application/views/user/new-leads.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        },
        controller: 'MyCtrlLead'
      });
  }]);

  myAppForm.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
  }]);
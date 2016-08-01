

//masterConins Details controller 
myCustomApp.controller('mastercoinsDetailsCtr', function($scope, $http, $location, $routeParams){
	  //var ID = $routeParams.id;
});

myCustomApp.controller('mastercoinsTransferCtr', function($scope, $http, $location, $routeParams){

});

myCustomApp.controller('transactionPasswordCtr', function($scope, $http, $location, $routeParams){
	
});

//Upgrade User Controller
myCustomApp.controller('upgradeUserCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.userId;
    $scope.activePath = null;

    $http.get(BASE_URL + 'upgrade/getEncriptionSystem').success(function(data){
      $scope.incriptionList = data;
    });

    $scope.upgradeUser = function(user){
          $http.put(BASE_URL+'upgrade/upgradeUser', user).success(function(data) {
              alert(data.message);
          });
    };
});

myCustomApp.controller('userUpgradeCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.userId;
    $scope.activePath = null;
    $http.get(BASE_URL + 'upgrade/getCurrentUser').success(function(data){
       $scope.currentUserList = data;
    });
    $http.get(BASE_URL + 'upgrade/getEncriptionSystemByUser').success(function(data){
      $scope.incriptionList = data;
    });

    $http.get(BASE_URL + 'upgrade/getPackageStoreCreditById').success(function(data){
       $scope.userPackageCredit = data;
    });

    $scope.onchangepackage = function(id) {
        $http.get(BASE_URL + 'upgrade/getonchangePackageStoreCreditById/'+id).success(function(data){
           $scope.packageCredit = data;
        });
    };

   

   $http.get(BASE_URL + 'upgrade/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
    $http.get(BASE_URL + 'upgrade/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });


    $scope.upgradeUser = function(user){
          $http.put(BASE_URL+'upgrade/upgradeUserByUser', user).success(function(data) {
              alert(data.message);
          });
    };
});

myCustomApp.controller('upgradeUserList', function($scope, $http, $location, $routeParams){
    //var ID = $routeParams.userId;
    $scope.activePath = null;

    $http.get(BASE_URL + 'upgrade/upgradeUserList').success(function(data){
      $scope.upgradeUserList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.upgradeUserList.length; //Initially for no filter  
      $scope.totalItems = $scope.upgradeUserList.length;
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
});

myCustomApp.controller('cancleSubscriptionCtr', function($scope, $http, $location, $routeParams){
	$http.get(BASE_URL +'upgrade/cancelSubscriptionList').success(function(data){
		  $scope.cancleUserSubscriptionList=data;
		  $scope.currentPage = 1; //current page
		  $scope.entryLimit = 10; //max no of items to display in a page
		  $scope.filteredItems = $scope.cancleUserSubscriptionList.length; //Initially for no filter  
		  $scope.totalItems = $scope.cancleUserSubscriptionList.length;
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
  
	$scope.cancleSubscription = function(sub){
		var cancelSuscription = confirm('Are you absolutely sure you want to cancel Suscription?');
		if (cancelSuscription) {
			$http.post(BASE_URL +'upgrade/cancelSubscription',sub).success(function(data){
				var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
				$('#message').html(message);
			});
		}
	};
});

myCustomApp.controller('cancleUserSubscriptionCtr',function($scope, $http, $location, $routeParams){
	$http.get(BASE_URL +'upgrade/cancelUserSubscriptionList').success(function(data){
		  $scope.cancleUserSubscriptionList=data;
		  $scope.currentPage = 1; //current page
		  $scope.entryLimit = 10; //max no of items to display in a page
		  $scope.filteredItems = $scope.cancleUserSubscriptionList.length; //Initially for no filter  
		  $scope.totalItems = $scope.cancleUserSubscriptionList.length;
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
	  
    $http.get(BASE_URL +'user/getCurrentUser').success(function(data){
      $scope.currentUserList = data;
    });

    $scope.cancleUserSubscription = function(user){
		var cancelSuscription = confirm('Are you absolutely sure you want to cancel Suscription?');
		if (cancelSuscription) {
			$http.post(BASE_URL +'upgrade/cancelUserSubscription',user).success(function(data){
				var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
				$('#message').html(message);
			});
		}
    };
});

myCustomApp.controller('activateSubscriptionCtr',function($scope, $http, $location, $routeParams){
  $scope.activateSubscription = function(user){
    $http.post(BASE_URL +'upgrade/activateSubscription', user).success(function(data){
		var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('#message').html(message);
	  //alert(data.message);
    });
  };
});

myCustomApp.controller('activateUserSubscriptionCtr',function($scope, $http, $location, $routeParams){
  $scope.activateSubscription = function(user){
    $http.post(BASE_URL +'upgrade/activateSubscription', user).success(function(data){
      alert(data.message);
      location.reload();
    });
  };
});

myCustomApp.controller('updateRankCtr', function($scope, $http, $location, $routeParams){
   $scope.activePath = null;
  $http.get(BASE_URL +'member/getLevel').success(function(data){
    $scope.levelList = data;
  });

  $scope.updateUserRank = function(user){
    $http.post(BASE_URL +'member/updateRank', user).success(function(data){
        alert(data.message);
        $location.path('/rank-members');
    });
  };
});

myCustomApp.controller('cronJobSettingCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL +'cronJob/getCronjobData').success(function(data){
    $scope.cronData=data;
  });

  $scope.update = function(cron){
    $http.put(BASE_URL+'cronJob/updateCronJobSettings/',cron).success(function(data) {
      var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
      $('#message').html(message);     
    });
  };
}); 

myCustomApp.controller('suscriptionListCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'upgrade/activeSuscriptionList').success(function(data){
    $scope.activeSusList = data;
    $scope.currentPage = 1; //current page
    $scope.entryLimit = 10; //max no of items to display in a page
    $scope.filteredItems = $scope.activeSusList.length; //Initially for no filter  
    $scope.totalItems = $scope.activeSusList.length;
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
  $http.get(BASE_URL + 'upgrade/notSusUserList').success(function(data){
    $scope.notSusList = data;
    $scope.currentPage1 = 1; //current page
    $scope.entryLimit1 = 10; //max no of items to display in a page
    $scope.filteredItems1 = $scope.notSusList.length; //Initially for no filter  
    $scope.totalItems1 = $scope.notSusList.length;
  });
  $scope.setPage = function(pageNo) {
      $scope.currentPage1 = pageNo;
  };
  $scope.filter = function() {
    
  };
  $scope.sort_by = function(predicate) {
      $scope.predicate1 = predicate;
      $scope.reverse1 = !$scope.reverse;
  };
  
});

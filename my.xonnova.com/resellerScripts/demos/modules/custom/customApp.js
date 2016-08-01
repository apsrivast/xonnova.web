var myCustomApp = angular.module('theme.demos.customApp', ['angularFileUpload','ngFileUpload','pickadate','ngRoute','ui.bootstrap','ngSignaturePad']);
  
  myCustomApp.factory("CustomServices", ['$http', function($http) {
    var base_url = BASE_URL
      var obj = {};
      var sortingOrder = 'name';

      obj.getUser = function(){
        return $http.get(base_url + 'user/getUser');
      };

      obj.getCashout = function(){
        return $http.get(base_url + 'cashout/getCashout');
      };

      obj.getProfile = function(){
          return $http.get(base_url + 'profile');
      };

      obj.getProduct = function(){
        return $http.get(base_url + 'product/getProduct')
      };

      obj.getEarnings = function(){
        return $http.get(base_url + 'userEarning/getEarning')
      };
	  
	  obj.getPackageAffiliate = function(){
          return $http.get(base_url + 'admin');
      };
	  obj.getdepositList = function(){
        return $http.get(base_url + 'user/depositList');
      };
	  
	  obj.insertHolding = function(user){
          return $http.post(base_url + 'user/addHolding', user).success(function(data){
            alert(data.message);
			
          });
      };
      return obj;   
  }]);

myCustomApp.controller('esignCtr',function($scope, $http, $location, Upload, $route, $routeParams){ 

    $scope.uploadPic = function (files) {
          Upload.upload({
            url: BASE_URL+'e_sign_reseller_ctr/uploadagrement',
         
            file: files
        }).success(function(data) {
           if((data.message != null)){
              
              alert(data.message);
              location.reload();
               
            }else{
             alert(data.mess);      
            }
         
       });
      };


    $scope.esignformSubmit = function(esignuser){
    var canvas = document.getElementById('myCanvas');
    var dataURL = canvas.toDataURL('image/png');
    $scope.esignuser.esign = dataURL;
    
    $http.post(BASE_URL +'e_sign_reseller_ctr/submitEsign', esignuser).success(function(data){
        // var pdf2 = $( "#esignpdf" ).html();
        // $scope.esignuser.esign2 = pdf2;
        // var pdf3 = $( "#esignpdf2" ).html();
        // $scope.esignuser.esign3 = pdf3;
        // var pdf4 = $( "#esignpdf3" ).html();
        // $scope.esignuser.esign4 = pdf4;
       
        if((data.message != null)){
           // $http.post(BASE_URL +'e_sign_ctr/submitEsignPdf',esignuser).success(function(data){
           //    if(data.sucess != null){
           //      var message = '<div class="alert alert-info fade in"><button onclick="reditect()"  class="close" data-dismiss="modal" aria-label="Close" type="button">close</button><strong>'+data.sucess+'</strong></div>';
           //      $('#message').html(message);
           //    }else{
           //      var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
           //      $('#message').html(message);
           //    }
           // });
            alert(data.message);
          location.reload();
            //$('#esignModel').hide();
            //$('.modal-backdrop').css('display','none');
        }else{
         alert(data.mess);      
        }
    });
  };
});




//Upload profile Images
  myCustomApp.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: BASE_URL+'profile/upload'
        });
  }]);
  
//profile Settings controller
  myCustomApp.controller('profileCtr', function ($scope, $http, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getProfile().then(function(data){
          $scope.profileList = data.data;
      });  

      $scope.update = function(user){
            $http.put(BASE_URL+'profile/editUser', user).success(function() {
                $scope.activePath = $location.path('/profile');
            });
      };
  });

  myCustomApp.controller('passwordCtr', function ($scope, $http, $location) {
  
		$http.get(BASE_URL + 'activate_platform_store').success(function(data){
			  $scope.profileList = data;
		  });  


		  $scope.storechange = function(user){
				  $http.put(BASE_URL+'activate_platform_store/storeUserChangePhone', user).success(function(data) {
					  alert(data.message);
				  });
		  };
        
        $scope.userchange = function(user){
              $http.put(BASE_URL+'profile/storeUserChangePass', user).success(function(data) {
                 /*  $scope.activePath = $location.path('/profile'); */
				  alert(data.message);
              });
        };

        $scope.managementchange = function(user){
              $http.put(BASE_URL+'profile/managementChangePass', user).success(function() {
                  $scope.activePath = $location.path('/profile');
              });
        };
    });
	
	
	myCustomApp.directive('ngStorepassword', ['$http', function ($http) {
	
      return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        elem.on('blur', function (evt) {
        scope.$apply(function () {
          $http({ 
          type: 'json',
          method: 'POST', 
          url: BASE_URL+'profile/isStorePassNotMatch', 
		  
          data: { 
            password:elem.val() 
          } 
          }).success(function(data) {
          ctrl.$setValidity('storepassword', data.status);
		  
         });
        });
        });
      }
      }
    }
  ]);



  myCustomApp.directive('ngUserpassword', ['$http', function ($http) {
      return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        elem.on('blur', function (evt) {
        scope.$apply(function () {
          $http({ 
          type: 'json',
          method: 'POST', 
          url: BASE_URL+'profile/isPassNotMatch', 
          data: { 
            password:elem.val() 
          } 
          }).success(function(data) {
          ctrl.$setValidity('userpassword', data.status);
         });
        });
        });
      }
      }
    }
  ]);

//File Upload Services
  myCustomApp.directive('fileModel', ['$parse', function ($parse) {
      return {
          restrict: 'A',
          link: function(scope, element, attrs) {
              var model = $parse(attrs.fileModel);
              var modelSetter = model.assign;
              
              element.bind('change', function(){
                  scope.$apply(function(){
                      modelSetter(scope, element[0].files[0]);
                  });
              });
          }
      };
  }]);

  myCustomApp.service('fileUpload', function ($http) {
      this.uploadFileToUrl = function(file, uploadUrl){
          var fd = new FormData();
          fd.append('file', file);
          $http.post(uploadUrl, fd, {
              transformRequest: angular.identity,
              headers: {'Content-Type': undefined}
          })
          .success(function(){
          })
          .error(function(){
          });
      }
  });
// Deposit controller
  /*myCustomApp.controller('depositCtr', function($scope, $http, $location, $routeParams, fileUpload){
    $scope.update = function(deposit){
          $http.post(BASE_URL+'user/uploadDeposit', user).success(function() {
              $scope.activePath = $location.path('/profile');
          });
    };
    $scope.uploadFile = function(){
        var file = $scope.deposit_image;
        console.log('file is ' + JSON.stringify(file));
        var uploadUrl = "http://localhost/angularjs/angular-file-upload-master/examples/simple/upload.php";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };
  });*/
  myCustomApp.controller('MyCtrlDeposit', ['$scope', 'Upload','$location', function ($scope,   Upload,$location) {
      // $http.get(BASE_URL + 'upgrade/getEncriptionSystemByUser').success(function(data){
      //   $scope.incriptionList = data;
      // });     

          $scope.uploadFilgfde = function(files) {
            var YesUpload = confirm('Are you Sure you want to Upload Deposit ?');
            if (YesUpload) {
                Upload.upload({
                    url: 'user/userdeposit',
                    fields: { 							  'package_id': 1,
                              'transaction_id': $scope.transaction_id,
                              'date_deposit': $scope.date_deposit,
							  'bank_amount': $scope.bank_amount,
                              'bank_deposit': $scope.bank_deposit,
                            },
                    file: files
                }).success(function (data) {
                    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.mess+'</strong></div>';
                    $('#message').html(message);
                });
            }
          };
  }]);
  
  myCustomApp.controller('depositCtr', ['$scope', 'Upload', function ($scope, Upload) {
      $scope.uploadPic = function (files) {
        Upload.upload({
            url: BASE_URL+'product/upload',
            fields: {'product_name': $scope.product_name,
                      'product_price': $scope.product_price,
                      'product_category': $scope.product_category,
                      'product_qty': $scope.product_qty,
                      'product_binary_point': $scope.product_binary_point,
                      'product_status': $scope.product_status,
                      'product_desc': $scope.product_desc,
                   },
            file: files
        });
      };
  }]);
//Earnings controller
  myCustomApp.controller('viewEarningsCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
    CustomServices.getEarnings().then(function(data){
        $scope.earningDataList = data.data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.earningDataList.length; //Initially for no filter  
        $scope.totalItems = $scope.earningDataList.length;
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
//Earning Controller
  myCustomApp.controller('viewEarningsByIdCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.userId;
      $scope.activePath = null;

      
	  
      $http.get(BASE_URL +'userEarning/getleftBinary/'+ID).success(function(data){
        $scope.leftBinary = data;
      });
      $http.get(BASE_URL +'userEarning/getrightBinary/'+ID).success(function(data){
        $scope.rightBinary = data;
      });
      $http.get(BASE_URL +'userEarning/getReferralBonus/'+ID).success(function(data){
        $scope.referralBonus = data;
      });
      $http.get(BASE_URL +'userEarning/getProductBonus/'+ID).success(function(data){
        $scope.productBonus = data;
      });
	    $http.get(BASE_URL +'earning/getRewardBonus/'+ID).success(function(data){
        $scope.rewardBonus = data;
      });

      $http.get(BASE_URL +'earning/getDeductBonus/'+ID).success(function(data){
        $scope.deductBonus = data;
      });
  });
  
  
	myCustomApp.controller('viewRewardPointByIdCtr', function($scope, $http, $location, $routeParams){
        var ID = $routeParams.userId;
      $scope.activePath = null;

      $http.get(BASE_URL+'userEarning/getEarningsById/'+ID).success(function(data) {
          $scope.rewardDetails = data;
      });

      $http.get(BASE_URL +'userEarning/getTotalBanlance/'+ID).success(function(data){
        $scope.TotalReward = data;
      });

    });
//Reward Point controller
  myCustomApp.controller('viewRewardPointCtr', function($scope, $http, $location, $routeParams){
    /* var ID = $routeParams.userId;
    $scope.activePath = null;

    $http.get(BASE_URL+'userEarning/getEarningsById/'+ID).success(function(data) {
        $scope.rewardDetails = data;
    });

    $http.get(BASE_URL +'userEarning/getTotalBanlance/'+ID).success(function(data){
      $scope.TotalReward = data;
    }); */

    $http.get(BASE_URL + 'userEarning/getEarning').success(function(data){
        $scope.rewardPoints = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.rewardPoints.length; //Initially for no filter  
        $scope.totalItems = $scope.rewardPoints.length;
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
//Cashout controller
  myCustomApp.controller('cashoutCtr', function($scope, $http, $location, $routeParams,$route, Upload){
   
          $scope.user = {
            cashout_method: 'Wire'
          };
          $http.get(BASE_URL + 'cashout/userCashoutInformationExist').success(function(data){
              $scope.exist = data.status;
           });

           $http.get(BASE_URL + 'deposit_ctr/useronHold').success(function(data){
              $scope.hold = data.status;
           });
          $http.get(BASE_URL + 'cashout/userCashoutEarningInformation').success(function(data){
              $scope.list = data;
           });


        $scope.userCashoutInfo = function(user){
              $http.put(BASE_URL+'cashout/userCashoutInformation', user).success(function(data) {
                  alert(data.message);
                  $route.reload();

              });
        };

        $scope.uploadIdProof = function (files) {
                    Upload.upload({
                        url: BASE_URL+'cashout/uploadCashoutProof',
                        file: files
                    }).success(function (data) {
                        $scope.user.id_proof=data.file_name;
                    });
        };
        $scope.uploadWProof = function (files) {
                    Upload.upload({
                        url: BASE_URL+'cashout/uploadCashoutProof',
                        file: files
                    }).success(function (data) {
                        $scope.user.w_form=data.file_name;
                    });
        };
       
        $scope.userCashoutNext = function(next){
              $http.put(BASE_URL+'cashout/userCashoutNextOut', next).success(function(data) {
                  alert(data.message);
                  $route.reload();
              });
        };

  }); 

  myCustomApp.directive('ngExistamount', ['$http', function ($http) {
      return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        elem.on('blur', function (evt) {
        scope.$apply(function () {
          $http({ 
          type: 'json',
          method: 'POST', 
          url: BASE_URL+'cashout/isAmountExist', 
          data: { 
            amount:elem.val() 
          } 
          }).success(function(data) {
          ctrl.$setValidity('existamount', data.status);
         });
        });
        });
      }
      }
    }
  ]);
//Upgrade User Controller
  myCustomApp.controller('upgradeUserCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.userId;
    $scope.activePath = null;

    $http.get(BASE_URL + 'user/getCurrentUser').success(function(data){
        $scope.currentUserList = data;
    });

    $http.get(BASE_URL + 'user/getEncriptionSystem').success(function(data){
      $scope.incriptionList = data;
    });
  });

// Product Controller
  myCustomApp.controller('getProductCtr', function($scope, $http, $location, $routeParams){

    $http.get(BASE_URL +'user/getProduct').success(function(data){
      $scope.productList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.productList.length; //Initially for no filter  
      $scope.totalItems = $scope.productList.length;
    });
	
	$http.get(BASE_URL + 'user/getCurrentUser').success(function(data){
        $scope.currentUserList = data;
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
  
  // board view controller 
  myCustomApp.controller('addAffliateCtr', function($scope, $http, $location, $routeParams, CustomServices){
        //var productID = $routeParams.pID;
        //$scope.activePath = null;

        /* $http.get(BASE_URL+'user/getUser').success(function(data) {
          $scope.userHolding = data;
        });

        $scope.submit = function(){
            $http.post(BASE_URL+'user/addHoldingPopup', user).success(function() {
                //$scope.activePath = $location.path('/board-view');
            });
        }; */
		$http.get(BASE_URL+'user/getUser').success(function(data) {
          $scope.userList = data;
        });

        $scope.addHoldingTank = function(user){
          if(user.user_position==user.user_name){
            alert('not same user');
            exit();
          }
          CustomServices.insertHolding(user);
          $location.path('/board-view');
          //alert('User Added Successfully!');
        };
		
		CustomServices.getPackageAffiliate().then(function(data){
          $scope.packages = data.data;
		});
		
		$scope.boardlevelSearch = function(boardlevel){
          $http.post(BASE_URL+'tree/boardlevelSearch',boardlevel).success(function(data) {
              alert(data.message);
              $location.path('/board-view');
              location.reload();  
          });
        };
  });
 // Unilevel Search Controller 
  myCustomApp.controller('unilevelSearchCtr', function($scope, $http, $route, $location, $routeParams, CustomServices){
      
      $http.get(BASE_URL+'user/getUser').success(function(data) {
        $scope.userHolding = data;
      });
      CustomServices.getPackageAffiliate().then(function(data){
          $scope.packages = data.data;
      });
      $scope.unilevelSearch = function(unilevel){
        $http.post(BASE_URL+'tree/unilevelSearch',unilevel).success(function(data) {
            alert(data.message);
            $location.path('/unilevel-view');
            location.reload();  
        });
      };
  });
  // Holding tank controller
myCustomApp.controller('holdingTankCtr', function($scope, $rootScope, $location, $routeParams, CustomServices) {
      $scope.addHoldingTank = function(user){
        if(user.user_position==user.user_name){
          alert('not same user');
          exit();
        }
        CustomServices.insertHolding(user);
        $location.path('/board-view');
        //alert('User Added Successfully!');
      };

  });
  myAppForm.directive('ngUniqueparent', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'user/isUniqueParent', 
        data: { 
          username:elem.val()
          
        } 
        }).success(function(data) {
        ctrl.$setValidity('uniqueparent', data.status);
       });
      });
      });
    }
    }
  }
]);
   myAppForm.directive('ngUniquechild', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'user/isUniqueChild', 
        data: { 
          username:elem.val()
          
        } 
        }).success(function(data) {
        ctrl.$setValidity('uniquechild', data.status);
       });
      });
      });
    }
    }
  }
]);
//Orders Controllers
   myCustomApp.controller('userProductOrderSummaryCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'user/productOrderSummary').success(function(data){
        $scope.productOrderList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.productOrderList.length; //Initially for no filter  
        $scope.totalItems = $scope.productOrderList.length;
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

 
  myCustomApp.controller('userNewProductOrderSummaryCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'user/newProductOrderSummary').success(function(data){
        $scope.newProductOrderList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.newProductOrderList.length; //Initially for no filter  
        $scope.totalItems = $scope.newProductOrderList.length;
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

  myCustomApp.controller('userproductOrderSummaryViewCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    
    
    $http.get(BASE_URL+'user/userproductOrderSummaryView/'+ID).success(function(data) {
      $scope.list = data;
    });

    
  });
  
  myCustomApp.controller('MyCtrDepositlist', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getdepositList().then(function(data){
          $scope.depositList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.depositList.length; //Initially for no filter  
          $scope.totalItems = $scope.depositList.length;
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
  
  //Rank details controller
  myCustomApp.controller('viewRankDetailsCtr', function($scope, $http, $location, $routeParams){
       var $topLoader = $("#topLoader").percentageLoader({width: 256, height: 256, controllable : true, progress : 0.5, onProgressUpdate : function(val) {
        $topLoader.setValue(Math.round(val * 100.0));
      }});
      var topLoaderRunning = false;
	  $http.get(BASE_URL + 'rank/getUserRank').success(function(data){
            $scope.level=data.level;
            $scope.labelText=data.labelText;
            $scope.labelTextRequired=data.labelTextRequired;
            $scope.Total=data.total;
            $scope.getRequired=data.required;
            $scope.currentRank= data.currentRank;
			$scope.requiredDif = data.requiredDiff;
			
			 if (topLoaderRunning) {
              return;
            }
            topLoaderRunning = true;
            $topLoader.setProgress(0);
            $topLoader.setValue('0QV');
            var kb = data.total;
            var QV = data.total;
            var totalKb = data.required;
            
            var animateFunc = function() {
              kb += 10;
              $topLoader.setProgress(QV / totalKb);
              $topLoader.setValue(QV.toString() + data.labelText);
              
              if (kb < QV) {
                setTimeout(animateFunc, 25);
              } else {
                topLoaderRunning = false;
              }
            }                   
            setTimeout(animateFunc, 25);
      });
  });
  
  myCustomApp.controller('userModuleDetailsCtr', function($scope, $http, $location, $routeParams){
     /*var $topLoader = $("#topLoader").percentageLoader({width: 256, height: 256, controllable : true, progress : 0.5, onProgressUpdate : function(val) {
        $topLoader.setValue(Math.round(val * 100.0));
      }});
      var topLoaderRunning = false;*/
      $http.get(BASE_URL + 'entrepreneurial/getUserModuleMemberDetails/').success(function(data){
            $scope.module= data.module;
            $scope.totalSponsorLevel=data.totalSponsorLevel;
            $scope.totalSponsor=data.totalSponsor;
            $scope.totalSponsorDifLevel=data.totalSponsorDifLevel;
            $scope.totalSponsorDif=data.totalSponsorDif;
            $scope.sponsorRequiredLevel=data.sponsorRequiredLevel;
            $scope.sponsorRequired=data.sponsorRequired;
            $scope.totalTeamMemberLevel=data.totalTeamMemberLevel;
            $scope.totalTeamMember=data.totalTeamMember;
            $scope.totalTeamMemberDifLevel=data.totalTeamMemberDifLevel;
            $scope.totalTeamMemberDif=data.totalTeamMemberDif;
            $scope.teamMemberRequiredLevel = data.teamMemberRequiredLevel;
            $scope.teamMemberRequired = data.teamMemberRequired;
            /*if (topLoaderRunning) {
              return;
            }
            topLoaderRunning = true;
            $topLoader.setProgress(0);
            $topLoader.setValue('0QV');
            var kb = data.total;
            var QV = data.total;
            var totalKb = data.required;
            
            var animateFunc = function() {
              kb += 10;
              $topLoader.setProgress(QV / totalKb);
              $topLoader.setValue(QV.toString() + data.labelText);
              
              if (kb < QV) {
                setTimeout(animateFunc, 25);
              } else {
                topLoaderRunning = false;
              }
            }                   
            setTimeout(animateFunc, 25);*/
      });
  });
  
  //Membership List controller
  myCustomApp.controller('memberShipReportCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'report/membershipReport').success(function(data){
      $scope.memberShipReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.memberShipReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.memberShipReportList.length;
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
 myCustomApp.controller('earningReportByUserCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.urid;

       $http.get(BASE_URL + 'earningreport/getEarningReportByUser/'+ID).success(function(data){
          $scope.earningReportListByUser = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.earningReportListByUser.length; //Initially for no filter  
          $scope.totalItems = $scope.earningReportListByUser.length;
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

  myCustomApp.controller('dateATTSimCtr', function($scope, $http){
     var $input = $( '.datepickerATTSim' ).pickadate({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',

            
            min: new Date(1900,1,01),
            max: -6570,
            
            container: '.containerATTSim',
            
            closeOnSelect: true,
            
            today: '',
            clear: '',
            close: '',
            
            selectYears: 100,
            
        });
  });
  myCustomApp.controller('dateSmSimCtr', function($scope, $http){
     var $input = $( '.datepickerSmSim' ).pickadate({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',

            
            min: new Date(1900,1,01),
            max: -6570,
            
            container: '.containerSmSim',
            
            closeOnSelect: true,
            
            today: '',
            clear: '',
            close: '',
            
            selectYears: 100,
            
        });
  });
 myCustomApp.controller('activatePlatformCtr', function($scope, $http, $location, $routeParams, CustomServices){
         $http.get(BASE_URL + 'activate_platform_store').success(function(data){
          $scope.profileList = data;
      });  



        $scope.submit = function(user){
            $http.post(BASE_URL+ 'activate_platform_store/activatePlatform', user).success(function(data) {
              
                alert(data.message);
               
            });
        };
    
    
  });

 myCustomApp.controller('rewardPointsReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
 

     $http.get(BASE_URL + 'reward_points/walletReportByUser2/').success(function(data){
        $scope.walletReportListByUser = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.walletReportListByUser.length; //Initially for no filter  
        $scope.totalItems = $scope.walletReportListByUser.length;
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

myCustomApp.controller('entrepreneurialBonusReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
    $scope.update = function(dateRangeSearch){
    
      $http.put(BASE_URL +'entrepreneurialReport/entrepreneurialHistory', dateRangeSearch).success(function(data){
          $scope.moduleList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 5; //max no of items to display in a page
          $scope.filteredItems = $scope.moduleList.length; //Initially for no filter  
          $scope.totalItems = $scope.moduleList.length;
       
      });
    };
     $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
      };

      $scope.filter = function() {
        
      };

      $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
      };
    $http.get(BASE_URL + 'entrepreneurialReport/getEntrepreneurialReport').success(function(data){
      $scope.user_name = data.user_name;
      $scope.total_paid_bonus = data.total_paid_bonus;
      $scope.current_module = data.current_module;
      $scope.total_direct_sponsor = data.total_direct_sponsor;
      $scope.total_team_member = data.total_team_member;
      $scope.next_module = data.next_module;
      $scope.rule_percent = data.rule_percent;
      $scope.required_sponsor = data.required_sponsor;
      $scope.missing_direct_sponsor = data.missing_direct_sponsor;
      $scope.total_qualified_member = data.total_qualified_member;
      $scope.missing_qualified_member = data.missing_qualified_member;
      $scope.module_amount = data.module_amount;
      /*$scope.required_member = data.required_member;
      $scope.required_member = data.required_member;*/
    });

    $http.get(BASE_URL + 'entrepreneurialReport/entrepreneurialTeamMember').success(function(data){
      $scope.memberReportList = data;
      $scope.currentPage2 = 1; //current page
      $scope.entryLimit2 = 10; //max no of items to display in a page
      $scope.filteredItems2 = $scope.memberReportList.length; //Initially for no filter  
      $scope.totalItems2 = $scope.memberReportList.length;
    });

    $scope.setPage2 = function(pageNo) {
      $scope.currentPage2 = pageNo;
    };

    $scope.filter2 = function() {
      
    };
}); 

myCustomApp.controller('entrepreneurialBonusReportByUserCtr2', function($scope, $http, $route, $location, $routeParams){
 

     // $http.get(BASE_URL + 'earningreport/entrepreneurialBonusByUser/'+Id).success(function(data){
     //    $scope.memberReportList = data;
     //  });
     $http.get(BASE_URL + 'earningreport/entrepreneurialBonusByUser3').success(function(data){
      $scope.memberReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.memberReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.memberReportList.length;
    });

    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
    };

    $scope.filter = function() {
      
    };

    $http.get(BASE_URL + 'earningreport/entrepreneurialBonusByUser4').success(function(data){
      $scope.memberReportList2 = data;
      $scope.currentPage2 = 1; //current page
      $scope.entryLimit2 = 10; //max no of items to display in a page
      $scope.filteredItems2 = $scope.memberReportList2.length; //Initially for no filter  
      $scope.totalItems2 = $scope.memberReportList2.length;
    });

    $scope.setPage2 = function(pageNo) {
      $scope.currentPage2 = pageNo;
    };

    $scope.filter2 = function() {
      
    };
}); 

   myCustomApp.controller('trainingVideosViewsCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', '$route', function($scope, $http, Upload, $location, $routeParams, $route){
      
      $http.get(BASE_URL + 'tools/getTrainingVideosTutorials').success(function(data){
        $scope.TrainingVideosViewList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.TrainingVideosViewList.length; //Initially for no filter  
        $scope.totalItems = $scope.TrainingVideosViewList.length;        
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
  }]);

    myCustomApp.controller('marketingMaterialsViewsCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', '$route', function($scope, $http, Upload, $location, $routeParams, $route){
      
      $http.get(BASE_URL + 'tools/getTrainingVideosTutorials2').success(function(data){
        $scope.TrainingVideosViewList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.TrainingVideosViewList.length; //Initially for no filter  
        $scope.totalItems = $scope.TrainingVideosViewList.length;        
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
  }]);

   myCustomApp.controller('phoneCreditCtr', function($scope, $http, $location, $routeParams, CustomServices){
    /*
      $http.get(BASE_URL + 'entrepreneurial/getAllUsers').success(function(data){
        $scope.moduleMemberList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.moduleMemberList.length; //Initially for no filter  
        $scope.totalItems = $scope.moduleMemberList.length;
      });
     */
    $scope.disab = false;
    $scope.msg = '';
    
    $scope.operators = [
                        {name: 'Telcel', value: 'TELCEL'},
                        {name: 'Movistar', value: 'MOVISTAR'},
                        {name: 'Iusacell', value: 'IUSACELL'},
                        {name: 'Unefon', value: 'UNEFON'},
                        {name: 'Nextel', value: 'NEXTEL'},
                        {name: 'Virgin Mobile', value: 'VIRGIN'},
                        {name: 'Cierto', value: 'CIERTO'},
                        {name: 'Maz Tiempo', value: 'MAZTIEMPO'},
                        {name: 'Tuenti', value: 'TUENTI'},
                        ];
    $scope.operators_options = [];
    // Telcel
    $scope.operators_options[0] = [ 
                                    {name: '10', value: 10}
                                   ];
    // Movistar
    $scope.operators_options[1] = [
                                   {name: '10', value: 10},
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '40', value: 40},
                       {name: '50', value: 50},
                       {name: '60', value: 60},
                       {name: '70', value: 70},
                       {name: '80', value: 80},
                       {name: '100', value: 100},
                       {name: '120', value: 120},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '250', value: 250},
                       {name: '300', value: 300},
                       {name: '400', value: 400},
                       {name: '500', value: 500}
                       ];
    // Iusacell
    $scope.operators_options[2] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Unefon
    $scope.operators_options[3] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Nextel
    $scope.operators_options[4] = [
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '200', value: 200},
                       {name: '500', value: 500}
                       ];
    // Virgin
    $scope.operators_options[5] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500}
                       ];
    // Cierto
    $scope.operators_options[6] = [
                                   {name: '10', value: 10},
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '40', value: 40},
                       {name: '50', value: 50},
                       {name: '60', value: 60},
                       {name: '70', value: 70},
                       {name: '80', value: 80},
                       {name: '100', value: 100},
                       {name: '120', value: 120},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '250', value: 250},
                       {name: '300', value: 300},
                       {name: '400', value: 400},
                       {name: '500', value: 500}
                       ];
    // Maz tiempo
    $scope.operators_options[7] = [
                                   {name: '10', value: 10},
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '40', value: 40},
                       {name: '50', value: 50},
                       {name: '60', value: 60},
                       {name: '70', value: 70},
                       {name: '80', value: 80},
                       {name: '100', value: 100},
                       {name: '120', value: 120},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '250', value: 250},
                       {name: '300', value: 300},
                       {name: '400', value: 400},
                       {name: '500', value: 500}
                       ];
    // Tuenti
    $scope.operators_options[8] = [
                                   {name: '10', value: 10},
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '40', value: 40},
                       {name: '50', value: 50},
                       {name: '60', value: 60},
                       {name: '70', value: 70},
                       {name: '80', value: 80},
                       {name: '100', value: 100},
                       {name: '120', value: 120},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '250', value: 250},
                       {name: '300', value: 300},
                       {name: '400', value: 400},
                       {name: '500', value: 500}
                       ];
    $scope.opoptions = [];
    $scope.setOperatorOptions = function()
    {
      console.log('setoperatoroptions: ' + $scope.phone.operator);
      console.log( $scope.phone.tobuy);
      //$scope.opoptions = $scope.operators_options[$scope.phone.operator];
      
      if(!$scope.phone.operator)
        return;
      
      
      switch($scope.phone.operator)
      {
        case 'TELCEL':
          $scope.opoptions = $scope.operators_options[0];  
        break;
        case 'MOVISTAR':
        $scope.opoptions = $scope.operators_options[1];  
        break;
        case 'IUSACELL':
        $scope.opoptions = $scope.operators_options[2];  
        break;
        case 'UNEFON':
        $scope.opoptions = $scope.operators_options[3];  
        break;
        case 'NEXTEL':
        $scope.opoptions = $scope.operators_options[4];  
        break;
        case 'VIRGIN':
        $scope.opoptions = $scope.operators_options[5];  
        break;
        case 'CIERTO':
        $scope.opoptions = $scope.operators_options[6];  
        break;
        case 'MAZTIEMPO':
        $scope.opoptions = $scope.operators_options[7];  
        break;
        case 'TUENTI':
        $scope.opoptions = $scope.operators_options[8];  
        break;
        default: break;
      }
      
      $scope.phone.tobuy = $scope.opoptions[0].value;
    }
    
    $scope.phone = {
          number: null,
          operator: $scope.operators[0].value,
          tobuy: $scope.operators_options[0].value
    };
    
    $scope.buyPhoneCredit = function()
    {
      console.log($scope.phone);
      $scope.msg = '';
      if(!$scope.phone.number || !$scope.phone.operator || !$scope.phone.tobuy)
      {
        $scope.msg = 'Please fill all info above';
        return;
      }
      
      $scope.msg = 'Wait for transaction...one minut please';
      $scope.disab = true;
      
      
      $http.post(BASE_URL + 'phonecredit/buyPhoneCredit', $scope.phone).success(function(data) 
      {
        $scope.msg = data.msg;
        $scope.disab = false;
        console.log(data);
      })
      .error(function(data)
          {
            $scope.msg = 'There was an error';
            $scope.disab = false;
            console.log(data);
          });
    }
    
    $scope.setOperatorOptions();
  });

myCustomApp.controller('transferEarningToStoreCreditCtr', function($scope, $http, $route, $location, $routeParams){
       //  $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
       //    $scope.totalEarning = data;
       //  });
       
       // $scope.buy = function(user){
       //      $http.post(BASE_URL+ 'transferEarning/buyStoreCreditByEarning', user).success(function(data) {
              
       //          alert(data.message);
       //           $route.reload();
               
       //      });
       //  };

     


    $http.get(BASE_URL + 'upgrade/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
    $http.get(BASE_URL + 'upgrade/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });
    
    $http.get(BASE_URL+'transferEarning/sponserbyUser').success(function(data) {
      $scope.sponserUser = data;
    });
    $http.get(BASE_URL+'transferEarning/getSponsorToSponsor').success(function(data) {
      $scope.sponserUserTop = data;
    });

    $http.get(BASE_URL + 'deposit_ctr/useronHold').success(function(data){
              $scope.hold = data.status;
           });

    $scope.creditChange = function(user){
        $http.post(BASE_URL+ 'transferEarning/transferStoreCreditByEarning', user).success(function(data) {
            alert(data.message);
             $route.reload();
           
        });
    };

    $http.get(BASE_URL + 'transferEarning/getTransferStoreCreditList').success(function(data){
      $scope.transferStoreCreditList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.transferStoreCreditList.length; //Initially for no filter  
      $scope.totalItems = $scope.transferStoreCreditList.length;        
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

myCustomApp.controller('userShippingManagementCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'user_shipping/getShippingList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'user_shipping/getShippingList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/user-shipping-management');
      });
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.filter = function(){      
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
});

myCustomApp.controller('buyStoreCreditCtr', function($scope, $http, $location, $route, $routeParams, Upload){
    $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
      $scope.totalEarning = data;
    });

    $http.get(BASE_URL + 'upgrade/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
    $http.get(BASE_URL + 'upgrade/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });

    $http.get(BASE_URL + 'deposit_ctr/useronHold').success(function(data){
              $scope.hold = data.status;
    });

    $scope.buy = function(user){
        $http.post(BASE_URL+ 'transferEarning/buyStoreCreditByEarning', user).success(function(data) {
            alert(data.message);
            $route.reload();           
        });
    };



        $scope.userinfo = {};

        $http.get(BASE_URL + 'transferEarning/userBuyStoreInformationExist').success(function(data){
            $scope.exist = data.status;
        });

        $scope.userbuyStoreInfo = function(user){
              $http.put(BASE_URL+'transferEarning/userBuyStoreInformation', user).success(function(data) {
                   if(data.message == null){
                        alert(data.err);
                    }else{
                      alert(data.message);
                      $route.reload();
                    }
              });
        };

        $scope.uploadIdProofa = function (files) {
                    Upload.upload({
                        url: BASE_URL+'transferEarning/uploadBuyStoreProof',
                        file: files
                    }).success(function (dataa) {
                          $scope.userinfo.id_proof2 = dataa.file_name;
                    });
        };

        $scope.uploadWProofa = function (files) {
                    Upload.upload({
                        url: BASE_URL+'transferEarning/uploadBuyStoreProof',
                        file: files
                    }).success(function (dataa) {
                         $scope.userinfo.w_form2 = dataa.file_name;
                    });
        };









    $http.get(BASE_URL + 'transferEarning/getBuyStoreCreditList').success(function(data){
      $scope.buyStoreCreditList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.buyStoreCreditList.length; //Initially for no filter  
      $scope.totalItems = $scope.buyStoreCreditList.length;        
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



myCustomApp.controller('redeemCouponsCtr', function($scope, $http, $location, $routeParams, $route){
        $scope.checkCoupon = function(user){
              $http.put(BASE_URL+'redeem_coupons/checkCouponCode', user).success(function(data) {
                $scope.couponPoint = data;
              });
        };
        $scope.getCouponRewardPoint = function(user){
              $http.put(BASE_URL+'redeem_coupons/getRewardPoint', user).success(function(data) {
                      alert(data.message);
                      $route.reload();
              });
        };
});


myCustomApp.controller('changeBankInfoForCashoutCtr', function($scope, $http, $location, $routeParams, $route){
        $http.get(BASE_URL + 'cashout/userCashoutInformationExist').success(function(data){
              $scope.exist = data.status;
           });
       $http.get(BASE_URL + 'cashout/getBankInfoForCashout').success(function(data){
          $scope.List = data;
        });
        $scope.update = function(user){
              $http.put(BASE_URL+'cashout/updateBankinfo', user).success(function(data) {
                      alert(data.message);
                      $route.reload();
              });
        };
});



myCustomApp.controller('deactivatesChangesCardCtr',function($scope, $http, $location, $routeParams){

  $scope.deactivate = function(){
    var sureDec = confirm('Are you absolutely sure ?');
    if (sureDec) {
      $http.post(BASE_URL +'changes_card/deactivateSubscription').success(function(data){
        alert(data.message);
        location.reload();
      });
    }
  };
  $scope.changesCard = function(user){
    var sure = confirm('Are you absolutely sure?');
    if (sure) {
      $http.post(BASE_URL +'changes_card/changesCardSubscription', user).success(function(data){
        alert(data.message);
        location.reload();
      });
    }
  };
});
myCustomApp.controller('deactivatesSubscriptionCtr',function($scope, $http, $location, $routeParams){

  $scope.deactivate = function(){
    var sureDec = confirm('Are you absolutely sure ?');
    if (sureDec) {
      $http.post(BASE_URL +'changes_card/deactivateSubscription').success(function(data){
        alert(data.message);
        location.reload();
      });
    }
  };
  $scope.changesCard = function(user){
    var sure = confirm('Are you absolutely sure?');
    if (sure) {
      $http.post(BASE_URL +'changes_card/changesCardSubscription', user).success(function(data){
        alert(data.message);
        location.reload();
      });
    }
  };
});


myCustomApp.controller('referAStoreCtr',function($scope, $http, $location, $routeParams){
  $scope.add = function(user){
      $http.post(BASE_URL +'reseller_ctr/addAStoreReseller', user).success(function(data){
        alert(data.message);
        //location.reload();
      });
  };
});


myCustomApp.controller('newsSectionCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
       $http.get(BASE_URL + 'news_section_ctr/getNewsUserListByID/'+ID).success(function(data){
          $scope.newsList = data;
        });
  });
  
  myCustomApp.controller('buyASimResellerCtr', function($scope, $http, $location, $routeParams){
       $http.get(BASE_URL + 'product_reseller/getSimListForStorestore').success(function(data){
          $scope.buyASimResellerHtml = data;
        });

	  $scope.buy = function(user){
	  
		  $http.post(BASE_URL +'product_reseller/buySimForStore', user).success(function(data){
			alert(data.message);
		  
		  });
	  
	  };
});

myCustomApp.controller('resellerSimNoCtr', function($scope, $http, $location, $routeParams){

    $http.get(BASE_URL + 'product_reseller/getResellerSimNo').success(function(data){
	
        $scope.getResellerSimNoList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.getResellerSimNoList.length; 
        $scope.totalItems = $scope.getResellerSimNoList.length;
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


myCustomApp.controller('resellerActivationCtr', function($scope, $http, $location, $routeParams){

    $http.get(BASE_URL + 'product_reseller/getResellerActivation').success(function(data){
	
        $scope.getResellerActivationList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.getResellerActivationList.length; 
        $scope.totalItems = $scope.getResellerActivationList.length;
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

myCustomApp.controller('resellerApprovePhoneCtr', function($scope, $http, $location, $routeParams){

    $http.get(BASE_URL + 'product_reseller/getResellerApprovePhone').success(function(data){
	
        $scope.getResellerPhoneList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.getResellerPhoneList.length; 
        $scope.totalItems = $scope.getResellerPhoneList.length;
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


myCustomApp.controller('resellerWaitingPhoneCtr', function($scope, $http, $location, $routeParams){

    $http.get(BASE_URL + 'product_reseller/getResellerWaitingPhone').success(function(data){
	
        $scope.getResellerWaitingPhoneList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.getResellerWaitingPhoneList.length; 
        $scope.totalItems = $scope.getResellerWaitingPhoneList.length;
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

myCustomApp.controller('orderStatusCtr', function($scope, $route, $http, $location, $routeParams){
    $http.get(BASE_URL+'product_reseller/getOrderStatusStore').success(function(data){
      $scope.orderStatusList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.orderStatusList.length; //Initially for no filter  
      $scope.totalItems = $scope.orderStatusList.length; 
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


myCustomApp.controller('activatePlatformStoreCtr', function($scope, $http, $location, $routeParams, CustomServices){
        $http.get(BASE_URL + 'activate_platform_store').success(function(data){
          $scope.profileList = data;
      });  
        $scope.submit = function(user){
            $http.post(BASE_URL+ 'activate_platform_store/activatePlatformStore', user).success(function(data) {
                alert(data.message);
            });
        };
  });




 myCustomApp.controller('transferSimStoreCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'transfer_sim_store_ctr/getTransferSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'transfer_sim_store_ctr/getTransferSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/transfer-sim-store');
      });
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.filter = function(){      
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
});


myCustomApp.controller('transferSimStoreToStoreCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      $http.get(BASE_URL + 'transfer_sim_store_ctr/getTransferSim/'+ID).success(function(data){
          $scope.htmlTransferSim = data;
      });

      $scope.add = function(user){
          $scope.activePath = null;
          var sure = confirm('Are you absolutely sure?');
          if (sure) {
       
            $http.post(BASE_URL +'transfer_sim_store_ctr/editTransferSim/'+ID, user).success(function(data){
              alert(data.message);
              $location.path('/transfer-sim-store');
             
            });
          }
        
      };

});



myCustomApp.controller('activateOlVoucherSCtr', function($scope, $http, $route, $location, $routeParams){
      $scope.submit = function(user){
          var sure = confirm('Are you absolutely sure?');
          if (sure) {
            $http.post(BASE_URL +'activate_ol_voucher_ctr/activateOlVoucherStore', user).success(function(data){
             // alert(data.message);
              if(data.messagee == null){
                  alert(data.message);
              }else{
                alert(data.messagee);
                $route.reload();
              }
            });
          }
      };
});

myCustomApp.controller('mxtopupBonusReportUserCtr', function($scope, $http, $route, $location, $routeParams){
     $http.get(BASE_URL + 'mxtopup_bonus/walletReportByUser2').success(function(data){
        $scope.walletReportListByUser = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.walletReportListByUser.length; //Initially for no filter  
        $scope.totalItems = $scope.walletReportListByUser.length;
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

myCustomApp.controller('mxTopUpCtr', function($scope, $http, $location, $routeParams, CustomServices){
    /*
      $http.get(BASE_URL + 'entrepreneurial/getAllUsers').success(function(data){
        $scope.moduleMemberList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.moduleMemberList.length; //Initially for no filter  
        $scope.totalItems = $scope.moduleMemberList.length;
      });
     */
    $scope.disab = false;
    $scope.msg = '';
    
    $scope.operators = [
                        {name: 'Telcel', value: 'TELCEL'},
                        {name: 'Movistar', value: 'MOVISTAR'},
                        {name: 'Iusacell', value: 'IUSACELL'},
                        {name: 'Unefon', value: 'UNEFON'},
                        {name: 'Nextel', value: 'NEXTEL'},
                        {name: 'Virgin Mobile', value: 'VIRGIN'},
                        {name: 'Cierto', value: 'CIERTO'},
                        {name: 'Maz Tiempo', value: 'MAZTIEMPO'},
                        {name: 'Tuenti', value: 'TUENTI'},
                        ];
    $scope.operators_options = [];
    // Telcel
    $scope.operators_options[0] = [ 
                                    {name: '10', value: 10}
                                   ];
    // Movistar
    $scope.operators_options[1] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Iusacell
    $scope.operators_options[2] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Unefon
    $scope.operators_options[3] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Nextel
    $scope.operators_options[4] = [
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '200', value: 200},
                       {name: '500', value: 500}
                       ];
    // Virgin
    $scope.operators_options[5] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500}
                       ];
    // Cierto
    $scope.operators_options[6] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Maz tiempo
    $scope.operators_options[7] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Tuenti
    $scope.operators_options[8] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    $scope.opoptions = [];
    $scope.setOperatorOptions = function()
    {
      console.log('setoperatoroptions: ' + $scope.phone.operator);
      console.log( $scope.phone.tobuy);
      //$scope.opoptions = $scope.operators_options[$scope.phone.operator];
      
      if(!$scope.phone.operator)
        return;
      
      
      switch($scope.phone.operator)
      {
        case 'TELCEL':
          $scope.opoptions = $scope.operators_options[0];  
        break;
        case 'MOVISTAR':
        $scope.opoptions = $scope.operators_options[1];  
        break;
        case 'IUSACELL':
        $scope.opoptions = $scope.operators_options[2];  
        break;
        case 'UNEFON':
        $scope.opoptions = $scope.operators_options[3];  
        break;
        case 'NEXTEL':
        $scope.opoptions = $scope.operators_options[4];  
        break;
        case 'VIRGIN':
        $scope.opoptions = $scope.operators_options[5];  
        break;
        case 'CIERTO':
        $scope.opoptions = $scope.operators_options[6];  
        break;
        case 'MAZTIEMPO':
        $scope.opoptions = $scope.operators_options[7];  
        break;
        case 'TUENTI':
        $scope.opoptions = $scope.operators_options[8];  
        break;
        default: break;
      }
      
      $scope.phone.tobuy = $scope.opoptions[0].value;
    }
    
    $scope.phone = {
          number: null,
          operator: $scope.operators[0].value,
          tobuy: $scope.operators_options[0].value
    };
    
    $scope.buyPhoneCredit = function()
    {
      console.log($scope.phone);
      $scope.msg = '';
      if(!$scope.phone.number || !$scope.phone.operator || !$scope.phone.tobuy)
      {
        $scope.msg = 'Please fill all info above';
        return;
      }
      
      $scope.msg = 'Wait for transaction...one minut please';
      $scope.disab = true;
      
      
      $http.post(BASE_URL + 'phonecreditbywallet/buyPhoneCredit', $scope.phone).success(function(data) 
      {
        $scope.msg = data.msg;
        $scope.disab = false;
        console.log(data);
      })
      .error(function(data)
          {
            $scope.msg = 'There was an error';
            $scope.disab = false;
            console.log(data);
          });
    }
    
    $scope.setOperatorOptions();
});
myCustomApp.controller('mxTopUpBonusCtr', function($scope, $http, $location, $routeParams, CustomServices){
    /*
      $http.get(BASE_URL + 'entrepreneurial/getAllUsers').success(function(data){
        $scope.moduleMemberList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.moduleMemberList.length; //Initially for no filter  
        $scope.totalItems = $scope.moduleMemberList.length;
      });
     */
    $scope.disab = false;
    $scope.msg = '';
    
    $scope.operators = [
                        {name: 'Telcel', value: 'TELCEL'},
                        {name: 'Movistar', value: 'MOVISTAR'},
                        {name: 'Iusacell', value: 'IUSACELL'},
                        {name: 'Unefon', value: 'UNEFON'},
                        {name: 'Nextel', value: 'NEXTEL'},
                        {name: 'Virgin Mobile', value: 'VIRGIN'},
                        {name: 'Cierto', value: 'CIERTO'},
                        {name: 'Maz Tiempo', value: 'MAZTIEMPO'},
                        {name: 'Tuenti', value: 'TUENTI'},
                        ];
    $scope.operators_options = [];
    // Telcel
    $scope.operators_options[0] = [ 
                                    {name: '10', value: 10}
                                   ];
    // Movistar
    $scope.operators_options[1] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Iusacell
    $scope.operators_options[2] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Unefon
    $scope.operators_options[3] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500},
                       {name: '1000', value: 1000}
                       ];
    // Nextel
    $scope.operators_options[4] = [
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '200', value: 200},
                       {name: '500', value: 500}
                       ];
    // Virgin
    $scope.operators_options[5] = [
                       {name: '20', value: 20},
                       {name: '30', value: 30},
                       {name: '50', value: 50},
                       {name: '100', value: 100},
                       {name: '150', value: 150},
                       {name: '200', value: 200},
                       {name: '300', value: 300},
                       {name: '500', value: 500}
                       ];
    // Cierto
    $scope.operators_options[6] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Maz tiempo
    $scope.operators_options[7] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    // Tuenti
    $scope.operators_options[8] = [
                                   {name: '10', value: 10},
                                   {name: '20', value: 20},
                                   {name: '30', value: 30},
                                   {name: '40', value: 40},
                                   {name: '50', value: 50},
                                   {name: '60', value: 60},
                                   {name: '70', value: 70},
                                   {name: '80', value: 80},
                                   {name: '100', value: 100},
                                   {name: '120', value: 120},
                                   {name: '150', value: 150},
                                   {name: '200', value: 200},
                                   {name: '250', value: 250},
                                   {name: '300', value: 300},
                                   {name: '400', value: 400},
                                   {name: '500', value: 500}
                                   ];
    $scope.opoptions = [];
    $scope.setOperatorOptions = function()
    {
      console.log('setoperatoroptions: ' + $scope.phone.operator);
      console.log( $scope.phone.tobuy);
      //$scope.opoptions = $scope.operators_options[$scope.phone.operator];
      
      if(!$scope.phone.operator)
        return;
      
      
      switch($scope.phone.operator)
      {
        case 'TELCEL':
          $scope.opoptions = $scope.operators_options[0];  
        break;
        case 'MOVISTAR':
        $scope.opoptions = $scope.operators_options[1];  
        break;
        case 'IUSACELL':
        $scope.opoptions = $scope.operators_options[2];  
        break;
        case 'UNEFON':
        $scope.opoptions = $scope.operators_options[3];  
        break;
        case 'NEXTEL':
        $scope.opoptions = $scope.operators_options[4];  
        break;
        case 'VIRGIN':
        $scope.opoptions = $scope.operators_options[5];  
        break;
        case 'CIERTO':
        $scope.opoptions = $scope.operators_options[6];  
        break;
        case 'MAZTIEMPO':
        $scope.opoptions = $scope.operators_options[7];  
        break;
        case 'TUENTI':
        $scope.opoptions = $scope.operators_options[8];  
        break;
        default: break;
      }
      
      $scope.phone.tobuy = $scope.opoptions[0].value;
    }
    
    $scope.phone = {
          number: null,
          operator: $scope.operators[0].value,
          tobuy: $scope.operators_options[0].value
    };
    
    $scope.buyPhoneCredit = function()
    {
      console.log($scope.phone);
      $scope.msg = '';
      if(!$scope.phone.number || !$scope.phone.operator || !$scope.phone.tobuy)
      {
        $scope.msg = 'Please fill all info above';
        return;
      }
      
      $scope.msg = 'Wait for transaction...one minut please';
      $scope.disab = true;
      
      
      $http.post(BASE_URL + 'phonecreditbybonus/buyPhoneCredit', $scope.phone).success(function(data) 
      {
        $scope.msg = data.msg;
        $scope.disab = false;
        console.log(data);
      })
      .error(function(data)
          {
            $scope.msg = 'There was an error';
            $scope.disab = false;
            console.log(data);
          });
    }
    
    $scope.setOperatorOptions();
});


myCustomApp.controller('mxtopupWalletReportResellerCtr', function($scope, $http, $route, $location, $routeParams){
     $http.get(BASE_URL + 'wallet2/walletReportByReseller').success(function(data){
        $scope.walletReportListByUser = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.walletReportListByUser.length; //Initially for no filter  
        $scope.totalItems = $scope.walletReportListByUser.length;
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



//configuration settings
  myCustomApp.config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider


    .when('/mxtopup-wallet-report-reseller',{    
          templateUrl: 'application/views/reseller/mxtopup-report-by-user.html',    
          controller: 'mxtopupWalletReportResellerCtr'  
    })

    .when('/mx-top-up-bonus',{    
          templateUrl: 'application/views/reseller/phone-credit.html',    
          controller: 'mxTopUpBonusCtr'  
    })
    .when('/mx-top-up',{    
          templateUrl: 'application/views/reseller/phone-credit.html',    
          controller: 'mxTopUpCtr'  
    })


    .when('/mxtopup-bonus-report-user',{    
          templateUrl: 'application/views/reseller/mxtopup-report-by-user.html',    
          controller: 'mxtopupBonusReportUserCtr'  
    })

    .when('/activate-ol-voucher',{
      templateUrl: 'application/views/reseller/activate-ol-voucher.html',
      controller: 'activateOlVoucherSCtr'
    })

    .when('/transfer-sim-store-to-store/:id',{
      templateUrl: 'application/views/reseller/transfer-sim-store-to-store.html',
      controller: 'transferSimStoreToStoreCtr'
    })

    .when('/transfer-sim-store',{
      templateUrl: 'application/views/reseller/transfer-sim-store.html',
      controller: 'transferSimStoreCtr'
    })
	
	.when('/activate-platform-store',{
      templateUrl: 'application/views/reseller/activate-platform-store.html',
      controller: 'activatePlatformStoreCtr'
    })
	.when('/buy-a-sim-reseller',{
      templateUrl: 'application/views/reseller/buy-a-sim-reseller.html',
      controller: 'buyASimResellerCtr'
    })
	
	 .when('/reseller-sim-number-list', {
        templateUrl: 'application/views/reseller/reseller-sim-number-list.html',
        controller: 'resellerSimNoCtr'
    })
	
    .when('/reseller-activation-list', {
        templateUrl: 'application/views/reseller/reseller-activation-list.html',
        controller: 'resellerActivationCtr'
    })
	
    .when('/reseller-waiting-phone-list', {
        templateUrl: 'application/views/reseller/reseller-waiting-phone-list.html',
        controller: 'resellerWaitingPhoneCtr'
    })
	
	.when('/approve-waiting-phone-list', {
        templateUrl: 'application/views/reseller/approve-waiting-phone-list.html',
        controller: 'resellerApprovePhoneCtr'
    })
	
	.when('/order-status',{
      templateUrl: 'application/views/reseller/order-status.html',
      controller: 'orderStatusCtr',
    })
	
	
  //     .when('/board-view', {
  //       templateUrl: 'application/views/reseller/board-view.html',
		//  resolve: {
  //         loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
  //           return $ocLazyLoad.load([
  //             'bower_components/jquery-validation/dist/jquery.validate.js',
  //             'bower_components/stepy/lib/jquery.stepy.js'
  //           ]);
  //         }]
  //       },
		// controller: 'addAffliateCtr'
  //     })
  //     .when('/unilevel-view',{
  //       templateUrl:'application/views/reseller/unilevel-view.html',
		//  resolve: {
  //         loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
  //           return $ocLazyLoad.load([
  //             'bower_components/jquery-validation/dist/jquery.validate.js',
  //             'bower_components/stepy/lib/jquery.stepy.js'
  //           ]);
  //         }]
  //       },
		// controller: 'unilevelSearchCtr'
  //     })
  //     .when('/tabular-view',{
  //       templateUrl:'application/views/reseller/tabular-view.html',
  //     })
  //     .when('/profile',{
  //       templateUrl:'application/views/reseller/profile.html',
  //       controller:'profileCtr'
  //     })
  //     .when('/edit-profile',{
  //       templateUrl:'application/views/reseller/edit-profile.html',
  //       controller:'profileCtr'
  //     })
		  .when('/change-password',{
		   templateUrl:'application/views/reseller/change-password.html',
			controller:'passwordCtr'
		})
  //     .when('/cashout',{
  //       templateUrl:'application/views/reseller/cashout.html',
  //       controller:'cashoutCtr'
  //     })      
  //     .when('/earnings',{
  //       templateUrl:'application/views/reseller/earnings.html',
  //       controller: 'viewEarningsCtr'
  //     })
      // .when('/view-earning-details/:userId',{
      //   templateUrl: 'application/views/reseller/view-earning-details.html',
      //   controller: 'viewEarningsByIdCtr'
      // })
      // .when('/reward-points',{
      //   templateUrl: 'application/views/user/reward-points.html',
      //   controller: 'viewRewardPointCtr'
      // })
      // .when('/reward-points',{    
      //   templateUrl: 'application/views/reseller/reward-points-report-by-user.html',    
      //   controller: 'rewardPointsReportByUserCtr'  
      //  })
      // .when('/view-reward-details/:userId',{
      //   templateUrl: 'application/views/reseller/view-reward-details.html',
      //   controller: 'viewRewardPointByIdCtr'
      // })
      .when('/upload-deposit',{
        templateUrl: 'application/views/reseller/deposit.html',
        controller: 'MyCtrlDeposit'
      })
   //    .when('/upgrade-user',{
   //      templateUrl: 'application/views/reseller/upgrade-user.html',
   //      controller: 'upgradeUserCtr',
   //    })
   //    .when('/product-view',{
   //      templateUrl: 'application/views/reseller/product-view.html',
   //      controller: 'getProductCtr'
   //    })
	  // .when('/holding-tank',{
   //      templateUrl:'application/views/reseller/holding-tank.html',
   //      controller:'holdingTankCtr'
   //    })
	  // .when('/user-product-order-summary',{
   //      templateUrl: 'application/views/reseller/user-product-order-summary.html',
   //      controller:'userProductOrderSummaryCtr'
   //    })
   //    .when('/user-new-product-order-summary',{
   //      templateUrl: 'application/views/reseller/user-new-product-order-summary.html',
   //      controller:'userNewProductOrderSummaryCtr'
   //    })
   //    .when('/user-product-order-summary-view/:id',{
   //      templateUrl: 'application/views/reseller/user-product-order-summary-view.html',
   //      controller:'userproductOrderSummaryViewCtr'
   //    })
	  .when('/user-deposit-list', {
        templateUrl: 'application/views/reseller/deposit-list.html',
        controller: 'MyCtrDepositlist'
      })
	  // .when('/user-ranks',{
   //        templateUrl: 'application/views/reseller/user-ranks.html',
   //        controller: 'viewRankDetailsCtr'
   //    })
	  // .when('/user-module-details',{
			// templateUrl: 'application/views/reseller/user-module-details.html',
			// controller:'userModuleDetailsCtr'
	  // })
	  // .when('/membership-report',{
			// templateUrl: 'application/views/reseller/membership-report.html',
			// controller: 'memberShipReportCtr'
	  // })
	  // .when('/earnings-report-by-user/:urid', {
		 //  templateUrl: 'application/views/reseller/earnings-report-by-user.html',
		 //  controller: 'earningReportByUserCtr'
	  // })
    .when('/activate-platform',{
		  templateUrl: 'application/views/reseller/activate-platform.html',
		  controller: 'activatePlatformCtr'
    })
    //  .when('/entrepreneurial-bonus-by-user',{    
    //   templateUrl: 'application/views/reseller/entrepreneurial-bonus-by-user.html',    
    //   controller: 'entrepreneurialBonusReportByUserCtr'  
    //  })

  
    // .when('/view-training-videos', {
    //   templateUrl: 'application/views/reseller/view-training-videos.html',
    //   controller: 'trainingVideosViewsCtr'
    // })
    // .when('/view-marketing-materials', {
    //   templateUrl: 'application/views/reseller/view-marketing-materials.html',
    //   controller: 'marketingMaterialsViewsCtr'
    // })
    // .when('/mexico-topup',{
    //   templateUrl: 'application/views/reseller/phone-credit.html',
    //   controller:'phoneCreditCtr'
    // })
    // .when('/transfer-earning-to-stor-credit', {
    //   templateUrl: 'application/views/reseller/transfer-earning-to-stor-credit.html',
    //   controller: 'transferEarningToStoreCreditCtr'
    // })
    // .when('/user-shipping-management', {
    //   templateUrl: 'application/views/reseller/user-shipping-management.html',
    //   controller: 'userShippingManagementCtr'
    // })
    // .when('/buy-store-credit',{
    //   templateUrl: 'application/views/reseller/buy-store-credit.html',
    //   controller: 'buyStoreCreditCtr'
    // })
    //  .when('/redeem-coupons',{
    //   templateUrl: 'application/views/reseller/redeem-coupons.html',
    //   controller: 'redeemCouponsCtr'
    // })

    // .when('/change-bank-info-for-cashout',{
    //   templateUrl: 'application/views/reseller/change-bank-info-for-cashout.html',
    //   controller: 'changeBankInfoForCashoutCtr'
    // })
    // .when('/deactivates-changes-card',{
    //   templateUrl: 'application/views/reseller/deactivates-changes-card.html',
    //   controller: 'deactivatesChangesCardCtr'
    // })
    // .when('/deactivates-subscription',{
    //   templateUrl: 'application/views/reseller/deactivates-subscription.html',
    //   controller: 'deactivatesSubscriptionCtr'
    // })
    // .when('/view-news/:id', {
    //   templateUrl: 'application/views/reseller/view-news.html',
    //   controller: 'newsSectionCtr'
    // })
    // .when('/refer-a-store',{
    //   templateUrl: 'application/views/reseller/refer-a-store.html',
    //   controller: 'referAStoreCtr'
    // })
    ;
  }]);
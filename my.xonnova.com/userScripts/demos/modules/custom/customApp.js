var myCustomApp = angular.module('theme.demos.customApp', ['angularFileUpload','ngFileUpload','pickadate','ngRoute','ui.bootstrap','ngSignaturePad','youtube-embed','ngDialog']);
  
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

myCustomApp.controller('phoneCarrierCtr',function($scope, $http, $location, $route, $routeParams){ 
    $scope.phoneCarrierSubmit = function(phcarrier){
    $http.post(BASE_URL +'phone_carrier_ctr/updatePhoneCarrier', phcarrier).success(function(data){
        if((data.message != null)){
            $('#phoneCarrier').hide();
            $('.modal-backdrop').css('display','none');
        }else{
         alert(data.mess);  
        }
    });
  };
});


myCustomApp.controller('esignCtr',function($scope, $http, $location, $route, $routeParams){ 
    $scope.esignformSubmit = function(esignuser){
    var canvas = document.getElementById('myCanvas');
    var dataURL = canvas.toDataURL('image/png');
    $scope.esignuser.esign = dataURL;
    
    $http.post(BASE_URL +'e_sign_ctr/submitEsign', esignuser).success(function(data){
        var pdf2 = $( "#esignpdf" ).html();
        $scope.esignuser.esign2 = pdf2;
        var pdf3 = $( "#esignpdf2" ).html();
        $scope.esignuser.esign3 = pdf3;
        var pdf4 = $( "#esignpdf3" ).html();
        $scope.esignuser.esign4 = pdf4;
       
        if((data.message != null)){
           $http.post(BASE_URL +'e_sign_ctr/submitEsignPdf',esignuser).success(function(data){
				if(data.sucess != null){
					var message = '<div class="alert alert-info fade in"><button onclick="reditect()"  class="close" data-dismiss="modal" aria-label="Close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
					$('#message').html(message);
				}else{
					var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
					$('#message').html(message);
				}
           });
          //location.reload();
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
        
        $scope.userchange = function(user){
              $http.put(BASE_URL+'profile/userChangePass', user).success(function() {
                  $scope.activePath = $location.path('/profile');
              });
        };

        $scope.managementchange = function(user){
              $http.put(BASE_URL+'profile/managementChangePass', user).success(function() {
                  $scope.activePath = $location.path('/profile');
              });
        };
    });


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

myCustomApp.controller('MyCtrlDeposit', ['$scope', '$http','Upload','$location', function ($scope, $http,  Upload,$location) {
      // $http.get(BASE_URL + 'upgrade/getEncriptionSystemByUser').success(function(data){
      //   $scope.incriptionList = data;
      // });     

          $scope.uploadFilgfde = function(files) {
            var canvas = document.getElementById('myCanvasid');
            var dataURL = canvas.toDataURL('image/png');
            $scope.esign = dataURL;

            var YesUpload = confirm('Are you Sure you want to Upload Deposit ?');
            if (YesUpload) {
                Upload.upload({
                    url: 'user/userdeposit',
                    fields: { 
                              'file_to_upload': $scope.file_to_upload,
                              'transaction_id': $scope.transaction_id,
                              'routing_no': $scope.routing_no,
                              'account_no': $scope.account_no,
                              'date_deposit': $scope.date_deposit,
                              'bank_deposit' : $scope.bank_deposit,
                              'bank_amount': $scope.bank_amount,
                              'terms_cond': $scope.terms_cond,
                              'esign':$scope.esign,
                            },
                    file: files
                }).success(function (data) {
                    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.mess+'</strong></div>';
                    $('#message').html(message);
                });
            }
          };

          $scope.uploadDeposit = function(files){
            var YesUpload = confirm('Are you Sure you want to Upload Deposit ?');
            if (YesUpload) {
                Upload.upload({
                    url: 'user/depositbank',
                    fields: { 
                              'file_to_upload': $scope.file_to_upload,
                              'transaction_id': $scope.transaction_id,
                              'date_deposit': $scope.date_deposit,
                              'bank_deposit' : $scope.bank_deposit,
                              'bank_amount': $scope.bank_amount,
                              'terms_cond': $scope.terms_cond,
                              //'esign':$scope.esign,
                            },
                    file: files
                }).success(function (data) {
                    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.mess+'</strong></div>';
                    $('#message').html(message);
                });
            }
            /*$http.post(BASE_URL+'user/depositbank',user).success(function(data) {
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.mess+'</strong></div>';
                $('#message').html(message); 
            });*/
          };
  }]);
   myCustomApp.controller('MyCtrlDeposit_old', ['$scope', 'Upload','$location', function ($scope, Upload,$location) {
          $scope.uploadFilgfde = function(files) {
            var YesUpload = confirm('Are you Sure you want to Upload Deposit ?');
            if (YesUpload) {
                Upload.upload({
                    url: 'user/userdeposit',
                    fields: {'package_id': $scope.package_id,
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
          $http.get(BASE_URL + 'cashout/userCashoutEarningInformation').success(function(data){
              $scope.list = data;
           });

          $http.get(BASE_URL + 'deposit_ctr/useronHold').success(function(data){
              $scope.hold = data.status;
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

    $http.get(BASE_URL +'store/getProduct').success(function(data){
      $scope.productList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 9; //max no of items to display in a page
      $scope.filteredItems = $scope.productList.length; //Initially for no filter  
      $scope.totalItems = $scope.productList.length;
    });
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 9);
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
  
    $http.get(BASE_URL + 'user/getCurrentUser').success(function(data){
        $scope.currentUserList = data;
    });
  

    $scope.listView = function(){
      $('#products .item').addClass('list-group-item');
    }

    $scope.gridView = function(){
        $('#products .item').removeClass('list-group-item');
        $('#products .item').addClass('grid-group-item');
    }
  });

  myCustomApp.controller('productPurchaseCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.p_id; 
    $http.get(BASE_URL +'store/getProductById/'+ID).success(function(data){
      $scope.productList = data;
      $scope.proName = data.product_name;
      $scope.totalPrice = data.us_product_price;
    });

    $scope.buyProductByStoreCredit = function(proinfo){
      wsloader(true);
      $http.post(BASE_URL+"store/buyProductByStoreCredit",proinfo).success(function(data){
        if(data.sucess != null){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
            $('#message').html(message);
            wsloader(false);
        }else{
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
            $('#message').html(message);
            wsloader(false);
        }
      });
    };

    $scope.buyProductBycard = function(proinfo){
      wsloader(true);
      $http.post(BASE_URL+"store/buyProductBycard",proinfo).success(function(data){
        if(data.sucess != null){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
            $('#message').html(message);
            wsloader(false);
        }else{
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
            $('#message').html(message);
            wsloader(false);
        }
      });
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

        $scope.onchangepackage = function(id) {
          $http.get(BASE_URL + 'product/getPackageDescriptionById/'+id).success(function(data){
            $scope.incriptionDiscription = data;
          });
          if(id==null){
            $scope.incriptionDiscription = '';
          }
        };  
        
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
		
		$http.get("packageCtr/getMexPackage").success(function(data){
            $scope.mxpackages = data;
        });
		$scope.boardlevelSearch = function(boardlevel){
          $http.post(BASE_URL+'tree/boardlevelSearchByUser',boardlevel).success(function(data) {
              if(data.err != null){
                alert(data.err);
              }else{
                alert(data.message);
                $location.path('/board-view');
                location.reload();
              }    
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
        $http.post(BASE_URL+'tree/unilevelSearchByUser',unilevel).success(function(data) {
            if(data.err != null){
              alert(data.err);
            }else{
              alert(data.message);
              $location.path('/unilevel-view');
              location.reload();               
            }  
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
        
      $http.get(BASE_URL + 'profile').success(function(data){
          $scope.profileList = data;
      });  
        $scope.submit = function(user){
            $http.post(BASE_URL+ 'activate_platform/activatePlatform', user).success(function(data) {
              
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
   myCustomApp.controller('trainingVideosViewsCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', '$route', function($scope, $http, Upload, $location, $routeParams, $route){
      $http.get(BASE_URL + 'tools/getTrainingTutorialsCatgeryUserSide').success(function(data){
        $scope.TrainingVideosCatgeryViewList = data;
      });
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
      $http.get(BASE_URL + 'tools/getMarketingMaterialsCatgeryUserSide').success(function(data){
        $scope.MarketingMaterialsCatgeryViewList = data;
      });  
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
	
myCustomApp.controller('userTransferCreditCtr', function($scope, $http, $location, $routeParams, CustomServices){
    $scope.disab = false;
    $scope.msg = '';
    
    $scope.targetUser = {
          userid: '',
          amount: 0
    };
    
    $scope.transferUserCredit = function()
    {
      $scope.msg = '';
      if(!$scope.targetUser.userid || !$scope.targetUser.amount)
      {
        $scope.msg = 'Please fill all info above, amount must be greather than 0';
        return;
      }

      $scope.msg = 'Wait for transaction...one minut please';
      $scope.disab = true;
      
      $http.post(BASE_URL + 'usercredit/transferUserCredit', $scope.targetUser).success(function(data) 
      {
        $scope.msg = data.msg;
        $scope.targetUser = {
              userid: '',
              amount: 0
        };
        $scope.disab = false;
      })
      .error(function(data)
          {
            $scope.msg = 'There was an error' + data.msg;
            $scope.disab = false;
          });
    }
    
});  

myCustomApp.controller('phoneCreditCtr', function($scope, $http, $location, $routeParams, CustomServices){
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
                                    {name: '20', value: 20},
                                    {name: '30', value: 30},
                                    {name: '50', value: 50},
                                    {name: '100', value: 100},
                                    {name: '200', value: 200},
                                    {name: '500', value: 500}
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
        $scope.phone.number = '';
        $scope.disab = false;
      })
      .error(function(data)
          {
            $scope.msg = 'There was an error' + data.msg;
            $scope.disab = false;
          });
    }
    
    //$scope.setOperatorOptions();
});
  


myCustomApp.controller('transferEarningToStoreCreditCtr', function($scope, $http, $route, $location, $routeParams){
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
        if(data.messagee == null){
          alert(data.message);
         
        }else{
           alert(data.messagee);
  		    $location.path('/referralinstructions');
         // location.reload();
        }
      });
  };
});


myCustomApp.controller('newsSectionUserCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
       $http.get(BASE_URL + 'news_section_ctr/getNewsUserListByID/'+ID).success(function(data){
          $scope.newsList = data;
        });
});

myCustomApp.controller('newEventCtr', function($scope, $http, $location, $route, $routeParams){
    $http.get(BASE_URL+'userEvent/getUserData').success(function(data){
        $scope.getUserList = data;
    });

    $scope.confirmEvent = function(eventData){
     /* var cancelSuscription = confirm('Are you absolutely sure you want to cancel Suscription?');
      if (cancelSuscription) { }*/
        $http.post(BASE_URL +'userEvent/confirmEvent',eventData).success(function(data){
            if(data.sucess != null){
                var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
                $('#message').html(message);
            }else{
                var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
                $('#message').html(message);
            }
        });     
    };
});

myCustomApp.controller('orderStatusCtr', function($scope, $route, $http, $location, $routeParams){
    $http.get(BASE_URL+'order/getOrderStatus').success(function(data){
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

myCustomApp.controller('newsSectionListUserCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'news_section_ctr/getNewsUserList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

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

myCustomApp.controller('bugReportUserCtr', function($scope, $http, Upload, $route, $location, $routeParams){
    $scope.submit = function(user){
      $http.post(BASE_URL +'bug_user/submitBug', user).success(function(data){
        alert(data.message);
        //location.reload();
        $route.reload();
      });
    };

    $scope.user = {};

    $scope.uploadBug = function (files) {
        Upload.upload({
            url: BASE_URL+'bug_user/uploadBug',
            file: files
        }).success(function (data) {
              $scope.user.bug_image = data.file_name;
        });
    };
  });

myCustomApp.controller('bugListUserCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'bug_user/getBugUserList').success(function(data){
      $scope.bugList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.bugList.length; 
      $scope.totalItems = $scope.bugList.length;
    });

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

myCustomApp.controller('MyCtrlDepositBank', ['$scope', 'Upload','$location', function ($scope, Upload,$location) {
          $scope.uploadFilgfde = function(files) {
            var YesUpload = confirm('Are you Sure you want to Upload Deposit ?');
            if (YesUpload) {
                Upload.upload({
                    url: 'user/userdeposit',
                    fields: {'package_id': $scope.package_id,
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
  
myCustomApp.controller('viewTrainingVideosListCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      $http.get(BASE_URL + 'tools/getTrainingTutorialsVideoUserSide/'+ID).success(function(data){
          $scope.TrainingTutorialsVideoViewList = data;
      });
	  
	  $('.fancybox').fancybox();

      
      $('.fancybox-media')
        .attr('rel', 'media-gallery')
        .fancybox({
          openEffect : 'none',
          closeEffect : 'none',
          prevEffect : 'none',
          nextEffect : 'none',

          arrows : false,
          helpers : {
            media : {},
            buttons : {}
          }
        });
});

myCustomApp.controller('viewMarketingMaterialsListCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      $http.get(BASE_URL + 'tools/getMarketingMaterialsUserSide/'+ID).success(function(data){
          $scope.MarketingMaterialsViewList = data;
      });
});

myCustomApp.filter('trusted', ['$sce', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
}]);

myCustomApp.controller('buyASimbackofficeCtr', function($scope, $http, $location, $routeParams){
       $http.get(BASE_URL + 'product_reseller/getSimListForStore').success(function(data){
          $scope.buyASimResellerHtml = data;
        });
		
		$http.get(BASE_URL + 'product_reseller/getlevelPrice').success(function(data){
          $scope.levelprice = data;
        });
		
		$scope.onchangeqty = function(qty, method) {
            $http.get(BASE_URL + 'product_reseller/getonchangetotalprice/'+qty+'/'+method).success(function(data){
               $scope.totalprice = data;
            });
        };

  $scope.buy = function(user){
	   var sure = confirm('Are you absolutely sure?');
      if (sure) {
   
		  $http.post(BASE_URL +'product_reseller/buySimForBackoffice', user).success(function(data){
			alert(data.message);
		   
		  });
	  }
    
  };
});


myCustomApp.controller('etherWalletForUserCtr', function($scope, $http, $route, $location, $routeParams){
     $http.get(BASE_URL + 'ether_wallet/getEtherWalletForUser/').success(function(data){
        $scope.etherWalletReportListByUser = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.etherWalletReportListByUser.length; //Initially for no filter  
        $scope.totalItems = $scope.etherWalletReportListByUser.length;
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



myCustomApp.controller('storeCreditForUserCtr', function($scope, $http, $route, $location, $routeParams){
     $http.get(BASE_URL + 'store_credit/getStoreCreditForUser/').success(function(data){
        $scope.storeCreditReportListByUser = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.storeCreditReportListByUser.length; //Initially for no filter  
        $scope.totalItems = $scope.storeCreditReportListByUser.length;
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


myCustomApp.controller('solarFormForUserCtr', function($scope, $http, $route, $location, $routeParams){
   $scope.user = {
      call_time: 'Morning',
       prefer_lang: 'English',
      owner_house: 'Yes',
    };
  $scope.submit = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
   
        $http.post(BASE_URL +'solar_form_ctr/insertSolarForm', user).success(function(data){
          //alert(data.message);

          if(data.message == null){
              alert(data.mess);
          }else{
            alert(data.message);
            $route.reload();
          }
         
        });
      }
    
  };
});

myCustomApp.controller('solarFormProgressForUserCtr', function($scope, $http, $route, $location, $routeParams){
     $http.get(BASE_URL + 'solar_form_ctr/getSolarFormForUser/').success(function(data){
        $scope.htmlSolarFormForUser = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.htmlSolarFormForUser.length;  
        $scope.totalItems = $scope.htmlSolarFormForUser.length;
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

myCustomApp.controller('pageLegacyexplosionCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL+'user/getUserName').success(function(data) {
        $scope.htmlUserName = data;
    });
});


myCustomApp.controller('buyPromoPackCtr', function($scope, $http, $location, $routeParams){
 
    $http.get(BASE_URL+'product_reseller/userPackage').success(function(data) {
      $scope.user_package_name = data;
    });

    $http.get(BASE_URL+'product_reseller/isBuyPromoPack').success(function(data) {
      $scope.user_is_buy_promo_pack = data;
    });

  $scope.buy = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
   
        $http.post(BASE_URL +'product_reseller/buyPromoPackForBackoffice', user).success(function(data){
          alert(data.message);
         
        });
      }
    
  };
});


myCustomApp.controller('transferSimUserCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'transfer_sim_ctr/getTransferSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'transfer_sim_ctr/getTransferSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/transfer-sim-user');
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


myCustomApp.controller('transferSimUserToUserCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      $http.get(BASE_URL + 'transfer_sim_ctr/getTransferSim/'+ID).success(function(data){
          $scope.htmlTransferSim = data;
      });

       $http.get(BASE_URL+'transfer_sim_ctr/sponserbyUser').success(function(data) {
          $scope.sponserUser = data;
        });
        $http.get(BASE_URL+'transfer_sim_ctr/getSponsorToSponsor').success(function(data) {
          $scope.sponserUserTop = data;
        });


      $scope.add = function(user){
          $scope.activePath = null;
          var sure = confirm('Are you absolutely sure?');
          if (sure) {
       
            $http.post(BASE_URL +'transfer_sim_ctr/editTransferSim/'+ID, user).success(function(data){
              alert(data.message);
              $location.path('/transfer-sim-user');
             
            });
          }
        
      };

});



myCustomApp.controller('activateOlVoucherCtr', function($scope, $http, $route, $location, $routeParams){
      $scope.submit = function(user){
          var sure = confirm('Are you absolutely sure?');
          if (sure) {
            $http.post(BASE_URL +'activate_ol_voucher_ctr/activateOlVoucher', user).success(function(data){
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


myCustomApp.controller('referredListViewCtrl', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'user_account/getReferredView/'+ID).success(function(data){
        $scope.referredListView = data;
    });
});


myCustomApp.controller('referredListCtrl',function($scope, $http, $location, $routeParams){
  
  // var ID = $routeParams.id;
   //$scope.activePath = null;
   
    $http.get(BASE_URL + 'user_account/getreferredList/').success(function(data){
    $scope.ListInfo = data;
    $scope.currentPage = 1; //current page
    $scope.entryLimit = 10; //max no of items to display in a page
    $scope.filteredItems = $scope.ListInfo.length; //Initially for no filter  
    $scope.totalItems = $scope.ListInfo.length;    

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

myCustomApp.controller('prepaidVoucherActivateCtr', function($scope, $http, $location, $routeParams){
   
    $http.get(BASE_URL + 'prepaid_voucher_ctr/getVoucherList').success(function(data){
        $scope.htmlVoucherList = data;
    });

     $scope.onchangevoucher = function(voucherlength, method) {
        if(method == 'FIRST CLASS'){
            $scope.shippingCast = 3.97 - 1 + voucherlength.length;
            $scope.activationCast = 15 * voucherlength.length;
            $scope.totalCast = $scope.shippingCast + $scope.activationCast;
        }else{
            $scope.shippingCast = 9.97 ;
            $scope.activationCast = 15 * voucherlength.length;
            $scope.totalCast = $scope.shippingCast + $scope.activationCast;
        }
     };

     $scope.user = {};
     $scope.submit = function(user){
            $http.post(BASE_URL +'prepaid_voucher_ctr/prepaidVoucherActivation', user).success(function(data){
              if(data.messagee == null){
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
                $('#message').html(message);
              }else{
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
                $('#message').html(message);
                $http.get(BASE_URL + 'prepaid_voucher_ctr/getVoucherList').success(function(data){
                    $scope.htmlVoucherList = data;
                });
                $scope.user = {};
              }
            });
      };
});


myCustomApp.controller('prepaidvoucherSimViewCtrl', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'prepaid_voucher_ctr/getPrepaidVoucher/'+ID).success(function(data){
        $scope.htmlUserVoucher = data;
    });

    $scope.submit = function(user){
            $http.post(BASE_URL +'prepaid_voucher_ctr/prepaidVoucherSim', user).success(function(data){
              if(data.messagee == null){
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
                $('#message').html(message);
              }else{
                alert(data.messagee);
                $location.path('/prepaid-voucher-sim');
               
              }
            });
    };
});


myCustomApp.controller('prepaidvoucherSimCtrl',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'prepaid_voucher_ctr/getUserVoucherList/').success(function(data){
    $scope.htmlUserVoucherList = data;
    $scope.currentPage = 1; //current page
    $scope.entryLimit = 10; //max no of items to display in a page
    $scope.filteredItems = $scope.htmlUserVoucherList.length; //Initially for no filter  
    $scope.totalItems = $scope.htmlUserVoucherList.length;    

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

myCustomApp.controller('requestedSimListUserCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'activate_platform/getRequestedSIMList/').success(function(data){
    $scope.htmlRequestedSIMList = data;
    $scope.currentPage = 1; 
    $scope.entryLimit = 10; 
    $scope.filteredItems = $scope.htmlRequestedSIMList.length;   
    $scope.totalItems = $scope.htmlRequestedSIMList.length;    

  });
   $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getRequestedSIMList', dateRangeSearch).success(function(data){
          $scope.htmlRequestedSIMList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRequestedSIMList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRequestedSIMList.length;
          $location.path('/requested-sim-list-user');
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
});

myCustomApp.controller('upgradeByCreditCardCtr', function($scope, $http, $location, $routeParams){
   
    $http.get(BASE_URL + 'upgrade/getCurrentUser').success(function(data){
       $scope.currentUserCCList = data;
    });
    $http.get(BASE_URL + 'upgrade/getEncriptionSystemByUser').success(function(data){
      $scope.incriptionCCList = data;
    });

    $scope.onchangepackage = function(id) {
      $http.get(BASE_URL + 'product/getPackageDescriptionById/'+id).success(function(data){
        $scope.incriptionDiscription = data;
      });
      if(id==null){
        $scope.incriptionDiscription = '';
      }
    };

    $scope.onchangeupgradepackage = function(oldid, id) {
      $http.get(BASE_URL + 'upgrade/getUpgradePackageDescription/'+oldid+'/'+id).success(function(data){
        $scope.incriptionDiscription2 = data;
      });
      if(id==null){
        $scope.incriptionDiscription2 = '';
      }
    };

    $scope.upgradeUser = function(user){
          $http.put(BASE_URL+'upgrade/upgradeByCreditCard', user).success(function(data) {
              alert(data.message);
          });
    };
});


myCustomApp.controller('topActivationUserListCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'activate_platform/getTopUserList').success(function(data){
       $scope.htmlTopUserList = data;
    });
});


myCustomApp.controller('buyASimByCreditCardCtr', function($scope, $http, $location, $routeParams){
       $http.get(BASE_URL + 'product_reseller/getSimListForStore').success(function(data){
          $scope.buyASimResellerHtml = data;
        });

        $http.get(BASE_URL + 'product_reseller/getlevelPrice').success(function(data){
          $scope.levelprice = data;
        });

        $scope.onchangeqty = function(qty, method) {
            $http.get(BASE_URL + 'product_reseller/getonchangetotalprice/'+qty+'/'+method).success(function(data){
               $scope.totalprice = data;
            });
        };
        
        $scope.buy = function(user){
          $http.post(BASE_URL +'product_reseller/buySimForBOCard', user).success(function(data){
              if(data.messagee == null){
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
                $('#message').html(message);
              }else{
                var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
                $('#message').html(message);
                user.qty ='';
              
              }
          });
        };
});

myCustomApp.controller('upgradeForUserSideCtr', function($scope, $http, $location, $routeParams){
      
});

myCustomApp.controller('transferEarningToMexStoreCreditCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'transferMexEarning/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
	
    $http.get(BASE_URL + 'transferMexEarning/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });
    
    $http.get(BASE_URL+'transferMexEarning/sponserbyUser').success(function(data) {
      $scope.sponserUser = data;
    });
	
    $http.get(BASE_URL+'transferMexEarning/getSponsorToSponsor').success(function(data) {
      $scope.sponserUserTop = data;
    });

    $scope.creditChange = function(user){
        $http.post(BASE_URL+ 'transferMexEarning/transferStoreCreditByEarning', user).success(function(data) {
            alert(data.message);
             $route.reload();
           
        });
    };

    $http.get(BASE_URL + 'transferMexEarning/getTransferStoreCreditList').success(function(data){
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

myCustomApp.controller('buyMexStoreCreditCtr', function($scope, $http, $location, $route, $routeParams, Upload){
    $http.get(BASE_URL+'user/getTotalEarning').success(function(data) {
      $scope.totalEarning = data;
    });

    $http.get(BASE_URL + 'transferMexEarning/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
    $http.get(BASE_URL + 'transferMexEarning/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });

    $scope.buy = function(user){
        $http.post(BASE_URL+ 'transferMexEarning/buyStoreCreditByEarning', user).success(function(data) {
            alert(data.message);
            $route.reload();           
        });
    };



     $http.get(BASE_URL + 'transferMexEarning/useronHold').success(function(data){
              $scope.hold = data.status;
    });
 
	$scope.userinfo = {};

	$http.get(BASE_URL + 'transferMexEarning/userBuyStoreInformationExist').success(function(data){
		$scope.exist = data.status;
	});

	$scope.userbuyStoreInfo = function(user){
		  $http.put(BASE_URL+'transferMexEarning/userBuyStoreInformation', user).success(function(data) {
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
					url: BASE_URL+'transferMexEarning/uploadBuyStoreProof',
					file: files
				}).success(function (dataa) {
					  $scope.userinfo.id_proof2 = dataa.file_name;
				});
	};

	$scope.uploadWProofa = function (files) {
		Upload.upload({
			url: BASE_URL+'transferMexEarning/uploadBuyStoreProof',
			file: files
		}).success(function (dataa) {
			 $scope.userinfo.w_form2 = dataa.file_name;
		});
	};
    $http.get(BASE_URL + 'transferMexEarning/getBuyStoreCreditList').success(function(data){
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

myCustomApp.controller('transferUsToMexStoreCreditCtr', function($scope, $http, $route, $location, $routeParams, ngDialog){
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalMexStoreCreditById').success(function(data){
       $scope.mexCreditTotal = data.total;
    });
  
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalDeductMexStoreCreditById').success(function(data){
      $scope.mexDedutTotal = data.total;
    });

    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalUsStoreCredit').success(function(data){
       $scope.usCreditTotal = data.total;
    });
  
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalDeductUsStoreCredit').success(function(data){
      $scope.usDedutTotal = data.total;
    });

    $scope.creditChange = function(user){
        $http.post(BASE_URL+ 'exchangeStoreCredit/transferUsToMexStoreCredit', user).success(function(data) {
            if(data.message != null){
              ngDialog.open({ template: 'firstDialogId', data: {foo: data.message} });
              $route.reload();
                       
            }else{
              ngDialog.open({ template: 'firstDialogId', data: {foo: data.err} }); 
              /*var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
              $('#error-message').html(message);*/
            }
        });
    };
});

myCustomApp.controller('transferMexToUsStoreCreditCtr', function($scope, $http, $route, $location, $routeParams, ngDialog){
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalMexStoreCreditById').success(function(data){
       $scope.mexCreditTotal = data.total;
    });
  
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalDeductMexStoreCreditById').success(function(data){
      $scope.mexDedutTotal = data.total;
    });

    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalUsStoreCredit').success(function(data){
       $scope.usCreditTotal = data.total;
    });
  
    $http.get(BASE_URL + 'exchangeStoreCredit/getTotalDeductUsStoreCredit').success(function(data){
      $scope.usDedutTotal = data.total;
    });

    $scope.creditChange = function(user){
        $http.post(BASE_URL+ 'exchangeStoreCredit/transferMexToUsStoreCredit', user).success(function(data) {
            //alert(data.message);
            if(data.message != null){
                ngDialog.open({ template: 'firstDialogId', data: {foo: data.message} });         
                $route.reload();
            }else{
                ngDialog.open({ template: 'firstDialogId', data: {foo: data.err} });
            }
        });
    };

    /*$http.get(BASE_URL + 'exchangeStoreCredit/getTransferStoreCreditList').success(function(data){
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
    };*/
});

myCustomApp.controller('topSponsorUserListCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'activate_platform/getTopSponsorUserList').success(function(data){
       $scope.htmlTopSponsorUserList = data;
    });
});


myCustomApp.controller('downlineUserRankCtr',function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'rank/getDownlineList').success(function(data){
      $scope.htmlDownline = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.htmlDownline.length;   
      $scope.totalItems = $scope.htmlDownline.length;    
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

myCustomApp.controller('userviewRankDetailsCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      var $topLoader = $("#topLoader").percentageLoader({width: 256, height: 256, controllable : true, progress : 0.5, onProgressUpdate : function(val) {
        $topLoader.setValue(Math.round(val * 100.0));
      }});
      var topLoaderRunning = false;
    
      $http.get(BASE_URL + 'rank/getAllUserRank/'+ID).success(function(data){
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

myCustomApp.controller('userVoucherListCtr',function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'prepaid_voucher_ctr/getUserAllVoucherList').success(function(data){
      $scope.htmlUserAllVoucher = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.htmlUserAllVoucher.length;   
      $scope.totalItems = $scope.htmlUserAllVoucher.length;    
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

myCustomApp.controller('buyOnlegacyGsmSimCtr', function($scope, $http, $location, $routeParams){
  var gid = $routeParams.id;
  $scope.user = {
        group_id:gid,
      }
  $scope.buy = function(user){
    $http.post(BASE_URL +'product_onlegacy_gsm_sim/buyOnlegacyGsmSimForBOCard', user).success(function(data){
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
          $('#message').html(message);
        }
    });
  };
});
myCustomApp.controller('addCustomerToTelekloudCtr', function($scope, $http, $location, $routeParams){
  var productID = $routeParams.productid;
  //$scope.productId = productID ;
  $http.post(BASE_URL +'product_onlegacy_gsm_sim/checkUserHaveAccount').success(function(data){
      if(data){
          $location.path('/telekloud-new-order/'+productID);
      }
  });

  $scope.isdisabled = false ;
  $scope.buy = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('#message').html(message);
    $http.post(BASE_URL +'product_onlegacy_gsm_sim/addCustomerTelekloud', user).success(function(data){
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
           $scope.isdisabled = false ;
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
          $('#message').html(message);
           $scope.isdisabled = false ;
           alert(data.messagee);
           $location.path('/telekloud-new-order/'+productID);
        }
    });
  };
});


myCustomApp.controller('telekloudNewOrderCtr', function($scope, $http, $location, $routeParams){
  var productID = $routeParams.productid;
  //$scope.productId = productID ;
  $http.post(BASE_URL +'product_onlegacy_gsm_sim/getGroupId/'+productID).success(function(data){
      $scope.user = {
        group_id:data,
        product_id:productID
      }
  });

  $http.post(BASE_URL +'product_onlegacy_gsm_sim/finalPrice/'+productID).success(function(data){
      $scope.finalPrice = data;
  });
  

  $scope.isdisabled = false ;
  $scope.buy = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('#message').html(message);
    $http.post(BASE_URL +'product_onlegacy_gsm_sim/newOrderForTelekloud', user).success(function(data){
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
           $scope.isdisabled = false ;
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
          $('#message').html(message);
           $scope.isdisabled = false ;
        }
    });
  };
});

myCustomApp.controller('newSendLeadsCtr', function($scope, Upload, $http, $location, $routeParams){
  $scope.user = {
  }
  $scope.uploadimageone = function (files) {
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait image uploading<i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    Upload.upload({
        url: BASE_URL+'new_send_leads_ctr/uploadimage',
        file: files
    }).success(function (data) {
          $scope.user.leadimageone = data.file_name;
          var message = '';
          $('.outmessage').html(message);
          $scope.isdisabled = false ;
    });
  };
  $scope.uploadimagetwo = function (files) {
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait image uploading<i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    Upload.upload({
        url: BASE_URL+'new_send_leads_ctr/uploadimage',
        file: files
    }).success(function (data) {
          $scope.user.leadimagetwo = data.file_name;
          var message = '';
          $('.outmessage').html(message);
          $scope.isdisabled = false ;
    });
  };
  $scope.uploadimagethree = function (files) {
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait image uploading<i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    Upload.upload({
        url: BASE_URL+'new_send_leads_ctr/uploadimage',
        file: files
    }).success(function (data) {
          $scope.user.leadimagethree = data.file_name;
          var message = '';
          $('.outmessage').html(message);
          $scope.isdisabled = false ;
    });
  };
  $scope.uploadimagefour = function (files) {
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait image uploading<i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    Upload.upload({
        url: BASE_URL+'new_send_leads_ctr/uploadimage',
        file: files
    }).success(function (data) {
          $scope.user.leadimagefour = data.file_name;
          var message = '';
          $('.outmessage').html(message);
          $scope.isdisabled = false ;
    });
  };
  $scope.uploadimagefive = function (files) {
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait image uploading<i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    Upload.upload({
        url: BASE_URL+'new_send_leads_ctr/uploadimage',
        file: files
    }).success(function (data) {
          $scope.user.leadimagefive = data.file_name;
          var message = '';
          $('.outmessage').html(message);
          $scope.isdisabled = false ;
    });
  };
  $scope.isdisabled = false ;

  $scope.submitPrinting = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    $http.post(BASE_URL +'new_send_leads_ctr/submitPrinting', user).success(function(data){
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('.outmessage').html(message);
        $scope.isdisabled = false ;
    });
  };

  $scope.submitRestaurant = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    $http.post(BASE_URL +'new_send_leads_ctr/submitRestaurant', user).success(function(data){
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('.outmessage').html(message);
        $scope.isdisabled = false ;
    });
  };

  $scope.submitSolar = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    $http.post(BASE_URL +'new_send_leads_ctr/submitSolar', user).success(function(data){
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('.outmessage').html(message);
        $scope.isdisabled = false ;
    });
  };

  $scope.submitMerchant = function(user){
    $scope.isdisabled = true ;
    var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>Wait <i class="fa fa-spinner fa-spin"></i></strong></div>';
          $('.outmessage').html(message);
    $http.post(BASE_URL +'new_send_leads_ctr/submitMerchant', user).success(function(data){
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('.outmessage').html(message);
        $scope.isdisabled = false ;
    });
  };
  
});

myCustomApp.controller('restaurantLeadBonusCtr', function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'new_send_leads_ctr/getRestaurantLeadsListBYUSER').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'new_send_leads_ctr/getRestaurantLeadsListBYUSER', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/restaurant-lead-bonus');
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
});


myCustomApp.controller('onlegacyMobileCtr',function($scope, $http, $location, $routeParams){
    
  
  $scope.changePlan = function(planid){
      $http.get(BASE_URL + 'telekloud/getPlan/'+planid).success(function(data){
        $scope.onlegacyMobilePlanList = data;
      });
    };
});

myCustomApp.controller('marketingLeadsCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'marketing_leads_ctr/getMarketingLeads').success(function(data){
      $scope.getMarketingLeadsHtml = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.getMarketingLeadsHtml.length;   
      $scope.totalItems = $scope.getMarketingLeadsHtml.length;    
    });
    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'marketing_leads_ctr/getMarketingLeads', dateRangeSearch).success(function(data){
          $scope.getMarketingLeadsHtml = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.getMarketingLeadsHtml.length; //Initially for no filter  
          $scope.totalItems = $scope.getMarketingLeadsHtml.length;
          $location.path('/marketing-leads');
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
});


myCustomApp.controller('restaurantLeadBonusByIdCtr', function ($scope, $http, $route, $location, $routeParams) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $http.get(BASE_URL+'new_send_leads_ctr/getRestaurantLeadsListById/'+id).success(function(data) {
      $scope.htmlRestaurantLeadsListById = data;
    });
    $scope.approve = function(user){
        $http.put(BASE_URL+'new_send_leads_ctr/redeemRestaurantLeadsListById', user).success(function(data) {
          if(data.messagee == null){
            var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
            $('#message').html(message);
          }else{
            alert(data.messagee);
            $location.path('/restaurant-lead-bonus');
          } 
        });
    };
});


myCustomApp.controller('payOutCardUserCtr', function ($scope, $http, $route, $location, $routeParams) {
   
});



myCustomApp.controller('pendingBalanceCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'pending_balance/getPendingBalance').success(function(data){
          $scope.earningReportListByUser = data;
          // $scope.currentPage = 1; //current page
          // $scope.entryLimit = 10; //max no of items to display in a page
          // $scope.filteredItems = $scope.earningReportListByUser.length; //Initially for no filter  
          // $scope.totalItems = $scope.earningReportListByUser.length;
        });

        // $scope.setPage = function(pageNo) {
        //   $scope.currentPage = pageNo;
        // };

        // $scope.filter = function() {
          
        // };

        // $scope.sort_by = function(predicate) {
        //   $scope.predicate = predicate;
        //   $scope.reverse = !$scope.reverse;
        // };
  });

myCustomApp.controller('pendingBalanceByUserCtr', function($scope, $http, $location, $routeParams){
   

       $http.get(BASE_URL + 'pending_balance/getEarningReportByUserApproved').success(function(data){
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


myCustomApp.controller('successTeamCtr', function($scope, $http, $location, $routeParams, CustomServices){
  $http.get(BASE_URL+'user/getUserSB').success(function(data) {
    $scope.userList = data;
  });

  $scope.boardlevelSearch = function(boardlevel){
    $http.post(BASE_URL+'user/boardlevelSearchByUser',boardlevel).success(function(data) {
        if(data.err != null){
          alert(data.err);
        }else{
          alert(data.message);
          $location.path('/board-view');
          location.reload();
        }    
    });
  };
});

myCustomApp.controller('appsBuilderCtr', function($scope, $http, $location, $routeParams){
});

myCustomApp.controller('etherWalletCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'ether_Wallet/getEtherWalletForUser').success(function(data){
      $scope.etherWalletReportListByUser = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.etherWalletReportListByUser.length;   
      $scope.totalItems = $scope.etherWalletReportListByUser.length;    
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


myCustomApp.controller('convertEtherValueCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'convert_ether_value/getTotalWalletBalance').success(function(data){
       $scope.creditTotal = data;
    });
    
    $http.get(BASE_URL + 'convert_ether_value/getTotalDeductWalletBalance').success(function(data){
       $scope.deductTotal = data;
    });
    
    $scope.Submit = function(user){
        $http.post(BASE_URL+ 'convert_ether_value/convertEtherAmount', user).success(function(data) {
            $scope.amount_to_convert = data;
            alert(data.message);
             $route.reload();
        });
    };

    $http.get(BASE_URL + 'convert_ether_value/getEtherConversionRateAddedByAdmin').success(function(data){
       $scope.ether_rate = data.ether_rate;
       $scope.conversion_charge = data.conversion_charge;
    });
});

myCustomApp.controller('recentUserListCtr', function($scope, $http, $location, $routeParams){
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
});

myCustomApp.controller('etherReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'etherReport/getEtherWalletReportByID').success(function(data){
      $scope.getEtherReportList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.getEtherReportList.length;  
      $scope.totalItems = $scope.getEtherReportList.length;
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

    $scope.exportEtherWalletReportList =function(){
        location.reload(BASE_URL + 'etherReport/export');
      // $http.get(BASE_URL + 'pendingEarningReport/export').success(function(data){
      // });
    };
});

myCustomApp.controller('etherReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
    var id = $routeParams.id;
    $scope.userId = id;
    $http.get(BASE_URL + 'etherReport/getEtherWalletReportByUser/'+id).success(function(data){
      $scope.getEtherWalletReportListByUser = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.getEtherWalletReportListByUser.length;  
      $scope.totalItems = $scope.getEtherWalletReportListByUser.length;
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

    $scope.exportEtherWalletReportList =function(){
        location.reload(BASE_URL + 'etherReport/export');
    };
});

//configuration settings
  myCustomApp.config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider


    .when('/apps-builder',{
          templateUrl: 'application/views/user/apps-builder.html',
          controller: 'appsBuilderCtr'
    })


    .when('/success-team', {
        templateUrl: 'application/views/success-team.html',
        controller: 'successTeamCtr'
    })

    .when('/pending-report-by-user',{
        templateUrl:'application/views/user/pending-report-by-user.html',
        controller: 'pendingBalanceByUserCtr'
    })
    .when('/pending-balance',{
        templateUrl:'application/views/user/pending-balance.html',
        controller: 'pendingBalanceCtr'
    })

    .when('/pay-out-card-user',{
      templateUrl: 'application/views/user/pay-out-card-user.html',
      controller:'payOutCardUserCtr'
    })

    .when('/restaurant-lead-bonus-by-id/:id',{    
          templateUrl: 'application/views/user/restaurant-lead-bonus-by-id.html',    
          controller: 'restaurantLeadBonusByIdCtr'  
        })

    .when('/marketing-leads',{
      templateUrl: 'application/views/user/marketing-leads.html',
      controller:'marketingLeadsCtr'
    })


    .when('/purchase-onlegacy-mobile',{
      templateUrl: 'application/views/user/purchase-onlegacy-mobile.html',
      controller:'onlegacyMobileCtr'
    })

     .when('/restaurant-lead-bonus',{
        templateUrl: 'application/views/user/restaurant-lead-bonus.html',
        controller:'restaurantLeadBonusCtr'
      })


      .when('/new-send-leads',{
        templateUrl: 'application/views/user/new-send-leads.html',
        controller:'newSendLeadsCtr'
      })

      .when('/telekloud-new-order/:productid',{
        templateUrl: 'application/views/user/telekloud-new-order.html',
        controller:'telekloudNewOrderCtr'
      })

     

      .when('/add-customer-to-telekloud/:productid',{
        templateUrl: 'application/views/user/add-customer-to-telekloud.html',
        controller:'addCustomerToTelekloudCtr'
      })

      .when('/buy-onlegacy-gsm-sim/:id',{
        templateUrl: 'application/views/user/buy-onlegacy-gsm-sim.html',
        controller:'buyOnlegacyGsmSimCtr'
      })

    .when('/user-voucher-list', {
        templateUrl: 'application/views/user/user-voucher-list.html',
        controller: 'userVoucherListCtr'
    })

    .when('/user-rank-members-details/:id',{
        templateUrl: 'application/views/user/user-rank-members-details.html',
        controller:'userviewRankDetailsCtr'
      })

    .when('/downline-user-rank',{
          templateUrl: 'application/views/user/downline-user-rank.html',
          controller: 'downlineUserRankCtr'
    })

    .when('/top-sponsor-user-list',{
          templateUrl: 'application/views/user/top-sponsor-user-list.html',
          controller: 'topSponsorUserListCtr'
    })

    .when('/upgrade-for-user-side',{
      templateUrl: 'application/views/user/upgrade-for-user-side.html',
      controller: 'upgradeForUserSideCtr'
    })

    .when('/buy-a-sim-by-credit-card',{
      templateUrl: 'application/views/user/buy-a-sim-by-credit-card.html',
      controller: 'buyASimByCreditCardCtr'
    })

    .when('/top-activation-user-list',{
          templateUrl: 'application/views/user/top-activation-user-list.html',
          controller: 'topActivationUserListCtr'
    })

    .when('/upgrade-by-credit-card',{
          templateUrl: 'application/views/user/upgrade-by-credit-card.html',
          controller: 'upgradeByCreditCardCtr'
    })

    .when('/requested-sim-list-user',{
          templateUrl: 'application/views/user/requested-sim-list-user.html',
          controller: 'requestedSimListUserCtr'
    })

    .when('/prepaid-voucher-sim-view/:id',{
          templateUrl: 'application/views/user/prepaid-voucher-sim-view.html',
          controller: 'prepaidvoucherSimViewCtrl'
    })

    .when('/prepaid-voucher-sim',{
          templateUrl: 'application/views/user/prepaid-voucher-sim.html',
          controller: 'prepaidvoucherSimCtrl'
    })


    .when('/prepaid-voucher-activate',{
          templateUrl: 'application/views/user/prepaid-voucher-activate.html',
          controller: 'prepaidVoucherActivateCtr'
    })

    .when('/referred-store-list-view/:id',{
          templateUrl: 'application/views/user/referred-store-list-view.html',
          controller: 'referredListViewCtrl'
        })

    .when('/referred-store-list',{
          templateUrl: 'application/views/user/referred-store-list.html',
          controller: 'referredListCtrl'
        })


    .when('/activate-ol-voucher',{
      templateUrl: 'application/views/user/activate-ol-voucher.html',
      controller: 'activateOlVoucherCtr'
    })


    .when('/transfer-sim-user-to-user/:id',{
      templateUrl: 'application/views/user/transfer-sim-user-to-user.html',
      controller: 'transferSimUserToUserCtr'
    })

    .when('/transfer-sim-user',{
      templateUrl: 'application/views/user/transfer-sim-user.html',
      controller: 'transferSimUserCtr'
    })


    .when('/buy-promo-pack',{
      templateUrl: 'application/views/user/buy-promo-pack.html',
      controller: 'buyPromoPackCtr'
    })

    .when('/page-legacyexplosion',{    
        templateUrl: 'application/views/user/page-legacyexplosion.html',    
        controller: 'pageLegacyexplosionCtr'  
    })
	
	
	.when('/solar-form-progress-for-user',{    
        templateUrl: 'application/views/user/solar-form-progress-for-user.html',    
        controller: 'solarFormProgressForUserCtr'  
    })
    .when('/solar-form-for-user',{    
        templateUrl: 'application/views/user/solar-form-for-user.html',    
        controller: 'solarFormForUserCtr'  
    })
	
	.when('/store-credit-for-user',{    
        templateUrl: 'application/views/user/store-credit-for-user.html',    
        controller: 'storeCreditForUserCtr'  
    })
	
	.when('/buy-a-sim-reseller',{
      templateUrl: 'application/views/user/buy-a-sim-reseller.html',
      controller: 'buyASimbackofficeCtr'
    })
	.when('/view-training-videos-list/:id',{
      templateUrl: 'application/views/user/view-training-videos-list.html',
      controller: 'viewTrainingVideosListCtr'
    })
    .when('/view-marketing-materials-list/:id',{
      templateUrl: 'application/views/user/view-marketing-materials-list.html',
      controller: 'viewMarketingMaterialsListCtr'
    })
	
	 .when('/upload-deposit-bank',{
        templateUrl: 'application/views/user/deposit-bank.html',
        controller: 'MyCtrlDepositBank'
      })
	  
	  .when('/view-news-list', {
      templateUrl: 'application/views/user/view-news-list.html',
      controller: 'newsSectionListUserCtr'
    })

    .when('/bug-report-user', {
      templateUrl: 'application/views/user/bug-report-user.html',
      controller: 'bugReportUserCtr'
    })

    .when('/bug-list-user', {
      templateUrl: 'application/views/user/bug-list-user.html',
      controller: 'bugListUserCtr'
    })
      .when('/board-view', {
        templateUrl: 'application/views/user/board-view.html',
		 resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        },
		controller: 'addAffliateCtr'
      })
      .when('/unilevel-view',{
        templateUrl:'application/views/unilevel-view.html',
		 resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        },
		controller: 'unilevelSearchCtr'
      })
      .when('/tabular-view',{
        templateUrl:'application/views/tabular-view.html',
      })
      .when('/profile',{
        templateUrl:'application/views/profile.html',
        controller:'profileCtr'
      })
      .when('/edit-profile',{
        templateUrl:'application/views/edit-profile.html',
        controller:'profileCtr'
      })
      .when('/change-password',{
        templateUrl:'application/views/change-password.html',
        controller:'passwordCtr'
      })
      .when('/cashout',{
        templateUrl:'application/views/user/cashout.html',
        controller:'cashoutCtr'
      })      
      .when('/earnings',{
        templateUrl:'application/views/user/earnings.html',
        controller: 'viewEarningsCtr'
      })
      .when('/view-earning-details/:userId',{
        templateUrl: 'application/views/user/view-earning-details.html',
        controller: 'viewEarningsByIdCtr'
      })
      // .when('/reward-points',{
      //   templateUrl: 'application/views/user/reward-points.html',
      //   controller: 'viewRewardPointCtr'
      // })
      .when('/reward-points',{    
        templateUrl: 'application/views/user/reward-points-report-by-user.html',    
        controller: 'rewardPointsReportByUserCtr'  
       })
      .when('/view-reward-details/:userId',{
        templateUrl: 'application/views/user/view-reward-details.html',
        controller: 'viewRewardPointByIdCtr'
      })
      .when('/upload-deposit',{
        templateUrl: 'application/views/user/deposit.html',
        controller: 'MyCtrlDeposit'
      })
      .when('/upgrade-user',{
        templateUrl: 'application/views/user/upgrade-user.html',
        controller: 'upgradeUserCtr',
      })
      .when('/product-view',{
        templateUrl: 'application/views/user/product-view.html',
        controller: 'getProductCtr'
      })
	  .when('/holding-tank',{
        templateUrl:'application/views/user/holding-tank.html',
        controller:'holdingTankCtr'
      })
	  .when('/user-product-order-summary',{
        templateUrl: 'application/views/user/user-product-order-summary.html',
        controller:'userProductOrderSummaryCtr'
      })
      .when('/user-new-product-order-summary',{
        templateUrl: 'application/views/user/user-new-product-order-summary.html',
        controller:'userNewProductOrderSummaryCtr'
      })
      .when('/user-product-order-summary-view/:id',{
        templateUrl: 'application/views/user/user-product-order-summary-view.html',
        controller:'userproductOrderSummaryViewCtr'
      })
	  .when('/user-deposit-list', {
        templateUrl: 'application/views/user/deposit-list.html',
        controller: 'MyCtrDepositlist'
      })
	  .when('/user-ranks',{
          templateUrl: 'application/views/user/user-ranks.html',
          controller: 'viewRankDetailsCtr'
      })
	  .when('/user-module-details',{
			templateUrl: 'application/views/user/user-module-details.html',
			controller:'userModuleDetailsCtr'
	  })
	  .when('/membership-report',{
			templateUrl: 'application/views/user/membership-report.html',
			controller: 'memberShipReportCtr'
	  })
	  .when('/earnings-report-by-user/:urid', {
		  templateUrl: 'application/views/user/earnings-report-by-user.html',
		  controller: 'earningReportByUserCtr'
	  }).when('/activate-platform',{
		  templateUrl: 'application/views/user/activate-platform.html',
		  controller: 'activatePlatformCtr'
    })
     .when('/entrepreneurial-bonus-by-user',{    
      templateUrl: 'application/views/user/entrepreneurial-bonus-by-user.html',    
      controller: 'entrepreneurialBonusReportByUserCtr'  
     })

  
    .when('/view-training-videos', {
      templateUrl: 'application/views/user/view-training-videos.html',
      controller: 'trainingVideosViewsCtr'
    })
    .when('/view-marketing-materials', {
      templateUrl: 'application/views/user/view-marketing-materials.html',
      controller: 'marketingMaterialsViewsCtr'
    })
    .when('/mexico-topup',{
      templateUrl: 'application/views/user/phone-credit.html',
      controller:'phoneCreditCtr'
    })
	.when('/user-transfer-credit',{
		templateUrl: 'application/views/user/user-transfer-credit.html',
		controller:'userTransferCreditCtr'
	})
	.when('/transfer-earning-to-stor-credit', {
      templateUrl: 'application/views/user/transfer-earning-to-stor-credit.html',
      controller: 'transferEarningToStoreCreditCtr'
    })
    .when('/buy-store-credit',{
      templateUrl: 'application/views/user/buy-store-credit.html',
      controller: 'buyStoreCreditCtr'
    })
    .when('/redeem-coupons',{
      templateUrl: 'application/views/user/redeem-coupons.html',
      controller: 'redeemCouponsCtr'
    })

    .when('/change-bank-info-for-cashout',{
      templateUrl: 'application/views/user/change-bank-info-for-cashout.html',
      controller: 'changeBankInfoForCashoutCtr'
    })
    .when('/deactivates-changes-card',{
      templateUrl: 'application/views/user/deactivates-changes-card.html',
      controller: 'deactivatesChangesCardCtr'
    })
    .when('/deactivates-subscription',{
      templateUrl: 'application/views/user/deactivates-subscription.html',
      controller: 'deactivatesSubscriptionCtr'
    })

    .when('/view-news/:id', {
      templateUrl: 'application/views/user/view-news.html',
      controller: 'newsSectionUserCtr'
    })
	.when('/new-event',{
      templateUrl: 'application/views/user/new-event.html',
      controller: 'newEventCtr'
    })
	.when('/refer-a-store',{
      templateUrl: 'application/views/user/refer-a-store.html',
      controller: 'referAStoreCtr'
    })
	.when('/referralinstructions',{
      templateUrl: 'application/views/user/referralinstructions.html',
      controller: 'referAStoreCtr'
    })
    .when('/order-status',{
      templateUrl: 'application/views/user/order-status.html',
      controller: 'orderStatusCtr',
    })
	.when('/transfer-earning-to-mex-store-credit', {
	  templateUrl: 'application/views/user/transfer-earning-to-mex-store-credit.html',
	  controller: 'transferEarningToMexStoreCreditCtr'
	})
	.when('/buy-mex-store-credit',{
	  templateUrl: 'application/views/user/buy-mex-store-credit.html',
	  controller: 'buyMexStoreCreditCtr'
	})
	.when('/transfer-store-credit-to-mex-wallet', {
		templateUrl: 'application/views/user/transfer-store-credit-to-mex-wallet.html',
		controller: 'transferUsToMexStoreCreditCtr'
	})
	.when('/transfer-store-credit-to-us-wallet', {
		templateUrl: 'application/views/user/transfer-store-credit-to-us-wallet.html',
		controller: 'transferMexToUsStoreCreditCtr'
	})
  .when('/ether-report', {
    templateUrl: 'application/views/user/ether-wallet.html',
    controller: 'etherWalletCtr'
  })
  .when('/convert-ether-value', {
    templateUrl: 'application/views/user/convert-ether-value.html',
    controller: 'convertEtherValueCtr'
  })
  .when('/purchase-product/:p_id', {
    templateUrl: 'application/views/user/product-purchase-view.html',
    controller: 'productPurchaseCtr'
  })
  .when('/ether-wallet', {
    templateUrl: 'application/views/user/ether-report.html',
    controller: 'etherReportCtr'
  })
  .when('/ether-wallat-report-by-user/:id', {
    templateUrl: 'application/views/user/ether-wallat-report-by-user.html',
    controller: 'etherReportByUserCtr'
  })
  ;
  }]);
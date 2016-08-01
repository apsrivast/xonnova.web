var myCustomApp = angular.module('theme.demos.customApp', ['angularFileUpload','ngFileUpload','pickadate','ngRoute','ui.bootstrap']);
    myCustomApp.filter('startFrom', function() {
      return function(input, start) {
          if(input) {
              start = +start; //parse to int
              return input.slice(start);
          }
          return [];
      }
	});
  myCustomApp.factory("CustomServices", ['$http', function($http) {
    var base_url = BASE_URL
      var obj = {};
      var sortingOrder = 'name';
      
	  obj.insertHolding = function(user){
          return $http.post(base_url + 'admin/addHolding', user).success(function(data){
            alert(data.message);
			
          });
      };

      obj.getPosition = function(){
          return $http.get(base_url + 'admin/getPosition');
      };

      obj.getUser = function(){
        return $http.get(base_url + 'admin/getUser');
      };

      obj.getVoucher = function(){
          return $http.get(base_url +'admin/getVoucher');
      };

      obj.getPackage = function(){
          return $http.get(base_url + 'admin/getPackage');
      };
      
      obj.getCashout = function(){
        return $http.get(base_url + 'cashout/getCashout');
      };

      obj.insertPkg = function (pkg) {
        return $http.post(base_url + 'admin/insertPkg', pkg).then(function (results) {
            return results;
        });
      };

      obj.updatePkg = function (id,user) {
          return $http.post(base_url + 'admin/updatePkg', {id:id, user:user}).then(function (status) {
              return status.data;
          });
      };
      obj.insertVoucher = function(voucher){
        return $http.post(base_url + 'admin/addVoucher', voucher).success(function(data) {
            alert(data.message);
        });
      };
      obj.deletePkg = function (id) {
          return $http.delete(base_url + 'admin/deletePkg?id=' + id).then(function (status) {
              return status.data;
          });
      };

      obj.getProfile = function(){ 
          return $http.get(base_url + 'profile');
      };

      obj.getCategory = function(){
        return $http.get(base_url + 'product/getCategory');
      };
	  
	  obj.getRootCategory = function(){
        return $http.get(base_url + 'product/getRootCatetory');
      };
	  obj.getSubCategory = function(){
        return $http.get(base_url + 'product/getSubCatetory');
      };
      obj.insertCategory = function(category){
        return $http.post(base_url + 'product/addCategory', category).then(function (results) {
           // return results;
			alert('Category Added Successfully');
          });
      };


      obj.insertProduct = function(product){
        return $http.post(base_url + 'product/addProduct', product).then(function (results) {
            return results;
          });
      };

      obj.getProduct = function(){
        return $http.get(base_url + 'product/getProduct')
      };

      obj.insertLevel = function(level){
        return $http.post(base_url + 'level/addLevel',level).then(function(results){
          return results;
        });
      };
      obj.getLevel =function(){
        return $http.get(base_url + 'level/getLevel')
      };

      obj.getEarnings = function(){
        return $http.get(base_url + 'earning/getEarning')
      };

      obj.getPlatforms = function(){
        return $http.get(base_url + 'admin/getPlatform');
      };
      
      obj.getLeads = function(){
        return $http.get(base_url + 'admin/getLead');
      };
	  obj.getPlatformsList = function(){
        return $http.get(base_url + 'admin/platformsList');
      };
	  
	  obj.getUserNames = function(){
        return $http.get(base_url + 'admin/getUserName');
      };
	  
	  obj.getPackageAffiliate = function(){
          return $http.get(base_url + 'admin');
      };
	  
      return obj;   
  }]);

  myCustomApp.controller('approveCashoutCtr', function ($scope,  $http, $rootScope, $location, $routeParams, CustomServices) {
      $http.get(BASE_URL + 'cashout/getApproveCashout').success(function(data){
          $scope.cashoutList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
          $scope.totalItems = $scope.cashoutList.length;
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
  myCustomApp.controller('cashoutCtr', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getCashout().then(function(data){
          $scope.cashoutList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
          $scope.totalItems = $scope.cashoutList.length;
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
 myCustomApp.controller('cashoutInfoCtr', function ($scope, $http, $location, $routeParams, $route) {
      var ID = $routeParams.id;
      $scope.activePath = null;

      $http.get(BASE_URL+'cashout/getCashoutInfoById/'+ID).success(function(data) {
        $scope.cashoutInfoData = data;
      });

      $http.get(BASE_URL + 'cashout/cashoutAmountFunc/'+ID).success(function(data){
        $scope.cashoutAmountList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.cashoutAmountList.length; //Initially for no filter  
        $scope.totalItems = $scope.cashoutAmountList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage = pageNo;
      };

      $scope.filter = function() {
          
      };
	  
      $scope.update = function(user){
        $http.put(BASE_URL+'cashout/updateAmountStatus',user).success(function(data) {
         alert(data.message);
         $route.reload();
        });
      };  


      $scope.rejectId = function(cid){
        $http.put(BASE_URL+'cashout/rejCashList/'+cid).success(function(data) {
          $scope.rejCashList = data;
        });
      };

      $scope.reject = function(user){
        $http.put(BASE_URL+'cashout/rejectAmountStatus', user).success(function(data) {
         alert(data.message);
         $route.reload();
        });
      };        
  });
  
///Package Ctr
  myCustomApp.controller('viewPackageCtrl', function ($scope, $http, $rootScope, $location, $routeParams, CustomServices) {

      $http.get(BASE_URL+'packageCtr/getPackage').success(function(data){
          $scope.pkgList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.pkgList.length; //Initially for no filter  
          $scope.totalItems = $scope.pkgList.length;
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

  myCustomApp.controller('packageEditCtr', function ($scope, $http, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;
      $http.get(BASE_URL+'packageCtr/getPackageById/'+pkgid).success(function(data) {
        $scope.packageData = data;
      });

      $scope.update = function(pkg){
          $location.path('/view-package');
          $http.put(BASE_URL+'packageCtr/updatePackage/'+pkgid, pkg).success(function(data) {
            $scope.packageData = data;
            $scope.activePath = $location.path('/view-package');
          });
      };

      $scope.updateMexPkg = function(pkg){
        $location.path('/view-package');
        $http.put(BASE_URL+'packageCtr/updateMEXPackage/'+pkgid, pkg).success(function(data) {
          $scope.packageData = data;
          $scope.activePath = $location.path('/view-package');
        });
      };

      $scope.delete = function(pkg) {
        var deleteUser = confirm('Are you absolutely sure you want to delete?');
        if (deleteUser) {
          $http.delete(BASE_URL+'packageCtr/deletePackage/'+pkgid);
          $scope.activePath = $location.path('/view-package');
        }
      };

      $scope.deleteMex = function(pkg) {
        var deleteUser = confirm('Are you absolutely sure you want to delete?');
        if (deleteUser) {
          $http.delete(BASE_URL+'packageCtr/deleteMexPackage/'+pkgid);
          $scope.activePath = $location.path('/view-package');
        }
      };
  });

  myCustomApp.controller('addPckageCtrl', function ($scope, $http, $rootScope, $location, $routeParams, CustomServices) {
      $scope.addPackage = function(pkg){
        $http.post(BASE_URL+'packageCtr/insertPkg',pkg).success(function(data){
          $location.path('/view-package');
        });
      };   
  });

//Upload profile Images
  myCustomApp.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: BASE_URL+'profile/upload'
        });
  }]);
  myCustomApp.controller('uploadProductImage',['$scope', 'Upload','$route',function($scope,  Upload, $route) {
      $scope.editProductImage = function(files) {
          Upload.upload({
              url: BASE_URL+'product/updateImage',
              fields: {'p_id': $scope.product.p_id,
                        },
              file: files
          }).success(function(data) {
             alert(data.message);
                  $route.reload();
          });
      };


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
              $http.put(BASE_URL+'profile/userChangePass', user).success(function(data) {
				  alert(data.message);
                  $scope.activePath = $location.path('/profile');
              });
        };

        $scope.managementchange = function(user){
              $http.put(BASE_URL+'profile/managementChangePass', user).success(function(data) {
				  alert(data.message);
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

  myCustomApp.directive('ngManagementpassword', ['$http', function ($http) {
      return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        elem.on('blur', function (evt) {
        scope.$apply(function () {
          $http({ 
          type: 'json',
          method: 'POST', 
          url: BASE_URL+'profile/isUserExist', 
          data: { 
            username:elem.val() 
          } 
          }).success(function(data) {
          ctrl.$setValidity('managementpassword', data.status);
         });
        });
        });
      }
      }
    }
  ]);

  myCustomApp.controller('addVoucherCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
      
      $scope.addVoucher = function(voucher){
        $location.path('/add-voucher');
        CustomServices.insertVoucher(voucher);
      };   
  });
  myCustomApp.controller('viewVoucherCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
      CustomServices.getVoucher().then(function(data){
          $scope.voucherList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.voucherList.length; //Initially for no filter  
          $scope.totalItems = $scope.voucherList.length;
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
//assign user to tree
  myCustomApp.controller('holdingTankCtr', function($scope, $http, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getPosition().then(function(data){
          $scope.userHolding = data.data;
      }); 

      CustomServices.getUser().then(function(data){
          $scope.userList = data.data;
      });  

      $scope.addHoldingTank = function(user){
        //CustomServices.insertHolding(user);
        //$location.path('/board-view'); 
		$http.post(BASE_URL + 'admin/addHolding', user).success(function(data){
          if(data.err !=null){
                alert(data.err);
            }else{
              alert(data.message);
              $location.path('/board-view');              
            } 
        });
      };

  });
  myCustomApp.controller('addHoldingTankCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){

  });
  // board view controller 
  myCustomApp.controller('addAffliateCtr', function($scope, $http, $location, $routeParams, CustomServices){
        //var productID = $routeParams.pID;
        //$scope.activePath = null;

        $scope.onchangepackage = function(id) {
          $http.get(BASE_URL + 'product/getPackageDescriptionById/'+id).success(function(data){
            $scope.incriptionDiscription = data;
          });
          if(id==null){
            $scope.incriptionDiscription = '';
          }
        };  
    
        $http.get(BASE_URL+'admin/getUser').success(function(data) {
          $scope.userHolding = data;
        });

        $scope.submit = function(){
            $http.post(BASE_URL+'admin/addHoldingPopup', user).success(function() {
                //$scope.activePath = $location.path('/board-view');
            });
        };
		
		CustomServices.getPackageAffiliate().then(function(data){
          $scope.packages = data.data;
		});
		
		$http.get("packageCtr/getMexPackage").success(function(data){
            $scope.mxpackages = data;
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
      
      $http.get(BASE_URL+'admin/getUser').success(function(data) {
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
//Upload Images
  myCustomApp.controller('fileUploaderCtr', ['$scope', 'FileUploader', function($scope, $rootScope, $location, $routeParams, FileUploader, CustomServices) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });
  }]);
// Product settings for add product
/*   myCustomApp.controller('addProductCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
      CustomServices.getSubCategory().then(function(data){
          $scope.categoryList = data.data;
      }); 
      $scope.addProduct = function(product){
        $location.path('/add-product');
        CustomServices.insertProduct(product);
        alert('Product Added Successfully!');
      };
  }); */

  myCustomApp.controller('addProductCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', 'CustomServices', function ($scope, $http, Upload, $location, $routeParams, CustomServices) {
      CustomServices.getSubCategory().then(function(data){
          $scope.categoryList = data.data;
      });
	  
	  $scope.uploadPic = function (files) {
          Upload.upload({
            url: BASE_URL+'product/addProduct',
            fields: {'product_name': $scope.product_name,
                     'country': $scope.country,
                      'us_product_price': $scope.us_product_price,
                      'mexico_product_price': $scope.mexico_product_price,
			           		  'shipping_price': $scope.shipping_price,
                      'product_category': $scope.product_category,
                      'product_qty': $scope.product_qty,
                      'product_binary_point': $scope.product_binary_point,
			           		  'product_qv_point':$scope.product_qv_point,
                      'product_status': $scope.product_status,
                      'product_desc': $scope.product_desc,
                      'checked':$scope.checked1,

                        'reward_points':$scope.reward_points,

                         'store_price':$scope.store_price,



					  
		          			  'member_price':$scope.member_price,
                      'representative_price':$scope.representative_price,
                      'partner_price':$scope.partner_price,
                      'brand_partner_price':$scope.brand_partner_price,
                      'team_partner_price':$scope.team_partner_price,
					  
                      'team_lead_price':$scope.team_lead_price,
                      'director_price':$scope.director_price,
                      'regional_price':$scope.regional_price,
                      'national_price':$scope.national_price,
                      'international_price':$scope.international_price,
                      //'VP_price':$scope.VP_price,
                      'p_price':$scope.p_price,
					  
	           				  'ambassador_price':$scope.ambassador_price,
                      'crown_ambassador_price':$scope.crown_ambassador_price,
                   },
            file: files
        }).success(function(data) {
          alert(data.message);
          $scope.activePath = $location.path('/view-product');
       });
      };
  }]);
  
  myCustomApp.controller('uploadProductCtrl', ['$scope', 'Upload', function ($scope, Upload) {
      
      $scope.uploadPic = function (files) {
          Upload.upload({
            url: BASE_URL+'product/upload',
            fields: {'product_name': $scope.product_name,
                      'country':$scope.country,
                      'product_category': $scope.product_category,
                      'product_qty': $scope.product_qty,
                      'product_binary_point': $scope.product_binary_point,
                      'product_status': $scope.product_status,
                      'product_desc': $scope.product_desc,
                      'checked':$scope.checked1,
                      'team_lead_price':$scope.team_lead_price,
                      'director_price':$scope.director_price,
                      'regional_price':$scope.regional_price,
                      'national_price':$scope.national_price,
                      'international_price':$scope.international_price,
                      'VP_price':$scope.VP_price,
                      'p_price':$scope.p_price,
                   },
            file: files
        });
      };
  }]);
  
  myCustomApp.controller('viewProductCtr', function($scope, $http, $rootScope, $location, $routeParams, CustomServices){
      CustomServices.getProduct().then(function(data){
          $scope.productList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.productList.length; //Initially for no filter  
          $scope.totalItems = $scope.productList.length;
      });  
	  CustomServices.getSubCategory().then(function(data){
          $scope.categoryList = data.data;
      });
	  
	  $scope.update = function(sproduct){
        $http.put(BASE_URL+'product/getProductByCat',sproduct).success(function(data){
          $scope.productList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.productList.length; //Initially for no filter  
          $scope.totalItems = $scope.productList.length;
          $location.path('/view-product');
        });
      };
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

   myCustomApp.controller('editProductCtr', function ($scope, $route, $http, $location, $routeParams) {
        var productID = $routeParams.pID;
        $scope.activePath = null;

        $http.get(BASE_URL+'product/getProductById/'+productID).success(function(data) {
          $scope.productData = data;
        });

        $http.get(BASE_URL+'product/getSubCatetory').success(function(data) {
          $scope.categoryList = data;
        });

        $scope.update = function(product){
            $location.path('/view-product');
            $http.put(BASE_URL+'product/updateProduct/'+productID, product).success(function(data) {
              $scope.packageData = data;
              $scope.activePath = $location.path('/view-product');
            });
        };

        $scope.delete = function(product) {
          var deleteProduct = confirm('Are you absolutely sure you want to delete?');
          if (deleteProduct) { 
            $http.put(BASE_URL+'product/deletePproduct/',product).success(function(){
				$scope.activePath = $location.path('/view-product');
				$route.reload();				
			});
          }
        };
  });
//Category Controller for CURD Operation
  myCustomApp.controller('addCategoryCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
		CustomServices.getRootCategory().then(function(data){
            $scope.rootCategoryList = data.data;
        });
		
        $scope.addCategory = function(category){
          $location.path('/add-category');
          CustomServices.insertCategory(category);
        };  
  });

  myCustomApp.controller('viewCategoryCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
      CustomServices.getCategory().then(function(data){
          $scope.categoryList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.categoryList.length; //Initially for no filter  
          $scope.totalItems = $scope.categoryList.length;
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
  myCustomApp.controller('editCategoryCtr', function ($scope, $http, $location, $routeParams) {
        var catID = $routeParams.catID;
        $scope.activePath = null;

        $http.get(BASE_URL+'product/getCategoryById/'+catID).success(function(data) {
          $scope.categoryData = data;
        });

        $http.get(BASE_URL+'product/getCategory').success(function(data) {
          $scope.categoryList = data;
        });

        $scope.update = function(product){
            $location.path('/view-category');
            $http.put(BASE_URL+'product/updateCategory/'+catID, product).success(function(data) {
              $scope.packageData = data;
              $scope.activePath = $location.path('/view-category');
            });
        };

        $scope.delete = function(product) {
          var deleteProduct = confirm('Are you absolutely sure you want to delete?');
          if (deleteProduct) {
            $http.delete(BASE_URL+'product/deleteCategory/'+catID);
            $scope.activePath = $location.path('/view-category');
          }
        };
  });
//Level Configuration controller getLevel
  myCustomApp.controller('viewLevelCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
      CustomServices.getLevel().then(function(data){
          $scope.levelList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.levelList.length; //Initially for no filter  
          $scope.totalItems = $scope.levelList.length;
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

myCustomApp.controller('addLevelCtr', function($scope, $rootScope, $location, $routeParams, CustomServices){
  $scope.addLevel = function(level){
    $location.path('/add-level');
    CustomServices.insertLevel(level);
    alert('Level added Successfully');
  }; 
});
myCustomApp.controller('editLevelCtr', function ($scope, $http, $location, $routeParams) {
        var levelID = $routeParams.levelID;
        $scope.activePath = null;

        $http.get(BASE_URL+'level/getLevelById/'+levelID).success(function(data) {
          $scope.levelData = data;
        });
        $scope.update = function(product){
            //$location.path('/view-level');
            $http.put(BASE_URL+'level/updateLevel/'+levelID, product).success(function(data) {
              if(data.message != null){
                var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
                $('#message').html(message);
                //alert('Success!');
              }else{
                $('#error_level_level_name').html(data.error_level_level_name);
                $('#error_level_bonus').html(data.error_level_bonus);
                $('#error_level_discount_percent').html(data.error_level_discount_percent);
                $('#error_exit_qv').html(data.error_exit_qv);
              }
            });
        };

        $scope.delete = function(product) {
          var deleteProduct = confirm('Are you absolutely sure you want to delete?');
          if (deleteProduct) {
            $http.delete(BASE_URL+'product/deleteLevel/'+levelID);
            $scope.activePath = $location.path('/view-level');
          }
        };
  });
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
        //$timeout(function() { 
         //   $scope.filteredItems = $scope.filtered.length;
       // }, 10);
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
  });

  myCustomApp.controller('viewEarningsByIdCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.userId;
    $scope.activePath = null;

      $http.get(BASE_URL +'earning/getleftBinary/'+ID).success(function(data){
        $scope.leftBinary = data;
      });
      $http.get(BASE_URL +'earning/getrightBinary/'+ID).success(function(data){
        $scope.rightBinary = data;
      });
      $http.get(BASE_URL +'earning/getReferralBonus/'+ID).success(function(data){
        $scope.referralBonus = data;
      });
      $http.get(BASE_URL +'earning/getProductBonus/'+ID).success(function(data){
        $scope.productBonus = data;
      });

	    $http.get(BASE_URL +'earning/getRewardBonus/'+ID).success(function(data){
        $scope.rewardBonus = data;
      });
      $http.get(BASE_URL +'earning/getCreditBonus/'+ID).success(function(data){
        $scope.creditBonus = data;
      });

      $http.get(BASE_URL +'earning/getDeductBonus/'+ID).success(function(data){
        $scope.deductBonus = data;
      });

      //get List Detals 
      $http.get(BASE_URL +'earning/getReferralBinaryList/'+ID).success(function(data){
        $scope.userBinaryList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.userBinaryList.length; //Initially for no filter  
        $scope.totalItems = $scope.userBinaryList.length;
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

      $http.get(BASE_URL +'earning/getRewardBonusList/'+ID).success(function(data){
        $scope.rewardBonusList = data;
        $scope.currentPage5 = 1; //current page
        $scope.entryLimit5 = 5; //max no of items to display in a page
        $scope.filteredItems5 = $scope.rewardBonusList.length; //Initially for no filter  
        $scope.totalItems5 = $scope.rewardBonusList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage5 = pageNo;
      };

      $scope.filter = function() {
      };

      $scope.sort_by = function(predicate) {
          $scope.predicate5 = predicate;
          $scope.reverse5 = !$scope.reverse;
      };

      $http.get(BASE_URL +'earning/getReferralBonusList/'+ID).success(function(data){
        $scope.referralBonusList = data;
        $scope.currentPage1 = 1; //current page
        $scope.entryLimit1 = 10; //max no of items to display in a page
        $scope.filteredItems1 = $scope.referralBonusList.length; //Initially for no filter  
        $scope.totalItems1 = $scope.referralBonusList.length;
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

      $http.get(BASE_URL +'earning/getProductBonusList/'+ID).success(function(data){
        $scope.productSaleBonusList = data;
        $scope.currentPage2 = 1; //current page
        $scope.entryLimit2 = 10; //max no of items to display in a page
        $scope.filteredItems2 = $scope.productSaleBonusList.length; //Initially for no filter  
        $scope.totalItems2 = $scope.productSaleBonusList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage2 = pageNo;
      };

      $scope.filter = function() {
      };

      $scope.sort_by = function(predicate) {
          $scope.predicate2 = predicate;
          $scope.reverse2 = !$scope.reverse;
      }; 

      $http.get(BASE_URL +'earning/getCreditBonusList/'+ID).success(function(data){
        $scope.creditBonusList = data;
        $scope.currentPage3 = 1; //current page
        $scope.entryLimit3 = 5; //max no of items to display in a page
        $scope.filteredItems3 = $scope.creditBonusList.length; //Initially for no filter  
        $scope.totalItems3 = $scope.creditBonusList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage3 = pageNo;
      };

      $scope.filter = function() {
      };

      $scope.sort_by = function(predicate) {
          $scope.predicate3 = predicate;
          $scope.reverse3 = !$scope.reverse;
      }; 

      $http.get(BASE_URL +'earning/getdeductBonusList/'+ID).success(function(data){
        $scope.deductBonusList = data;
        $scope.currentPage4 = 1; //current page
        $scope.entryLimit4 = 5; //max no of items to display in a page
        $scope.filteredItems4 = $scope.deductBonusList.length; //Initially for no filter  
        $scope.totalItems4 = $scope.deductBonusList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage4 = pageNo;
      };

      $scope.filter = function() {
      };

      $scope.sort_by = function(predicate) {
          $scope.predicate4 = predicate;
          $scope.reverse4 = !$scope.reverse;
      };

  });
//New platform controller
    myCustomApp.controller('newPlatformsViewCtr', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getPlatforms().then(function(data){
          $scope.cashoutList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
          $scope.totalItems = $scope.cashoutList.length;
      });  
      $scope.setPage = function(pageNo) {
          $scope.currentPage = pageNo;
      };

      $scope.filter = function() {
          //$timeout(function() { 
           //   $scope.filteredItems = $scope.filtered.length;
         // }, 10);
      };

      $scope.sort_by = function(predicate) {
          $scope.predicate = predicate;
          $scope.reverse = !$scope.reverse;
      }; 
  });

  myCustomApp.controller('addPlatformsCtr',[ '$scope', 'Upload','$location',  '$http','CustomServices', function ($scope,  $location,  $http, Upload, CustomServices) {
      
      CustomServices.getUserNames().success(function(data) {
          $scope.list = data;
      });
      
      $scope.addPlatformsss = function(files) {
          Upload.upload({
              url: BASE_URL+'admin/addPlatform',
              fields: {'user_id': $scope.user_id,
                        'platforms_name': $scope.platforms_name,
                        'platforms_url': $scope.platforms_url,
                      },
              file: files
          });
      };
  }]);

  myCustomApp.controller('addplatform', ['$scope',  'Upload','$location', function($scope,  Upload, $location) {     
    $scope.addPlatforms = function(files) {
        Upload.upload({
            url: BASE_URL+'admin/addPlatform',
            fields: {
                      'platforms_name': $scope.platforms_name,
                      'platforms_url': $scope.platforms_url,
					  'platforms_comment': $scope.platforms_comment,
                    },
            file: files
        }).success(function(data) {
              alert(data.message);
              $scope.activePath = $location.path('/platforms-list');
       });
    };
  }]);

  myCustomApp.controller('editplatform', ['$scope',  'Upload','$location', function($scope,  Upload, $location) {        
    $scope.editPlatforms = function(files) {
      Upload.upload({
        url: BASE_URL+'admin/editPlatform',
        fields: {'id': $scope.platforms.id,
             
              'platforms_name': $scope.platforms.platforms_name,
              'platforms_url': $scope.platforms.platforms_url,
            },
        file: files
      }).success(function(data) {
        alert(data.message);
        $scope.activePath = $location.path('/platforms-list');
       });
    };
  }]);

  myCustomApp.controller('platformsListCtr', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
    CustomServices.getPlatformsList().then(function(data){
        $scope.cashoutList = data.data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
        $scope.totalItems = $scope.cashoutList.length;
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


  myCustomApp.controller('editPlatformsCtr', function ($scope, $http, $location, $routeParams) {
    var productID = $routeParams.id;
    $scope.activePath = null;

    $http.get(BASE_URL+'admin/getPlatformsById/'+productID).success(function(data) {
      $scope.productData = data;
    });

    $http.get(BASE_URL+'admin/getUserName').success(function(data) {
      $scope.list = data;
    });
   
    $scope.update = function(platforms){
        $http.put(BASE_URL+'admin/updatePlatforms/'+productID, platforms).success(function() {
          
         $location.path('/platforms-list');
        });
    };

    $scope.delete = function(platforms) {
      var deleteProduct = confirm('Are you absolutely sure you want to delete?');
      if (deleteProduct) {
        $http.delete(BASE_URL+'admin/deletePlatforms/'+productID).success(function() {
        $location.path('/platforms-list');
        });
      }
    };
  });
  myCustomApp.controller('viewPlatformsImageCtr', function ($scope, $http, $location, $routeParams) {
    var Id = $routeParams.id;
    $http.get(BASE_URL+'admin/getPlatformsImageById/'+Id).success(function(data) {
      $scope.depositData = data;
    });    
    
	$scope.update = function(plat){
        $http.put(BASE_URL+'platform/updatePlatforms/'+Id, plat).success(function(data) {
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('.plat-message').html(message);
        });
    };
  });
//New Leads Controller

myCustomApp.controller('newLeadsViewCtr', function ($scope, $rootScope, $http, $location, $routeParams, CustomServices) {
      CustomServices.getLeads().then(function(data){
          $scope.cashoutList = data.data;
          $scope.currentPage = 1; 
          $scope.entryLimit = 10; 
          $scope.filteredItems = $scope.cashoutList.length; 
          $scope.totalItems = $scope.cashoutList.length;
      }); 
      $scope.update = function(dateRangeSearch){
        $scope.activePath = null;
        $http.put(BASE_URL +'admin/getLead', dateRangeSearch).success(function(data){
            $scope.cashoutList = data;
            $scope.currentPage = 1; 
            $scope.entryLimit = 20;
            $scope.filteredItems = $scope.cashoutList.length; 
            $scope.totalItems = $scope.cashoutList.length;
            $location.path('/new-leads-view');
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
  myCustomApp.controller('newLeadsViewCtr2', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getLeads().then(function(data){
          $scope.cashoutList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.cashoutList.length; //Initially for no filter  
          $scope.totalItems = $scope.cashoutList.length;
      });  
  });
//Get Deposit Controller
myCustomApp.controller('getApproveDepositCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'admin/getApproveDeposit').success(function(data){
        $scope.depositList = data;
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
  myCustomApp.controller('getDepositCtr2', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'admin/getDeposit').success(function(data){
        $scope.depositList = data;
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

  myCustomApp.controller('getDepositCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'admin/getDeposit').success(function(data){
        $scope.depositList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.depositList.length; //Initially for no filter  
        $scope.totalItems = $scope.depositList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'admin/getDeposit', dateRangeSearch).success(function(data){
          $scope.depositList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.depositList.length; //Initially for no filter  
          $scope.totalItems = $scope.depositList.length;
          $location.path('/deposit-view');
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
// Reward wallet settings
	myCustomApp.controller('viewRewardCtr', function($scope, $http, $location, $routeParams){

	});

// Get Deposit By id Controller 
	myCustomApp.controller('getDepositByIdCtr', function($scope, $http, $location, $routeParams){
	  var ID = $routeParams.d_id;
	  $scope.activePath = null;

	  $http.get(BASE_URL+'admin/getDepositImageById/'+ID).success(function(data) {
		  $scope.depositData = data;
	  });
	  
		$scope.update = function(user){
		  $http.put(BASE_URL+'admin/updateDepositStatus/'+ID,user).success(function(data) {
		   alert(data.message);
		   $location.path('/deposit-view');
		  });
		};

    $scope.reject = function(user){
      $http.put(BASE_URL+'deposit_ctr/rejectDepositStatus/'+ID,user).success(function(data) {
       alert(data.message);
       $location.path('/deposit-view');
      });
    };
    $scope.approvehold = function(user){
      var sure = confirm(user.amount+'  store credits will be credit to user.');
      if (sure) {
        $http.put(BASE_URL+'deposit_ctr/holdDepositStatus/'+ID,user).success(function(data) {
         alert(data.message);
         $location.path('/deposit-view');
        });
      }
    };
    $scope.approvereleas = function(user){
      var sure = confirm(user.amount+'  store credits will be credit to user.');
      if (sure) {
        $http.put(BASE_URL+'deposit_ctr/releaseDepositStatus/'+ID,user).success(function(data) {
         alert(data.message);
         $location.path('/deposit-view');
        });
      }
    };

	});
// View Leads Comments controller
	myCustomApp.controller('veiwLeadsCommentsCtr', function($scope, $http, $location, $routeParams){
		var ID = $routeParams.l_id;
		$scope.activePath = null;
    
		$http.get(BASE_URL+'admin/getLeadsCommentById/'+ID).success(function(data) {
			$scope.leadsData = data;
		});
		
		 $scope.leadsStatus = function(user){
			$http.put(BASE_URL+'admin/updateLeadsStatus/'+ID, user).success(function(data) {
			 alert(data.message);
			 $location.path('/new-leads-view');
			});
		};
	});
// Unilevel Search Controller 
 /*  myCustomApp.controller('unilevelSearchCtr', function($scope, $http, $route, $location, $routeParams){
      
      $http.get(BASE_URL+'admin/getUser').success(function(data) {
        $scope.userHolding = data;
      });
      $scope.unilevelSearch = function(unilevel){
        $http.post(BASE_URL+'tree/unilevelSearch',unilevel).success(function(data) {
            alert(data.message);
            $location.path('/unilevel-view');
            location.reload();  
        });
      };
  }); */
  
  //Orders Controllers
myCustomApp.controller('productOrderSummaryCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'admin/productOrderSummary').success(function(data){
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

 
  myCustomApp.controller('newProductOrderSummaryCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'admin/newProductOrderSummary').success(function(data){
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
	myCustomApp.controller('productOrderSummaryViewCtr', function($scope, $http, $location, $routeParams){
		var ID = $routeParams.id;
		
		
		$http.get(BASE_URL+'admin/productOrderSummaryView/'+ID).success(function(data) {
		  $scope.list = data;
		});

		$scope.orderStatus = function(user){
		  $http.put(BASE_URL+'admin/updateOrderStatus/', user).success(function(data) {
			alert(data.message);
		  });
		};
	});
//date piker for order status
	myCustomApp.controller('orderdateCtr', function($scope, $http){
		var $input = $( '.datepicker1' ).pickadate({
			formatSubmit: 'yyyy-mm-dd',
			format: 'yyyy-mm-dd',
			min: true,
			container: '#container1',
			closeOnSelect: true,
			today: '',
			clear: '',
			close: '',
			selectYears: 1,
		});
	});
	
	
  
	  myCustomApp.controller('memberReportCtr', function($scope, $http, $location, $routeParams){
		$http.get(BASE_URL + 'admin/getUserName').success(function(data){
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
			/* $timeout(function() { 
				$scope.filteredItems = $scope.filtered.length;
			}, 10); */
		};

		$scope.sort_by = function(predicate) {
			$scope.predicate = predicate;
			$scope.reverse = !$scope.reverse;
		}; 
	  });

	myCustomApp.controller('editMemberReportCtr', function ($scope, $http, $location, $routeParams) {
        var id = $routeParams.id;
        $scope.activePath = null;

        $http.get(BASE_URL+'admin/editReferrals/'+id).success(function(data) {
          $scope.users = data;
        });

        $scope.update = function(user){
           
            $http.put(BASE_URL+'admin/updateReferrals/'+id, user).success(function(data) {
              //$scope.users = data;
              alert(data.message);
              $location.path('/member-report');
            });
        };

        $scope.delete = function(user) {
          console.log(user);

          var deleteUser = confirm('Are you absolutely sure you want to delete?');
          if (deleteUser) {
            $http.delete(BASE_URL+'admin/deleteReferrals/'+id);
            $scope.activePath = $location.path('/');
          }
        };
	});

	
	
	myCustomApp.controller('rankMembersCtr', function($scope,$http){
    
    $http.get(BASE_URL + 'admin/getRankMembersList').success(function(data){
      $scope.rankMembersList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.rankMembersList.length; //Initially for no filter  
      $scope.totalItems = $scope.rankMembersList.length;
    });

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.filter = function() {
       /*  $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10); */
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
   });

  //Rank details controller
	myCustomApp.controller('viewRankDetailsCtr', function($scope, $http, $location, $routeParams){
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
	
	
	
	myCustomApp.controller('addCreditCtr', function ($scope, $http, $route, $location) {
        $scope.creditChange = function(user){
            $http.put(BASE_URL+'admin/addCreditUser', user).success(function() {
                alert('Credit Added successfully!');
                $route.reload();
            });
        };
        $http.get(BASE_URL + 'admin/getCreditList').success(function(data){
          $scope.getCreditList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.getCreditList.length; //Initially for no filter  
          $scope.totalItems = $scope.getCreditList.length;
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
	
	myCustomApp.controller('deleteCreditCtr', function ($scope, $http, $route, $location) {
        $scope.deleteEarnings = function(user){
            $http.put(BASE_URL+'admin/deleteCreditUser', user).success(function(data) {
                alert(data.message);
				        $route.reload();
            });
        };
        $http.get(BASE_URL + 'admin/deleteCreditList').success(function(data){
          $scope.deleteCreditList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.deleteCreditList.length; //Initially for no filter  
          $scope.totalItems = $scope.deleteCreditList.length;
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
	
  myCustomApp.controller('moduleMembersCtr', function($scope, $http, $location, $routeParams){
      $http.get(BASE_URL + 'entrepreneurial/getAllUsers').success(function(data){
        $scope.moduleMemberList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.moduleMemberList.length; //Initially for no filter  
        $scope.totalItems = $scope.moduleMemberList.length;
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

  myCustomApp.controller('moduleMembersDetailsCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.id;
      /*var $topLoader = $("#topLoader").percentageLoader({width: 256, height: 256, controllable : true, progress : 0.5, onProgressUpdate : function(val) {
        $topLoader.setValue(Math.round(val * 100.0));
      }});
      var topLoaderRunning = false;*/
      $http.get(BASE_URL + 'entrepreneurial/getModuleMemberDetails/'+ID).success(function(data){
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
  
  myCustomApp.controller('newUserUpgradeCtr', function($scope, $http, $location, $routeParams){
      $scope.activePath = null;

      $http.get(BASE_URL + 'upgrade/newUpgradeUserList').success(function(data){
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
//New Member List controller
  myCustomApp.controller('newMemberListCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'member/getNewMemberList').success(function(data){
      $scope.newMemberReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.newMemberReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.newMemberReportList.length;
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

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'member/getNewMemberList', dateRangeSearch).success(function(data){
          $scope.newMemberReportList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.newMemberReportList.length; //Initially for no filter  
          $scope.totalItems = $scope.newMemberReportList.length;
          $location.path('/new-member-report');
      });
    };
  });
  
  myCustomApp.controller('approveNewMemberStatusCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.uID;
      $http.get(BASE_URL + 'member/getNewMemberListByID/'+ID).success(function(data){
        $scope.approveNewMemberReportList = data;
      }); 

      $scope.update = function(user){
        $scope.activePath = null;
        $http.put(BASE_URL +'member/updataNewMemberStatus', user).success(function(data){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
            $('#suc-message').html(message);
            //$location.path('/new-member-report');
        });
      };
  });
  
  myCustomApp.controller('approveUpgradeStatusCtr', function($scope, $http, $location, $routeParams){
      var ID = $routeParams.uID;
      $http.get(BASE_URL + 'member/getUpgradeStatusByID/'+ID).success(function(data){
        $scope.approveNewMemberReportList = data;
      }); 

      $scope.update = function(user){
        $scope.activePath = null;
        $http.put(BASE_URL +'member/updateUpgradeStatus', user).success(function(data){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
            $('#suc-message').html(message);
            //$location.path('/new-member-report');
        });
      };
  });
  
  myCustomApp.controller('earningReportCtrl', function($scope, $http, $location, $routeParams){
     $http.get(BASE_URL + 'earningreport/getEarningReport').success(function(data){
      $scope.earningReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.earningReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.earningReportList.length;
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

  myCustomApp.controller('creditmxtopupCtr', function ($scope, $http,$route, $location) {        
  $scope.creditChange = function(user){            
   $http.put(BASE_URL+'wallet2/creditwallet', user).success(function(data) {                
    if(data.message != null){
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
     $('#message').html(message);
     $route.reload();     
    }else{
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
     $('#message').html(message);
     //$route.reload();
    }
   });        
  };        
  $http.get(BASE_URL + 'wallet2/getCreditwallet').success(function(data){          
   $scope.getCreditList = data;          
   $scope.currentPage = 1; //current page          
   $scope.entryLimit = 10; //max no of items to display in a page          
   $scope.filteredItems = $scope.getCreditList.length; //Initially for no filter            
   $scope.totalItems = $scope.getCreditList.length;        
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
 
myCustomApp.controller('deductmxtopupCtr', function ($scope, $http, $route, $location) {
  $scope.deleteEarnings = function(user){
          $http.put(BASE_URL+'wallet2/deductwallet', user).success(function(data) {
      if(data.message != null){
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
    $('#message').html(message);
    $route.reload();     
   }else{
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
    $('#message').html(message);
    //$route.reload();
   }
          });
      };

      $http.get(BASE_URL + 'wallet2/getDeletewallet').success(function(data){
        $scope.deleteCreditList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.deleteCreditList.length;  
        $scope.totalItems = $scope.deleteCreditList.length;
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
myCustomApp.controller('mxtopupReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'wallet2/walletReport').success(function(data){
      $scope.walletReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.walletReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.walletReportList.length;
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
myCustomApp.controller('mxtopupReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var ID = $routeParams.vuID;

     $http.get(BASE_URL + 'wallet2/walletReportByUser/'+ID).success(function(data){
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

myCustomApp.controller('creditrewardPointsCtr', function ($scope, $http,$route, $location) {        
  $scope.creditChange = function(user){            
   $http.put(BASE_URL+'reward_points/creditwallet', user).success(function(data) {                
    if(data.message != null){
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
     $('#message').html(message);
     $route.reload();     
    }else{
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
     $('#message').html(message);
     //$route.reload();
    }
   });        
  };        
  $http.get(BASE_URL + 'reward_points/getCreditwallet').success(function(data){          
   $scope.getCreditList = data;          
   $scope.currentPage = 1; //current page          
   $scope.entryLimit = 10; //max no of items to display in a page          
   $scope.filteredItems = $scope.getCreditList.length; //Initially for no filter            
   $scope.totalItems = $scope.getCreditList.length;        
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
 
myCustomApp.controller('deductrewardPointsCtr', function ($scope, $http, $route, $location) {
  $scope.deleteEarnings = function(user){
          $http.put(BASE_URL+'reward_points/deductwallet', user).success(function(data) {
      if(data.message != null){
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
    $('#message').html(message);
    $route.reload();     
   }else{
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
    $('#message').html(message);
    //$route.reload();
   }
          });
      };

      $http.get(BASE_URL + 'reward_points/getDeletewallet').success(function(data){
        $scope.deleteCreditList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.deleteCreditList.length;  
        $scope.totalItems = $scope.deleteCreditList.length;
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
myCustomApp.controller('rewardPointsReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'reward_points/walletReport').success(function(data){
      $scope.walletReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.walletReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.walletReportList.length;
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
myCustomApp.controller('rewardPointsReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var ID = $routeParams.vuID;

     $http.get(BASE_URL + 'reward_points/walletReportByUser/'+ID).success(function(data){
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

myCustomApp.controller('creditstoreCreditCtr', function ($scope, $http,$route, $location) {        
  $scope.creditChange = function(user){            
   $http.put(BASE_URL+'store_credit/creditwallet', user).success(function(data) {                
    if(data.message != null){
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
     $('#message').html(message);
	 alert(data.message);
     $route.reload();     
    }else{
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
     $('#message').html(message);
     //$route.reload();
    }
   });        
  };        
  $http.get(BASE_URL + 'store_credit/getCreditwallet').success(function(data){          
   $scope.getCreditList = data;          
   $scope.currentPage = 1; //current page          
   $scope.entryLimit = 10; //max no of items to display in a page          
   $scope.filteredItems = $scope.getCreditList.length; //Initially for no filter            
   $scope.totalItems = $scope.getCreditList.length;        
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
 
myCustomApp.controller('deductstoreCreditCtr', function ($scope, $http, $route, $location) {
  $scope.deleteEarnings = function(user){
          $http.put(BASE_URL+'store_credit/deductwallet', user).success(function(data) {
      if(data.message != null){
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
    $('#message').html(message);
	alert(data.message);
    $route.reload();     
   }else{
    var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
    $('#message').html(message);
    //$route.reload();
   }
          });
      };

      $http.get(BASE_URL + 'store_credit/getDeletewallet').success(function(data){
        $scope.deleteCreditList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.deleteCreditList.length;  
        $scope.totalItems = $scope.deleteCreditList.length;
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
myCustomApp.controller('storeCreditReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'store_credit/walletReport').success(function(data){
      $scope.walletReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.walletReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.walletReportList.length;
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
myCustomApp.controller('storeCreditReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var ID = $routeParams.vuID;

     $http.get(BASE_URL + 'store_credit/walletReportByUser/'+ID).success(function(data){
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

myCustomApp.controller('activationPlatformReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.ID;

    $http.get(BASE_URL + 'activate_platform/activatePlatformReportByUser/'+Id).success(function(data){
        $scope.walletReportListByUser = data;
    });

    $scope.reject = function(user){
		$scope.activePath = null;
		$http.put(BASE_URL+'activate_platform/rejectSimStatus/'+Id,user).success(function(data) {
			alert(data.message);
			$location.path('/activation-platform-report');
		});
    };

    $scope.approve = function(){
		$scope.activePath = null;
		$http.put(BASE_URL+'activate_platform/approveSimStatus/'+Id).success(function(data) {
			alert(data.message);
			$location.path('/activation-platform-report');
		});
    };
});

myCustomApp.controller('activationPlatformReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'activate_platform/activatePlatformReport').success(function(data){
      $scope.walletReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.walletReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.walletReportList.length;
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
myCustomApp.controller('entrepreneurialBonusReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'entrepreneurialReport/entrepreneurialBonus').success(function(data){
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

    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    };
});

myCustomApp.controller('entrepreneurialBonusReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
    var Id = $routeParams.ID;

    $http.get(BASE_URL + 'entrepreneurialReport/getEntrepreneurialReport/'+Id).success(function(data){
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

    $http.get(BASE_URL + 'entrepreneurialReport/entrepreneurialTeamMember/'+Id).success(function(data){
      $scope.memberReportList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.memberReportList.length; //Initially for no filter  
      $scope.totalItems = $scope.memberReportList.length;
    });

    $scope.setPage2 = function(pageNo) {
      $scope.currentPage = pageNo;
    };

    $scope.filter2 = function() {
      
    };

    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    };
});
  
  myCustomApp.controller('marketingMaterialsCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', '$route', function($scope, $http, Upload, $location, $routeParams, $route){
      
      $http.get(BASE_URL +'tools/getVideosCategory2').success(function(data){
        $scope.vediosCategoryList = data;
      });
      

      

      $scope.uploadVideo = function (files) {
          Upload.upload({
            url: BASE_URL+'tools/addVideosTutorials2',
            fields: {
                    'category_name':$scope.category_name,
                    'country': $scope.country,
                    'video_message': $scope.video_message,
                  },
            file: files
        }).success(function(data) {
            if(data.sucess != null){
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
              $('#message').html(message);
              //$route.reload();          
            }else{
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
              $('#message').html(message);
              //$route.reload();
            }
       });
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

      $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'tools/deleteMarketingMaterials', user).success(function(){         
            $route.reload();
        });
      }
    };



  }]);

  myCustomApp.controller('addMarketingMaterialsCtr', function($scope, $route, $http, $location, $routeParams){
    $http.get(BASE_URL +'tools/getVideosCategory2').success(function(data){
      $scope.vediosCategoryList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.vediosCategoryList.length; //Initially for no filter  
      $scope.totalItems = $scope.vediosCategoryList.length;
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

     $http.get(BASE_URL+'tools/getMMCategoryParentID').success(function(data) {
      $scope.htmlTVCategoryParentID = data;
    });

    $scope.addCategory = function(videos){
      $http.post(BASE_URL + 'tools/addVideosCategory2',videos).success(function(data){
        if(data.sucess != null){
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
          $('#message').html(message);
          alert(data.sucess);
          $route.reload();          
        }else{
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
          $('#message').html(message);
          //$route.reload();
        }
      });
    };
  });

  myCustomApp.controller('trainingVideosCtr', ['$scope', '$http', 'Upload', '$location', '$routeParams', '$route', function($scope, $http, Upload, $location, $routeParams, $route){
      
      $http.get(BASE_URL +'tools/getVideosCategory').success(function(data){
        $scope.vediosCategoryList = data;
      });

      $scope.uploadUrl = function(user){
          $http.put(BASE_URL+'tools/addVideosUrlTutorials', user).success(function(data) {
              if(data.sucess != null){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
            $('#message').html(message);
            //$route.reload();     
           }else{
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
            $('#message').html(message);
            //$route.reload();
           }
          });
      };
	  
	  $scope.uploadVideofield = function (user) {
        
        $http.put(BASE_URL+'tools/addVideosUrlTutorialsfield', user).success(function(data) {
            if(data.sucess != null){
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
              $('#message').html(message);
                     
            }else{
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
              $('#message').html(message);
             
            }
        });
      };

      $scope.uploadVideo = function (files) {
          Upload.upload({
            url: BASE_URL+'tools/addVideosTutorials',
            fields: {
                    'category_name':$scope.category_name,
                    'country': $scope.country,
                    'video_message': $scope.video_message,
                  },
            file: files
        }).success(function(data) {
            if(data.sucess != null){
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
              $('#message').html(message);
              //$route.reload();          
            }else{
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
              $('#message').html(message);
              //$route.reload();
            }
       });
      };
  }]);

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

      $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'tools/deleteTrainingVideos', user).success(function(){         
            $route.reload();
        });
      }
    };


    
  }]);

  myCustomApp.controller('addTrainingVideosCtr', function($scope, $route, $http, $location, $routeParams){
    $http.get(BASE_URL +'tools/getVideosCategory').success(function(data){
      $scope.vediosCategoryList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.vediosCategoryList.length; //Initially for no filter  
      $scope.totalItems = $scope.vediosCategoryList.length;
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

    $http.get(BASE_URL+'tools/getTVCategoryParentID').success(function(data) {
      $scope.htmlTVCategoryParentID = data;
    });

    $scope.addCategory = function(videos){
      $http.post(BASE_URL + 'tools/addVideosCategory',videos).success(function(data){
        if(data.sucess != null){
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
          $('#message').html(message);
          alert(data.sucess);
          $route.reload();          
        }else{
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
          $('#message').html(message);
          //$route.reload();
        }
      });
    };
  });
myCustomApp.controller('editCategoryTrainingVideosCtr', function ($scope, $http, $location, $routeParams) {
        var catID = $routeParams.catID;
        $scope.activePath = null;

        $http.get(BASE_URL+'tools/getTrainingVideosCategoryById/'+catID).success(function(data) {
          $scope.categoryData = data;
        });

        $http.get(BASE_URL+'tools/getTrainingVideosCategory').success(function(data) {
          $scope.categoryList = data;
        });

        $scope.update = function(tools){
            
            $http.put(BASE_URL+'tools/updateTrainingVideosCategory/'+catID, tools).success(function(data) {
              $scope.packageData = data;
              $scope.activePath = $location.path('/add-category-training-videos');
            });
        };

        $scope.delete = function(tools) {
          var deleteProduct = confirm('Are you absolutely sure you want to delete?');
          if (deleteProduct) {
            $http.delete(BASE_URL+'tools/deleteTrainingVideosCategory/'+catID);
            $scope.activePath = $location.path('/add-category-training-videos');
          }
        };
  });
myCustomApp.controller('editCategoryMarketingMaterialsCtr', function ($scope, $http, $location, $routeParams) {
        var catID = $routeParams.catID;
        $scope.activePath = null;

        $http.get(BASE_URL+'tools/getMarketingMaterialsCategoryById/'+catID).success(function(data) {
          $scope.categoryData = data;
        });

        $http.get(BASE_URL+'tools/getMarketingMaterialsCategory').success(function(data) {
          $scope.categoryList = data;
        });

        $scope.update = function(tools){
           
            $http.put(BASE_URL+'tools/updateMarketingMaterialsCategory/'+catID, tools).success(function(data) {
              $scope.packageData = data;
              $scope.activePath = $location.path('/add-category-marketing-materials');
            });
        };

        $scope.delete = function(tools) {
          var deleteProduct = confirm('Are you absolutely sure you want to delete?');
          if (deleteProduct) {
            $http.delete(BASE_URL+'tools/deleteMarketingMaterialsCategory/'+catID);
            $scope.activePath = $location.path('/add-category-marketing-materials');
          }
        };
  });
  
  myCustomApp.controller('failmemberReportCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'member/getFailMemberReport').success(function(data){
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
      /* $timeout(function() { 
        $scope.filteredItems = $scope.filtered.length;
      }, 10); */
    };

    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    }; 
});

myCustomApp.controller('viewfailmemberReportCtr', function ($scope, $http, $location, $routeParams) {
        var id = $routeParams.id;
       

        $http.get(BASE_URL+'member/viewFailMemberReport/'+id).success(function(data) {
          $scope.users = data;
        });

        $scope.update = function(){
           
            $http.put(BASE_URL+'member/updateFailMember/'+id).success(function(data) {
            
              alert(data.message);
           
            });
        };
  });
  
  myCustomApp.controller('viewPackageDescriptionCtrl', function ($scope, $rootScope, $location, $routeParams, CustomServices) {
      CustomServices.getPackage().then(function(data){
          $scope.pkgList = data.data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.pkgList.length; //Initially for no filter  
          $scope.totalItems = $scope.pkgList.length;
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

  myCustomApp.controller('packageEditDescriptionCtr', function ($scope, $http, $route, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;

      $http.get(BASE_URL+'product/getPackageDescriptionById/'+pkgid).success(function(data) {
        $scope.packageData = data;
      });

      $scope.add = function(pkg){
          $http.put(BASE_URL+'product/addPackageDescription/'+pkgid, pkg).success(function() {
               $route.reload();
          });
      };

      $scope.update = function(pkg){
          $http.put(BASE_URL+'product/updatePackageDescription/'+pkgid, pkg).success(function() {
               $route.reload();
          });
      };

      $scope.delete = function(pkg) {
          $http.put(BASE_URL+'product/deletePackageDescription/'+pkgid, pkg).success(function() {
                 $route.reload();
          });
      };
  });
  myCustomApp.controller('importArbSuscriptionCtr', [ '$scope', '$route', '$http', '$routeParams', 'Upload',function($scope, $route, $http, $routeParams, Upload){
      $scope.csvUpload = function (files) {
          Upload.upload({
            url: BASE_URL+'csv/importcsv',
            file: files
        }).success(function(data) {
            if(data.sucess != null){
                var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
                $('#csv-msg').html(message);
            }else{
                var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
                $('#csv-msg').html(message);
            }
       });
      };
  }]);
  
  myCustomApp.controller('newEventRegistrationListCtr', function($scope, $route, $http, $location, $routeParams){
      $http.get(BASE_URL+'addEvent/eventRegistrationList').success(function(data){
          $scope.newEventRegistrationList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.newEventRegistrationList.length; //Initially for no filter  
          $scope.totalItems = $scope.newEventRegistrationList.length;
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
	  
	  $scope.delete = function(eventId){
		var eventStatus = confirm('Are you sure you want to cancel this registration ?');
		if(eventStatus){
			$http.post(BASE_URL +'addEvent/deleteEvent/'+eventId).success(function(data){
				 $route.reload();
				alert(data.sucess);
			});
		}
	  };
  });

myCustomApp.controller('activationOlVoucherCtrl', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'activate_platform/activatePlatformVoucher').success(function(data){
      $scope.VoucherList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.VoucherList.length; //Initially for no filter  
      $scope.totalItems = $scope.VoucherList.length;
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
 myCustomApp.controller('activationVoucherViewCtrl', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.ID;

     $http.get(BASE_URL + 'activate_platform/activateVoucherView/'+Id).success(function(data){
        $scope.voucherViewList = data;
      });

     $scope.reject = function(){
     $http.put(BASE_URL+'activate_platform/rejectVoucherStatus/'+Id).success(function(data) {
       alert(data.message);
      
     });
    };

    $scope.approve = function(data){
     $http.put(BASE_URL+'activate_platform/approveVoucherStatus/'+Id,data).success(function(data) {
       alert(data.message);
      
      });
    };
});

myCustomApp.controller('requestedVoucherCtrl', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'activate_platform/requestedVoucher').success(function(data){
      $scope.requestedVoucherList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.requestedVoucherList.length; 
      $scope.totalItems = $scope.requestedVoucherList.length;
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
myCustomApp.controller('requestedVoucherViewCtrl', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.ID;

     $http.get(BASE_URL + 'activate_platform/requestedVoucherViewById/'+Id).success(function(data){
        $scope.requestedViewList = data;
      });

     $scope.addsubmit = function(user){
      $http.put(BASE_URL+'update_address_ctr/updateSimShippingAddress', user).success(function(data) {
      alert(data.message);
      $route.reload();
      });
    };

  
    $scope.orderStatus = function(data){
      $http.put(BASE_URL+'activate_platform/updateOrderStatus/'+Id, data).success(function(data) {
      alert(data.message);
      $location.path('/requested-voucher-shipping');
      });
    };

    $scope.uspsid = function(user){
      var statemodifide;
      var statestaet =user.s_state;
      statemodifide =statestaet.toUpperCase();
      statestaet =statestaet.toUpperCase();
      switch (statestaet) {
          case 'ALABAMA':
              statemodifide = "AL";
              break;
          case 'ALASKA':
              statemodifide = "AK";
              break;
          case 'AMERICAN SAMOA':
              statemodifide = "AS";
              break;
          case 'ARIZONA':
              statemodifide = "AZ";
              break;
          case 'ARKANSAS':
              statemodifide = "AR";
              break;
          case 'ARMED FORCES AMERICAS':
              statemodifide = "AA";
              break;
          case 'ARMED FORCES EUROPE':
              statemodifide = "AE";
              break;
          case 'ARMED FORCES PACIFIC':
              statemodifide = "AP";
              break;
          case 'CALIFORNIA':
              statemodifide = "CA";
              break;
          case 'COLORADO':
              statemodifide = "CO";
              break;
          case 'CONNECTICUT':
              statemodifide = "CT";
              break;
          case 'DELAWARE':
              statemodifide = "DE";
              break;
          case 'DISTRICT OF COLUMBIA':
              statemodifide = "DC";
              break; 
          case 'FEDERATED STATES OF MICRONESIA':
              statemodifide = "FM";
              break;
          case 'FLORIDA':
              statemodifide = "FL";
              break;
          case 'GEORGIA':
              statemodifide = "GA";
              break;

          case 'GUAM':
              statemodifide = "GU";
              break;  

          case 'HAWAII':
              statemodifide = "HI";
              break;
          case 'IDAHO':
              statemodifide = "ID";
              break;

          case 'ILLINOIS':
              statemodifide = "IL";
              break;  

          case 'INDIANA':
              statemodifide = "IN";
              break;
          case 'IOWA':
              statemodifide = "IA";
              break;

          case 'KANSAS':
              statemodifide = "KS";
              break;  

          case 'KENTUCKY':
              statemodifide = "KY";
              break;
          case 'LOUISIANA':
              statemodifide = "LA";
              break;

          case 'MAINE':
              statemodifide = "ME";
              break;  

          case 'MARSHALL ISLANDS':
              statemodifide = "MH";
              break;
          case 'MARYLAND':
              statemodifide = "MD";
              break;

          case 'MASSACHUSETTS':
              statemodifide = "MA";
              break;  

          case 'MICHIGAN':
              statemodifide = "MI";
              break;
          case 'MINNESOTA':
              statemodifide = "MN";
              break;

          case 'MISSISSIPPI':
              statemodifide = "MS";
              break;  

          case 'MISSOURI':
              statemodifide = "MO";
              break;  
          case 'MONTANA':
              statemodifide = "MT";
              break;

          case 'NEBRASKA':
              statemodifide = "NE";
              break;  

          case 'NEVADA':
              statemodifide = "NV";
              break; 
          case 'NEW HAMPSHIRE':
              statemodifide = "NH";
              break;

          case 'NEW JERSEY':
              statemodifide = "NJ";
              break;  

          case 'NEW MEXICO':
              statemodifide = "NM";
              break; 
          case 'NEW YORK':
              statemodifide = "NY";
              break;

          case 'NORTH CAROLINA':
              statemodifide = "NC";
              break;  

          case 'NORTH DAKOTA':
              statemodifide = "ND";
              break; 
          case 'NORTHERN MARIANA ISLANDS':
              statemodifide = "MP";
              break;

          case 'OHIO':
              statemodifide = "OH";
              break;  

          case 'OKLAHOMA':
              statemodifide = "OK";
              break; 
          case 'OREGON':
              statemodifide = "OR";
              break;  

          case 'PALAU':
              statemodifide = "PW";
              break; 
          case 'PENNSYLVANIA':
              statemodifide = "PA";
              break;  

          case 'PUERTO RICO':
              statemodifide = "PR";
              break; 
          case 'RHODE ISLAND':
              statemodifide = "RI";
              break;  

          case 'SOUTH CAROLINA':
              statemodifide = "SC";
              break; 
          case 'SOUTH DAKOTA':
              statemodifide = "SD";
              break;  

          case 'TENNESSEE':
              statemodifide = "TN";
              break; 

          case 'TEXAS':
              statemodifide = "TX";
              break; 
          case 'UTAH':
              statemodifide = "UT";
              break; 

          case 'VERMONT':
              statemodifide = "VT";
              break; 
          case 'VIRGINIA':
              statemodifide = "VA";
              break; 

          case 'VIRGIN ISLANDS':
              statemodifide = "VI";
              break; 
          case 'WASHINGTON':
              statemodifide = "WA";
              break; 

          case 'WEST VIRGINIA':
              statemodifide = "WV";
              break; 
          case 'WISCONSIN':
              statemodifide = "WI";
              break; 
          case 'WYOMING':
              statemodifide = "WY";
              break; 

      };
      var servicetype = 'PRIORITY';
      //single sim  stander.....
      //if(user.p_id == 98 && user.p_qty == 1){
      //  servicetype = 'FIRST CLASS';
      //}

     // var servicetype = 'PRIORITY';
      //single sim  stander.....
     // if(user.p_id == 98 && user.p_qty == 1){
       // servicetype = 'FIRST CLASS';
      //}

       servicetype = user.shipping_method;
      //single sim  stander.....
      if(servicetype == ''){
        servicetype = 'FIRST CLASS';
      }


      var weight = 3;
        $http({
            method  : 'GET',
            url     : 'https://secure.shippingapis.com/ShippingAPI.dll?API=DeliveryConfirmationV4&XML=<DeliveryConfirmationV4.0Request USERID="892ONLEG1078"><FromName>Shipping Department</FromName><FromFirm>Onlegacy Network</FromFirm><FromAddress1>1231 8TH ST</FromAddress1><FromAddress2>STE 300</FromAddress2><FromCity>MODESTO</FromCity><FromState>CA</FromState><FromZip5>95354</FromZip5><FromZip4>2235</FromZip4><ToName>'+user.first_name+' '+user.last_name+'</ToName><ToFirm></ToFirm><ToAddress1>'+user.s_address1+'</ToAddress1><ToAddress2>'+user.s_address1+'</ToAddress2><ToCity>'+user.s_city+'</ToCity><ToState>'+statemodifide+'</ToState><ToZip5>'+user.s_zip+'</ToZip5><ToZip4/><WeightInOunces>'+weight+'</WeightInOunces><ServiceType>'+servicetype+'</ServiceType><SeparateReceiptPage>False</SeparateReceiptPage><ImageType>PDF</ImageType></DeliveryConfirmationV4.0Request>',
            //timeout : 10000,
            params  : {},  // Query Parameters (GET)
            transformResponse : function(data) {
                return $.parseXML(data);
            }
        }).success(function(data, status, headers, config) {
            console.dir(data); 
              $scope.pdflavel = 'y';
              str = user.first_name+' '+user.last_name;
              $scope.checkerror =str.toUpperCase();
            //$scope.xml = data.documentElement.innerHTML;
             var y = data.documentElement.childNodes.item(0).innerHTML;
             $scope.result2 = y;
             //user.tracking_id = y ;
             var z = data.documentElement.childNodes.item(1).innerHTML;
             $scope.imageaa = z;

             var e = data.documentElement.childNodes.item(2).innerHTML;
             $scope.errorrer = e;


             user.shipping_status = 'shipped';
             user.shipping_via = 'USPS';
             
             var res = y.substring(8);
             user.shipping_id = res;
             var today = new Date();
             user.shipping_date = today.toISOString().substring(0, 10);
             

        });
    };
});

myCustomApp.controller('cashoutInfoApproveCtr', function ($scope, $http, $location, $routeParams, $route) {
      var ID = $routeParams.id;
      $scope.activePath = null;

      $http.get(BASE_URL+'cashout/getCashoutInfoById/'+ID).success(function(data) {
        $scope.cashoutInfoData = data;
      });

      $http.get(BASE_URL + 'cashout/cashoutAmountFuncApprove/'+ID).success(function(data){
        $scope.cashoutAmountList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.cashoutAmountList.length; //Initially for no filter  
        $scope.totalItems = $scope.cashoutAmountList.length;
      });

      $scope.setPage = function(pageNo) {
          $scope.currentPage = pageNo;
      };

      $scope.filter = function() {
          
      };
    
      $scope.update = function(user){
        $http.put(BASE_URL+'cashout/updateAmountStatus',user).success(function(data) {
         alert(data.message);
         $route.reload();
        });
      };  

 
      $scope.rejectId = function(cid){
        $http.put(BASE_URL+'cashout/rejCashList/'+cid).success(function(data) {
          $scope.rejCashList = data;
        });
      };

      $scope.reject = function(user){
        $http.put(BASE_URL+'cashout/rejectAmountStatus', user).success(function(data) {
         alert(data.message);
         $route.reload();
        });
      };        
  });

myCustomApp.controller('rankMembersNewCtr', function($scope,$http){
    
    $http.get(BASE_URL + 'admin/getRankMembersNewList').success(function(data){
      $scope.rankMembersList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.rankMembersList.length; //Initially for no filter  
      $scope.totalItems = $scope.rankMembersList.length;
    });

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.filter = function() {
       /*  $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10); */
    };

    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    }; 
});

myCustomApp.controller('admindownlineUserRankCtr',function($scope, $http, $location, $routeParams){
  var ID = $routeParams.id;
    $http.get(BASE_URL + 'rank/getDownlineForAdminList/'+ID).success(function(data){
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


myCustomApp.controller('successTeamCtr', function($scope, $http, $location, $routeParams, CustomServices){
  $http.get(BASE_URL+'user/getUserSB').success(function(data) {
    $scope.userList = data;
  });

  $scope.boardlevelSearch = function(boardlevel){
    $http.post(BASE_URL+'user/boardlevelSearch',boardlevel).success(function(data) {
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


myCustomApp.controller('pendingBalanceCtr', function($scope, $http, $location, $routeParams){
        $http.get(BASE_URL + 'pending_balance/admingetPendingBalance').success(function(data){
          $scope.earningReportList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.earningReportList.length; //Initially for no filter  
          $scope.totalItems = $scope.earningReportList.length;
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

myCustomApp.controller('pendingBalanceByUserCtr', function($scope, $route, $http, $location, $routeParams){
    var id = $routeParams.id;
       $scope.releasePendingBalanceByUser = function(){
          
          var confirmBalance1 = confirm('Are you sure you want to release Pending Balance?');
          if (confirmBalance1) { 
            wsloader(true);
          $http.get(BASE_URL+ 'pending_balance/releasePendingBalanceByUser/'+id).success(function(data){
            wsloader(false);
            $route.reload();
          });
         }
       };
       $http.get(BASE_URL + 'pending_balance/admingetEarningReportByUserApproved/'+id).success(function(data){
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


myCustomApp.controller('addEtherValueCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL+'ether_value').success(function(data) {
      $scope.etherValueList = data;
    });

    $scope.addEtherValue = function(user){
        $http.post(BASE_URL+ 'ether_value/addEtherValueForAdmin',user).success(function(data) {
            alert(data.message);
             $route.reload();
        });
    };
});


myCustomApp.controller('etherConversionRateCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL+'ether_conversion_rate').success(function(data){
        $scope.ether_rate = data.ether_rate;
        $scope.conversion_charge = data.conversion_charge;
        $scope.etherConversionRateSttings = data;
    });

    $scope.update = function(user){
        $http.post(BASE_URL+ 'ether_conversion_rate/addEtherConversionRate',user).success(function(data) {
            alert(data.message);
             $route.reload();
        });
    };
});


myCustomApp.controller('etherCreditStoreCtr', function ($scope, $http,$route, $location) {        
  $scope.creditChange = function(user){            
   $http.put(BASE_URL+'ether_credit_store_for_user/creditToEtherwallet', user).success(function(data) {                
    if(data.message != null){
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
     $('#message').html(message);
   alert(data.message);
     $route.reload();     
    }else{
     var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
     $('#message').html(message);
     //$route.reload();
    }
   });        
  };        
  $http.get(BASE_URL + 'ether_credit_store_for_user/getEtherCreditwallet').success(function(data){          
   $scope.getEtherCreditList = data;          
   $scope.currentPage = 1; //current page          
   $scope.entryLimit = 10; //max no of items to display in a page          
   $scope.filteredItems = $scope.getEtherCreditList.length; //Initially for no filter            
   $scope.totalItems = $scope.getEtherCreditList.length;        
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
 

myCustomApp.controller('etherDeductStoreCtr', function ($scope, $http, $route, $location) {
	$scope.deleteEarnings = function(user){
		$http.put(BASE_URL+'ether_credit_store_for_user/deductFromEtherwallet', user).success(function(data) {
			if(data.message != null){
				var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
				$('#message').html(message);
				//alert(data.message);
				//$route.reload();     
			}else{
				var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.error+'</strong></div>';
				$('#message').html(message);
				//$route.reload();
			}
		});
	};

	$http.get(BASE_URL + 'ether_credit_store_for_user/getEtherDeductwallet').success(function(data){
        $scope.getEtherDeductList = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 10; 
        $scope.filteredItems = $scope.getEtherDeductList.length;  
        $scope.totalItems = $scope.getEtherDeductList.length;
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

myCustomApp.controller('pendingBalanceReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'pendingEarningReport/getPendingBalanceReport').success(function(data){
      $scope.getPendingBalanceReportList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.getPendingBalanceReportList.length;  
      $scope.totalItems = $scope.getPendingBalanceReportList.length;
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

    $scope.exportPendingBalanceReportList =function(){
        location.reload(BASE_URL + 'pendingEarningReport/export');
      // $http.get(BASE_URL + 'pendingEarningReport/export').success(function(data){
      // });
    };
});

myCustomApp.controller('etherWalletReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'ether/getEtherWalletReport').success(function(data){
      $scope.getEtherWalletReportList = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.getEtherWalletReportList.length;  
      $scope.totalItems = $scope.getEtherWalletReportList.length;
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
        location.reload(BASE_URL + 'eather/export');
      // $http.get(BASE_URL + 'pendingEarningReport/export').success(function(data){
      // });
    };
});

myCustomApp.controller('etherReportCtr', function($scope, $http, $route, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'etherReport/getEtherWalletReport').success(function(data){
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

    .when('/pending-report-by-user/:id',{
        templateUrl:'application/views/admin/pending-report-by-user.html',
        controller: 'pendingBalanceByUserCtr'
    })
    .when('/pending-balance',{
        templateUrl:'application/views/admin/pending-balance.html',
        controller: 'pendingBalanceCtr'
    })

    .when('/success-team', {
        templateUrl: 'application/views/success-team.html',
        controller: 'successTeamCtr'
    })


    .when('/downline-user-rank/:id',{
          templateUrl: 'application/views/admin/downline-user-rank.html',
          controller: 'admindownlineUserRankCtr'
    })

    .when('/rank-members-new',{
        templateUrl: 'application/views/admin/rank-members.html',
        controller:'rankMembersNewCtr'
    })

    .when('/cashout-info-approve/:id',{
        templateUrl:'application/views/admin/cashout-info-approve.html',
        controller:'cashoutInfoApproveCtr'
      })
	
	.when('/requested-voucher-shipping',{    
      templateUrl: 'application/views/admin/requested-voucher-shipping.html',   
      controller: 'requestedVoucherCtrl'  
     }) 
    .when('/requested-voucher-shipping-view/:ID',{    
      templateUrl: 'application/views/admin/requested-voucher-shipping-view.html',    
      controller: 'requestedVoucherViewCtrl'  
     })

    .when('/activation-ol-voucher',{    
      templateUrl: 'application/views/admin/activation-ol-voucher.html',   
      controller: 'activationOlVoucherCtrl'  
     }) 
    .when('/activation-ol-voucher-view/:ID',{    
      templateUrl: 'application/views/admin/activation-ol-voucher-view.html',    
      controller: 'activationVoucherViewCtrl'  
     })


      .when('/board-view', {
        templateUrl: 'application/views/admin/board-view.html',
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
      .when('/add-package',{
        templateUrl:'application/views/admin/add-package.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }]
        },
		controller : 'addPckageCtrl'
      })
      .when('/view-package',{
        templateUrl:'application/views/admin/view-package.html',
        controller:'viewPackageCtrl'
      })
      .when('/edit-package/:packageID',{
        templateUrl:'application/views/admin/edit-package.html',
        controller:'packageEditCtr'
      })
      .when('/profile',{
        templateUrl:'application/views/admin/profile.html',
        controller:'profileCtr'
      })
      .when('/edit-profile',{
        templateUrl:'application/views/admin/edit-profile.html',
        controller:'profileCtr'
      })
      .when('/change-password',{
        templateUrl:'application/views/admin/change-password.html',
        controller:'passwordCtr'
      })
      .when('/member-management',{
        templateUrl:'application/views/admin/member-management.html',
        controller:'passwordCtr'
      })
      .when('/add-voucher',{
        templateUrl:'application/views/admin/add-voucher.html',
        controller:'addVoucherCtr'
      })
      .when('/holding-tank',{
        templateUrl:'application/views/admin/holding-tank.html',
        controller:'holdingTankCtr'
      })
      .when('/view-voucher',{
        templateUrl:'application/views/admin/view-voucher.html',
        controller:'viewVoucherCtr'
      })
      .when('/cashout',{
        templateUrl:'application/views/admin/cashout.html',
        controller:'cashoutCtr'
      })
	   .when('/approve-cashout-view',{
        templateUrl:'application/views/admin/approve-cashout-view.html',
        controller:'approveCashoutCtr'
      })
	  .when('/cashout-info/:id',{
        templateUrl:'application/views/admin/cashout-info.html',
        controller:'cashoutInfoCtr'
      })
      .when('/add-product',{
        templateUrl:'application/views/admin/add-product.html',
        controller:'addProductCtr'
      })
      .when('/view-product',{
        templateUrl:'application/views/admin/view-product.html',
        controller:'viewProductCtr'
      })
      .when('/edit-product/:pID',{
        templateUrl:'application/views/admin/edit-product.html',
        controller:'editProductCtr'
      })
      .when('/add-category',{
        templateUrl:'application/views/admin/add-category.html',
        controller:'addCategoryCtr'
      })
      .when('/view-category',{
        templateUrl:'application/views/admin/view-category.html',
        controller:'viewCategoryCtr'
      })
      .when('/edit-category/:catID',{
        templateUrl:'application/views/admin/edit-category.html',
        controller: 'editCategoryCtr'
      })
      .when('/add-level',{
        templateUrl:'application/views/admin/add-level.html',
        controller: 'addLevelCtr'
      })
      .when('/view-level',{
        templateUrl:'application/views/admin/view-level.html',
        controller: 'viewLevelCtr'
      })
      .when('/edit-level/:levelID',{
        templateUrl:'application/views/admin/edit-level.html',
        controller: 'editLevelCtr'
      })
      .when('/earnings',{
        templateUrl:'application/views/admin/earnings.html',
        controller: 'viewEarningsCtr'
      })
      .when('/view-earning-details/:userId',{
        templateUrl: 'application/views/admin/view-earning-details.html',
        controller: 'viewEarningsByIdCtr'
      })
	  .when('view-user-earning-details/:ID',{
		  templateUrl: 'application/views/admin/view-user-earning-details.html',
		  //controller: ''
	  })
      .when('/reward-wallet',{
        templateUrl:'application/views/admin/reward-wallet.html',
        controller: 'viewRewardCtr'
      })
      .when('/new-platforms-view', {
        templateUrl: 'application/views/admin/new-platforms-view.html',
        controller: 'newPlatformsViewCtr'
      })
	  .when('/add-platforms', {
        templateUrl: 'application/views/admin/add-platforms.html',
        controller: 'addPlatformsCtr'
      })
       .when('/platforms-list', {
        templateUrl: 'application/views/admin/platforms-list.html',
        controller: 'platformsListCtr'
      })
       .when('/edit-platforms/:id',{
        templateUrl:'application/views/admin/edit-platforms.html',
        controller:'editPlatformsCtr'
      })
      .when('/new-leads-view', {
        templateUrl: 'application/views/admin/new-leads-view.html',
        controller: 'newLeadsViewCtr'
      })
      .when('/map', {
        templateUrl: 'application/views/map.html',
        //controller: 'newLeadsViewCtr'
      })
       .when('/rank-members',{
        templateUrl: 'application/views/admin/rank-members.html',
        controller:'rankMembersCtr'
      })
      .when('/rank-members-details/:id',{
        templateUrl: 'application/views/admin/rank-members-details.html',
        controller:'viewRankDetailsCtr'
      })
      .when('/deposit-view',{
        templateUrl: 'application/views/admin/deposit-view.html',
        controller:'getDepositCtr'
      })
       .when('/approve-deposit-view',{
        templateUrl: 'application/views/admin/approve-deposit-view.html',
        controller:'getApproveDepositCtr'
      })
	  .when('/view-deposit-image/:d_id',{
        templateUrl: 'application/views/admin/view-deposit-image.html',
        controller:'getDepositByIdCtr'
      })
	  .when('/view-leads-comments/:l_id',{
        templateUrl: 'application/views/admin/view-leads-comments.html',
        controller: 'veiwLeadsCommentsCtr'
      })
	  .when('/view-platforms-image/:id',{
        templateUrl: 'application/views/admin/view-platforms-image.html',
        controller:'viewPlatformsImageCtr'
      })
	  .when('/product-order-summary',{
      templateUrl: 'application/views/admin/product-order-summary.html',
      controller:'productOrderSummaryCtr'
    })
    .when('/new-product-order-summary',{
      templateUrl: 'application/views/admin/new-product-order-summary.html',
      controller:'newProductOrderSummaryCtr'
    })
    .when('/product-order-summary-view/:id',{
      templateUrl: 'application/views/admin/product-order-summary-view.html',
      controller:'productOrderSummaryViewCtr'
    })
	.when('/member-report',{
        templateUrl: 'application/views/admin/member-report.html',
        controller:'memberReportCtr'
      })
      .when('/edit-member-report/:id',{
        templateUrl: 'application/views/admin/edit-member-report.html',
        controller:'editMemberReportCtr'
      })
	.when('/add-earning',{
	  templateUrl: 'application/views/admin/add-credit.html',
	  controller:'addCreditCtr'
	})
	.when('/deduct-earning',{
      templateUrl: 'application/views/admin/delete-credit.html',
      controller:'deleteCreditCtr'
    })
	.when('/module-members',{
		templateUrl: 'application/views/admin/module-members.html',
		controller: 'moduleMembersCtr'
	})
	.when('/module-members-details/:id',{
		templateUrl: 'application/views/admin/module-members-details.html',
		controller: 'moduleMembersDetailsCtr'
	})
    .when('/new-upgrade-user-list',{
		templateUrl: 'application/views/admin/new-upgrade-user-list.html',
		controller: 'newUserUpgradeCtr'
	})
	.when('/new-member-report',{
		templateUrl: 'application/views/admin/new-member-report.html',
		controller: 'newMemberListCtr'
	})
	.when('/approve-new-member-status/:uID', {
		templateUrl: 'application/views/admin/approve-new-member-status.html',
		controller: 'approveNewMemberStatusCtr'
	})
	.when('/approve-new-member-status-upgrade/:uID', {
		templateUrl: 'application/views/admin/approve-new-member-status-upgrade.html',
		controller: 'approveUpgradeStatusCtr'
	})
	.when('/earnings-reoprt', {
		templateUrl: 'application/views/admin/earnings-report.html',
		controller: 'earningReportCtrl'
	})
	.when('/earnings-report-by-user/:urid', {
		templateUrl: 'application/views/admin/earnings-report-by-user.html',
		controller: 'earningReportByUserCtr'
	})
  .when('/credit-mxtopup',{    
   templateUrl: 'application/views/admin/credit-mxtopup.html',    
   controller:'creditmxtopupCtr'  
  })  
  .when('/dedut-mxtopup',{      
  templateUrl: 'application/views/admin/dedut-mxtopup.html',      
  controller:'deductmxtopupCtr'  
 })  
  .when('/mxtopup-report',{    
  templateUrl: 'application/views/admin/mxtopup-report.html',   
  controller: 'mxtopupReportCtr'  
 })  
  .when('/mxtopup-report-by-user/:vuID',{    
  templateUrl: 'application/views/admin/mxtopup-report-by-user.html',    
  controller: 'mxtopupReportByUserCtr'  
 })
  .when('/credit-reward-points',{    
   templateUrl: 'application/views/admin/credit-reward-points.html',    
   controller:'creditrewardPointsCtr'  
  })  
  .when('/dedut-reward-points',{      
  templateUrl: 'application/views/admin/dedut-reward-points.html',      
  controller:'deductrewardPointsCtr'  
 })  
  .when('/reward-points-report',{    
  templateUrl: 'application/views/admin/reward-points-report.html',   
  controller: 'rewardPointsReportCtr'  
 })  
  .when('/reward-points-report-by-user/:vuID',{    
  templateUrl: 'application/views/admin/reward-points-report-by-user.html',    
  controller: 'rewardPointsReportByUserCtr'  
 })
  .when('/credit-store-credit',{    
   templateUrl: 'application/views/admin/credit-store-credit.html',    
   controller:'creditstoreCreditCtr'  
  })  
  .when('/dedut-store-credit',{      
  templateUrl: 'application/views/admin/dedut-store-credit.html',      
  controller:'deductstoreCreditCtr'  
 })  
  .when('/store-credit-report',{    
  templateUrl: 'application/views/admin/store-credit-report.html',   
  controller: 'storeCreditReportCtr'  
 })  
  .when('/store-credit-report-by-user/:vuID',{    
  templateUrl: 'application/views/admin/store-credit-report-by-user.html',    
  controller: 'storeCreditReportByUserCtr'  
 })
  .when('/activation-platform-report',{    
  templateUrl: 'application/views/admin/activation-platform-report.html',   
  controller: 'activationPlatformReportCtr'  
 })  
  .when('/activation-report-by-user/:ID',{    
  templateUrl: 'application/views/admin/activation-report-by-user.html',    
  controller: 'activationPlatformReportByUserCtr'  
 })
    .when('/entrepreneurial-bonus',{    
  templateUrl: 'application/views/admin/entrepreneurial-bonus.html',   
  controller: 'entrepreneurialBonusReportCtr'  
 })  
  .when('/entrepreneurial-bonus-by-user/:ID',{    
  templateUrl: 'application/views/admin/entrepreneurial-bonus-by-user.html',    
  controller: 'entrepreneurialBonusReportByUserCtr'  
 })
  .when('/view-training-videos', {
    templateUrl: 'application/views/admin/view-training-videos.html',
    controller: 'trainingVideosViewsCtr'
  })
  .when('/view-marketing-materials', {
    templateUrl: 'application/views/admin/view-marketing-materials.html',
    controller: 'marketingMaterialsViewsCtr'
  })
  .when('/training-videos', {
    templateUrl: 'application/views/admin/training-videos.html',
    controller: 'trainingVideosCtr'
  }) 
  .when('/marketing-materials',{
    templateUrl: 'application/views/admin/marketing-materials.html',
    controller: 'marketingMaterialsCtr'
  })
  .when('/add-category-training-videos',{
    templateUrl: 'application/views/admin/add-category-training-videos.html',
    controller: 'addTrainingVideosCtr'
  })
  .when('/add-category-marketing-materials',{
    templateUrl: 'application/views/admin/add-category-marketing-materials.html',
    controller: 'addMarketingMaterialsCtr'
  })
   .when('/edit-category-training-videos/:catID',{
        templateUrl:'application/views/admin/edit-category-training-videos.html',
        controller: 'editCategoryTrainingVideosCtr'
      })
  .when('/edit-category-marketing-materials/:catID',{
        templateUrl:'application/views/admin/edit-category-marketing-materials.html',
        controller: 'editCategoryMarketingMaterialsCtr'
      })
	  
  .when('/fail-member-report',{
    templateUrl: 'application/views/admin/fail-member-report.html',
    controller:'failmemberReportCtr'
  })
  .when('/view-fail-member-report/:id',{
    templateUrl: 'application/views/admin/view-fail-member-report.html',
    controller:'viewfailmemberReportCtr'
  })
  
  .when('/package-description',{
    templateUrl:'application/views/admin/view-package-description.html',
    controller:'viewPackageDescriptionCtrl'
  }) 
  .when('/edit-package-description/:packageID',{
    templateUrl:'application/views/admin/edit-package-description.html',
    controller:'packageEditDescriptionCtr'
  })
  .when('/import-arb-suscription', {
    templateUrl: 'application/views/admin/import-arb-suscription.html',
    controller: 'importArbSuscriptionCtr'
  })
  .when('/event-reg-list', {
    templateUrl: 'application/views/admin/event-reg-list.html',
    controller: 'newEventRegistrationListCtr'
  })
  .when('/ether-value', {
    templateUrl: 'application/views/admin/ether-value.html',
    controller: 'addEtherValueCtr'
  })
  .when('/ether-conversion-rate-setting', {
    templateUrl: 'application/views/admin/ether-conversion-rate-setting.html',
    controller: 'etherConversionRateCtr'
  })
  .when('/ether-credit-store-for-user', {
    templateUrl: 'application/views/admin/ether-credit-store-for-user.html',
    controller: 'etherCreditStoreCtr'
  })
  .when('/ether-deduct-store-for-user', {
    templateUrl: 'application/views/admin/ether-deduct-store-for-user.html',
    controller: 'etherDeductStoreCtr'
  })
  .when('/pending-balance-report-list', {
    templateUrl: 'application/views/admin/pending-balance-report-list.html',
    controller: 'pendingBalanceReportCtr'
  })
  .when('/ether-wallet-report-list', {
    templateUrl: 'application/views/admin/ether-wallet-report-list.html',
    controller: 'etherWalletReportCtr'
  })
  .when('/ether-report', {
    templateUrl: 'application/views/admin/ether-report.html',
    controller: 'etherReportCtr'
  })
  .when('/ether-wallat-report-by-user/:id', {
    templateUrl: 'application/views/admin/ether-wallat-report-by-user.html',
    controller: 'etherReportByUserCtr'
  })
  ;
  }]);
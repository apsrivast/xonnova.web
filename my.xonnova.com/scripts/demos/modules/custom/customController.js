   myCustomApp.controller('fastSalesBonusCtr', [ '$scope', '$route', '$http', '$routeParams', 'Upload',function($scope, $route, $http, $routeParams, Upload){
      $scope.csvUpload = function (files) {
          Upload.upload({
            url: BASE_URL+'csv_bonus/importcsvSales',
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

  myCustomApp.controller('solarBonusCtr', [ '$scope', '$route', '$http', '$routeParams', 'Upload',function($scope, $route, $http, $routeParams, Upload){
      $scope.csvUpload = function (files) {
          Upload.upload({
            url: BASE_URL+'csv_bonus/importcsv',
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


  myCustomApp.controller('stripeSettingCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL +'cronJob/getStripeData').success(function(data){
    $scope.cronData=data;
  });

  $scope.update = function(cron){
    $http.put(BASE_URL+'cronJob/updateStripeSettings/',cron).success(function(data) {
      var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
      $('#message').html(message);     
    });
  };
}); 

myCustomApp.controller('ccInfoCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'cc_info/getPaymentList').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'cc_info/getPaymentList', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/cc-info');
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



myCustomApp.controller('newMerchantLeadsViewByUserCtr', function ($scope, $http, $route, $location, $routeParams) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $http.get(BASE_URL+'new_send_leads_ctr/getRestaurantLeadsListById/'+id).success(function(data) {
      $scope.htmlRestaurantLeadsListById = data;
    });
    $scope.approve = function(user){
        $http.put(BASE_URL+'new_send_leads_ctr/approveLeadsListById', user).success(function(data) {
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);   
        });
    };
    $scope.reject = function(user) {
        $http.put(BASE_URL+'new_send_leads_ctr/rejectLeadsListById', user).success(function(data) {
             var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
             $('#message').html(message);   
        });
    };
});
myCustomApp.controller('newMerchantLeadsViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'new_send_leads_ctr/getMerchantLeadsList').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'new_send_leads_ctr/getMerchantLeadsList', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/new-merchant-leads-view');
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


myCustomApp.controller('newSolorLeadsViewByUserCtr', function ($scope, $http, $route, $location, $routeParams) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $http.get(BASE_URL+'new_send_leads_ctr/getRestaurantLeadsListById/'+id).success(function(data) {
      $scope.htmlRestaurantLeadsListById = data;
    });
    $scope.approve = function(user){
        $http.put(BASE_URL+'new_send_leads_ctr/approveLeadsListById', user).success(function(data) {
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);   
        });
    };
    $scope.reject = function(user) {
        $http.put(BASE_URL+'new_send_leads_ctr/rejectLeadsListById', user).success(function(data) {
             var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
             $('#message').html(message);   
        });
    };
});
myCustomApp.controller('newSolorLeadsViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'new_send_leads_ctr/getSolorLeadsList').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'new_send_leads_ctr/getSolorLeadsList', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/new-solor-leads-view');
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


myCustomApp.controller('newPrintingLeadsViewByUserCtr', function ($scope, $http, $route, $location, $routeParams) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $http.get(BASE_URL+'new_send_leads_ctr/getRestaurantLeadsListById/'+id).success(function(data) {
      $scope.htmlRestaurantLeadsListById = data;
    });
    $scope.approve = function(user){
        $http.put(BASE_URL+'new_send_leads_ctr/approveLeadsListById', user).success(function(data) {
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);   
        });
    };
    $scope.reject = function(user) {
        $http.put(BASE_URL+'new_send_leads_ctr/rejectLeadsListById', user).success(function(data) {
             var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
             $('#message').html(message);   
        });
    };
});
myCustomApp.controller('newPrintingLeadsViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'new_send_leads_ctr/getPrintingLeadsList').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'new_send_leads_ctr/getPrintingLeadsList', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/new-printing-leads-view');
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

myCustomApp.controller('newRestaurantLeadsViewByUserCtr', function ($scope, $http, $route, $location, $routeParams) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $http.get(BASE_URL+'new_send_leads_ctr/getRestaurantLeadsListById/'+id).success(function(data) {
      $scope.htmlRestaurantLeadsListById = data;
    });
    $scope.approve = function(user){
        $http.put(BASE_URL+'new_send_leads_ctr/approveRestaurantLeadsListById', user).success(function(data) {
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);   
        });
    };
    $scope.reject = function(user) {
        $http.put(BASE_URL+'new_send_leads_ctr/rejectRestaurantLeadsListById', user).success(function(data) {
             var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
             $('#message').html(message);   
        });
    };
});
myCustomApp.controller('newRestaurantLeadsViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'new_send_leads_ctr/getRestaurantLeadsList').success(function(data){
      $scope.htmlRestaurantLeadsList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'new_send_leads_ctr/getRestaurantLeadsList', dateRangeSearch).success(function(data){
          $scope.htmlRestaurantLeadsList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlRestaurantLeadsList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlRestaurantLeadsList.length;
          $location.path('/new-restaurant-leads-view');
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
myCustomApp.controller('menuUserMenuMappingCtr', function($scope, $http, $location,$route, $routeParams){
    $http.get(BASE_URL + 'user_menu/getMenuList').success(function(data){
      $scope.getMenuList = data;
    });
    $scope.onchangeMenu = function(id){
      $http.get(BASE_URL + 'user_menu/getSubMenuList/'+id).success(function(data){
        $scope.getSubMenuList = data;
      });
    };
    $scope.addMenuUser = function(user){
      $http.put(BASE_URL+'user_menu/addMenuUser', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
          $route.reload();
        }
      });
    };
    $http.get(BASE_URL + 'user_menu/getMenuMappingList').success(function(data){
      $scope.getUserMenuList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.getUserMenuList.length; //Initially for no filter  
      $scope.totalItems = $scope.getUserMenuList.length;
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
        $http.put(BASE_URL +'user_menu/deleteMenuMapping', user).success(function(){         
            $route.reload();
        });
    };
});

myCustomApp.controller('mxtopupSettingCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL +'mxtopup_bonus/getConversionRateData').success(function(data){
    $scope.cronData=data;
  });

  $scope.update = function(cron){
    $http.put(BASE_URL+'mxtopup_bonus/updateConversionRateSettings/',cron).success(function(data) {
      var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
      $('#message').html(message);     
    });
  };
}); 
myCustomApp.controller('mxtopupBonusReportCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'mxtopup_bonus/walletReport').success(function(data){
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
    $scope.creditChange = function(user){            
     $http.put(BASE_URL+'mxtopup_bonus/creditwallet', user).success(function(data) {                
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

    $scope.deleteEarnings = function(user){
          $http.put(BASE_URL+'mxtopup_bonus/deductwallet', user).success(function(data) {
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
});
myCustomApp.controller('mxtopupBonusReportByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var ID = $routeParams.id;

     $http.get(BASE_URL + 'mxtopup_bonus/walletReportByUser/'+ID).success(function(data){
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

myCustomApp.controller('packageEditDescriptionMexCtr', function ($scope, $http, $route, $location, $routeParams) {
      var pkgid = $routeParams.packageID;
      $scope.activePath = null;

      $http.get(BASE_URL+'package_ctr/getMexPackageDescriptionById/'+pkgid).success(function(data) {
        $scope.packageData = data;
      });

      $scope.add = function(pkg){
          $http.put(BASE_URL+'package_ctr/addMexPackageDescription/'+pkgid, pkg).success(function() {
               $route.reload();
          });
      };

      $scope.update = function(pkg){
          $http.put(BASE_URL+'package_ctr/updateMexPackageDescription', pkg).success(function() {
               $route.reload();
          });
      };

      $scope.delete = function(pkg) {
          $http.put(BASE_URL+'package_ctr/deleteMexPackageDescription', pkg).success(function() {
                 $route.reload();
          });
      };
  });


myCustomApp.controller('conversionRateSettingCtr',function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL +'cronJob/getConversionRateData').success(function(data){
    $scope.cronData=data;
  });

  $scope.update = function(cron){
    $http.put(BASE_URL+'cronJob/updateConversionRateSettings/',cron).success(function(data) {
      var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
      $('#message').html(message);     
    });
  };
}); 

 myCustomApp.controller('upgradePackageDescriptionEditCtr', function ($scope, $http, $route, $location, $routeParams) {
      var oldid = $routeParams.oldid;
      var newid = $routeParams.newid;


      $http.get(BASE_URL+'package_ctr/getUpgradePackageDescription/'+oldid+'/'+newid).success(function(data) {
        $scope.packageData = data;
      });

      $scope.add = function(pkg){
          $http.put(BASE_URL+'package_ctr/addPackageDescription/'+oldid+'/'+newid, pkg).success(function() {
               $route.reload();
          });
      };

      $scope.update = function(pkg){
          $http.put(BASE_URL+'package_ctr/updatePackageDescription', pkg).success(function() {
               $route.reload();
          });
      };

      $scope.delete = function(pkg) {
          $http.put(BASE_URL+'package_ctr/deletePackageDescription', pkg).success(function() {
                 $route.reload();
          });
      };
  });

 
myCustomApp.controller('upgradePackageDescriptionCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'package_ctr/getUpgradePackage').success(function(data){
      $scope.htmlUpgradePackage = data;
      $scope.currentPage = 1;
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.htmlUpgradePackage.length; 
      $scope.totalItems = $scope.htmlUpgradePackage.length;
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


myCustomApp.controller('ticketListOldCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'ticket_ctr/getTicketListByEmployee').success(function(data){
      $scope.htmlTicketOldList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlTicketOldList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlTicketOldList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'ticket_ctr/getTicketListByEmployee', dateRangeSearch).success(function(data){
          $scope.htmlTicketOldList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlTicketOldList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlTicketOldList.length;
          $location.path('/ticket-list-old');
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

myCustomApp.controller('ticketListNewByIdCtr', function($scope, $http, $location,$route, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'ticket_ctr/getTickeByID/'+ID).success(function(data){
        $scope.htmlTicket = data;
    });

    $http.get(BASE_URL + 'ticket_ctr/getTickeCommentByID/'+ID).success(function(data){
        $scope.htmlTicketComment = data;
    });

  

    
    $scope.addcomment = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'ticket_ctr/addFirstComment/'+ID, user).success(function(data) {
         if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
         // user.employee = '';
          $route.reload();
         
        }
      });
    };
});
myCustomApp.controller('ticketListNewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'ticket_ctr/getTicketListByDepartment').success(function(data){
      $scope.htmlTicketList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlTicketList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'ticket_ctr/getTicketListByDepartment', dateRangeSearch).success(function(data){
          $scope.htmlTicketList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlTicketList.length;
          $location.path('/ticket-list-new');
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


myCustomApp.controller('ticketListByDepartmentCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'ticket_ctr/getTicketListByDepartment').success(function(data){
      $scope.htmlTicketList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlTicketList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'ticket_ctr/getTicketListByDepartment', dateRangeSearch).success(function(data){
          $scope.htmlTicketList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlTicketList.length;
          $location.path('/ticket-list-by-department');
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

myCustomApp.controller('ticketListByIdCtr', function($scope, $http, $location,$route, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'ticket_ctr/getTickeByID/'+ID).success(function(data){
        $scope.htmlTicket = data;
    });

    $http.get(BASE_URL + 'ticket_ctr/getTickeCommentByID/'+ID).success(function(data){
        $scope.htmlTicketComment = data;
    });

  

    
    $scope.addcomment = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'ticket_ctr/addComment/'+ID, user).success(function(data) {
         if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
         // user.employee = '';
          $route.reload();
         
        }
      });
    };
});


myCustomApp.controller('ticketListCtr', function($scope, $http, $location,$route, $routeParams){
    $http.get(BASE_URL + 'ticket_ctr/getTicketList').success(function(data){
      $scope.htmlTicketList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlTicketList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'ticket_ctr/getTicketList', dateRangeSearch).success(function(data){
          $scope.htmlTicketList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlTicketList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlTicketList.length;
          $location.path('/ticket-list');
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

    $scope.sendMail = function(user){
      $http.put(BASE_URL+'ticket_ctr/sendUserMail', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
         // user.employee = '';
          $route.reload();
         
        }
      });
    };
});
myCustomApp.controller('ticketAddCtr', function($scope,  Upload, $http, $location,$route, $routeParams){
    $http.get(BASE_URL + 'add_menu/getDepartmentList').success(function(data){
      $scope.getDepartmentList = data;
    });

    $scope.user = {};

    $scope.uploadBug = function (files) {
        Upload.upload({
            url: BASE_URL+'bug_user/uploadBug',
            file: files
        }).success(function (data) {
              $scope.user.bug_image = data.file_name;
        });
    };


   
   
   
    $scope.addTicket = function(user){
      $http.put(BASE_URL+'ticket_ctr/addTicket', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
         // user.employee = '';
          //$route.reload();
         
        }
      });
    };

});


myCustomApp.controller('menuDepartmentMappingCtr', function($scope, $http, $location,$route, $routeParams){
    $http.get(BASE_URL + 'add_menu/getDepartmentList').success(function(data){
      $scope.getDepartmentList = data;
    });

    $http.get(BASE_URL + 'add_menu/getMenuList').success(function(data){
      $scope.getMenuList = data;
    });
    $scope.onchangeMenu = function(id){
      $http.get(BASE_URL + 'add_menu/getSubMenuList/'+id).success(function(data){
        $scope.getSubMenuList = data;
      });
    };

   
   
   
    $scope.addMenuDepartment = function(user){
      $http.put(BASE_URL+'add_menu/addMenuDepartment', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
         // user.employee = '';
          $route.reload();
         
        }
      });
    };


    $http.get(BASE_URL + 'add_menu/getDepartmentMenuMappingList').success(function(data){
      $scope.getDepartmentMenuList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.getDepartmentMenuList.length; //Initially for no filter  
      $scope.totalItems = $scope.getDepartmentMenuList.length;
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
        $http.put(BASE_URL +'add_menu/deleteDepartmentMenuMapping', user).success(function(){         
            $route.reload();
        });
    };
});

myCustomApp.controller('menuAddDepartmentCtr', function($scope, $http, $location, $route, $routeParams){
   $http.get(BASE_URL + 'add_menu/getDepartmentList').success(function(data){
      $scope.getDepartmentList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.getDepartmentList.length; //Initially for no filter  
      $scope.totalItems = $scope.getDepartmentList.length;
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

    $scope.addDepartment = function(user){
      $http.put(BASE_URL+'add_menu/addDepartment', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
          user.department_name = '';
           $route.reload();
          
        }
      });
    };
});



myCustomApp.controller('menuAddMenuCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'add_menu/getMenuList').success(function(data){
      $scope.getMenuList = data;
    });
    $http.get(BASE_URL + 'add_menu/getEmployeeList').success(function(data){
      $scope.getEmployeeList = data;
    });
   
   
    $scope.addMenu = function(user){
      $http.put(BASE_URL+'add_menu/addMenu', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
          user.employee = '';
         
        }
      });
    };


    $http.get(BASE_URL + 'add_menu/getEmployeeMenuMappingList').success(function(data){
      $scope.getEmployeeMenuList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.getEmployeeMenuList.length; //Initially for no filter  
      $scope.totalItems = $scope.getEmployeeMenuList.length;
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


myCustomApp.controller('menuAddEmployeeCtr', function($scope, $http, $location,$route, $routeParams){

    $http.get(BASE_URL + 'add_menu/getDepartmentList').success(function(data){
      $scope.getDepartmentList = data;
    });


   $http.get(BASE_URL + 'add_menu/getEmployeeList').success(function(data){
      $scope.getEmployeeList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.getEmployeeList.length; //Initially for no filter  
      $scope.totalItems = $scope.getEmployeeList.length;
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

    $scope.addEmployee = function(user){
      $http.put(BASE_URL+'add_menu/addEmployee', user).success(function(data) {
        if(data.messagee == null){
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          //alert(data.message);
        }else{
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.messagee+'</strong></div>';
              $('#message').html(message);
          user.employee_name = '';
          user.employee_pass = '';
          $route.reload();
        }
      });
    };
});
myCustomApp.controller('editTraningVideo', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'tools/editTraningVideobyID/'+ID).success(function(data){
        $scope.htmlTraningVideo = data;
    });

    $http.get(BASE_URL + 'tools/getTrainingVideosCategory').success(function(data){
        $scope.vediosCategoryList = data;
    });

    
    $scope.updateTraningVideo = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'tools/editTraningVideo/'+ID, user).success(function(data) {
        if(data.messagee == null){
          alert(data.message);
        }else{
          alert(data.messagee);
          $location.path('/view-training-videos');
        }
      });
    };
});

myCustomApp.controller('changesCardSubscriptionAdminCtr',function($scope, $http, $location, $routeParams){

  $scope.changesCard = function(user){
    // var sure = confirm('Are you absolutely sure?');
    // if (sure) {
      $http.post(BASE_URL +'changes_card/changesCardSubscriptionByAdmin', user).success(function(data){
        alert(data.message);
        location.reload();
      });
    //}
  };
});


myCustomApp.controller('viewRequestPrepaidVoucherCtrl', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'prepaid_voucher_ctr/getPrepaidVoucher/'+ID).success(function(data){
        $scope.htmlPrepaidVoucher = data;
    });
    $scope.updatesim = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'prepaid_voucher_ctr/updateSim/', user).success(function(data) {
        if(data.messagee == null){
          alert(data.message);
        }else{
          alert(data.messagee);
          $location.path('/requested-prepaid-voucher');
        }
      });
    };
});

myCustomApp.controller('requestPrepaidVoucherCtrl', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'prepaid_voucher_ctr/getPrepaidVoucherList').success(function(data){
      $scope.htmlPrepaidVoucherList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.htmlPrepaidVoucherList.length; //Initially for no filter  
      $scope.totalItems = $scope.htmlPrepaidVoucherList.length;
    });
     $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'prepaid_voucher_ctr/getPrepaidVoucherList', dateRangeSearch).success(function(data){
          $scope.htmlPrepaidVoucherList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.htmlPrepaidVoucherList.length; //Initially for no filter  
          $scope.totalItems = $scope.htmlPrepaidVoucherList.length;
          $location.path('/requested-prepaid-voucher');
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

myCustomApp.controller('solarViewOneCtrl', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.id;
    $http.get(BASE_URL + 'solar/getSolar/'+ID).success(function(data){
        $scope.SolarFormListView = data;
    });
});

myCustomApp.controller('solarViewCtrl', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'solar/getList').success(function(data){
      $scope.solarList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.solarList.length; //Initially for no filter  
      $scope.totalItems = $scope.solarList.length;
    });
     $scope.updateResult = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'solar/getList', dateRangeSearch).success(function(data){
          $scope.solarList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.solarList.length; //Initially for no filter  
          $scope.totalItems = $scope.solarList.length;
          $location.path('/solar-view');
      });
    };
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



myCustomApp.controller('transferSimCtrl', function ($scope, $http, $route, $location, $routeParams) {
    
    $http.get(BASE_URL + 'sim_activation/getTransferSimList').success(function(data){
      $scope.TransferList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.TransferList.length; //Initially for no filter  
      $scope.totalItems = $scope.TransferList.length;
    });
  
       $scope.updateResult = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'sim_activation/getTransferSimList',dateRangeSearch).success(function(data){
          $scope.TransferList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.TransferList.length; //Initially for no filter  
          $scope.totalItems = $scope.TransferList.length;
          $location.path('/transfer-sim');
      });
    };

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



myCustomApp.controller('editVoucherNumberCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'activate_platform/getVoucherNumberByID/'+Id).success(function(data){
        $scope.List = data;
      });

     $scope.edit = function(user){
      
      $http.put(BASE_URL+'activate_platform/editVoucherNumber', user).success(function(data) {
       alert(data.message);
      });
    };
});


myCustomApp.controller('voucherNumberCtr', function($scope, $http, $route, $location, $routeParams){

    $scope.add = function(user){
      $http.put(BASE_URL +'activate_platform/addVoucher', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };

   $http.get(BASE_URL + 'activate_platform/getVoucherList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getVoucherList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/voucher-number');
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


    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'activate_platform/deleteVoucher', user).success(function(){         
            $route.reload();
        });
      }
    };
});

myCustomApp.controller('blockUserAccountCtr', function($scope, $http, $route, $location, $routeParams){

    $scope.add = function(user){
      $http.put(BASE_URL +'block_user_account_ctr/addUser', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };

   $http.get(BASE_URL + 'block_user_account_ctr/getList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'block_user_account_ctr/getList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/block-user-account');
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


    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'block_user_account_ctr/deleteUser', user).success(function(){         
            $route.reload();
        });
      }
    };
});



myCustomApp.controller('referAStoreAgrByUserCtCopy', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;
  $scope.user ={};

     $http.get(BASE_URL + 'reseller_ctr/referAStoreReportArgByUser/'+Id).success(function(data){
        $scope.referAStoreAgrByUserHtmlList = data;
      });
	  
	  $http.get(BASE_URL + 'reseller_ctr/getdealercode/'+Id).success(function(data){
        $scope.dealercode = data;
      });
	  
    $scope.approve = function(user){
      var pdfcontent = $('#content').html();
      $scope.user.agrmcontantpdf = pdfcontent;
      $http.put(BASE_URL+'reseller_ctr/mailpdfagrrementcopy/'+Id,user).success(function(data) {
      
      });
    };

});

myCustomApp.controller('rejectedSimByUserCtr', function($scope, $http, $route, $location, $routeParams){
	var Id = $routeParams.id;

    $http.get(BASE_URL + 'activate_platform/activatePlatformReportByUser/'+Id).success(function(data){
        $scope.walletReportListByUser = data;
    });
	  
	$scope.submit = function(user){
      $http.put(BASE_URL+'activate_platform/approverejectedSIMByUser/'+Id, user).success(function(data) {
       alert(data.message);
      
      });
    };
});
myCustomApp.controller('viewDailyReportCtr', function($scope, $http, $location, $routeParams){
    var date = $routeParams.date;
      $scope.date = date;
    $http.get(BASE_URL + 'daily_report_for_admin/getProductAmount/'+date).success(function(data){
        $scope.ListP = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListP.length; 
        $scope.totalItems = $scope.ListP.length;
    });

    $http.get(BASE_URL + 'daily_report_for_admin/getRegistrationAmount/'+date).success(function(data){
        $scope.ListR = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListR.length; 
        $scope.totalItems = $scope.ListR.length;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getUpgradeAmount/'+date).success(function(data){
        $scope.ListU = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListU.length; 
        $scope.totalItems = $scope.ListU.length;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getFastStartAmount/'+date).success(function(data){
        $scope.ListFS = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListFS.length; 
        $scope.totalItems = $scope.ListFS.length;
    });

    $http.get(BASE_URL + 'daily_report_for_admin/getBinaryAmount/'+date).success(function(data){
        $scope.ListB = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListB.length; 
        $scope.totalItems = $scope.ListB.length;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getEntrepreneurialAmount/'+date).success(function(data){
        $scope.ListE = data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.ListE.length; 
        $scope.totalItems = $scope.ListE.length;
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



    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('product').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "product.xls");
         var blob = new Blob([document.getElementById('registration').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "registration.xls");
         var blob = new Blob([document.getElementById('upgrade').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "upgrade.xls");
         var blob = new Blob([document.getElementById('faststart').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "faststart.xls");
         var blob = new Blob([document.getElementById('binary').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "binary.xls");
         var blob = new Blob([document.getElementById('entrepreneurial').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "entrepreneurial.xls");
    };



    
});

myCustomApp.controller('dailyReportCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'daily_report_for_admin/getDailyReportList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalTotalIncome').success(function(data){
      $scope.TotalTotalIncome = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalFastStart').success(function(data){
      $scope.TotalFastStart = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalBinary').success(function(data){
      $scope.TotalBinary = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalCoded').success(function(data){
      $scope.TotalCoded = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalEntrepreneurial').success(function(data){
      $scope.TotalEntrepreneurial  = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalMatching').success(function(data){
      $scope.TotalMatching = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/getTotalTotalPaid').success(function(data){
      $scope.TotalTotalPaid = data;
    });
    $http.get(BASE_URL + 'daily_report_for_admin/TotalTotalProfit').success(function(data){
      $scope.TotalTotalProfit = data;
    });

    $scope.update = function(dateRangeSearch){
      var from = dateRangeSearch.from_date;
      var to = dateRangeSearch.to_date;
     //alert(dateRangeSearch.from_date);
      $scope.activePath = null;

      $http.get(BASE_URL + 'daily_report_for_admin/getTotalTotalIncome/'+from+'/'+to).success(function(data){
        $scope.TotalTotalIncome = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalFastStart/'+from+'/'+to).success(function(data){
        $scope.TotalFastStart = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalBinary/'+from+'/'+to).success(function(data){
        $scope.TotalBinary = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalCoded/'+from+'/'+to).success(function(data){
        $scope.TotalCoded = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalEntrepreneurial/'+from+'/'+to).success(function(data){
        $scope.TotalEntrepreneurial  = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalMatching/'+from+'/'+to).success(function(data){
        $scope.TotalMatching = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/getTotalTotalPaid/'+from+'/'+to).success(function(data){
        $scope.TotalTotalPaid = data;
      });
      $http.get(BASE_URL + 'daily_report_for_admin/TotalTotalProfit/'+from+'/'+to).success(function(data){
        $scope.TotalTotalProfit = data;
      });
      $http.put(BASE_URL +'daily_report_for_admin/getDailyReportList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/daily-report');
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

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "Report.xls");
    };
});


myCustomApp.controller('bugRejectedByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;
     $http.get(BASE_URL + 'bug_user/bugByUser/'+Id).success(function(data){
        $scope.rejectedUser = data;
      });
});



myCustomApp.controller('bugRejectedListCtr', function($scope, $http, $route, $location, $routeParams){
    $http.get(BASE_URL + 'bug_user/getrejectedBugList').success(function(data){
      $scope.rejectedBugList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.rejectedBugList.length; //Initially for no filter  
      $scope.totalItems = $scope.rejectedBugList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'bug_user/getrejectedBugList', dateRangeSearch).success(function(data){
          $scope.rejectedBugList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.rejectedBugList.length; //Initially for no filter  
          $scope.totalItems = $scope.rejectedBugList.length;
          $location.path('/bug-rejected');
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



myCustomApp.controller('bugApprovedByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;
     $http.get(BASE_URL + 'bug_user/bugByUser/'+Id).success(function(data){
        $scope.approvedUser = data;
      });
});



myCustomApp.controller('bugApprovedListCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'bug_user/getApprovedBugList').success(function(data){
      $scope.approvedBugList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.approvedBugList.length; //Initially for no filter  
      $scope.totalItems = $scope.approvedBugList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'bug_user/getApprovedBugList', dateRangeSearch).success(function(data){
          $scope.approvedBugList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.approvedBugList.length; //Initially for no filter  
          $scope.totalItems = $scope.approvedBugList.length;
          $location.path('/bug-approved');
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

myCustomApp.controller('bugPendingByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'bug_user/bugByUser/'+Id).success(function(data){
        $scope.pendingUser = data;
      });
    $scope.approve = function(user){
      $http.put(BASE_URL+'bug_user/approveUserBug/'+Id, user).success(function(data) {
       alert(data.message);
      
      });
    };

    $scope.reject = function(){
      $http.put(BASE_URL+'bug_user/rejectUserBug/'+Id).success(function(data) {
       alert(data.message);
      
      });
    };
});



myCustomApp.controller('bugPendingListCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'bug_user/getPendingBugList').success(function(data){
      $scope.pendingBugList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.pendingBugList.length; //Initially for no filter  
      $scope.totalItems = $scope.pendingBugList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'bug_user/getPendingBugList', dateRangeSearch).success(function(data){
          $scope.pendingBugList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.pendingBugList.length; //Initially for no filter  
          $scope.totalItems = $scope.pendingBugList.length;
          $location.path('/bug-pending');
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



myCustomApp.controller('referAStoreBlockCtr', function($scope, $http, $location, $route, $routeParams){
  $http.get(BASE_URL +'reseller_ctr/blockResellerList').success(function(data){
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
    var cancelSuscription = confirm('Are you absolutely sure ?');
    if (cancelSuscription) {
      $http.post(BASE_URL +'reseller_ctr/blockReseller',sub).success(function(data){
       alert(data.message);
       $route.reload();
      });
    }
  };
});


myCustomApp.controller('rejectedAStoreByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'reseller_ctr/referAStoreReportByUser/'+Id).success(function(data){
        $scope.rejectedAStoreByUserList = data;
      });
   
});

myCustomApp.controller('rejectedAStoreListCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'reseller_ctr/getrejectedAStoreList').success(function(data){
      $scope.rejectedAStoreList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.rejectedAStoreList.length; //Initially for no filter  
      $scope.totalItems = $scope.rejectedAStoreList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'reseller_ctr/getrejectedAStoreList', dateRangeSearch).success(function(data){
          $scope.rejectedAStoreList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.rejectedAStoreList.length; //Initially for no filter  
          $scope.totalItems = $scope.rejectedAStoreList.length;
          $location.path('/rejected-refer-a-store');
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

myCustomApp.controller('referAStoreAgrByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;
	$scope.user ={};

    $http.get(BASE_URL + 'reseller_ctr/getmaxdealercode/').success(function(data){
        $scope.maxdealerno = data;
    });

     $http.get(BASE_URL + 'reseller_ctr/referAStoreReportArgByUser/'+Id).success(function(data){
        $scope.referAStoreAgrByUserHtmlList = data;
      });

      $http.get(BASE_URL + 'reseller_ctr/referAStoreReportByUser/'+Id).success(function(data){
        $scope.htmlStoreAReferView = data;
      });
    $scope.approve = function(user){
      $scope.activePath = null;
		
		var pdfcontent = $('#content').html();
		$scope.user.agrmcontantpdf = pdfcontent;
		$http.put(BASE_URL+'reseller_ctr/mailpdfagrrement/',user).success(function(data) {
			//alert(data.message);
		});
      $http.put(BASE_URL+'reseller_ctr/approvereferAStoreReportArg/'+Id, user).success(function(data) {
       alert(data.message);
        $location.path('/refer-a-store-agreement');
      });
    };
	
  	$scope.reject = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'reseller_ctr/rejectDocAStoreReport/'+Id, user).success(function(data) {
       alert(data.message);
        $location.path('/refer-a-store-agreement');
      
      });
    };

    $scope.resendStoreUserApproved = function(){
      $http.put(BASE_URL+'reseller_ctr/resendStoreUserApproved/'+Id).success(function(data) {
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
      });
    };
});

myCustomApp.controller('referAStoreArgListCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'reseller_ctr/getreferAStoreArgList').success(function(data){
      $scope.referAStoreagreementList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.referAStoreagreementList.length; //Initially for no filter  
      $scope.totalItems = $scope.referAStoreagreementList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'reseller_ctr/getreferAStoreArgList', dateRangeSearch).success(function(data){
          $scope.referAStoreagreementList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.referAStoreagreementList.length; //Initially for no filter  
          $scope.totalItems = $scope.referAStoreagreementList.length;
          $location.path('/refer-a-store-agreement');
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




myCustomApp.controller('approvedreferAStoreByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'reseller_ctr/referAStoreReportByUser/'+Id).success(function(data){
        $scope.List = data;
      });

    $scope.resendStoreUserApproved = function(){
      $http.put(BASE_URL+'reseller_ctr/resendStoreUserApproved/'+Id).success(function(data) {
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
      });
    };
    $scope.resendStoreAgreementApproved = function(){
      $http.put(BASE_URL+'reseller_ctr/resendStoreAgreementApproved/'+Id).success(function(data) {
        var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
      });
    };
   
});

myCustomApp.controller('approvedreferAStoreListCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'reseller_ctr/getapprovedreferAStoreList').success(function(data){
      $scope.approvedreferAStoreList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.approvedreferAStoreList.length; //Initially for no filter  
      $scope.totalItems = $scope.approvedreferAStoreList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'reseller_ctr/getapprovedreferAStoreList', dateRangeSearch).success(function(data){
          $scope.approvedreferAStoreList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.approvedreferAStoreList.length; //Initially for no filter  
          $scope.totalItems = $scope.approvedreferAStoreList.length;
          $location.path('/approved-refer-a-store-list');
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



myCustomApp.controller('referAStoreByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'reseller_ctr/referAStoreReportByUser/'+Id).success(function(data){
        $scope.referAStoreHtmlList = data;
      });
    $scope.approve = function(user){
      $http.put(BASE_URL+'reseller_ctr/approvereferAStoreReport/'+Id, user).success(function(data) {
       alert(data.message);
      
      });
    };
	
	  $scope.reject = function(user){
      $http.put(BASE_URL+'reseller_ctr/rejectferAStoreReport/'+Id, user).success(function(data) {
       alert(data.message);
      
      });
    };

    $scope.edit = function(user){
      $http.put(BASE_URL+'reseller_ctr/editReferAStoreReport/'+Id, user).success(function(data) {
       alert(data.message);
       $route.reload();
      
      });
    };
});

myCustomApp.controller('referAStoreListCtr', function($scope, $http, $route, $location, $routeParams){    
    $http.get(BASE_URL + 'reseller_ctr/getreferAStoreList').success(function(data){
      /*  alert(data); */
	  $scope.referStoreList = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.referStoreList.length; //Initially for no filter  
      $scope.totalItems = $scope.referStoreList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'reseller_ctr/getreferAStoreList', dateRangeSearch).success(function(data){
          $scope.referStoreList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.referStoreList.length; //Initially for no filter  
          $scope.totalItems = $scope.referStoreList.length;
          $location.path('/refer-a-store-list');
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







myCustomApp.controller('rejectedSimCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'activate_platform/getrejectedSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.List.length;
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getrejectedSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; 
          $scope.entryLimit = 20; 
          $scope.filteredItems = $scope.List.length; 
          $scope.totalItems = $scope.List.length;
          $location.path('/rejected-sim');
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



myCustomApp.controller('editNewsSectionCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'news_section_ctr/getNewsUserListByID/'+Id).success(function(data){
        $scope.List = data;
      });

     $scope.edit = function(user){
       $scope.activePath = null;
      $http.put(BASE_URL+'news_section_ctr/editNewsSection', user).success(function(data) {
       alert(data.message);
       $location.path('/news-section');
      });
    };
});



myCustomApp.controller('foundersListCtr', function($scope, $http, $route, $location, $routeParams){
    

    $scope.add = function(user){
      $http.put(BASE_URL +'member/addFounders', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };



    $http.get(BASE_URL + 'member/getFoundersList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'member/getFoundersList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/founders-list');
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

    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'member/deleteFounder', user).success(function(){         
            $route.reload();
        });
      }
    };
});



myCustomApp.controller('editSimNumberCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'activate_platform/getSimNumberByID/'+Id).success(function(data){
        $scope.List = data;
      });

     $scope.edit = function(user){
      $http.put(BASE_URL+'activate_platform/editSimNumber', user).success(function(data) {
       alert(data.message);
      });
    };
});
myCustomApp.controller('approvedSimByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'activate_platform/activatePlatformReportByUser/'+Id).success(function(data){
        $scope.walletReportListByUser = data;
      });
});

myCustomApp.controller('approvedSimCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'activate_platform/getapprovedSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.List.length;
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getapprovedSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; 
          $scope.entryLimit = 20; 
          $scope.filteredItems = $scope.List.length; 
          $scope.totalItems = $scope.List.length;
          $location.path('/approved-sim');
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


myCustomApp.controller('waitingSimByUserCtr', function($scope, $http, $route, $location, $routeParams){
  var Id = $routeParams.id;

     $http.get(BASE_URL + 'activate_platform/activatePlatformReportByUser/'+Id).success(function(data){
        $scope.walletReportListByUser = data;
      });
    $scope.approve = function(user){
      $http.put(BASE_URL+'activate_platform/approveWaitingSimStatus/'+Id, user).success(function(data) {
       alert(data.message);
      
      });
    };
    $scope.reject = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL+'activate_platform/rejectSimStatus/'+Id,user).success(function(data) {
        alert(data.message);
        $location.path('/waiting-sim');
      });
    };


    $scope.submit = function(user){
      $http.put(BASE_URL+'activate_platform/editWatingSIMByUser/'+Id, user).success(function(data) {
       alert(data.message);
       $route.reload();
      
      });
    };
});

myCustomApp.controller('waitingSimCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'activate_platform/getwaitingSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getwaitingSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/waiting-sim');
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

myCustomApp.controller('simNumberCtr', function($scope, $http, $route, $location, $routeParams){

    $scope.add = function(user){
      $http.put(BASE_URL +'activate_platform/addSim', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };

   $http.get(BASE_URL + 'activate_platform/getSimList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'activate_platform/getSimList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/sim-number');
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


    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'activate_platform/deleteSim', user).success(function(){         
            $route.reload();
        });
      }
    };
});






myCustomApp.controller('newsSectionCtr', function($scope, $http, $route, $location, $routeParams){

    $scope.add = function(user){
      $http.put(BASE_URL +'news_section_ctr/addNews', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };

   $http.get(BASE_URL + 'news_section_ctr/getNewsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'news_section_ctr/getNewsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/news-section');
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


    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'news_section_ctr/deleteNews', user).success(function(){         
            $route.reload();
        });
      }
    };
});


myCustomApp.controller('viewBounceChequeCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'deposit_ctr/getDepositByID/'+id).success(function(data){
        $scope.List = data;
    });


    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/releaseHoldDeposit', user).success(function(data){ 
             alert(data.message);    
          
        });
      }
    };

    
});


myCustomApp.controller('bounceChequeCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'deposit_ctr/getBounceDepositList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'deposit_ctr/getBounceDepositList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/bounce-cheque');
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



    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/releaseHoldDeposit', user).success(function(data){ 
             alert(data.message);    
           $route.reload();
        });
      }
    };


});


myCustomApp.controller('suscriptionDeactivateCtr', function($scope, $http,  $route, $location, $routeParams){
  $http.get(BASE_URL +'changes_card/suscriptionDeactivateList').success(function(data){
      $scope.List=data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
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
  
  $scope.cardChangeDone = function(sub){
    var cancelSuscription = confirm('Are you absolutely sure ?');
    if (cancelSuscription) {
      $http.post(BASE_URL +'changes_card/updatesuScriptionDeactivateList',sub).success(function(data){
        alert(data.message);    
           $route.reload();
      });
    }
  };
});


myCustomApp.controller('suscriptionChangeCtr', function($scope, $http,  $route, $location, $routeParams){
  $http.get(BASE_URL +'changes_card/suscriptionChangeList').success(function(data){
      $scope.List=data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
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
  
  $scope.cardChangeDone = function(sub){
    var cancelSuscription = confirm('Are you absolutely sure ?');
    if (cancelSuscription) {
      $http.post(BASE_URL +'changes_card/updateChangeCardList',sub).success(function(data){
        alert(data.message);    
           $route.reload();
      });
    }
  };
});



myCustomApp.controller('cancleUpgradeCtr', function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL +'userLoginStatus/cancelUpgradeList').success(function(data){
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
      $http.post(BASE_URL +'userLoginStatus/cancelUpgrade',sub).success(function(data){
        var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
        $('#message').html(message);
      });
    }
  };
});

myCustomApp.controller('couponsViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'redeem_coupons/getCouponsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'redeem_coupons/getCouponsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/coupons-view');
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


myCustomApp.controller('rejectedCashoutViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'cashout/getRejectedCashoutList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'cashout/getRejectedCashoutList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/rejected-cashout-view');
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


myCustomApp.controller('viewBuyStoreCreditUserInfoCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'transferEarning/getBuyStoreCreditUserInfoByID/'+id).success(function(data){
        $scope.List = data;
    });
});

myCustomApp.controller('buyStoreCreditUserInfoCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'transferEarning/getBuyStoreCreditUserInfoList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'transferEarning/getBuyStoreCreditUserInfoList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/buy-store-credit-user-info');
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





myCustomApp.controller('viewApproveChequeDepositViewCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'deposit_ctr/getDepositByID/'+id).success(function(data){
        $scope.List = data;
    });
});
myCustomApp.controller('viewChequeDepositViewCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'deposit_ctr/getDepositByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/approveChequeDeposit', user).success(function(data){ 
             alert(data.message);    
           //$route.reload();
        });
      }
    };

});
myCustomApp.controller('approveChequeDepositViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'deposit_ctr/getApproveChequeDepositList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'deposit_ctr/getApproveChequeDepositList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/approve-cheque-deposit-view');
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

myCustomApp.controller('chequeDepositViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'deposit_ctr/getChequeDepositList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'deposit_ctr/getChequeDepositList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/cheque-deposit-view');
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



    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/approveChequeDeposit', user).success(function(data){ 
             alert(data.message);    
           //$route.reload();
        });
      }
    };
});

myCustomApp.controller('viewHoldDepositViewCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'deposit_ctr/getDepositByID/'+id).success(function(data){
        $scope.List = data;
    });


    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/releaseHoldDeposit', user).success(function(data){ 
             alert(data.message);    
          
        });
      }
    };


    $scope.bounce = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/bounceHoldDeposit', user).success(function(data){ 
             alert(data.message);    
           
        });
      }
    };

    
});
myCustomApp.controller('viewRejectedDepositViewCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'deposit_ctr/getDepositByID/'+id).success(function(data){
        $scope.List = data;
    });
});
myCustomApp.controller('rejectedDepositViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'deposit_ctr/getRejectedDepositList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'deposit_ctr/getRejectedDepositList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/rejected-deposit-view');
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

myCustomApp.controller('holdDepositViewCtr', function($scope, $http, $route, $location, $routeParams){
    
    $http.get(BASE_URL + 'deposit_ctr/getHoldDepositList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'deposit_ctr/getHoldDepositList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/hold-deposit-view');
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



    $scope.release = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/releaseHoldDeposit', user).success(function(data){ 
             alert(data.message);    
           $route.reload();
        });
      }
    };

    $scope.bounce = function(user){
      var sure = confirm('Are you absolutely sure?');
      if (sure) {
       
        $http.put(BASE_URL +'deposit_ctr/bounceHoldDeposit', user).success(function(data){ 
             alert(data.message);    
           $route.reload();
        });
      }
    };


});

myCustomApp.controller('platformUserMappingCtr', function($scope, $http, $route, $location, $routeParams){

    $http.get(BASE_URL + 'platform/getUserName').success(function(data){
        $scope.UList = data;
    });
    $http.get(BASE_URL + 'platform/getPlatformName').success(function(data){
        $scope.PList = data;
    });

    $scope.add = function(user){
      $http.put(BASE_URL +'platform/addMapping', user).success(function(data){         
          alert(data.message);
          $route.reload();
      });
    };

    $http.get(BASE_URL + 'platform/getMapping').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; 
      $scope.entryLimit = 10; 
      $scope.filteredItems = $scope.List.length; 
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

    $scope.delete = function(user){
      var deleteMapping = confirm('Are you absolutely sure you want to delete?');
      if (deleteMapping) {
        $http.put(BASE_URL +'platform/deleteMapping', user).success(function(){         
            $route.reload();
        });
      }
    };
});

myCustomApp.controller('addSponsorCtr', function($scope, $http, $route, $location, $routeParams){

    $http.get(BASE_URL + 'add_sponsor/getUserForSponsor').success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'add_sponsor/updateSponsor', user).success(function(data){         
          // var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          // $('#message').html(message);
         
          alert(data.message);
          $route.reload();
      });
    };
});

myCustomApp.controller('followupNewLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getNewLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getNewLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-new-leads');
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

myCustomApp.controller('updateFollowupNewLeadsCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'followup_leads/getNewLeadsListByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'followup_leads/updateNewLeadsListByID', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});
myCustomApp.controller('followupColdLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getColdLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getColdLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-cold-leads');
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

myCustomApp.controller('updateFollowupColdLeadsCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'followup_leads/getColdLeadsListByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'followup_leads/updateColdLeadsListByID', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});
myCustomApp.controller('followupWarmLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getWarmLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getWarmLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-warm-leads');
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

myCustomApp.controller('updateFollowupWarmLeadsCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'followup_leads/getWarmLeadsListByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'followup_leads/updateWarmLeadsListByID', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});

myCustomApp.controller('followupHotLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getHotLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getHotLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-hot-leads');
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

myCustomApp.controller('updateFollowupHotLeadsCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'followup_leads/getHotLeadsListByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'followup_leads/updateHotLeadsListByID', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});
myCustomApp.controller('followupClosedLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getClosedLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getClosedLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-closed-leads');
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

myCustomApp.controller('updateFollowupClosedLeadsCtr', function($scope, $http, $location, $routeParams){
    var id = $routeParams.id;
    $http.get(BASE_URL + 'followup_leads/getClosedLeadsListByID/'+id).success(function(data){
        $scope.List = data;
    });

    $scope.update = function(user){
      $http.put(BASE_URL +'followup_leads/updateClosedLeadsListByID', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});

myCustomApp.controller('followupEmployeeLeadsCtr', function($scope, $http, $location, $routeParams){
    
    $http.get(BASE_URL + 'followup_leads/getEmployeeLeadsList').success(function(data){
      $scope.List = data;
      $scope.currentPage = 1; //current page
      $scope.entryLimit = 10; //max no of items to display in a page
      $scope.filteredItems = $scope.List.length; //Initially for no filter  
      $scope.totalItems = $scope.List.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'followup_leads/getEmployeeLeadsList', dateRangeSearch).success(function(data){
          $scope.List = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.List.length; //Initially for no filter  
          $scope.totalItems = $scope.List.length;
          $location.path('/followup-employee-leads');
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
          wsloader(true);
          $http.put(BASE_URL+'upgrade/upgradeUser', user).success(function(data) {
              wsloader(false);
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

    $http.get(BASE_URL + 'upgrade/getTotalStoreCreditById').success(function(data){
       $scope.creditTotal = data.total;
    });
    $http.get(BASE_URL + 'upgrade/getTotalDeductStoreCreditById').success(function(data){
      $scope.dedutTotal = data.total;
    });


    $scope.upgradeUser = function(user){
          wsloader(true);
          $http.put(BASE_URL+'upgrade/upgradeUserByUser', user).success(function(data) {
              wsloader(false);
              alert(data.message);
          });
    };
	/* $scope.upgradeUser = function(user){
          $http.put(BASE_URL+'upgrade/upgradeUser', user).success(function(data) {
              alert(data.message);
          });
    }; */
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

  	$scope.filter = function(){      
  	};

  	$scope.sort_by = function(predicate) {
      	$scope.predicate = predicate;
      	$scope.reverse = !$scope.reverse;
 	  }; 
});

myCustomApp.controller('cancleSubscriptionCtr', function($scope, $http, $location, $routeParams){
	$http.get(BASE_URL +'userLoginStatus/cancelSubscriptionList').success(function(data){
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
		var cancelSuscription = confirm('Are you absolutely sure you want to cancel User Account ?');
		if (cancelSuscription) {
			$http.post(BASE_URL +'userLoginStatus/cancelSubscription',sub).success(function(data){
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
	$http.get(BASE_URL+"upgrade/getInactiveUser").success(function(data){
		$scope.userDATA = data;
	});
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
  $scope.setPage1 = function(pageNo) {
      $scope.currentPage1 = pageNo;
  };
  $scope.filter1 = function() {
    
  };
  $scope.sort_by1 = function(predicate) {
      $scope.predicate1 = predicate;
      $scope.reverse1 = !$scope.reverse1;
  };
  
});

myCustomApp.controller('notificationReportCtr', function($scope, $http, $route, $location, $routeParams){ 
    $http.get(BASE_URL+'notification/newOrderTab').success(function(data) {
        $scope.newOrderTabList = data;
    });   
    $http.get(BASE_URL + 'notification/getNewUserSignupsCount').success(function(data){
        $scope.archiveMemberTotal = data;
    });
    $http.get(BASE_URL + 'notification/getTotalUpgradeUser').success(function(data){
        $scope.archiveUpgradeUserTotal = data;
    });
});

myCustomApp.controller('orderArchiveReportCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'archive/productOrderSummary').success(function(data){
        $scope.productOrderList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.productOrderList.length; //Initially for no filter  
        $scope.totalItems = $scope.productOrderList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/productOrderSummary', dateRangeSearch).success(function(data){
          $scope.productOrderList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.productOrderList.length; //Initially for no filter  
          $scope.totalItems = $scope.productOrderList.length;
          $location.path('/order-archive-report');
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

myCustomApp.controller('newMemberArchiveReportCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'archive/getNewMemberSummary').success(function(data){
        $scope.newMemberArchiveReportList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.newMemberArchiveReportList.length; //Initially for no filter  
        $scope.totalItems = $scope.newMemberArchiveReportList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/getNewMemberSummary', dateRangeSearch).success(function(data){
          $scope.newMemberArchiveReportList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.newMemberArchiveReportList.length; //Initially for no filter  
          $scope.totalItems = $scope.newMemberArchiveReportList.length;
          $location.path('/new-member-archive-report');
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

myCustomApp.controller('updateNewMemberArchiveReportCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.uID;
    $http.get(BASE_URL + 'archive/getNewMemberSummaryByID/'+ID).success(function(data){
        $scope.newMemberArchiveReportByIDList = data;
    });

    $scope.update = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/updateNewMemberSummary', user).success(function(data){         
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});

myCustomApp.controller('upgradeMemberArchiveReportCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'archive/upgradeUserList').success(function(data){
        $scope.upgradeUserList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.upgradeUserList.length; //Initially for no filter  
        $scope.totalItems = $scope.upgradeUserList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/upgradeUserList', dateRangeSearch).success(function(data){
          $scope.upgradeUserList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.upgradeUserList.length; //Initially for no filter  
          $scope.totalItems = $scope.upgradeUserList.length;
          $location.path('/upgrade-member-archive-report');
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

myCustomApp.controller('updateUpgradeMemberArchiveReportCtr', function($scope, $http, $location, $routeParams){
    var upgradeID = $routeParams.upgradeID;
    $http.get(BASE_URL + 'archive/getUpgradeListById/'+upgradeID).success(function(data){
        $scope.upgradeArchiveReportList = data;
    });

    $scope.update = function(user){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/updateUpgradeArchiveReport', user).success(function(data){
          var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
          $('#message').html(message);
      });
    };
});

myCustomApp.controller('productArchiveOrderSummaryCtr', function($scope, $http, $route, $location, $routeParams){
  var ID = $routeParams.odid;
  
  
  $http.get(BASE_URL+'archive/productOrderSummaryView/'+ID).success(function(data) {
    $scope.list = data;
  });

  $scope.addsubmit = function(user){
      $http.put(BASE_URL+'update_address_ctr/updateOrderAddress', user).success(function(data) {
      alert(data.message);
      $route.reload();
      });
    };

    $http.get(BASE_URL+'archive/getVoucherOrderFromActivation/'+ID).success(function(data){
        $scope.htmlVoucherFromActivationList = data;
    });

  $scope.orderStatus = function(user){
    $http.put(BASE_URL+'archive/updateOrderStatus/', user).success(function(data) {
		 if(data.message != null){
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
              alert(data.message);
            $route.reload();
          }else{
              var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.message+'</strong></div>';
              $('#message').html(message);
          }
    });
  };

    $scope.orderReject = function(user){
      var reject = confirm('Are you absolutely sure you want to Reject?');
      if (reject) {
        $scope.activePath = null;
        $http.put(BASE_URL+'product/rejectOrderForBackOffice/', user).success(function(data) {
        alert(data.message);
        });
       $location.path('/order-archive-report');
      }
    };

   $http.get(BASE_URL+'archive/getSimOrder/'+ID).success(function(data){
        $scope.getSimList = data;
    });

   $scope.simchange = function(user){
      if(user.sim_no.length === 20){
        $http.put(BASE_URL+'archive/addSimOrder',user).success(function(data){
            if(data.err != null){
              alert(data.err);
            }else{
              var message = '<div class="alert alert-info fade in"><button onclick="deleteSim('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
              $('#add-sim').append(message);
               $("#add-sim-no").val("");
            }
        });
      }
    };

    $scope.addSim = function(user){
      $http.put(BASE_URL+'archive/addSimOrder',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteSim('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-sim').append(message);
             $("#add-sim-no").val("");
          }
      });
    };
    // $scope.deleteSim = function(simNo){
    //   $http.put(BASE_URL+'archive/deleteSimOrde/'+simNo).success(function(data){
    //     $route.reload();
    //   });
    // };

    $scope.deletePrevSim = function(simNo){
      $http.put(BASE_URL+'archive/deletePrevSim/'+simNo).success(function(data){
        $route.reload();
      });
    };


    $http.get(BASE_URL+'archive/getVoucherOrder/'+ID).success(function(data){
        $scope.getVoucherList = data;
    });

   $scope.voucherchange = function(user){
      if(user.si_no.length === 8){
        $http.put(BASE_URL+'archive/addVoucherOrder',user).success(function(data){
            if(data.err != null){
              alert(data.err);
            }else{
              var message = '<div class="alert alert-info fade in"><button onclick="deleteVoucher('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
              $('#add-voucher').append(message);
               $("#add-voucher-no").val("");
            }
        });
      }
    };

    $scope.addVoucher = function(user){
      $http.put(BASE_URL+'archive/addVoucherOrder',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteVoucher('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-voucher').append(message);
             $("#add-voucher-no").val("");
          }
      });
    };

    $scope.deletePrevVoucher = function(simNo){
      $http.put(BASE_URL+'archive/deletePrevVoucher/'+simNo).success(function(data){
        $route.reload();
      });
    };


    $scope.uspsid = function(user){
      var statemodifide;
      var statestaet =user.state;
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
      if(user.p_id == 98 && user.p_qty == 1){
        servicetype = 'FIRST CLASS';
      }

       servicetype = user.shipping_method;
      //single sim  stander.....
      if(servicetype == ''){
        servicetype = 'PRIORITY';
      }

      var weight = 3;
        $http({
            method  : 'GET',
            url     : 'https://secure.shippingapis.com/ShippingAPI.dll?API=DeliveryConfirmationV4&XML=<DeliveryConfirmationV4.0Request USERID="892ONLEG1078"><FromName>Shipping Department</FromName><FromFirm>Onlegacy Network</FromFirm><FromAddress1>1231 8TH ST</FromAddress1><FromAddress2>STE 300</FromAddress2><FromCity>MODESTO</FromCity><FromState>CA</FromState><FromZip5>95354</FromZip5><FromZip4>2235</FromZip4><ToName>'+user.first_name+' '+user.last_name+'</ToName><ToFirm></ToFirm><ToAddress1>'+user.address1+'</ToAddress1><ToAddress2>'+user.address1+'</ToAddress2><ToCity>'+user.city+'</ToCity><ToState>'+statemodifide+'</ToState><ToZip5>'+user.zip+'</ToZip5><ToZip4/><WeightInOunces>'+weight+'</WeightInOunces><ServiceType>'+servicetype+'</ServiceType><SeparateReceiptPage>False</SeparateReceiptPage><ImageType>PDF</ImageType></DeliveryConfirmationV4.0Request>',
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


             user.delivery_status = 'Shipped';
             user.shipped_via = 'USPS';
             
             var res = y.substring(8);
             user.tracking_id = res;
             var today = new Date();
             user.shipping_date = today.toISOString().substring(0, 10);
             

        });
    };



});


myCustomApp.controller('archiveReportViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'archive/archiveReportView').success(function(data){
        $scope.archiveReportViewList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.archiveReportViewList.length; //Initially for no filter  
        $scope.totalItems = $scope.archiveReportViewList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/archiveReportView', dateRangeSearch).success(function(data){
          $scope.archiveReportViewList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.archiveReportViewList.length; //Initially for no filter  
          $scope.totalItems = $scope.archiveReportViewList.length;
          $location.path('/archive-report-view');
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

myCustomApp.controller('archiveReportUpdateCtr', function($scope, $route, $http, $location, $routeParams){
    var archiveID = $routeParams.arID;
    $http.get(BASE_URL + 'archive/archiveReportEditView/'+archiveID).success(function(data){
        $scope.archiveReportViewByIDList = data;
    });

    $scope.addsubmit = function(user){
      $http.put(BASE_URL+'update_address_ctr/updateMemberAddress', user).success(function(data) {
      alert(data.message);
      $route.reload();
      });
    };

    $http.get(BASE_URL+'archive/getVoucherFromActivation/'+archiveID).success(function(data){
        $scope.htmlVoucherFromActivationList = data;
    });

    $scope.update = function(report){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/updateArchiveReport', report).success(function(data){
          if(data.sucess != null){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
            $('#message').html(message);
            alert(data.sucess);
            $route.reload();
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
            $('#message').html(message);
          }
      });
    };
	
	$scope.showShippingStatus = function(id){
      $http.get(BASE_URL+'archive/getUserPackageShippingStatus/'+id+'/'+archiveID).success(function(data){
          if(data.err != null){
            alert('No previous data found');
          }else{
            $scope.prevPkgDetails = data;          
            $scope.prevPkg = '1';            
          }
      });
    };  
	
	$http.get(BASE_URL+'archive/getSim/'+archiveID).success(function(data){
        $scope.getSimList = data;
    });

    $scope.simchange = function(user){
      if(user.sim_no.length === 20){
        $http.put(BASE_URL+'archive/addSim',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteSim('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-sim').append(message);
             $("#add-sim-no").val("");
          }
      });
      }
    };

    $scope.addSim = function(user){
      $http.put(BASE_URL+'archive/addSim',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteSim('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-sim').append(message);
			       $("#add-sim-no").val("");
          }
      });
    };

    $scope.deletePrevSim = function(simNo){
      $http.put(BASE_URL+'archive/deletePrevSim/'+simNo).success(function(data){
		$route.reload();
      });
    };




     $http.get(BASE_URL+'archive/getVoucher/'+archiveID).success(function(data){
        $scope.getVoucherList = data;
    });

     $scope.voucherchange = function(user){
      if(user.si_no.length === 8){
       $http.put(BASE_URL+'archive/addVoucher',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteVoucher('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-voucher').append(message);
             $("#add-voucher-no").val("");
          }
      });
      }
    };

    $scope.addVoucher = function(user){
      $http.put(BASE_URL+'archive/addVoucher',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteVoucher('+data.last_id+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-voucher').append(message);
             $("#add-voucher-no").val("");
          }
      });
    };

    $scope.deletePrevVoucher = function(simNo){
      $http.put(BASE_URL+'archive/deletePrevVoucher/'+simNo).success(function(data){
        $route.reload();
      });
    };


    $scope.uspsid = function(user){
      var statemodifide;
      var statestaet =user.state;
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
       // servicetype = 'FIRST CLASS';
      //}

      servicetype = user.shipping_method;
      //single sim  stander.....
      if(servicetype == ''){
        servicetype = 'PRIORITY';
      }

      var weight = 3;
        $http({
            method  : 'GET',
            url     : 'https://secure.shippingapis.com/ShippingAPI.dll?API=DeliveryConfirmationV4&XML=<DeliveryConfirmationV4.0Request USERID="892ONLEG1078"><FromName>Shipping Department</FromName><FromFirm>Onlegacy Network</FromFirm><FromAddress1>1231 8TH ST</FromAddress1><FromAddress2>STE 300</FromAddress2><FromCity>MODESTO</FromCity><FromState>CA</FromState><FromZip5>95354</FromZip5><FromZip4>2235</FromZip4><ToName>'+user.first_name+' '+user.last_name+'</ToName><ToFirm></ToFirm><ToAddress1>'+user.address1+'</ToAddress1><ToAddress2>'+user.address2+'</ToAddress2><ToCity>'+user.city+'</ToCity><ToState>'+statemodifide+'</ToState><ToZip5>'+user.zip+'</ToZip5><ToZip4/><WeightInOunces>'+weight+'</WeightInOunces><ServiceType>'+servicetype+'</ServiceType><SeparateReceiptPage>False</SeparateReceiptPage><ImageType>PDF</ImageType></DeliveryConfirmationV4.0Request>',
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


             user.archive_member_status = 'shipped';
             user.shipe_via = 'USPS';
             
             var res = y.substring(8);
             user.shipping_code = res;
             var today = new Date();
             user.shipp_date = today.toISOString().substring(0, 10);
             

        });
    };






});


myCustomApp.controller('memberShippingArchiveReportViewCtr', function($scope, $http, $location, $routeParams){
    $http.get(BASE_URL + 'archive/memberShippingArchiveReportView').success(function(data){
        $scope.archiveReportViewList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.archiveReportViewList.length; //Initially for no filter  
        $scope.totalItems = $scope.archiveReportViewList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/memberShippingArchiveReportView', dateRangeSearch).success(function(data){
          $scope.archiveReportViewList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.archiveReportViewList.length; //Initially for no filter  
          $scope.totalItems = $scope.archiveReportViewList.length;
          $location.path('/member-shipping-archive-report-view');
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

myCustomApp.controller('memberShippingArchiveReportUpdateCtr', function($scope, $http, $location, $routeParams){
    var archiveID = $routeParams.msarID;
    $http.get(BASE_URL + 'archive/archiveReportEditView/'+archiveID).success(function(data){
        $scope.archiveReportViewByIDList = data;
    });

    $scope.update = function(report){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/updateArchiveReport', report).success(function(data){
          if(data.sucess != null){
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.sucess+'</strong></div>';
            $('#message').html(message);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="reditect()" data-dismiss="alert" class="close" type="button">×</button><strong>'+data.err+'</strong></div>';
            $('#message').html(message);
          }
      });
    };
	
	$scope.showShippingStatus = function(id){
      $http.get(BASE_URL+'archive/getUserPackageShippingStatus/'+id+'/'+archiveID).success(function(data){
          if(data.err != null){
            alert('No previous data found');
          }else{
            $scope.prevPkgDetails = data;          
            $scope.prevPkg = '1';            
          }
      });
    }; 
	
	$http.get(BASE_URL+'archive/getSim/'+archiveID).success(function(data){
        $scope.getSimList = data;
    });

    $scope.addSim = function(user){
      $http.put(BASE_URL+'archive/addSim',user).success(function(data){
          if(data.err != null){
            alert(data.err);
          }else{
            var message = '<div class="alert alert-info fade in"><button onclick="deleteSim('+data.sim_no+')" data-dismiss="alert" class="close" type="button"><span class="glyphicon glyphicon-trash"></span></button><strong>'+data.sim_no+'</strong></div>';
            $('#add-sim').append(message);
          }
      });
    }; 

     $scope.deletePrevSim = function(numberId){
      alert('OK');
      $http.put(BASE_URL+'archive/deleteSim/'+numberId).success(function(data){

      });
    }; 
});

myCustomApp.controller('depositArchiveReportViewCtr', function($scope, $http, $location, $routeParams){
  $http.get(BASE_URL + 'archive/depositArchiveView').success(function(data){
        $scope.depositArchiveList = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
        $scope.filteredItems = $scope.depositArchiveList.length; //Initially for no filter  
        $scope.totalItems = $scope.depositArchiveList.length;
    });

    $scope.update = function(dateRangeSearch){
      $scope.activePath = null;
      $http.put(BASE_URL +'archive/depositArchiveView', dateRangeSearch).success(function(data){
          $scope.depositArchiveList = data;
          $scope.currentPage = 1; //current page
          $scope.entryLimit = 20; //max no of items to display in a page
          $scope.filteredItems = $scope.depositArchiveList.length; //Initially for no filter  
          $scope.totalItems = $scope.depositArchiveList.length;
          $location.path('/deposit-archive-report-view');
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

myCustomApp.controller('depositArchiveReportUpdateCtr', function($scope, $http, $location, $routeParams){
    var ID = $routeParams.d_id;
    $scope.activePath = null;

    $http.get(BASE_URL+'archive/getDepositImageById/'+ID).success(function(data) {
      $scope.depositData = data;
    });
    
    $scope.update = function(user){
      $http.put(BASE_URL+'archive/updateDepositStatus/'+ID,user).success(function(data) {
       alert(data.message);
       $location.path('/deposit-archive-report-view');
      });
    };

});

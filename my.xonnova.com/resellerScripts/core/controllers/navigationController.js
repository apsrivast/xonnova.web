angular
  .module('theme.core.navigation_controller', ['theme.core.services'])
  .controller('NavigationController', ['$scope', '$http', '$location', '$timeout', function($scope, $http, $location, $timeout) {
    'use strict';
      $http.get(BASE_URL +'language/menuLabel').success(function(data){
        $scope.menu = [{
          label: 'Overview',
          iconClasses: '',
          separator: true
        },

          {
           label: data.dashboard,
           iconClasses: 'glyphicon glyphicon-home',
           url: '#/'
         },
		//, {
        // label: 'Shipping Management',
        // iconClasses: 'glyphicon glyphicon-th-list',
        // html: '<span class="badge badge-indigo"></span>',
        // url: '#/user-shipping-management'
        // }, {
        //   label: data.lng_team,
        //   iconClasses: 'glyphicon glyphicon-th-list',
        //   html: '<span class="badge badge-warning"></span>',
        //   children: [{
        //     label: data.lng_binary_view,
        //     url: '#/board-view'
        //   },{
        //     label: data.lng_unilevel_view,
        //     url: '#/unilevel-view'
        //   }, {
        //     label: data.lng_add_new_member,
        //     url: '#/add-new-member'
        //   },{
        //     label: data.lng_personal_referrals,
        //     url: '#/personal-referrals'
        //   }]
        // },
       
        //  {
        //   label: data.lng_store,
        //   iconClasses: 'glyphicon glyphicon-th-list',
        //   url: '#/product-view'
        // },
       
        {
          label: data.money,
          iconClasses: 'glyphicon glyphicon-usd',
          html: '<span class="badge badge-indigo"></span>',
          children: [
          // {
          //   label: data.lng_earnings,
          //   url: '#/earnings'
          // }, {
          //   label: 'Buy Store Credit',
          //   url: '#/transfer-earning-to-stor-credit'
          // }, {
          //   label: 'Redeem Coupon',
          //   url: '#/redeem-coupons'
          // }
          // , {
          //   label: 'Buy Store Credit2',
          //   url: '#/buy-store-credit'
          // }, {
          //   label: data.lng_reward_points,
          //   url: '#/reward-points'
          // },  {
          //   label: data.lng_cashout,
          //   url: '#/cashout'
          // }, {
          //   label: 'Change Bank Info For Cashout',
          //   url: '#/change-bank-info-for-cashout'
          // },  
          {
            label: data.upload_deposit,
            url: '#/upload-deposit'
          }, {
            label: data.deposit_list,
            url: '#/user-deposit-list'
          }]
       
     
        },
        {
          label: data.business,
          iconClasses: 'glyphicon glyphicon-inbox',
          html: '<span class="badge badge-indigo"></span>',
          children: [
		   {
            label: 'Activate Sim By Store Credit',
            url: '#/activate-platform-store'
          },
          {
            label: data.activate_your_sim,
            url: '#/activate-platform'
          }
		 /*  , {
            label: 'Activate OL Voucher',
            url: '#/activate-ol-voucher'
          } */
		  , {
            label: 'INSTALLATION KIT ',
            url: '#/buy-a-sim-reseller'
          }, {
            label: 'Transfer SIM ',
            url: '#/transfer-sim-store'
          } , {
            label: 'SIM # List',
            url: '#/reseller-sim-number-list'
          }
		  
          , {
            label: 'Activation List',
            url: '#/reseller-activation-list'
          }
		  
          , {
            label: 'Waiting Phone # List',
            url: '#/reseller-waiting-phone-list'
          }
		  
		  , {
            label: 'Approve Phone # List',
            url: '#/approve-waiting-phone-list'
          }
		  
          // , 
          // {
          //   label: data.lng_mexico_topUp,
          //   url: '#/mexico-topup'
          // },
          // // {
          // //   label: 'Third Party Platforms',
          // //   url: '#/third-party-platforms'
          // // },
          // {
          // label: data.lng_order_summary,
          //   url: '#/user-product-order-summary'
          // }, {
          //   label: data.lng_new_order_summary,
          //   url: '#/user-new-product-order-summary'
          // },{
          //   label: data.lng_request_platforms,
          //   url: '#/new-platforms'
          // }, {
          //   label: 'Refer A Store',
          //   url: '#/refer-a-store'
          // }
          ]
        },{
        label: 'Orders',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        url: '#/order-status'
        }, 
        // {
        // label: data.lng_tools,
        // iconClasses: 'glyphicon glyphicon-home',
        // html: '<span class="badge badge-indigo"></span>',      
        // children: [{
        // label: data.lng_send_leads,
        // url: '#/new-leads'
        //   }, {
        //     label: data.lng_leads_progress,
        //     url: '#/user-leads-list'
        //   }, {
        //     label: 'Training Videos',
        //     url: '#/view-training-videos'
        //   }, {
        //     label: 'Marketing Materials',
        //     url: '#/view-marketing-materials'
        //   }]

        //    },
          {
           label: data.account,
          iconClasses: 'glyphicon glyphicon-inbox',
           html: '<span class="badge badge-indigo"></span>',
           children: [{
        //     label: 'Rank Status',
        //     url: '#/user-ranks'
        //   },
        //   //  {
        //   //   label: 'Entrepreneurial Status',
        //   //   url: '#/entrepreneurial-status'
        //   // },
        //   {
        //     label: data.lng_profile,
        //     url: '#/profile'
        //   }, {
             label: 'Profile',
            url: '#/change-password'
           }
		  // , {
        //     label: data.lng_manage_subscription,
        //     url: '#/cancle-user-subscription'
        //   }, {
        //     label: data.lng_upgrade,
        //     url: '#/user-upgrade'
        //   }, {
        //     label: 'Change Card Subscription',
        //     url: '#/deactivates-changes-card'
        //   }, {
        //     label: 'Deactivate Subscription',
        //     url: '#/deactivates-subscription'
        //   }
          ]
         }, 
		 //{      
        //   label: data.lng_entrepreneurial_bonus,      
        //   iconClasses: 'glyphicon glyphicon-th-list',      
        //   url: '#/entrepreneurial-bonus-by-user'      
        // },
         {
      label: data.sign_out,
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      url: BASE_URL+'signingreseller/logout'
      }];


        var setParent = function(children, parent) {
          angular.forEach(children, function(child) {
            child.parent = parent;
            if (child.children !== undefined) {
              setParent(child.children, child);
            }
          });
        };

        $scope.findItemByUrl = function(children, url) {
          for (var i = 0, length = children.length; i < length; i++) {
            if (children[i].url && children[i].url.replace('#', '') === url) {
              return children[i];
            }
            if (children[i].children !== undefined) {
              var item = $scope.findItemByUrl(children[i].children, url);
              if (item) {
                return item;
              }
            }
          }
        };

        setParent($scope.menu, null);

        $scope.openItems = []; $scope.selectedItems = []; $scope.selectedFromNavMenu = false;

        $scope.select = function(item) {
          // close open nodes
          if (item.open) {
            item.open = false;
            return;
          }
          for (var i = $scope.openItems.length - 1; i >= 0; i--) {
            $scope.openItems[i].open = false;
          }
          $scope.openItems = [];
          var parentRef = item;
          while (parentRef !== null) {
            parentRef.open = true;
            $scope.openItems.push(parentRef);
            parentRef = parentRef.parent;
          }

          // handle leaf nodes
          if (!item.children || (item.children && item.children.length < 1)) {
            $scope.selectedFromNavMenu = true;
            for (var j = $scope.selectedItems.length - 1; j >= 0; j--) {
              $scope.selectedItems[j].selected = false;
            }
            $scope.selectedItems = [];
            parentRef = item;
            while (parentRef !== null) {
              parentRef.selected = true;
              $scope.selectedItems.push(parentRef);
              parentRef = parentRef.parent;
            }
          }
        };

        $scope.highlightedItems = [];
        var highlight = function(item) {
          var parentRef = item;
          while (parentRef !== null) {
            if (parentRef.selected) {
              parentRef = null;
              continue;
            }
            parentRef.selected = true;
            $scope.highlightedItems.push(parentRef);
            parentRef = parentRef.parent;
          }
        };

        var highlightItems = function(children, query) {
          angular.forEach(children, function(child) {
            if (child.label.toLowerCase().indexOf(query) > -1) {
              highlight(child);
            }
            if (child.children !== undefined) {
              highlightItems(child.children, query);
            }
          });
        };

        // $scope.searchQuery = '';
        $scope.$watch('searchQuery', function(newVal, oldVal) {
          var currentPath = '#' + $location.path();
          if (newVal === '') {
            for (var i = $scope.highlightedItems.length - 1; i >= 0; i--) {
              if ($scope.selectedItems.indexOf($scope.highlightedItems[i]) < 0) {
                if ($scope.highlightedItems[i] && $scope.highlightedItems[i] !== currentPath) {
                  $scope.highlightedItems[i].selected = false;
                }
              }
            }
            $scope.highlightedItems = [];
          } else
          if (newVal !== oldVal) {
            for (var j = $scope.highlightedItems.length - 1; j >= 0; j--) {
              if ($scope.selectedItems.indexOf($scope.highlightedItems[j]) < 0) {
                $scope.highlightedItems[j].selected = false;
              }
            }
            $scope.highlightedItems = [];
            highlightItems($scope.menu, newVal.toLowerCase());
          }
        });

        $scope.$on('$routeChangeSuccess', function() {
          if ($scope.selectedFromNavMenu === false) {
            var item = $scope.findItemByUrl($scope.menu, $location.path());
            if (item) {
              $timeout(function() {
                $scope.select(item);
              });
            }
          }
          $scope.selectedFromNavMenu = false;
          $scope.searchQuery = '';
        });
    });
  }]);
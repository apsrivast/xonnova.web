angular
  .module('theme.core.navigation_controller', ['theme.core.services'])
  .controller('NavigationController', ['$scope', '$location', '$timeout', function($scope, $location, $timeout) {
    'use strict';
    $scope.menu = [{
      label: 'Overview',
      iconClasses: '',
      separator: true
    }, {
      label: 'Dashboard',
      iconClasses: 'glyphicon glyphicon-home',
      url: '#/'
    }, {
      label: 'Team',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-warning"></span>',
      children: [{
        label: 'Binary View',
        url: '#/board-view'
      }, /* {
        label: 'Tabular View',
        url: '#/tabular-view'
      }, */{
        label: 'UniLevel View',
        url: '#/unilevel-view'
      }, {
        label: 'Add New Member',
        url: '#/add-new-member'
      },{
        label: 'Holding Tank',
        url: '#/holding-tank'
      },{
        label: 'Personal Referrals',
        url: '#/personal-referrals'
      }]
    },
    //  {
    //   label: 'Upgrade',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Upgrade',
    //     url: '#/user-upgrade'
    //   }, {
    //     label: 'User Upgrade Lists',
    //     url: '#/user-upgrade-list'
    //   }, 
    //   // {
    //   //   label: 'Cancle Subscription',
    //   //   url: '#/cancle-user-subscription'
    //   // }
    //   ]
    // },
     {
      label: 'Store',
      iconClasses: 'glyphicon glyphicon-th-list',
      url: '#/product-view'
    },
    //  {
    //   label: 'Settings',
    //   iconClasses: 'glyphicon glyphicon-cog',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Holding Tank',
    //     url: '#/holding-tank'
    //   }]
    // }, 
    {
      label: 'Money',
      iconClasses: 'glyphicon glyphicon-usd',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Earnings',
        url: '#/earnings'
      }, {
        label: 'Reward Points',
        url: '#/reward-points'
      },  {
        label: 'Cashout',
        url: '#/cashout'
      },  {
        label: 'Upload deposit',
        url: '#/upload-deposit'
      }, {
        label: 'Deposit List',
        url: '#/user-deposit-list'
      }]
   
    // {
    //   label: 'Referrals',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Personal Referrals',
    //     url: '#/personal-referrals'
    //   }
      /* , {
        label: 'UniLevel Referrals',
        url: '#/unilevel-referrals'
      } */
    },
    {
      label: 'Business',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [
      // {
      //   label: 'Activate SIM',
      //   url: '#/Activate_SIM'
      // }, 
      // {
      //   label: 'Mexico TopUp',
      //   url: '#/Mexico_TopUp'
      // }, {
      //   label: 'Third Party Platforms',
      //   url: '#/Third_Party_Platforms'
      // },
      {
      label: 'Order Summary',
        url: '#/user-product-order-summary'
      }, {
        label: 'New Order Summary',
        url: '#/user-new-product-order-summary'
     
      }]
    },
    {
      label: 'Tools',
      iconClasses: 'glyphicon glyphicon-home',
       html: '<span class="badge badge-indigo"></span>',
      
      children: [{
        label: 'Send Leads',
       url: '#/new-leads'
      }, {
        label: 'Leads List',
        url: '#/user-leads-list'
      },
      {
        label: 'Request Platforms',
        url: '#/new-platforms'
      }, {
        label: 'Platforms List',
        url: '#/user-platforms-list'
      }
      ]
      },
     {
      label: 'Account',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Rank Status',
        url: '#/user-ranks'
      },
      {
        label: 'Profile',
        url: '#/profile'
      }, {
        label: 'Change Password',
        url: '#/change-password'
      }, {
        label: 'Cancle Subscription',
        url: '#/cancle-user-subscription'
      },
      {
        label: 'Upgrade',
        url: '#/user-upgrade'
      }
      // , {
      //   label: 'User Upgrade Lists',
      //   url: '#/user-upgrade-list'
      // }

      /* , {
        label: 'Link social media',
        url: '#/link-social-media'
      } */]
    }, /* {
      label: 'Reports',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Purchase report',
        url: '#/purchase-report'
      }, {
        label: 'Referrals',
        url: '#/change-password'
      }, {
        label: 'Contact Responses',
        url: '#/contact-responses'
      }]
    },  *//* {
      label: 'Tools',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Education',
        url: '#/education'
      }, {
        label: 'Training videos',
        url: '#/training-videos'
      }, {
        label: 'Training tools',
        url: '#/training-tools'
      }, {
        label:'Marketing tools',
        url: '#/marketing-tools'
      }, {
        label:'Downloadable docs',
        url: '#/downloadable-docs'
      }, {
        label: 'Email Marketing',
        url: '#/email-marketing'
      }] 
    }, */ 
    // {
    //   label: 'Platforms',
    //   iconClasses: 'glyphicon glyphicon-home',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Request Platforms',
    //     url: '#/new-platforms'
    //   }, {
    //     label: 'Platforms List',
    //     url: '#/user-platforms-list'
    //   }]
    // },
     {
      label: 'Activation Platform',
      iconClasses: 'glyphicon glyphicon-th-list',
      url: '#/activate-platform'
    },
    // {
    //   label: 'Module Report',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   url: '#/user-module-details'
    // },
    //  {
    //   label: 'Orders',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Order Summary',
    //     url: '#/user-product-order-summary'
    //   }, {
    //     label: 'New Order Summary',
    //     url: '#/user-new-product-order-summary'
    //   }]
    // },
    //  {
    //   label: 'Rank',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   url: '#/user-ranks'
    // },
     
    //   {
    //   label: 'MemberShip Report',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   url: '#/membership-report'
    // },
    /* {
      label: 'New Leads',
      iconClasses: 'glyphicon glyphicon-home',
       html: '<span class="badge badge-indigo"></span>',
      url: '#/new-leads'
    }, */ 
    // {
    //   label: 'Email',
    //   iconClasses: 'glyphicon glyphicon-inbox',
    //   html: '<span class="badge badge-indigo"></span>',
    //   children: [{
    //     label: 'Inbox',
    //     url: '#/inbox'
    //   }, {
    //     label: 'Compose',
    //     url: '#/compose-mail'
    //   }, {
    //     label: 'Read',
    //     url: '#/sent-mail'
    //   }]
    // }, 
    {
        label: 'Sign Out',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        url: BASE_URL+'signing/logout'
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
  }]);
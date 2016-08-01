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
    },  {
      label: 'Team',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-warning"></span>',
      children: [{
        label: 'Binary View',
        url: '#/board-view'
      }, /* {
        label: 'Tabular View',
        url: '#/tabular-view'
      }, */ {
        label: 'UniLevel View',
        url: '#/unilevel-view'
      }, {
        label: 'New members',
        url: '#/add-new-member'
      }]
    }, {
      label: 'Settings',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'View Level Configuration',
        url: '#/view-level'
      },{
        label: 'Holding Tank',
        url: '#/holding-tank'
      }, {
        label: 'Add Voucher',
        url: '#/add-voucher'
      }, {
        label: 'Add Package',
        url: '#/add-package'
      }, {
        label: 'View Package',
        url: '#/view-package'
      }, {
        label:'CronJob Settings',
        url: '#/cronjob-setting'
      }]
    }, {
      label: 'Money',
      iconClasses: 'glyphicon glyphicon-usd',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Earnings Report',
        url: '#/earnings-reoprt'
      },/*{
        label: 'Earnings',
        url: '#/earnings'
      },  {
        label: 'Reward Wallet',
        url: '#/reward-wallet'
      },  */{
        label: 'Cashout Earnings',
        url: '#/cashout'
      },{
        label: 'Add Earning ',
        url: '#/add-earning'
      },{
        label: 'Deduct Earning ',
        url: '#/deduct-earning'
      },{
        label: 'Deposit View',
        url: '#/deposit-view'
      }]
    }, {
      label: 'Referrals',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Personal Referrals',
        url: '#/personal-referrals'
      }/* , {
        label: 'UniLevel Referrals',
        url: '#/unilevel-referrals'
      } */]
    }, {
      label: 'Account',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Profile',
        url: '#/profile'
      }, {
        label: 'Change Password',
        url: '#/change-password'
      }/* , {
        label: 'Member Management',
        url: '#/member-management'
      },{
        label: 'Member Report',
        url: '#/member-report'
      } */]
    }, {
      label: 'Upgrade',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Upgrade',
        url: '#/upgrade-user'
      }, {
        label: 'User Upgrade Lists',
        url: '#/user-upgrade-list'
      }, {
        label: 'New User Upgrade List',
        url: '#/new-upgrade-user-list'
      }, {
        label: 'Cancel Suscription',
        url: '#/cancle-subscription'
      }, {
        label: 'Activate Suscription',
        url: '#/activate-subscription'
      }, {
        label: 'Suscription List',
        url: '#/suscription-list'
      }]
    }, {
      label: 'Product Settings',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Add Product',
        url: '#/add-product'
      }, {
        label: 'View Product',
        url: '#/view-product'
      }, {
        label: 'Add Category',
        url: '#/add-category'
      }, {
        label: 'View Category',
        url: '#/view-category'
      }]
    }, {
      label: 'Orders',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Order Summary',
        url: '#/product-order-summary'
      }, {
        label: 'New Order Summary',
        url: '#/new-product-order-summary'
      }]
    }, {              
      label: 'Platforms',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
		children: [{
		  label: 'Requested platforms',
		  url: '#/new-platforms-view'
		}, {
		  label: 'Add Platforms',
		  url: '#/add-platforms'
		}, {
		  label: 'Platforms List',
		  url: '#/platforms-list'
		}]
    }, {
      label: 'Send Leads View',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      url: '#/new-leads-view'
    },/*  {
      label: 'Messages',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Inbox',
        url: '#/inbox'
      }, {
        label: 'Compose',
        url: '#/compose-mail'
      }, {
        label: 'Read',
        url: '#/read-mail'
      }]
    }, {
        label: 'Map',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        url: '#/map'
      },*/ {
        label: 'Module members',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        url: '#/module-members'
      }, {
        label: 'Rank members',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        url: '#/rank-members'
      }, {              
		label: 'Member Management',
		iconClasses: 'glyphicon glyphicon-th-list',
		html: '<span class="badge badge-indigo"></span>',
		children: [{
			label: 'Update Rank',
			url: '#/update-rank'
		}, {
			label: 'Change Member Password',
			url: '#/member-management'
		},{
			label: 'Member Report',
			url: '#/member-report'
		},{
			label: 'New Member Report',
			url: '#/new-member-report'
		}]
	  },{      
      label: 'Store Credit Report',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      html: '<span class="badge badge-indigo"></span>',      
      children: [{        
        label: 'Store Credit Report',        
        url: '#/store-credit-report'      
      }, 
      {        
        label: 'Credit Store Credit',        
        url: '#/credit-store-credit'      
      }, {        
        label: 'Deduct Store Credit',        
        url: '#/dedut-store-credit'      
      }]    
    }, {      
      label: 'MXTOPUP Report',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      html: '<span class="badge badge-indigo"></span>',      
      children: [{        
        label: 'MXTOPUP Report',        
        url: '#/mxtopup-report'      
      }, 
      {        
        label: 'Credit MXTOPUP',        
        url: '#/credit-mxtopup'      
      }, {        
        label: 'Deduct MXTOPUP',        
        url: '#/dedut-mxtopup'      
      }]    
    }, {      
      label: 'Reward Points Report',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      html: '<span class="badge badge-indigo"></span>',      
      children: [{        
        label: 'Reward Points Report',        
        url: '#/reward-points-report'      
      }, 
      {        
        label: 'Credit Reward Points',        
        url: '#/credit-reward-points'      
      }, {        
        label: 'Deduct Reward Points',        
        url: '#/dedut-reward-points'      
      }]    
    }, 

    {      
      label: 'Activation  Report',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      url: '#/activation-platform-report'     
      
    },{      
      label: 'Entrepreneurial Bonus',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      url: '#/entrepreneurial-bonus'     
      
    },
    {
      label: 'Tools',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Training Category',
        url: '#/add-category-training-videos'
      }, {
        label: 'Training Videos',
        url: '#/training-videos'
      }, {
        label: 'View Training Videos',
        url: '#/view-training-videos'
      },
      {
        label: 'Marketing Category',
        url: '#/add-category-marketing-materials'
      }, {
        label: 'Marketing Materials',
        url: '#/marketing-materials'
      }, {
        label: 'View Marketing Materials',
        url: '#/view-marketing-materials'
      }
      ]
    },
    
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
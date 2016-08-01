angular
  .module('theme.core.navigation_controller', ['theme.core.services'])
  .controller('NavigationController', ['$scope', '$location', '$timeout', function($scope, $location, $timeout) {
    'use strict';
if(LOGIN_TYPE == "admin"){
    $scope.menu = [
    // {
    //   label: 'Overview',
    //   iconClasses: '',
    //   separator: true
    // }, 
    {
      label: 'Dashboard',
      iconClasses: 'glyphicon glyphicon-stats homecolor',
      url: '#/'
    }, {
      label: 'Add Menu',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Add Department',
        url: '#/menu-add-department'
      },{
        label: 'Add Employee',
        url: '#/menu-add-employee'
      },{
        label: 'Menu Department Mapping',
        url: '#/menu-department-mapping'
      },{
        label: 'User Menu',
        url: '#/menu-user-menu'
      }
      ]
    }, {
      label: 'Ticket',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Add Ticket',
        url: '#/ticket-add'
      },{
        label: 'Ticket List',
        url: '#/ticket-list'
      }/*,{
        label: 'Ticket List by Department',
        url: '#/ticket-list-by-department'
      }*/,{
        label: 'Ticket List NEW',
        url: '#/ticket-list-new'
      },{
        label: 'Ticket List OLD',
        url: '#/ticket-list-old'
      }]
    }, 
    // {
    //   label: 'Add Sponsor',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   html: '<span class="badge badge-indigo"></span>',
    //   url: '#/add-sponsor'
    // } , 
    // {
    //   label: 'Notification report',
    //   iconClasses: 'glyphicon glyphicon-th-list',
    //   url: '#/notification-report'
    // }, 
    {
      label: 'Team',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-warning"></span>',
      children: [{
        label: 'Binary View',
        url: '#/board-view'
      },{
        label: 'Success Team',
        url: '#/success-team'
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
        label: 'Package Description',
        url: '#/package-description'
      }, {
        label: 'Upgrade Package Description',
        url: '#/upgrade-package-description'
      }, {
        label:'CronJob Settings',
        url: '#/cronjob-setting'
      }, {
        label:'Conversion Rate Settings',
        url: '#/conversion-rate-setting'
      }, {
        label:'Import ARB Subscription',
        url: '#/import-arb-suscription'
      }, {
        label:'Stripe Settings',
        url: '#/stripe-setting'
      }, {
        label:'Ether Value',
        url: '#/ether-value'
      }, {
        label:'Ether Conversion Rate Settings',
        url: '#/ether-conversion-rate-setting'
      }]
    }, {
      label: 'Money',
      iconClasses: 'glyphicon glyphicon-usd',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Earnings Report',
        url: '#/earnings-reoprt'
      },{
        label: 'Pending Balance',
        url: '#/pending-balance'
      },{
        label: 'CC info',
        url: '#/cc-info'
      },{
        label: 'Coupons',
        url: '#/coupons-view'
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
        label: 'Approve Cashout ',
        url: '#/approve-cashout-view'
      },{
        label: 'Rejected Cashout',
        url: '#/rejected-cashout-view'
      },{
        label: 'Add Earning ',
        url: '#/add-earning'
      },{
        label: 'Deduct Earning ',
        url: '#/deduct-earning'
      },{
        label: 'Deposit View',
        url: '#/deposit-view'
      } ,{
        label: 'Cheque Deposit View',
        url: '#/cheque-deposit-view'
      },{
        label: 'Hold Deposit View',
        url: '#/hold-deposit-view'
      },{
        label: 'Buy Store Credit User Info',
        url: '#/buy-store-credit-user-info'
      }/* ,{
        label: 'Approve Deposit View',
        url: '#/approve-deposit-view'
      } */,{
        label: 'Fast Sales Bonus',
        url: '#/fast-sales-bonus'
      },{
        label: 'Solar bonus',
        url: '#/solar-bonus'
      }]
    }, {
      label: 'Daily Report',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      url: '#/daily-report'
    }, {
      label: 'News Section',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      url: '#/news-section'
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
      label: 'Shipping Management',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Orders Shipping',
        url: '#/order-archive-report'
      }, {
        label:'Member Shipping',
        url: '#/archive-report-view'
      }, {
        label:'Shipped member',
        url: '#/member-shipping-archive-report-view'
      }/*, {
        label:'Deposit Archive Report',
        url: '#/deposit-archive-report-view'
      }{
        label: 'New Member Archive Report',
        url: '#/new-member-archive-report'
      } ,  {
        label: 'Upgrade Member Archive Report',
        url: '#/upgrade-member-archive-report'
      } */]
    }, {
      label: 'Archive Report',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [/*{
        label: 'Orders Archive Report',
        url: '#/order-archive-report'
      },*/ {
        label:'Deposit Archive Report',
        url: '#/deposit-archive-report-view'
      },{
        label: 'Rejected Deposit View',
        url: '#/rejected-deposit-view'
      },{
        label: 'Bounce Cheque View',
        url: '#/bounce-cheque'
      }/*
      ,{ 
        label: 'Approve Cheque Deposit View',
        url: '#/approve-cheque-deposit-view'
      },{
        label: 'New Member Archive Report',
        url: '#/new-member-archive-report'
      } ,  {
        label: 'Upgrade Member Archive Report',
        url: '#/upgrade-member-archive-report'
      } */]
    }, { 
      label: 'Upgrade',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Upgrade',
        url: '#/upgrade-user'
      }, /* {
        label: 'User Upgrade Lists',
        url: '#/user-upgrade-list'
      },*/ {
        label: 'New User Upgrade List',
        url: '#/new-upgrade-user-list'
      }, {
        label: 'Block User Account',
        url: '#/block-user-account'
      },  {
        label: 'Cancel Account',
        url: '#/cancle-subscription'
      }, {
        label: 'Cancel Upgrade',
        url: '#/cancle-upgrade'
      }, {
        label: 'Activate Subscription',
        url: '#/activate-subscription'
      }, {
        label: 'Change Card Subscription',
        url: '#/changes-card-subscription-by-admin'
      }, {
        label: 'Subscription List',
        url: '#/suscription-list'
      }, {
        label: 'Subscrioption Change Card List',
        url: '#/suscription-change'
      }, {
        label: 'Subscrioption Deactivate',
        url: '#/suscription-deactivate'
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
    }
	/* , {
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
    } */
	, {              
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
		}, {
      label: 'Platform User Mapping ',
      url: '#/platform-user-mapping'
    }]
    }, {
      label: 'Send Leads View',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Restaurant Leads View',
       url: '#/new-restaurant-leads-view'
      },{
        label: 'Printing Leads View',
       url: '#/new-printing-leads-view'
      },{
        label: 'Solor Leads View',
       url: '#/new-solor-leads-view'
      },{
        label: 'Merchant Leads View',
       url: '#/new-merchant-leads-view'
      }
      // ,{
      //   label: 'Leads View',
      //  url: '#/new-leads-view'
      // },{
      //   label: 'Solor leads',
      //   url: '#/solar-view'
      // }
      ]
      
    }, {
      label: 'LEADS',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'NEW LEADS',
        url: '#/followup-new-leads'
      },{
        label: 'COLD LEADS',
        url: '#/followup-cold-leads'
      }, {
        label: 'WARM LEADS',
        url: '#/followup-warm-leads'
      }, {
        label: 'HOT LEADS',
        url: '#/followup-hot-leads'
      }, {
        label: 'CLOSED LEADS',
        url: '#/followup-closed-leads'
      }, {
        label: 'ALL EMPLOYEE LEADS',
        url: '#/followup-employee-leads'
      } ]
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
		},{
			label: 'Fail Member Report',
			url: '#/fail-member-report'
		},{
      label: 'Founders List',
      url: '#/founders-list'
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
    },{
      label: 'Ether Report',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
          label: 'Ether Report List',
          url: '#/ether-report'
        },{
          label: 'Ether Credit Store',
          url: '#/ether-credit-store-for-user'
        },{
          label: 'Ether Deduct Store',
          url: '#/ether-deduct-store-for-user'
      }]
    },{      
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
    }, {      
      label: 'Bug Report',      
      iconClasses: 'glyphicon glyphicon-th-list',      
      html: '<span class="badge badge-indigo"></span>',      
      children: [{        
        label: 'Bug Pending',        
        url: '#/bug-pending'      
      }, {        
        label: 'Bug Approved',        
        url: '#/bug-approved'      
      }, {        
        label: 'Bug Rejected',        
        url: '#/bug-rejected'      
      }]    
    },{
      label: 'SIM Activation',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [
       {
        label: 'Requested Prepaid Voucher ',
        url: '#/requested-prepaid-voucher'
      },
       {
        label: 'Requested Voucher Shipping',
        url: '#/requested-voucher-shipping'
      },{
        label: 'Activation Voucher',
        url: '#/activation-ol-voucher'
      },{
        label: 'Activation  Report',
        url: '#/activation-platform-report'
      }, {
        label: 'Enter SIM #',
        url: '#/sim-number'
      },{
        label : 'Transfer Sim List',
        url:'#/transfer-sim'
      }, {
        label: 'Enter Voucher #',
        url: '#/voucher-number'
      }, {
        label: 'Waiting SIM List',
        url: '#/waiting-sim'
      }, {
        label: 'Approved SIM List',
        url: '#/approved-sim'
      }, {
        label: 'Rejected SIM List',
        url: '#/rejected-sim'
      }, {
        label: 'Block Refer A Store',
        url: '#/refer-a-store-block'
      }, {
        label: 'Refer A Store List',
        url: '#/refer-a-store-list'
      }, {
        label: 'Refer A Store Agreement ',
        url: '#/refer-a-store-agreement'
      }, {
        label: 'Approved Refer A Store List',
        url: '#/approved-refer-a-store-list'
      }, {
        label: 'Rejected Refer A Store',
        url: '#/rejected-refer-a-store'
      }]
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
	}else if(LOGIN_TYPE == "employee"){
      $scope.menu = EMP_MENU ;  
 }else if(LOGIN_TYPE == "emp"){
    $scope.menu = [{
      label: 'Overview',
      iconClasses: '',
      separator: true
    }, {
      label: 'Send Leads View',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Leads View',
       url: '#/new-leads-view'
      },{
        label: 'Solor leads',
        url: '#/solar-view'
      }]
      
    }, {
      label: 'LEADS',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'NEW LEADS',
        url: '#/followup-new-leads'
      },{
        label: 'COLD LEADS',
        url: '#/followup-cold-leads'
      }, {
        label: 'WARM LEADS',
        url: '#/followup-warm-leads'
      }, {
        label: 'HOT LEADS',
        url: '#/followup-hot-leads'
      }, {
        label: 'CLOSED LEADS',
        url: '#/followup-closed-leads'
      }]
    }, {
        label: 'Sign Out',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        url: BASE_URL+'signing/logout'
      }];


  }else if(LOGIN_TYPE == "shipping"){
		$scope.menu = [{
		  label: 'Shipping Management',
		  iconClasses: 'glyphicon glyphicon-th-list',
		  html: '<span class="badge badge-indigo"></span>',
		  children: [{
			label: 'Orders Shipping',
			url: '#/order-archive-report'
		  }, {
			label:'Member Shipping',
			url: '#/archive-report-view'
		  },{
			label:'Shipped Members',
			url: '#/member-shipping-archive-report-view'
		  }]
		},{
        label: 'Sign Out',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        url: BASE_URL+'signing/logout'
      }];
  }else if(LOGIN_TYPE == "support"){
      $scope.menu = [{
        label: 'Overview',
        iconClasses: '',
        separator: true
      }, {
        label: 'Notification report',
        iconClasses: 'glyphicon glyphicon-th-list',
        url: '#/notification-report'
      }, {
        label: 'News Section',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        url: '#/news-section'
      }, {
        label: 'Shipping Management',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        children: [{
          label: 'Orders Shipping',
          url: '#/order-archive-report'
        }, {
          label:'Member Shipping',
          url: '#/archive-report-view'
        },{
			label:'Shipped Members',
			url: '#/member-shipping-archive-report-view'
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
      }, {
        label: 'Platform User Mapping ',
        url: '#/platform-user-mapping'
      }]
      }, {
        label: 'Send Leads View',
        iconClasses: 'glyphicon glyphicon-th-list',
        html: '<span class="badge badge-indigo"></span>',
        children: [{
          label: 'Leads View',
         url: '#/new-leads-view'
        },{
          label: 'Solor leads',
          url: '#/solar-view'
        }]
        
      }, {
        label: 'LEADS',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        children: [{
          label: 'NEW LEADS',
          url: '#/followup-new-leads'
        },{
          label: 'COLD LEADS',
          url: '#/followup-cold-leads'
        }, {
          label: 'WARM LEADS',
          url: '#/followup-warm-leads'
        }, {
          label: 'HOT LEADS',
          url: '#/followup-hot-leads'
        }, {
          label: 'CLOSED LEADS',
          url: '#/followup-closed-leads'
        }, {
          label: 'ALL EMPLOYEE LEADS',
          url: '#/followup-employee-leads'
        } ]
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
          label: 'Change Member Password',
          url: '#/member-management'
        },{
          label: 'Member Report',
          url: '#/member-report'
        },{
          label: 'New Member Report',
          url: '#/new-member-report'
        },{
          label: 'Fail Member Report',
          url: '#/fail-member-report'
        },{
          label: 'Founders List',
          url: '#/founders-list'
        }]
      }, {      
        label: 'Bug Report',      
        iconClasses: 'glyphicon glyphicon-th-list',      
        html: '<span class="badge badge-indigo"></span>',      
        children: [{        
          label: 'Bug Pending',        
          url: '#/bug-pending'      
        }, {        
          label: 'Bug Approved',        
          url: '#/bug-approved'      
        }, {        
          label: 'Bug Rejected',        
          url: '#/bug-rejected'      
        }]    
      },{
      label: 'SIM Activation',
      iconClasses: 'glyphicon glyphicon-inbox',
      html: '<span class="badge badge-indigo"></span>',
      children: [
       {
        label: 'Requested Prepaid Voucher ',
        url: '#/requested-prepaid-voucher'
      },
       {
        label: 'Requested Voucher Shipping',
        url: '#/requested-voucher-shipping'
      },{
        label: 'Activation Voucher',
        url: '#/activation-ol-voucher'
      },{
        label: 'Activation  Report',
        url: '#/activation-platform-report'
      }, {
        label: 'Enter SIM #',
        url: '#/sim-number'
      },{
        label : 'Transfer Sim List',
        url:'#/transfer-sim'
      }, {
        label: 'Enter Voucher #',
        url: '#/voucher-number'
      }, {
        label: 'Waiting SIM List',
        url: '#/waiting-sim'
      }, {
        label: 'Approved SIM List',
        url: '#/approved-sim'
      }, {
        label: 'Rejected SIM List',
        url: '#/rejected-sim'
      }, {
        label: 'Block Refer A Store',
        url: '#/refer-a-store-block'
      }, {
        label: 'Refer A Store List',
        url: '#/refer-a-store-list'
      }, {
        label: 'Refer A Store Agreement ',
        url: '#/refer-a-store-agreement'
      }, {
        label: 'Approved Refer A Store List',
        url: '#/approved-refer-a-store-list'
      }, {
        label: 'Rejected Refer A Store',
        url: '#/rejected-refer-a-store'
      }]
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
    }
     
     ,{
        label: 'Sign Out',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        url: BASE_URL+'signing/logout'
      }];

	}else{
    $scope.menu = [{
      label: 'Overview',
      iconClasses: '',
      separator: true
    }, {
      label: 'Notification report',
      iconClasses: 'glyphicon glyphicon-th-list',
      url: '#/notification-report'
    }, {
      label: 'Shipping Management',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'Orders Shipping',
        url: '#/order-archive-report'
      }, {
        label:'Member Shipping',
        url: '#/archive-report-view'
      }]
    }, {
      label: 'Archive Report',
      iconClasses: 'glyphicon glyphicon-th-list',
      html: '<span class="badge badge-indigo"></span>',
      children: [ {
        label:'Deposit Archive Report',
        url: '#/deposit-archive-report-view'
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
    },{
      label: 'Fail Member Report',
      url: '#/fail-member-report'
    }]
    },{
      label: 'LEADS',
      iconClasses: 'glyphicon glyphicon-cog',
      html: '<span class="badge badge-indigo"></span>',
      children: [{
        label: 'NEW LEADS',
        url: '#/followup-new-leads'
      },{
        label: 'COLD LEADS',
        url: '#/followup-cold-leads'
      }, {
        label: 'WARM LEADS',
        url: '#/followup-warm-leads'
      }, {
        label: 'HOT LEADS',
        url: '#/followup-hot-leads'
      }, {
        label: 'CLOSED LEADS',
        url: '#/followup-closed-leads'
      }]
    },{
        label: 'Sign Out',
        iconClasses: 'glyphicon glyphicon-cog',
        html: '<span class="badge badge-indigo"></span>',
        url: BASE_URL+'signing/logout'
      }];


}	  


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
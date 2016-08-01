 myCustomApp.config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider
    	.when('/mastercoins-details', {
	        templateUrl: 'application/views/mastercoins-details.html',
			controller: 'mastercoinsDetailsCtr'
      	})
    	.when('/mastercoins-transfer',{
    		templateUrl: 'application/views/mastercoins-transfer.html',
    		controller: 'mastercoinsTransferCtr'
    	})
    	.when('/transaction-password',{
    		templateUrl: 'application/views/transaction-password.html',
    		controller: 'transactionPasswordCtr'
    	})
    	.when('/upgrade-user',{
	        templateUrl: 'application/views/upgrade-user.html',
	        controller: 'upgradeUserCtr',
	    })
		.when('/user-upgrade',{
            templateUrl: 'application/views/user/upgrade-user.html',
            controller: 'userUpgradeCtr',
        })
	    .when('/user-upgrade-list',{
	    	templateUrl: 'application/views/user/user-upgrade-list.html',
	    	controller:'upgradeUserList'
	    })
	    .when('/cancle-subscription',{
	    	templateUrl: 'application/views/user/cancle-subscription.html',
	    	controller: 'cancleSubscriptionCtr'
	    })
		.when('/cancle-user-subscription',{
            templateUrl: 'application/views/user/cancle-user-subscription.html',
            controller: 'cancleUserSubscriptionCtr'
        })
		.when('/activate-subscription',{
            templateUrl: 'application/views/user/activate-subscription.html',
            controller: 'activateSubscriptionCtr'
        })
		.when('/update-rank',{
            templateUrl: 'application/views/admin/update-rank-view.html',
            controller: 'updateRankCtr'
        })
		.when('/cronjob-setting',{
            templateUrl:'application/views/admin/cronjob-setting-view.html',
            controller: 'cronJobSettingCtr'
        })
		.when('/suscription-list',{
            templateUrl:'application/views/admin/suscription-list.html',
            controller: 'suscriptionListCtr'
        })
    	;
  }]);
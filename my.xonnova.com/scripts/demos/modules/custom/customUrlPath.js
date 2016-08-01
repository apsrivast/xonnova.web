 myCustomApp.config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider

        .when('/fast-sales-bonus', {
            templateUrl: 'application/views/admin/fast-sales-bonus.html',
            controller: 'fastSalesBonusCtr'
        })


        .when('/solar-bonus', {
            templateUrl: 'application/views/admin/solar-bonus.html',
            controller: 'solarBonusCtr'
        })

        
        .when('/stripe-setting',{
            templateUrl:'application/views/admin/stripe-setting-view.html',
            controller: 'stripeSettingCtr'
        })
        .when('/cc-info',{
            templateUrl:'application/views/admin/cc-info.html',
            controller:'ccInfoCtr'
        })
        
        .when('/new-merchant-leads-view-by-user/:id',{    
          templateUrl: 'application/views/admin/new-merchant-leads-view-by-user.html',    
          controller: 'newMerchantLeadsViewByUserCtr'  
        })

        .when('/new-merchant-leads-view',{
            templateUrl:'application/views/admin/new-merchant-leads-view.html',
            controller:'newMerchantLeadsViewCtr'
        })

        .when('/new-solor-leads-view-by-user/:id',{    
          templateUrl: 'application/views/admin/new-solor-leads-view-by-user.html',    
          controller: 'newSolorLeadsViewByUserCtr'  
        })

        .when('/new-solor-leads-view',{
            templateUrl:'application/views/admin/new-solor-leads-view.html',
            controller:'newSolorLeadsViewCtr'
        })

        .when('/new-printing-leads-view-by-user/:id',{    
          templateUrl: 'application/views/admin/new-printing-leads-view-by-user.html',    
          controller: 'newPrintingLeadsViewByUserCtr'  
        })

        .when('/new-printing-leads-view',{
            templateUrl:'application/views/admin/new-printing-leads-view.html',
            controller:'newPrintingLeadsViewCtr'
        })

         .when('/new-restaurant-leads-view-by-user/:id',{    
          templateUrl: 'application/views/admin/new-restaurant-leads-view-by-user.html',    
          controller: 'newRestaurantLeadsViewByUserCtr'  
        })

        .when('/new-restaurant-leads-view',{
            templateUrl:'application/views/admin/new-restaurant-leads-view.html',
            controller:'newRestaurantLeadsViewCtr'
        })

        .when('/menu-user-menu',{
            templateUrl:'application/views/admin/menu-user-menu.html',
            controller:'menuUserMenuMappingCtr'
        })

        .when('/mxtopup-setting',{
            templateUrl:'application/views/admin/mxtopup-setting.html',
            controller: 'mxtopupSettingCtr'
        })

        
        .when('/mxtopup-bonus-report',{    
          templateUrl: 'application/views/admin/mxtopup-bonus-report.html',   
          controller: 'mxtopupBonusReportCtr'  
        })  
        .when('/mxtopup-bonus-report-by-user/:id',{    
          templateUrl: 'application/views/admin/mxtopup-report-by-user.html',    
          controller: 'mxtopupBonusReportByUserCtr'  
        })

        .when('/edit-package-description-mex/:packageID',{
            templateUrl:'application/views/admin/edit-package-description.html',
            controller:'packageEditDescriptionMexCtr'
          })

        .when('/conversion-rate-setting',{
            templateUrl:'application/views/admin/conversion-rate-setting.html',
            controller: 'conversionRateSettingCtr'
        })

        .when('/upgrade-package-description-edit/:oldid/:newid',{
            templateUrl:'application/views/admin/upgrade-package-description-edit.html',
            controller:'upgradePackageDescriptionEditCtr'
        })

        .when('/upgrade-package-description',{
            templateUrl:'application/views/admin/upgrade-package-description.html',
            controller:'upgradePackageDescriptionCtr'
        })

        .when('/ticket-list-new-by-id/:id',{
          templateUrl: 'application/views/admin/ticket-list-by-id.html',
          controller:'ticketListNewByIdCtr'
        })
        .when('/ticket-list-new',{
            templateUrl:'application/views/admin/ticket-list-new.html',
            controller:'ticketListNewCtr'
        })
        .when('/ticket-list-old',{
            templateUrl:'application/views/admin/ticket-list-old.html',
            controller:'ticketListOldCtr'
        })
        .when('/ticket-list-by-department',{
            templateUrl:'application/views/admin/ticket-list.html',
            controller:'ticketListByDepartmentCtr'
        })

        .when('/ticket-add',{
            templateUrl:'application/views/admin/ticket-add.html',
            controller:'ticketAddCtr'
        })
        .when('/ticket-list',{
            templateUrl:'application/views/admin/ticket-list.html',
            controller:'ticketListCtr'
        })
        .when('/ticket-list-by-id/:id',{
          templateUrl: 'application/views/admin/ticket-list-by-id.html',
          controller:'ticketListByIdCtr'
        })

        .when('/menu-department-mapping',{
            templateUrl:'application/views/admin/menu-department-mapping.html',
            controller:'menuDepartmentMappingCtr'
        })

        .when('/menu-add-department',{
            templateUrl:'application/views/admin/menu-add-department.html',
            controller:'menuAddDepartmentCtr'
        })

        .when('/menu-add-menu',{
            templateUrl:'application/views/admin/menu-add-menu.html',
            controller:'menuAddMenuCtr'
        })

         .when('/menu-add-employee',{
            templateUrl:'application/views/admin/menu-add-employee.html',
            controller:'menuAddEmployeeCtr'
        })

        .when('/edit-traning-video/:id',{
          templateUrl: 'application/views/admin/edit-traning-video.html',
          controller:'editTraningVideo'
        })

        .when('/changes-card-subscription-by-admin',{
            templateUrl:'application/views/admin/changes-card-subscription-by-admin.html',
            controller:'changesCardSubscriptionAdminCtr'
        })

        .when('/view-requested-prepaid-voucher/:id',{
          templateUrl: 'application/views/admin/view-requested-prepaid-voucher.html',
          controller:'viewRequestPrepaidVoucherCtrl'
        })
        .when('/requested-prepaid-voucher',{
            templateUrl:'application/views/admin/requested-prepaid-voucher.html',
            controller:'requestPrepaidVoucherCtrl'
        })

        .when('/solar-view',{
            templateUrl:'application/views/admin/solar-view.html',
            controller:'solarViewCtrl'
          })
          .when('/view-solar-one/:id',{
          templateUrl: 'application/views/admin/view-solar-one.html',
          controller:'solarViewOneCtrl'
        })
      
         .when('/transfer-sim',{
          templateUrl: 'application/views/admin/transfer-sim.html',
          controller:'transferSimCtrl'
        })

        .when('/voucher-number', {
            templateUrl: 'application/views/admin/voucher-number.html',
            controller: 'voucherNumberCtr'
        })

        .when('/edit-voucher-number/:id', {
            templateUrl: 'application/views/admin/edit-voucher-number.html',
            controller: 'editVoucherNumberCtr'
        })


        .when('/block-user-account', {
            templateUrl: 'application/views/admin/block-user-account.html',
            controller: 'blockUserAccountCtr'
        })
		.when('/refer-a-store-agreement-by-user-copy/:id', {
            templateUrl: 'application/views/admin/refer-a-store-agreement-by-user-copy.html',
            controller: 'referAStoreAgrByUserCtCopy'
        })  
		.when('/rejected-sim-by-user/:id', {
            templateUrl: 'application/views/admin/rejected-sim-by-user.html',
            controller: 'rejectedSimByUserCtr'
        })
		.when('/daily-report', {
            templateUrl: 'application/views/admin/daily-report.html',
            controller: 'dailyReportCtr'
        })
        .when('/view-daily-report/:date',{
          templateUrl: 'application/views/admin/view-daily-report.html',
          controller:'viewDailyReportCtr'
        })
        .when('/bug-rejected-by-user/:id', {
            templateUrl: 'application/views/admin/bug-rejected-by-user.html',
            controller: 'bugRejectedByUserCtr'
        })
        .when('/bug-rejected', {
            templateUrl: 'application/views/admin/bug-rejected.html',
            controller: 'bugRejectedListCtr'
        })


        .when('/bug-approved-by-user/:id', {
            templateUrl: 'application/views/admin/bug-approved-by-user.html',
            controller: 'bugApprovedByUserCtr'
        })
        .when('/bug-approved', {
            templateUrl: 'application/views/admin/bug-approved.html',
            controller: 'bugApprovedListCtr'
        })

        .when('/bug-pending-by-user/:id', {
            templateUrl: 'application/views/admin/bug-pending-by-user.html',
            controller: 'bugPendingByUserCtr'
        })
        .when('/bug-pending', {
            templateUrl: 'application/views/admin/bug-pending.html',
            controller: 'bugPendingListCtr'
        })

	
		.when('/refer-a-store-block', {
            templateUrl: 'application/views/admin/refer-a-store-block.html',
            controller: 'referAStoreBlockCtr'
        })

		
		.when('/rejected-refer-a-store-by-user/:id', {
            templateUrl: 'application/views/admin/rejected-refer-a-store-by-user.html',
            controller: 'rejectedAStoreByUserCtr'
        })
        .when('/rejected-refer-a-store', {
            templateUrl: 'application/views/admin/rejected-refer-a-store.html',
            controller: 'rejectedAStoreListCtr'
        })
		.when('/refer-a-store-agreement-by-user/:id', {
            templateUrl: 'application/views/admin/refer-a-store-agreement-by-user.html',
            controller: 'referAStoreAgrByUserCtr'
        })
        .when('/refer-a-store-agreement', {
            templateUrl: 'application/views/admin/refer-a-store-agreement.html',
            controller: 'referAStoreArgListCtr'
        })

        .when('/approved-refer-a-store-by-user/:id', {
            templateUrl: 'application/views/admin/approved-refer-a-store-by-user.html',
            controller: 'approvedreferAStoreByUserCtr'
        })
        .when('/approved-refer-a-store-list', {
            templateUrl: 'application/views/admin/approved-refer-a-store-list.html',
            controller: 'approvedreferAStoreListCtr'
        })

     
        .when('/refer-a-store-by-user/:id', {
            templateUrl: 'application/views/admin/refer-a-store-by-user.html',
            controller: 'referAStoreByUserCtr'
        })
        .when('/refer-a-store-list', {
            templateUrl: 'application/views/admin/refer-a-store-list.html',
            controller: 'referAStoreListCtr'
        })
    
         .when('/rejected-sim', {
            templateUrl: 'application/views/admin/rejected-sim.html',
            controller: 'rejectedSimCtr'
        })
        .when('/edit-news-section/:id', {
            templateUrl: 'application/views/admin/edit-news-section.html',
            controller: 'editNewsSectionCtr'
        })
        .when('/founders-list', {
            templateUrl: 'application/views/admin/founders-list.html',
            controller: 'foundersListCtr'
        })
        .when('/edit-sim-number/:id', {
            templateUrl: 'application/views/admin/edit-sim-number.html',
            controller: 'editSimNumberCtr'
        })
        .when('/approved-sim-by-user/:id', {
            templateUrl: 'application/views/admin/approved-sim-by-user.html',
            controller: 'approvedSimByUserCtr'
        })
        .when('/approved-sim', {
            templateUrl: 'application/views/admin/approved-sim.html',
            controller: 'approvedSimCtr'
        })
        .when('/waiting-sim-by-user/:id', {
            templateUrl: 'application/views/admin/waiting-sim-by-user.html',
            controller: 'waitingSimByUserCtr'
        })
        .when('/waiting-sim', {
            templateUrl: 'application/views/admin/waiting-sim.html',
            controller: 'waitingSimCtr'
        })

         .when('/sim-number', {
            templateUrl: 'application/views/admin/sim-number.html',
            controller: 'simNumberCtr'
        })

        .when('/news-section', {
            templateUrl: 'application/views/admin/news-section.html',
            controller: 'newsSectionCtr'
        })

        .when('/bounce-cheque', {
            templateUrl: 'application/views/admin/bounce-cheque.html',
            controller: 'bounceChequeCtr'
        })
       
         .when('/view-bounce-cheque/:id',{
          templateUrl: 'application/views/admin/view-bounce-cheque.html',
          controller:'viewBounceChequeCtr'
        })
        .when('/suscription-deactivate',{
          templateUrl: 'application/views/admin/suscription-deactivate.html',
          controller: 'suscriptionDeactivateCtr'
        })
    
        .when('/suscription-change',{
          templateUrl: 'application/views/admin/suscription-change.html',
          controller: 'suscriptionChangeCtr'
        })


        .when('/cancle-upgrade',{
          templateUrl: 'application/views/admin/cancle-upgrade.html',
          controller: 'cancleUpgradeCtr'
        })

        .when('/coupons-view', {
            templateUrl: 'application/views/admin/coupons-view.html',
            controller: 'couponsViewCtr'
        })
         .when('/rejected-cashout-view', {
            templateUrl: 'application/views/admin/rejected-cashout-view.html',
            controller: 'rejectedCashoutViewCtr'
        })
        .when('/buy-store-credit-user-info', {
            templateUrl: 'application/views/admin/buy-store-credit-user-info.html',
            controller: 'buyStoreCreditUserInfoCtr'
        })
         .when('/view-buy-store-credit-user-info/:id',{
          templateUrl: 'application/views/admin/view-buy-store-credit-user-info.html',
          controller:'viewBuyStoreCreditUserInfoCtr'
        })
        .when('/cheque-deposit-view', {
            templateUrl: 'application/views/admin/cheque-deposit-view.html',
            controller: 'chequeDepositViewCtr'
        })
         .when('/approve-cheque-deposit-view', {
            templateUrl: 'application/views/admin/approve-cheque-deposit-view.html',
            controller: 'approveChequeDepositViewCtr'
        })
         .when('/view-cheque-deposit-view/:id',{
          templateUrl: 'application/views/admin/view-cheque-deposit-view.html',
          controller:'viewChequeDepositViewCtr'
        })
          .when('/view-rapprove-cheque-deposit-view/:id',{
          templateUrl: 'application/views/admin/view-approve-cheque-deposit-view.html',
          controller:'viewApproveChequeDepositViewCtr'
        })
        .when('/hold-deposit-view', {
            templateUrl: 'application/views/admin/hold-deposit-view.html',
            controller: 'holdDepositViewCtr'
        })
         .when('/rejected-deposit-view', {
            templateUrl: 'application/views/admin/rejected-deposit-view.html',
            controller: 'rejectedDepositViewCtr'
        })
         .when('/view-hold-deposit-view/:id',{
          templateUrl: 'application/views/admin/view-hold-deposit-view.html',
          controller:'viewHoldDepositViewCtr'
        })
          .when('/view-rejected-deposit-view/:id',{
          templateUrl: 'application/views/admin/view-rejected-deposit-view.html',
          controller:'viewRejectedDepositViewCtr'
        })
        .when('/platform-user-mapping', {
            templateUrl: 'application/views/admin/platform-user-mapping.html',
            controller: 'platformUserMappingCtr'
        })
        .when('/add-sponsor', {
            templateUrl: 'application/views/admin/add-sponsor.html',
            controller: 'addSponsorCtr'
        })
        .when('/followup-new-leads', {
            templateUrl: 'application/views/admin/followup-new-leads.html',
            controller: 'followupNewLeadsCtr'
        })
        .when('/followup-cold-leads', {
            templateUrl: 'application/views/admin/followup-cold-leads.html',
            controller: 'followupColdLeadsCtr'
        })
        .when('/followup-warm-leads', {
            templateUrl: 'application/views/admin/followup-warm-leads.html',
            controller: 'followupWarmLeadsCtr'
        })
        .when('/followup-hot-leads', {
            templateUrl: 'application/views/admin/followup-hot-leads.html',
            controller: 'followupHotLeadsCtr'
        })
        .when('/followup-closed-leads', {
            templateUrl: 'application/views/admin/followup-closed-leads.html',
            controller: 'followupClosedLeadsCtr'
        })
        .when('/followup-employee-leads', {
            templateUrl: 'application/views/admin/followup-employee-leads.html',
            controller: 'followupEmployeeLeadsCtr'
        })
        .when('/update-followup-new-leads/:id',{
          templateUrl: 'application/views/admin/update-followup-new-leads.html',
          controller:'updateFollowupNewLeadsCtr'
        })
        .when('/update-followup-cold-leads/:id',{
          templateUrl: 'application/views/admin/update-followup-cold-leads.html',
          controller:'updateFollowupColdLeadsCtr'
        })
        .when('/update-followup-warm-leads/:id',{
          templateUrl: 'application/views/admin/update-followup-warm-leads.html',
          controller:'updateFollowupWarmLeadsCtr'
        })
        .when('/update-followup-hot-leads/:id',{
          templateUrl: 'application/views/admin/update-followup-hot-leads.html',
          controller:'updateFollowupHotLeadsCtr'
        })
        .when('/update-followup-closed-leads/:id',{
          templateUrl: 'application/views/admin/update-followup-closed-leads.html',
          controller:'updateFollowupClosedLeadsCtr'
        })
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
		.when('/user-upgrade-by-bitpay',{
			templateUrl: '/application/views/user/bitpay-upgrade-user.html',
			controller: 'userUpgradeCtr',
		})
	    .when('/user-upgrade-list',{
	    	templateUrl: 'application/views/user-upgrade-list.html',
	    	controller:'upgradeUserList'
	    })
	    .when('/cancle-subscription',{
	    	templateUrl: 'application/views/cancle-subscription.html',
	    	controller: 'cancleSubscriptionCtr'
	    })
		.when('/cancle-user-subscription',{
            templateUrl: 'application/views/user/cancle-user-subscription.html',
            controller: 'cancleUserSubscriptionCtr'
        })
		.when('/activate-subscription',{
            templateUrl: 'application/views/activate-subscription.html',
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
        .when('/notification-report',{
            templateUrl:'application/views/admin/notification-report.html',
            controller: 'notificationReportCtr'
        })
        .when('/order-archive-report',{
            templateUrl:'application/views/admin/order-archive-report.html',
            controller: 'orderArchiveReportCtr'
        })
        .when('/update-order-archive-report/:odid',{
          templateUrl: 'application/views/admin/update-order-archive-report.html',
          controller:'productArchiveOrderSummaryCtr'
        })
        .when('/new-member-archive-report',{
            templateUrl:'application/views/admin/new-member-archive-report.html',
            controller: 'newMemberArchiveReportCtr'
        })
        .when('/update-new-member-archive-report/:uID',{
            templateUrl:'application/views/admin/update-new-member-archive-report.html',
            controller: 'updateNewMemberArchiveReportCtr'
        })
        .when('/upgrade-member-archive-report',{
            templateUrl:'application/views/admin/upgrade-member-archive-report.html',
            controller: 'upgradeMemberArchiveReportCtr'
        })
        .when('/update-upgrade-member-archive-report/:upgradeID',{
            templateUrl:'application/views/admin/update-upgrade-member-archive-report.html',
            controller: 'updateUpgradeMemberArchiveReportCtr'
        })
		.when('/archive-report-view',{
            templateUrl:'application/views/admin/archive-report-view.html',
            controller: 'archiveReportViewCtr'
        })
        .when('/update-archive-report/:arID', {
            templateUrl:'application/views/admin/update-archive-report.html',
            controller: 'archiveReportUpdateCtr'
        })
		.when('/member-shipping-archive-report-view',{
            templateUrl:'application/views/admin/member-shipping-archive-report-view.html',
            controller: 'memberShippingArchiveReportViewCtr'
        })
        .when('/update-member-shipping-archive-report/:msarID', {
            templateUrl:'application/views/admin/update-member-shipping-archive-report.html',
            controller: 'memberShippingArchiveReportUpdateCtr'
        })
		.when('/deposit-archive-report-view', {
            templateUrl:'application/views/admin/deposit-archive-report-view.html',
            controller: 'depositArchiveReportViewCtr'
        })
        .when('/deposit-archive-report-view/:d_id', {
            templateUrl: 'application/views/admin/update-deposit-archive-report-view.html',
            controller: 'depositArchiveReportUpdateCtr'
        })
    	;
  }]);
angular.module('theme.core.main_controller', ['theme.core.services'])
  .controller('MainController', ['$scope', '$theme', '$timeout', 'progressLoader', '$location', '$http', function($scope, $theme, $timeout, progressLoader, $location, $http) {
    'use strict';
    // $scope.layoutIsSmallScreen = false;
		$http.get(BASE_URL+'user/getCurrentUser').success(function(data) {
			$scope.list = data;
		});
		$http.get(BASE_URL+'user/userRank').success(function(data) {
		  $scope.user_rank_name = data.rank_name;
		});

    $http.get(BASE_URL+'user_leads/userPackage').success(function(data) {
      $scope.user_package_name = data;
    });
    // $http.get(BASE_URL+'admin/getLanguage').success(function(data) {
    //       $scope.listCuntry = data;
    //   });

    $http.get(BASE_URL+'language/contentLabel').success(function(data) {
      $scope.lng_dashboard = data.lng_dashboard;
      $scope.lng_store = data.lng_store;
      $scope.lng_reward_points = data.lng_reward_points;
      $scope.lng_cashout = data.lng_cashout;
      $scope.lng_team = data.lng_team;
      $scope.lng_personal_referrals = data.lng_personal_referrals;
      $scope.lng_add_new_member = data.lng_add_new_member;
      $scope.lng_unilevel_view = data.lng_unilevel_view;
      $scope.lng_binary_view = data.lng_binary_view;
      $scope.lng_upload_deposit = data.lng_upload_deposit;
      $scope.lng_deposit_list = data.lng_deposit_list;
      $scope.lng_business = data.lng_business;
      $scope.lng_activate_your_sim = data.lng_activate_your_sim;
      $scope.lng_mexico_topUp = data.lng_mexico_topUp;
      $scope.lng_order_summary = data.lng_order_summary;
      $scope.lng_new_order_summary = data.lng_new_order_summary;
      $scope.lng_request_platforms = data.lng_request_platforms;
      $scope.lng_tools = data.lng_tools;
      $scope.lng_send_leads = data.lng_send_leads;
      $scope.lng_leads_progress = data.lng_leads_progress;
      $scope.lng_training_videos = data.lng_training_videos;
      $scope.lng_marketing_materials = data.lng_marketing_materials;
      $scope.lng_applications = data.lng_applications;
      $scope.lng_account = data.lng_account;
      $scope.lng_rank_status = data.lng_rank_status;
      $scope.lng_entrepreneurial_status = data.lng_entrepreneurial_status;
      $scope.lng_manage_subscription = data.lng_manage_subscription;
      $scope.lng_entrepreneurial_bonus = data.lng_entrepreneurial_bonus;
      $scope.lng_sign_out = data.lng_sign_out;
      $scope.lng_profile = data.lng_profile;
      $scope.lng_change_password = data.lng_change_password;
      $scope.lng_upgrade = data.lng_upgrade;
      $scope.lng_activate_subscription = data.lng_activate_subscription;
      $scope.lng_user_name = data.lng_user_name;
      $scope.lng_this_user_subscription_already_active = data.lng_this_user_subscription_already_active;
      $scope.lng_name_on_card = data.lng_name_on_card;
      $scope.lng_card_no = data.lng_card_no;
      $scope.lng_expiry_date = data.lng_expiry_date;
      $scope.lng_mm = data.lng_mm;
      $scope.lng_yyyy = data.lng_yyyy;
      $scope.lng_cvv_no = data.lng_cvv_no;
      $scope.lng_billing_zip = data.lng_billing_zip;
      $scope.lng_submit = data.lng_submit;
      $scope.lng_add_new_member = data.lng_add_new_member;
      $scope.lng_contact_information = data.lng_contact_information;
      $scope.lng_country = data.lng_country;
      $scope.lng_select_country = data.lng_select_country;
      $scope.lng_first_name = data.lng_first_name;
      $scope.lng_middle_name = data.lng_middle_name;
      $scope.lng_last_name = data.lng_last_name;
      $scope.lng_ssn_itin_ein = data.lng_ssn_itin_ein;
      $scope.lng_username_is_already_taken = data.lng_username_is_already_taken;
      $scope.lng_email = data.lng_email;
      $scope.lng_email_is_already_taken = data.lng_email_is_already_taken;
      $scope.lng_password = data.lng_password;
      $scope.lng_confirm_password = data.lng_confirm_password;
      $scope.lng_password_not_match = data.lng_password_not_match;
      $scope.lng_birth_date = data.lng_birth_date;
      $scope.lng_address_1 = data.lng_address_1;
      $scope.lng_address_2 = data.lng_address_2;
      $scope.lng_city = data.lng_city;
      $scope.lng_state = data.lng_state;
      $scope.lng_zip = data.lng_zip;
      $scope.lng_phone = data.lng_phone;
      $scope.lng_do_you_want_to_activate_you_platforms_right_away = data.lng_do_you_want_to_activate_you_platforms_right_away;
      $scope.lng_take_a_picture_of_your_id_front = data.lng_take_a_picture_of_your_id_front;
      $scope.lng_take_a_picture_of_your_id_back = data.lng_take_a_picture_of_your_id_back;
      $scope.lng_take_a_picture_of_your_credit_debit_card_front = data.lng_take_a_picture_of_your_credit_debit_card_front;
      $scope.lng_take_a_picture_of_your_credit_debit_card_back = data.lng_take_a_picture_of_your_credit_debit_card_back;
      $scope.lng_take_a_picture_of_your_proof_of_address = data.lng_take_a_picture_of_your_proof_of_address;
      $scope.lng_payment = data.lng_payment;
      $scope.lng_sponsor = data.lng_sponsor;
      $scope.lng_sponsor_not_exist = data.lng_sponsor_not_exist;
      $scope.lng_package = data.lng_package;
      $scope.lng_select_package = data.lng_select_package;
      $scope.lng_if_you_have_voucher = data.lng_if_you_have_voucher;
      $scope.lng_voucher_code = data.lng_voucher_code;
      $scope.lng_voucher_code_not_exist = data.lng_voucher_code_not_exist;
      $scope.lng_thank_you = data.lng_thank_you;
      $scope.lng_binary_view = data.lng_binary_view;
      $scope.lng_update_tree = data.lng_update_tree;
      $scope.lng_team = data.lng_team;
      $scope.lng_thank_you_for_registering_with_onlegacy_network = data.lng_thank_you_for_registering_with_onlegacy_network;
      $scope.lng_select_country = data.lng_select_country;
      $scope.lng_usa = data.lng_usa;
      $scope.lng_mexico = data.lng_mexico;
      $scope.lng_last_name = data.lng_last_name;
      $scope.lng_username_is_already_taken = data.lng_username_is_already_taken;
      $scope.lng_confirm_password = data.lng_confirm_password;
      $scope.lng_address_2 = data.lng_address_2;
      $scope.lng_take_a_picture_of_your_id_front = data.lng_take_a_picture_of_your_id_front;
      $scope.lng_take_a_picture_of_your_id_back = data.lng_take_a_picture_of_your_id_back;
      $scope.lng_take_a_picture_of_your_credit_debit_card_front = data.lng_take_a_picture_of_your_credit_debit_card_front;
      $scope.lng_take_a_picture_of_your_credit_debit_card_back = data.lng_take_a_picture_of_your_credit_debit_card_back;
      $scope.lng_take_a_picture_of_your_proof_of_address = data.lng_take_a_picture_of_your_proof_of_address;
      $scope.lng_if_you_have_voucher = data.lng_if_you_have_voucher;
      $scope.lng_cancle_subscription = data.lng_cancle_subscription;
      $scope.lng_this_user_not_exist = data.lng_this_user_not_exist;
      $scope.lng_pagesize = data.lng_pagesize;
      $scope.lng_filter = data.lng_filter;
      $scope.lng_id = data.lng_id;
      $scope.lng_rank = data.lng_rank;
      $scope.lng_status = data.lng_status;
      $scope.lng_no_subscription_found = data.lng_no_subscription_found;
      $scope.lng_profile = data.lng_profile;
      $scope.lng_change_password = data.lng_change_password;
      $scope.lng_current_password = data.lng_current_password;
      $scope.lng_password_not_match = data.lng_password_not_match;
      $scope.lng_new_password = data.lng_new_password;
      $scope.lng_confirm_new_password = data.lng_confirm_new_password;
      $scope.lng_password_not_match = data.lng_password_not_match;
      $scope.lng_update = data.lng_update;
      $scope.lng_edit_user = data.lng_edit_user;
      $scope.lng_meddle_name = data.lng_meddle_name;
      $scope.lng_contact_no = data.lng_contact_no;
      $scope.lng_address = data.lng_address;
      $scope.lng_address_2 = data.lng_address_2;
      $scope.lng_referrals = data.lng_referrals;
      $scope.lng_personal_referrals = data.lng_personal_referrals;
      $scope.lng_export_as = data.lng_export_as;
      $scope.lng_action = data.lng_action;
      $scope.lng_another_action = data.lng_another_action;
      $scope.lng_something_else_here = data.lng_something_else_here;
      $scope.lng_separated_link = data.lng_separated_link;
      $scope.lng_image = data.lng_image;
      $scope.lng_join_date = data.lng_join_date;
      $scope.lng_no_referrals_found = data.lng_no_referrals_found;
      $scope.lng_account = data.lng_account;
      $scope.lng_user_profile = data.lng_user_profile;
      $scope.lng_upload_image = data.lng_upload_image;
      $scope.lng_details = data.lng_details;
      $scope.lng_birthe_date = data.lng_birthe_date;
      $scope.lng_address = data.lng_address;
      $scope.lng_rank_details = data.lng_rank_details;
      $scope.lng_something_else_here = data.lng_something_else_here;
      $scope.lng_emty_page = data.lng_emty_page;
      $scope.lng_unilevel_view = data.lng_unilevel_view;
      $scope.lng_thank_you_for_registering_with_onlegacy_network = data.lng_thank_you_for_registering_with_onlegacy_network;
      $scope.lng_close = data.lng_close;
      $scope.lng_password_not_match = data.lng_password_not_match;
      $scope.lng_sponsor_not_exist = data.lng_sponsor_not_exist;
      $scope.lng_user_upgrade = data.lng_user_upgrade;
      $scope.lng_incription_system = data.lng_incription_system;
      $scope.lng_select_incription_system = data.lng_select_incription_system;
      $scope.lng_user_upgrade_list = data.lng_user_upgrade_list;
      $scope.lng_upgrated_at = data.lng_upgrated_at;
      $scope.lng_no_found = data.lng_no_found;
      $scope.lng_onlegacy_network_login = data.lng_onlegacy_network_login;
      $scope.lng_remember_me = data.lng_remember_me;
      $scope.lng_sign_in = data.lng_sign_in;
      $scope.lng_enter_your_valid_email = data.lng_enter_your_valid_email;
      $scope.lng_recover_password = data.lng_recover_password;
      $scope.lng_forgot_password = data.lng_forgot_password;
      $scope.lng_enter_your_username_and_password = data.lng_enter_your_username_and_password;
      $scope.lng_register = data.lng_register;
      $scope.lng_login = data.lng_login;
      $scope.lng_signup = data.lng_signup;
      $scope.lng_money = data.lng_money;
      $scope.lng_earnings = data.lng_earnings;
      $scope.lng_reward_points = data.lng_reward_points;
      $scope.lng_cashout = data.lng_cashout;
      $scope.lng_personal_referrals = data.lng_personal_referrals;
      $scope.lng_add_new_member = data.lng_add_new_member;
      $scope.lng_binary_view = data.lng_binary_view;
      $scope.lng_upload_deposit = data.lng_upload_deposit;
      $scope.lng_deposit_list = data.lng_deposit_list;
      $scope.lng_business = data.lng_business;
      $scope.lng_activate_your_sim = data.lng_activate_your_sim;
      $scope.lng_mexico_topUp = data.lng_mexico_topUp;
      $scope.lng_order_summary = data.lng_order_summary;
      $scope.lng_new_order_summary = data.lng_new_order_summary;
      $scope.lng_request_platforms = data.lng_request_platforms;
      $scope.lng_tools = data.lng_tools;
      $scope.lng_send_leads = data.lng_send_leads;
      $scope.lng_leads_progress = data.lng_leads_progress;
      $scope.lng_training_videos = data.lng_training_videos;
      $scope.lng_marketing_materials = data.lng_marketing_materials;
      $scope.lng_applications = data.lng_applications;
      $scope.lng_rank_status = data.lng_rank_status;
      $scope.lng_entrepreneurial_status = data.lng_entrepreneurial_status;
      $scope.lng_manage_subscription = data.lng_manage_subscription;
      $scope.lng_entrepreneurial_bonus = data.lng_entrepreneurial_bonus;
      $scope.lng_sign_out = data.lng_sign_out;
      $scope.lng_change_password = data.lng_change_password;
      $scope.lng_home = data.lng_home;
      $scope.lng_total_earning = data.lng_total_earning;
      $scope.lng_new_orders = data.lng_new_orders;
      $scope.lng_total_member = data.lng_total_member;
      $scope.lng_holding_tank = data.lng_holding_tank;
      $scope.lng_total_rewards = data.lng_total_rewards;
      $scope.lng_log_out = data.lng_log_out;
      $scope.lng_search = data.lng_search;
      $scope.lng_update_tree = data.lng_update_tree;
      $scope.lng_enter_user_name = data.lng_enter_user_name;
      $scope.lng_click_here_go_to_store = data.lng_click_here_go_to_store;
      $scope.lng_store_view = data.lng_store_view;
      $scope.lng_earning_details = data.lng_earning_details;
      $scope.lng_earning_report = data.lng_earning_report;
    });
    $scope.layoutFixedHeader = $theme.get('fixedHeader');
    $scope.layoutPageTransitionStyle = $theme.get('pageTransitionStyle');
    $scope.layoutDropdownTransitionStyle = $theme.get('dropdownTransitionStyle');
    $scope.layoutPageTransitionStyleList = ['bounce',
      'flash',
      'pulse',
      'bounceIn',
      'bounceInDown',
      'bounceInLeft',
      'bounceInRight',
      'bounceInUp',
      'fadeIn',
      'fadeInDown',
      'fadeInDownBig',
      'fadeInLeft',
      'fadeInLeftBig',
      'fadeInRight',
      'fadeInRightBig',
      'fadeInUp',
      'fadeInUpBig',
      'flipInX',
      'flipInY',
      'lightSpeedIn',
      'rotateIn',
      'rotateInDownLeft',
      'rotateInDownRight',
      'rotateInUpLeft',
      'rotateInUpRight',
      'rollIn',
      'zoomIn',
      'zoomInDown',
      'zoomInLeft',
      'zoomInRight',
      'zoomInUp'
    ];

    $scope.layoutLoading = true;

    $scope.getLayoutOption = function(key) {
      return $theme.get(key);
    };

    $scope.setNavbarClass = function(classname, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      $theme.set('topNavThemeClass', classname);
    };

    $scope.setSidebarClass = function(classname, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      $theme.set('sidebarThemeClass', classname);
    };

    $scope.$watch('layoutFixedHeader', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('fixedHeader', newVal);
    });
    $scope.$watch('layoutLayoutBoxed', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('layoutBoxed', newVal);
    });
    $scope.$watch('layoutLayoutHorizontal', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('layoutHorizontal', newVal);
    });
    $scope.$watch('layoutPageTransitionStyle', function(newVal) {
      $theme.set('pageTransitionStyle', newVal);
    });
    $scope.$watch('layoutDropdownTransitionStyle', function(newVal) {
      $theme.set('dropdownTransitionStyle', newVal);
    });

    $scope.hideHeaderBar = function() {
      $theme.set('headerBarHidden', true);
    };

    $scope.showHeaderBar = function($event) {
      $event.stopPropagation();
      $theme.set('headerBarHidden', false);
    };

    $scope.toggleLeftBar = function() {
      if ($scope.layoutIsSmallScreen) {
        return $theme.set('leftbarShown', !$theme.get('leftbarShown'));
      }
      $theme.set('leftbarCollapsed', !$theme.get('leftbarCollapsed'));
    };

    $scope.toggleRightBar = function() {
      $theme.set('rightbarCollapsed', !$theme.get('rightbarCollapsed'));
    };

    $scope.toggleSearchBar = function($event) {
      $event.stopPropagation();
      $event.preventDefault();
      $theme.set('showSmallSearchBar', !$theme.get('showSmallSearchBar'));
    };

    $scope.chatters = [{
      id: 0,
      status: 'online',
      avatar: 'potter.png',
      name: 'Jeremy Potter'
    }, {
      id: 1,
      status: 'online',
      avatar: 'tennant.png',
      name: 'David Tennant'
    }, {
      id: 2,
      status: 'online',
      avatar: 'johansson.png',
      name: 'Anna Johansson'
    }, {
      id: 3,
      status: 'busy',
      avatar: 'jackson.png',
      name: 'Eric Jackson'
    }, {
      id: 4,
      status: 'online',
      avatar: 'jobs.png',
      name: 'Howard Jobs'
    }, {
      id: 5,
      status: 'online',
      avatar: 'potter.png',
      name: 'Jeremy Potter'
    }, {
      id: 6,
      status: 'away',
      avatar: 'tennant.png',
      name: 'David Tennant'
    }, {
      id: 7,
      status: 'away',
      avatar: 'johansson.png',
      name: 'Anna Johansson'
    }, {
      id: 8,
      status: 'online',
      avatar: 'jackson.png',
      name: 'Eric Jackson'
    }, {
      id: 9,
      status: 'online',
      avatar: 'jobs.png',
      name: 'Howard Jobs'
    }];
    $scope.currentChatterId = null;
    $scope.hideChatBox = function() {
      $theme.set('showChatBox', false);
    };
    $scope.toggleChatBox = function(chatter, $event) {
      $event.preventDefault();
      if ($scope.currentChatterId === chatter.id) {
        $theme.set('showChatBox', !$theme.get('showChatBox'));
      } else {
        $theme.set('showChatBox', true);
      }
      $scope.currentChatterId = chatter.id;
    };

    $scope.hideChatBox = function() {
      $theme.set('showChatBox', false);
    };

    $scope.$on('themeEvent:maxWidth767', function(event, newVal) {
      $timeout(function() {
        $scope.layoutIsSmallScreen = newVal;
        if (!newVal) {
          $theme.set('leftbarShown', false);
        } else {
          $theme.set('leftbarCollapsed', false);
        }
      });
    });
    $scope.$on('themeEvent:changed:fixedHeader', function(event, newVal) {
      $scope.layoutFixedHeader = newVal;
    });
    $scope.$on('themeEvent:changed:layoutHorizontal', function(event, newVal) {
      $scope.layoutLayoutHorizontal = newVal;
    });
    $scope.$on('themeEvent:changed:layoutBoxed', function(event, newVal) {
      $scope.layoutLayoutBoxed = newVal;
    });

    // there are better ways to do this, e.g. using a dedicated service
    // but for the purposes of this demo this will do :P
    $scope.isLoggedIn = true;
    $scope.logOut = function() {
      $scope.isLoggedIn = false;
    };
    $scope.logIn = function() {
      $scope.isLoggedIn = true;
    };

    $scope.rightbarAccordionsShowOne = false;
    $scope.rightbarAccordions = [{
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }];

    $scope.$on('$routeChangeStart', function() {
      if ($location.path() === '') {
        return $location.path('/');
      }
      progressLoader.start();
      progressLoader.set(0);
    });
    $scope.$on('$routeChangeSuccess', function() {
      progressLoader.end();
      if ($scope.layoutLoading) {
        $scope.layoutLoading = false;
      }
    });
  }]);
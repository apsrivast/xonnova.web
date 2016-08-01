angular.module('theme.demos.mail', [
    'theme.mail.inbox_controller',
    'theme.mail.compose_controller'
  ])
  .config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider
      .when('/inbox', {
        templateUrl: '/application/views/admin/extras-inbox.html'
      })
      .when('/compose-mail', {
        templateUrl: '/application/views/admin/extras-inbox-compose.html'
      })
      .when('/read-mail', {
        templateUrl: '/application/views/admin/extras-inbox-read.html'
      });
  }]);
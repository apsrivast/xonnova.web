angular.module('theme.demos.mail', [
    'theme.mail.inbox_controller',
    'theme.mail.compose_controller'
  ])
  .config(['$routeProvider', function($routeProvider) {
    'use strict';
    $routeProvider
      .when('/inbox', {
        templateUrl: 'application/views/user/extras-inbox.html'
      })
      .when('/compose-mail', {
        templateUrl: 'application/views/user/extras-inbox-compose.html'
      })
      .when('/read-mail', {
        templateUrl: 'application/views/user/extras-inbox-read.html'
      });
  }]);
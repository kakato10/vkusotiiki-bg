'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('LoginCtrl', [ '$rootScope', '$scope', 'ref', 'Authentication', '$state',
    function ($rootScope, $scope, ref, Authentication, $state) {
      $scope.awesomeThings = [
        'HTML5 Boilerplate',
        'AngularJS',
        'Karma'
      ];

      if (ref.getAuth()) {
        $state.transitionTo('home');
      }

      $scope.logIn = function (email, password, remember) {
        remember ? remember = 'default' : remember = 'sessionOnly';
        Authentication.logIn(email, password, remember);
      }
    } ]);

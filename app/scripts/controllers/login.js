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
      if ($scope.state.user) {
        console.log($scope.state.user);
        $state.transitionTo('home.landing');
      }

      $scope.logIn = function (email, password, remember) {
        remember ? remember = 'default' : remember = 'sessionOnly';
        Authentication.logIn(email, password, remember);
      };
    } ]);

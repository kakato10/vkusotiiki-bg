'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('MainCtrl', [ '$scope', function ($scope) {
    $scope.breadcrumbs = [ {
      'name'    : 'Начало',
      'stateUrl': 'home'
    } ];
  } ]);

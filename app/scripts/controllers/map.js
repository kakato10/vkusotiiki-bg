'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('MapCtrl', [ '$scope', function ($scope) {
    $scope.breadcrumbs = [ {
      'name'    : 'Начало',
      'stateUrl': 'home'
    }, {
      'name'    : 'Карта',
      'stateUrl': 'map'
    } ];
  } ]);

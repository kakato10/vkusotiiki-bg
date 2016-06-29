'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('ContactsCtrl', [ '$scope', function ($scope) {
    $scope.breadcrumbs   = [{
        'name'    : 'Начало',
        'stateUrl': 'home'
      }, {
        'name'    : 'Контакти',
        'stateUrl': 'contacts'
      }];
  } ]);

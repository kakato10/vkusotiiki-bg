'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('MyRecipesCtrl', [ '$scope', 'recipies',
    function ($scope, recipies) {
      $scope.recipies = recipies;
    } ]);

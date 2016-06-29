'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('NewRecipesCtrl', [ '$scope', 'recipies',
    function ($scope, recipies) {
      $scope.breadcrumbs = [ {
        'name'    : 'Начало',
        'stateUrl': 'home'
      }, {
        'name'    : 'Нови рецепти',
        'stateUrl': 'newRecipes'
      } ];
      
      $scope.recipies = recipies;
    } ]);

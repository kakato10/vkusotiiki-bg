'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('RecipesCtrl', [ '$scope', 'recipes', function ($scope, recipes) {
    $scope.breadcrumbs = [ {
      'name'    : 'Начало',
      'stateUrl': 'home'
    }, {
      'name'    : 'Рецепти',
      'stateUrl': 'recipes'
    } ];
    $scope.recipes = recipes;
    console.log(recipes);
  } ]);

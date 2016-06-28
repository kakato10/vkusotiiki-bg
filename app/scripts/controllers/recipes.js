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
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
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

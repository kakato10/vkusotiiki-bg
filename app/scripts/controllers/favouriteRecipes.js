'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('FavouriteRecipesCtrl', [ '$scope', function ($scope) {
    $scope.breadcrumbs   = [ {
      'name'    : 'Начало',
      'stateUrl': 'home'
    }, {
      'name'    : 'Любими рецепти',
      'stateUrl': 'favouriteRecipes'
    } ];
  } ]);

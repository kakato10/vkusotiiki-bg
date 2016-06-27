'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('OfferedRecipesCtrl', [ '$scope', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    $scope.breadcrumbs = [ {
      'name'    : 'Начало',
      'stateUrl': 'home'
    }, {
      'name'    : 'Предлагани рецепти',
      'stateUrl': 'offeredRecipes'
    } ];
  } ]);

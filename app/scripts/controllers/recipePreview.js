'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('RecipePreview', [ '$scope', 'Rating',
    function ($scope, Rating) {
      var recipe = $scope.recipe;
      var rating = recipe.rating;

      $scope.rating = rating;
    } ]);

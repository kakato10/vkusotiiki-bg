'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('NewRecipeCtrl', [ '$scope', 'Authentication', 'Recipe', 'regions', 'categories', '$state',
    function ($scope, Authentication, Recipe, regions, categories, $state) {
      $scope.regions = regions;
      $scope.categories = categories;

      $scope.slider = {
        value  : 2,
        options: {
          floor: 1,
          ceil : 5
        }
      };
      $scope.recipe = {
        otherOptions: {}
      };

      function formatIngredients(ingredients) {
        ingredients = ingredients.split('\n');
        ingredients = ingredients.map(function (ingredient) {
          var data = ingredient.split(' - ');
          return {
            name    : data[ 0 ],
            quantity: parseInt(data[ 1 ], 10),
            unit    : data[ 2 ]
          };
        });
        return ingredients;
      }

      $scope.save = Authentication.require(function (recipe) {
        recipe.ingredients = formatIngredients(recipe.ingredients);
        recipe.createdOn = new Date().toString();
        recipe.authorId = $scope.state.user.id;
        recipe.difficulty = $scope.slider.value;
        Recipe.create(recipe, {
          cacheResponse: true
        }).then(function (recipe) {
          $state.go('home.recipies.details', {
            id: recipe.id
          });
        });
      })
    } ]);

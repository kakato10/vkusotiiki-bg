'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('NewRecipeCtrl', [ '$scope', 'Authentication', 'Recipe', 'regions', 'categories', 'dishes', '$state',
    function ($scope, Authentication, Recipe, regions, categories, dishes, $state) {
      $scope.regions = regions;
      $scope.categories = categories;
      $scope.dishes = dishes;
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
            unit    : data[ 2 ],
            is_allergic : 0
          };
        });
        return ingredients;
      }

      $scope.save = Authentication.require(function (recipe) {
        recipe.ingredients = formatIngredients(recipe.ingredients);
        recipe.authorId = $scope.state.user.id;
        recipe.difficulty = $scope.slider.value;

        delete recipe.season;
        delete recipe.holiday;
        delete recipe.otherOptions;

        Recipe.create(recipe, {
          cacheResponse: true
        }).then(function (recipe) {
          $state.go('home.recipies.details', {
            id: recipe.id
          });
        });
      })
    } ]);

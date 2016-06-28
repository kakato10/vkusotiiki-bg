'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('NewRecipeCtrl', [ '$scope', 'Authentication', 'Recipe', 'regions', 'categories',
    function ($scope, Authentication, Recipe, regions, categories) {
      $scope.awesomeThings = [
        'HTML5 Boilerplate',
        'AngularJS',
        'Karma'
      ];

      $scope.regions = regions;
      $scope.categories = categories;
      $scope.breadcrumbs = [ {
        'name'    : 'Начало',
        'stateUrl': 'home'
      }, {
        'name'    : 'Нова рецепта',
        'stateUrl': 'newRecipe'
      } ];
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
            name       : data[ 0 ],
            quantity   : parseInt(data[ 1 ], 10),
            unit: data[ 2 ]
          };
        });
        return ingredients;
      }

      $scope.save = Authentication.require(function (recipe) {
        recipe.ingredients = formatIngredients(recipe.ingredients);
        Recipe.create(recipe);
      })
    } ]);

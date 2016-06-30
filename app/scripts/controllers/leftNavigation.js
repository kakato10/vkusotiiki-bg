'use strict';

angular.module('vkusotiikiBgApp')
  .controller('LeftNavigation', [ '$scope', 'Recipe',
    function ($scope, Recipe) {
      function randomIndex(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
      }

      Recipe.findAll()
        .then(function (recipes) {
          var index = randomIndex(0, recipes.length);
          $scope.weekly = recipes[index];

          recipes = recipes.filter(function (recipe) {
            return recipe.rating;
          });

          recipes.sort(function (a, b) {
            var firstRating = a.rating || 0,
                secondRating = b.rating || 0;
            return secondRating - firstRating;
          });

          $scope.recipies = recipes.slice(0, 5);
        });

    } ]);

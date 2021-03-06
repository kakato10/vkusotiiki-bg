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
            var firstRating = parseFloat(a.rating) || 0,
                secondRating = parseFloat(b.rating) || 0;
            return secondRating - firstRating;
          });

          $scope.recipes = recipes.slice(0, 5);
        });

    } ]);

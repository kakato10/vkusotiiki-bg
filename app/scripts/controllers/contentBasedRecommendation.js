'use strict';

angular.module('vkusotiikiBgApp')
  .controller('ContentBasedRecommendation', [ '$scope', 'Recipe',
    function ($scope, Recipe) {
      Recipe.findAll()
        .then(function (recipes) {
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

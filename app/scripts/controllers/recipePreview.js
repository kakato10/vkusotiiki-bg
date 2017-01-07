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

      // Rating.findAll({}, {bypassCache: true})
      //   .then(function (ratings) {
      //     ratings = ratings.filter(function (rating) {
      //       return rating.recipe === recipe.id;
      //     });
      //     if (!rating) {
      //       rating = ratings.reduce(function (current, rating) {
      //           return current + rating.rating;
      //         }, 0);
      //       if (ratings.length) {
      //         rating = rating / ratings.length;
      //       }
      //     }
      //     $scope.rating = rating;
      //   });
      $scope.rating = rating;
    } ]);

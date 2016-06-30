'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('RecipeDetailsCtrl', [ '$scope', 'recipe', 'author', 'region', 'category', 'Rating', 'Authentication',
    function ($scope, recipe, author, region, category, Rating, Authentication) {
      $scope.recipe = recipe;
      $scope.author = author;
      $scope.region = region.name;
      $scope.category = category.name;
      $scope.slider = {
        value  : 2,
        options: {
          floor: 1,
          ceil : 5
        }
      };
      var rating = recipe.rating;

      function canRate() {
        Rating.findAll({}, {bypassCache: true})
          .then(function (ratings) {
            ratings = ratings.filter(function (rating) {
              return rating.recipe === recipe.id;
            });
            if (!rating) {
              rating = ratings.reduce(function (current, rating) {
                  return current + rating.rating;
                }, 0) / ratings.length;
              $scope.rating = rating;
            }
            if ($scope.state.user) {
              $scope.canRate = !ratings.some(function (rating) {
                return rating.user === $scope.state.user.id;
              });
              return;
            }
            $scope.canRate = false;
          });
      }

      Authentication.bind($scope, {
        whenAuthenticated   : canRate,
        whenNotAuthenticated: canRate
      });

      $scope.removeFromFavourites = function (recipeId) {
        var user = $scope.state.user;
        user.favourites.splice(user.favourites.indexOf(recipeId, 1));
        user.DSUpdate({
          favourites: user.favourites
        }, {
          cacheResponse: true
        });
      };

      $scope.addToFavourites = function (recipeId) {
        var favourites = $scope.state.user.favourites || [];
        favourites.push(recipeId);

        return $scope.state.user.DSUpdate({
          favourites: favourites
        }, {
          cacheResponse: true
        });
      };

      $scope.rating = rating;
      $scope.date = new Date(recipe.createdOn);

      $scope.rate = function (recipe, rating) {
        if ($scope.canRate) {
          $scope.canRate = false;
          Rating.create({
            user  : $scope.state.user.id,
            recipe: recipe.id,
            rating: rating
          });
        }
      }
    } ]);

'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('RecipeDetailsCtrl', [ '$scope', 'recipe', 'author', 'Rating', 'Authentication',
    function ($scope, recipe, author, Rating, Authentication) {
      $scope.breadcrumbs = [
        {
          'name'    : 'Начало',
          'stateUrl': 'home'
        },
        {
          'name'    : 'Рецепти',
          'stateUrl': 'recipes'
        },
        {
          'name'    : 'Разглеждане на рецепта',
          'stateUrl': 'recipeDetails'
        }
      ];
      $scope.recipe = recipe;
      $scope.author = author;

      $scope.slider = {
        value  : 2,
        options: {
          floor: 1,
          ceil : 5
        }
      };

      function canRate() {
        Rating.findAll({
            where: {
              recipe: {
                '=': recipe.id
              }
            }
          })
          .then(function (ratings) {
            if ($scope.state.user) {
              $scope.canRate = !ratings.some(function (rating) {
                console.log(rating.user, $scope.state.user.id, rating.user === $scope.state.user.id);
                return rating.user === $scope.state.user.id;
              });
            }
            $scope.canRate = false;
          });
      }

      Authentication.bind($scope, {
        whenAuthenticated: canRate,
        whenNotAuthenticated: canRate
      });

      $scope.removeFromFavourites = function (recipeId) {
        var user = $scope.state.user;
        user.favourites.splice(user.favourites.indexOf(recipeId, 1));
        console.log(user.favourites);
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

      $scope.rating = recipe.rating;

      $scope.rate = function (recipe, rating) {
        if (!$scope.rated) {
          $scope.canRate = true;
          Rating.create({
            user: $scope.state.user.id,
            recipe: recipe.id
          });
        }
      }
    } ]);

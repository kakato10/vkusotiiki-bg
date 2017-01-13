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
        Rating.findAll({})
          .then(function (ratings) {
            ratings = ratings.filter(function (rating) {
              return rating.recipe === recipe.id;
            });

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

      $scope.rating = rating || 0;
      $scope.date = new Date(recipe.createdOn);

      $scope.rate = function (recipe, rating) {
        if ($scope.canRate) {
          $scope.canRate = false;
          debugger;
          Rating.create({
            user  : $scope.state.user.id,
            recipe: recipe.id,
            rating: rating
          });
        }
      }
    } ])
  .run([ '$rootScope', function ($rootScope) {
    $rootScope.createPDF = function () {
      var doc = new jsPDF('l', 'em','a2',true);

      var utf_8_string_to_render = $('#recipe-holder').html();

      Promise.all(
      [
          new Promise(function (resolve) 
          {
              var temp = document.createElement("div");
              temp.id = "temp";
              temp.style = "color: black;margin:0px;font-size:20px;";
              temp.innerHTML= utf_8_string_to_render;
              //need to render element, otherwise it won't be displayed
              document.body.appendChild(temp);

              html2canvas($("#temp"), {
              onrendered: function(canvas) {

                      $("#temp").remove();
                  resolve(canvas.toDataURL('image/png'));
              },
              });
          })
      ]).then(function (ru_text) { 

          doc.addImage(ru_text[0], 'JPEG', 0,0);
          doc.text(10, 10, '' );

          doc.save('filename.pdf');
          });


      // };


      // var specialElementHandlers = {
      //     '#printHelper': function (element, renderer) {
      //         return true;
      //     }
      // };

      // doc.fromHTML($('#recipe-holder').html(), 15, 15, {
      //     'width': 170,
      //         'elementHandlers': specialElementHandlers
      // });
      // doc.save('sample-file.pdf');
    };
  }]);

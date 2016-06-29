'use strict';

angular.module('vkusotiikiBgApp')
  .directive('recipePreviewBasic', function () {
    return {
      templateUrl: 'views/recipePreviewBasic.html',
      restrict: 'E',
      scope: {
        recipe: '='
      }
    };
  });

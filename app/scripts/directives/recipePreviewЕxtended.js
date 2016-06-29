'use strict';

angular.module('vkusotiikiBgApp')
  .directive('recipePreviewExtended', function () {
    return {
      templateUrl: 'views/recipePreviewExtended.html',
      restrict: 'E',
      scope: {
        recipe: '='
      }
    };
  });

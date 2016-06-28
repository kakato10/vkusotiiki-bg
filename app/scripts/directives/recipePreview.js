'use strict';

angular.module('vkusotiikiBgApp')
  .directive('recipePreview', function () {
    return {
      templateUrl: 'views/recipePreview.html',
      restrict: 'E',
      scope: {
        recipe: '='
      }
    };
  });

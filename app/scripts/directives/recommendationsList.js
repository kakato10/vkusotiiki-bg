'use strict';

angular.module('vkusotiikiBgApp')
  .directive('recommendationsList', function () {
    return {
      templateUrl: 'views/recommendationsList.html',
      restrict: 'E',
      scope: {
          recipes: '='
      }
    };
  });

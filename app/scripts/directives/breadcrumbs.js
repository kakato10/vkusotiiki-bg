'use strict';

angular.module('vkusotiikiBgApp')
  .directive('breadcrumbs', function () {
    return {
      templateUrl: 'views/breadcrumbs.html',
      restrict: 'E',
      scope: {
        values: '='
      }
    };
  });

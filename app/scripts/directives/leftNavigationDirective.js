'use strict';

angular.module('vkusotiikiBgApp')
  .directive('leftNavigation', function () {
    return {
      templateUrl: 'views/leftNavigation.html',
      restrict: 'E',
      controller: 'LeftNavigation'
    };
  });

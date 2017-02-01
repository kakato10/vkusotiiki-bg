'use strict';

angular.module('vkusotiikiBgApp')
  .directive('contentBasedRecommendation', function () {
    return {
      templateUrl: 'views/contentBasedRecommendation.html',
      restrict: 'E',
      controller: 'ContentBasedRecommendation',
      scope: {}
    };
  });

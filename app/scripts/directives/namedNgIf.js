//wrap ngIf with customized behaviour
angular.module('vkusotiikiBgApp')
  .factory('namedNgIf', ['ngIfDirective',
    function(ngIfDirective) {
      'use strict';
      return function(property) {
        var ngIf = ngIfDirective[0];

        return {
          transclude: ngIf.transclude,
          priority: ngIf.priority,
          terminal: ngIf.terminal,
          restrict: ngIf.restrict,
          link: function($scope, $element, $attr) {
            $attr.ngIf = function() {
              return $scope.$eval(property);
            };
            ngIf.link.apply(ngIf, arguments);
          }
        };
      };
    }
  ]);

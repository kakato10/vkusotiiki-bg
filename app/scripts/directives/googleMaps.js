'use strict';

angular.module('vkusotiikiBgApp')
  .directive('googleMaps', function () {
    return {
      template: '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASrwZ5hSZahiv-u09xV3ugI8G8k_a6D2U"></script>',
      restrict: 'E'
    };
  });
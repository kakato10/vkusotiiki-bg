'use strict';
angular.module('vkusotiikiBgApp')
  .service('Region', [ 'DS', function (DS) {
    return DS.defineResource({
      name: 'Region'
    });
  } ]);

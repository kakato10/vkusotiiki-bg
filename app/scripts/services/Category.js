'use strict';
angular.module('vkusotiikiBgApp')
  .service('Category', [ 'DS', function (DS) {
    return DS.defineResource({
      name: 'Category'
    });
  } ]);

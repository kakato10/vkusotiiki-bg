'use strict';
angular.module('vkusotiikiBgApp')
  .service('Category', [ 'DS', function (DS) {
    var mapping = {
      name: 'name',
      id: 'id'
    };

    return DS.defineResource({
      name: 'Category',
      endpoint: '/category',
      methods: {
        mapping: function () {
          return mapping;
        }
      }
    });
  } ]);

'use strict';
angular.module('vkusotiikiBgApp')
  .service('Dish', [ 'DS', function (DS) {
    var mapping = {
      name: 'name',
      id: 'id'
    };

    return DS.defineResource({
      name: 'Dish',
      endpoint: '/dish',
      methods: {
        mapping: function () {
          return mapping;
        }
      }
    });
  } ]);

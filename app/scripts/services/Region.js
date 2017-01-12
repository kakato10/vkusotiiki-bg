'use strict';
angular.module('vkusotiikiBgApp')
  .service('Region', [ 'DS', function (DS) {
    var mapping = {
      name: 'name',
      id: 'id'
    };

    return DS.defineResource({
      name: 'Region',
      endpoint: '/region',
      methods: {
        mapping: function () {
          return mapping;
        }
      }
    });
  } ]);

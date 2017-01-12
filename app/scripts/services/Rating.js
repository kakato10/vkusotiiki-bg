/**
 * Created by kakato10 on 28.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('Rating', [ '$rootScope', 'ref', 'DS',
    function ($rootScope, ref, DS) {
      var mapping = {
        id: 'id',
        user: 'user',
        recipe: 'recipe',
        rating: 'value'
      };
      return DS.defineResource({
        name: 'Rating',
        endpoint: '/rating',
        methods: {
          mapping: function () {
            return mapping;
          }
        }
      });
    }
  ]);

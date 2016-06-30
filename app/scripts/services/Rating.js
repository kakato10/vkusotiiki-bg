/**
 * Created by kakato10 on 28.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('Rating', [ '$rootScope', 'ref', 'DS',
    function ($rootScope, ref, DS) {
      return DS.defineResource({
        name: 'Rating'
      });
    }
  ]);

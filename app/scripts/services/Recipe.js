/**
 * Created by kakato10 on 28.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('Recipe', [ '$rootScope', 'ref', 'User', 'DS',
    function ($rootScope, ref, User, DS) {
      return DS.defineResource({
        name: 'Recipe'
      });
    }
  ]);

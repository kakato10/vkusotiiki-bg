/**
 * Created by kakato10 on 27.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('User', [ 'DS', function (DS) {
    var mapping = {
      name: 'name'  ,
      email: 'email',
      region: 'region',
      authId: 'id',
      id: 'id',
      favourites: 'favourites'
    };

    return DS.defineResource({
      name: 'User',
      defaultAdapter: 'http',
      endpoint: '/user',
      methods: {
        likes: function(recipeId) {
          if (this.favourites) {
            return this.favourites.indexOf(recipeId) !== -1;
          }
          return false;
        },
        mapping: function () {
          return mapping;
        }
      }
    });
  } ]);

/**
 * Created by kakato10 on 27.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('User', [ function () {
    var fakeUser = {
      name: 'Иван Петров',
      email: 'ivan.petrov@abv.bg',
      region: 'София'
    };
    return {
      create: function (user) {
        console.log(user);
        return new Promise(function (resolve, reject) {
          resolve(user);
        });
      },

      find: function(user) {
        return new Promise(function (resolve, reject) {
          resolve(fakeUser);
        });
      }
    };
  } ]);

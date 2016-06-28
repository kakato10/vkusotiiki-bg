/**
 * Created by kakato10 on 27.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('User', [ 'DS', function (DS) {
    var fakeUser = {
      name  : 'Иван Петров',
      email : 'ivan.petrov@abv.bg',
      region: 'София',
      id    : "f121925d-d296-4818-870f-5f453389c4a8"
    };

    return DS.defineResource({
      name: 'User'
    });
  } ]);

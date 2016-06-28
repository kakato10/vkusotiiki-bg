/**
 * Created by kakato10 on 28.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('State', [ '$rootScope', 'ref', 'User',
    function ($rootScope, ref, User) {
      return {
        setUser   : function () {
          console.log(User);
          User.find(ref.getAuth().uid)
            .then(function (user) {
              $rootScope.state = {
                user: user
              };
            });
        },
        removeUser: function () {
          $rootScope.state = {};
        }
      }
    }
  ]);

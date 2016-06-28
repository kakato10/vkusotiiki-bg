/**
 * Created by kakato10 on 27.06.16.
 */
angular.module('vkusotiikiBgApp')
  .service('Authentication', [ 'ref', '$rootScope', 'State', '$state',
    function (ref, $rootScope, State, $state) {

      function authHandler(error, authData) {
        if (error) {
          console.log('Login Failed!', error);
        } else {
          $state.transitionTo('home');
          console.log('Authenticated successfully with payload:', authData);
        }
      }

      function unAuthHandler(error) {
        if (error) {
          console.log('Logout Failed!', error);
        }
      }

      function require(func) {
        /*jshint validthis:true */
        return function () {
          if ($rootScope.state.user) {
            func.apply(this, arguments);
          }
        };
      }

      function requireIdentity(func, requiredUid) {
        /*jshint validthis:true */
        return function () {
          var currentUser = $rootScope.state.user;
          if (currentUser && requiredUid === currentUser.id) {
            func.apply(this, arguments);
          }
        };
      }

      function bind(scope, funcs) {
        /*jshint validthis:true */
        var auth = this;
        scope.$watch('state.user', function (authenticated) {
          if (authenticated && funcs.whenAuthenticated) {
            funcs.whenAuthenticated(auth.uid);
          } else if (!authenticated && funcs.whenNotAuthenticated) {
            funcs.whenNotAuthenticated();
          }
        });
      }

      ref.onAuth(function (authData) {
        if (authData) {
          State.setUser(authData.uid);
        } else {
          State.removeUser();
        }
      });

      var auth = {
        require        : require,
        requireIdentity: requireIdentity,
        bind           : bind,
        logIn          : function (email, password, remember) {
          ref.authWithPassword({
            email   : email,
            password: password,
            remember: remember
          }, authHandler);
        },
        logOut         : function () {
          ref.unauth(unAuthHandler);
        }
      };

      return auth;
    }
  ]);

(function () {
  'use strict';

  function namedNgIfDirective(name, property) {
    angular.module('vkusotiikiBgApp')
      .directive(name, [ 'namedNgIf',
        function (namedNgIf) {
          return namedNgIf(property);
        }
      ]);
  }

  namedNgIfDirective('esIsLoggedIn', 'state.user');
  namedNgIfDirective('esNotLogged', '!state.user');

})();

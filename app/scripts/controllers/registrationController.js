'use strict';

/**
 * @ngdoc function
 * @name vkusotiikiBgApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the vkusotiikiBgApp
 */
angular.module('vkusotiikiBgApp')
  .controller('RegistrationController', [ '$scope', 'ref', 'swal', '$state', 'User',
    function ($scope, ref, swal, $state, User) {
      if (ref.getAuth()) {
        $state.transitionTo('home');
      }

      $scope.user = {};
      $scope.register = function (user, password, passwordRepeat) {
        if (password === passwordRepeat) {
          ref.createUser({
            email   : user.email,
            password: password
          }, function (error, userData) {
            if (error) {
              switch (error.code) {
                case 'EMAIL_TAKEN':
                  swal({
                    title: 'Error!',
                    text : 'This email has already been registered!',
                    type : 'error'
                  });
                  break;
                case 'INVALID_EMAIL':
                  swal({
                    title: 'Error!',
                    text : 'Invalid email!',
                    type : 'error'
                  });
                  break;
                default:
                  swal({
                    title: 'Error!',
                    text : 'There was an error while creating the user!!',
                    type : 'error'
                  });
              }
            } else {
              this.user.authId = userData.uid;
              User.create(this.user)
                .then(function () {
                  swal({
                    title: 'Success!',
                    text : 'You have been registered!',
                    type : 'success'
                  }, function () {
                    $state.transitionTo('home.landing');
                  });
                });
            }
          }.bind(this));
        } else {
          swal({
            title: 'Error!',
            text : 'Passwords do not match!!',
            type : 'error',
            id   : ''
          });
        }
      };
    }
  ]);

'use strict';

/**
 * @ngdoc overview
 * @name vkusotiikiBgApp
 * @description
 * # vkusotiikiBgApp
 *
 * Main module of the application.
 */
angular
  .module('vkusotiikiBgApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ngRateIt',
    'ui.router',
    'rzModule',
    'js-data'
  ])
  /*globals Firebase, swal */
  .constant('ref', new Firebase('vkusotiiki-bg.firebaseio.com'))
  .constant('swal', swal)
  .config(function ($stateProvider, $urlRouterProvider, DSProvider, DSFirebaseAdapterProvider) {
    DSFirebaseAdapterProvider.defaults.basePath = 'https://vkusotiiki-bg.firebaseio.com';
    $urlRouterProvider.otherwise('/');
    $stateProvider
      .state('home', {
        templateUrl : 'views/main.html',
        controller  : 'MainCtrl',
        controllerAs: 'main',
        url         : '/'
      })
      .state('map', {
        templateUrl : 'views/map.html',
        controller  : 'MapCtrl',
        controllerAs: 'map',
        url         : '/map'
      })
      .state('recipes', {
        templateUrl : 'views/recipes.html',
        controller  : 'RecipesCtrl',
        controllerAs: 'recipeS',
        url         : '/recipes',
        resolve: {
          recipes: ['Recipe', function (Recipe) {
            return Recipe.findAll();
          }]
        }
      })
      .state('newRecipes', {
        templateUrl : 'views/newRecipes.html',
        controller  : 'NewRecipesCtrl',
        controllerAs: 'newRecipes',
        url         : '/newRecipes'
       })
      .state('favouriteRecipes', {
        templateUrl : 'views/favouriteRecipes.html',
        controller  : 'FavouriteRecipesCtrl',
        controllerAs: 'favouriteRecipes',
        url         : '/favouriteRecipes'
      })
      .state('myRecipes', {
        templateUrl : 'views/myRecipes.html',
        controller  : 'MyRecipesCtrl',
        controllerAs: 'myRecipes',
        url         : '/myRecipes'
      })
      .state('offeredRecipes', {
        templateUrl : 'views/offered.html',
        controller  : 'OfferedRecipesCtrl',
        controllerAs: 'offeredRecipes',
        url         : '/offeredRecipes'
      })
      .state('newRecipe', {
        templateUrl : 'views/newRecipe.html',
        controller  : 'NewRecipeCtrl',
        controllerAs: 'newRecipe',
        url         : '/newRecipe',
        resolve: {
          regions: ['Region', function (Region) {
            return Region.findAll();
          }],
          categories: ['Category', function (Category) {
            return Category.findAll();
          }]
        }
      })
      .state('about', {
        templateUrl : 'views/about.html',
        controller  : 'AboutCtrl',
        controllerAs: 'about',
        url         : '/about'
      })
      .state('contacts', {
        templateUrl : 'views/contacts.html',
        controller  : 'ContactsCtrl',
        controllerAs: 'contacts',
        url         : '/contacts'
      })
      .state('login', {
        templateUrl : 'views/login.html',
        controller  : 'LoginCtrl',
        controllerAs: 'login',
        url         : '/login'
      })
      .state('chooseUserRegistration', {
        templateUrl : 'views/chooseUserRegistration.html',
        controller  : 'ChooseUserRegistrationCtrl',
        controllerAs: 'chooseUserRegistration',
        url         : '/chooseUserRegistration'
      })
      .state('registerAsOrdinaryUser', {
        templateUrl : 'views/registerAsOrdinaryUser.html',
        controller  : 'RegistrationController',
        url         : '/registerAsOrdinaryUser'
      })
      .state('editOrdinaryUserProfile', {
        templateUrl : 'views/editOrdinaryUserProfile.html',
        controller  : 'EditOrdinaryUserProfileCtrl',
        controllerAs: 'editOrdinaryUserProfile',
        url         : '/editOrdinaryUserProfile'
      });
  })
  .run(['State', '$rootScope', 'Authentication', function (State, $rootScope, Authentication) {
    $rootScope.logOut = Authentication.logOut;
    $rootScope.state = {};
  }])
  .run(['DS', 'DSFirebaseAdapter',
    function(DS, DSFirebaseAdapter) {
      DS.registerAdapter('firebase', DSFirebaseAdapter, {
        default: true
      });
    }
  ])
  .run(['Recipe', function (Recipe, User, Region, Category) {
    /* jshint unused: false */
  }]);

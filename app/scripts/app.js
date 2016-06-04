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
    'ui.router',
    'rzModule'
  ])
  .config(function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/');
    $stateProvider
      .state('home', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main',
        url: '/'
      })
      .state('recipes', {
        templateUrl: 'views/recipes.html',
        controller: 'RecipesCtrl',
        controllerAs: 'recipeS',
        url: '/recipes'
      })
      .state('favouriteRecipes', {
        templateUrl: 'views/favouriteRecipes.html',
        controller: 'FavouriteRecipesCtrl',
        controllerAs: 'favouriteRecipes',
        url: '/favouriteRecipes'
      })
      .state('myRecipes', {
        templateUrl: 'views/myRecipes.html',
        controller: 'MyRecipesCtrl',
        controllerAs: 'myRecipes',
        url: '/myRecipes'
      })
      .state('offeredRecipes', {
        templateUrl: 'views/offered.html',
        controller: 'OfferedRecipesCtrl',
        controllerAs: 'offeredRecipes',
        url: '/offeredRecipes'
      })
      .state('newRecipe', {
        templateUrl: 'views/newRecipe.html',
        controller: 'NewRecipeCtrl',
        controllerAs: 'newRecipe',
        url: '/newRecipe'
      })
      .state('about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about',
        url: '/about'
      })
      .state('login', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl',
        controllerAs: 'login',
        url: '/login'
      })
      .state('chooseUserRegistration', {
        templateUrl: 'views/chooseUserRegistration.html',
        controller: 'ChooseUserRegistrationCtrl',
        controllerAs: 'chooseUserRegistration',
        url: '/chooseUserRegistration'
      })
      .state('registerAsOrdinaryUser', {
        templateUrl: 'views/registerAsOrdinaryUser.html',
        controller: 'RegisterAsOrdinaryUserCtrl',
        controllerAs: 'registerAsOrdinaryUser',
        url: '/registerAsOrdinaryUser'
      })
      .state('editOrdinaryUserProfile', {
        templateUrl: 'views/editOrdinaryUserProfile.html',
        controller: 'EditOrdinaryUserProfileCtrl',
        controllerAs: 'editOrdinaryUserProfile',
        url: '/editOrdinaryUserProfile'
      });


      

  })

  .run(['$rootScope', function($rootScope){
    // $rootScope.loggedIn = true;
    $rootScope.logOut = function() {
      $rootScope.loggedIn = false;
    };

    $rootScope.logIn = function() {
      $rootScope.loggedIn = true;
    };
  }]);
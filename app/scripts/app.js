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
    'ui.router'
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
      .state('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about',
        url: '/about'
      });

  });

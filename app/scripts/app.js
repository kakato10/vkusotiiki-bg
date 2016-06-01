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
    $urlRouterProvider.otherwise("/");
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
        controllerAs: 'recipe',
        url: '/recipes'
      })
      .state('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about',
        url: '/about'
      });

  });

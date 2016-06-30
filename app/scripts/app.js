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
    $urlRouterProvider.otherwise('/home');
    $stateProvider
      .state('home', {
        abstract: true,
        template: '<div ui-view></div>',
        url     : '/',
        data    : {
          label     : 'Начало',
          redirectTo: 'home.landing'
        }
      })
      .state('home.landing', {
        templateUrl : 'views/recipes.html',
        controller  : 'RecipesCtrl',
        controllerAs: 'recipeS',
        url         : 'home',
        data        : {
          label: 'Начало'
        },
        resolve     : {
          recipes: [ 'Recipe', function (Recipe) {
            return Recipe.findAll({}, {bypassCache: true});
          } ]
        }
      })
      .state('home.map', {
        templateUrl : 'views/map.html',
        controller  : 'MapCtrl',
        controllerAs: 'map',
        url         : 'map',
        data        : {
          label: 'Карта на България'
        }
      })
      .state('home.recipies', {
        url     : 'recipies',
        template: '<div ui-view></div>',
        abstract: true
      })
      .state('home.recipies.list', {
        templateUrl : 'views/recipes.html',
        controller  : 'RecipesCtrl',
        controllerAs: 'recipeS',
        url         : 'list',
        resolve     : {
          recipes: [ 'Recipe', function (Recipe) {
            return Recipe.findAll({}, {bypassCache: true});
          } ]
        },
        data        : {
          label: 'Рецепти'
        }
      })
      .state('home.recipies.new', {
        templateUrl : 'views/newRecipes.html',
        controller  : 'NewRecipesCtrl',
        controllerAs: 'newRecipes',
        url         : 'new',
        resolve     : {
          recipies: [ 'Recipe', function (Recipe) {
            return Recipe.findAll({}, {bypassCache: true})
              .then(function (recipies) {
                recipies.sort(function (a, b) {
                  return new Date(b.createdOn) - new Date(a.createdOn);
                });
                return recipies.slice(0, 5);
              });
          } ]
        },
        data        : {
          label: 'Нови рецепти'
        }
      })
      .state('home.recipies.favourites', {
        templateUrl : 'views/favouriteRecipes.html',
        controller  : 'FavouriteRecipesCtrl',
        controllerAs: 'favouriteRecipes',
        url         : 'favourites',
        resolve     : {
          recipies: [ 'Recipe', '$rootScope',
            function (Recipe, $rootScope) {
              return Recipe.findAll({}, {bypassCache:true})
                .then(function (recipies) {
                  return recipies.filter(function (recipe) {
                    return $rootScope.state.user.likes(recipe.id);
                  })
                });
            } ]
        },
        data        : {
          label: 'Любими рецепти'
        }
      })
      .state('home.recipies.my', {
        templateUrl : 'views/myRecipes.html',
        controller  : 'MyRecipesCtrl',
        controllerAs: 'myRecipes',
        url         : 'my',
        resolve     : {
          recipies: [ 'Recipe', '$rootScope', function (Recipe, $rootScope) {
            return Recipe.findAll({}, {bypassCache: true})
              .then(function (recipies) {
                var userRecipies = recipies.filter(function (recipe) {
                  return recipe.authorId === $rootScope.state.user.id;
                });
                return userRecipies;
              });
          } ]
        },
        data        : {
          label: 'Моите рецепти'
        }
      })
      .state('offeredRecipes', {
        templateUrl : 'views/offered.html',
        controller  : 'OfferedRecipesCtrl',
        controllerAs: 'offeredRecipes',
        url         : 'offeredRecipes'
      })
      .state('home.recipies.create', {
        templateUrl : 'views/newRecipe.html',
        controller  : 'NewRecipeCtrl',
        controllerAs: 'newRecipe',
        url         : 'create',
        resolve     : {
          regions   : [ 'Region', function (Region) {
            return Region.findAll();
          } ],
          categories: [ 'Category', function (Category) {
            return Category.findAll();
          } ]
        },
        data        : {
          label: 'Нова рецепта'
        }
      })
      .state('home.about', {
        templateUrl : 'views/about.html',
        controller  : 'AboutCtrl',
        controllerAs: 'about',
        url         : 'about',
        data        : {
          label: 'За нас'
        }
      })
      .state('home.contacts', {
        templateUrl : 'views/contacts.html',
        controller  : 'ContactsCtrl',
        controllerAs: 'contacts',
        url         : 'contacts',
        data        : {
          label: 'Контакти'
        }
      })
      .state('login', {
        templateUrl : 'views/login.html',
        controller  : 'LoginCtrl',
        controllerAs: 'login',
        url         : '/login',
        data        : {
          label: 'Вписване'
        }

      })
      .state('chooseUserRegistration', {
        templateUrl : 'views/chooseUserRegistration.html',
        controller  : 'ChooseUserRegistrationCtrl',
        controllerAs: 'chooseUserRegistration',
        url         : 'chooseUserRegistration'
      })
      .state('register', {
        templateUrl: 'views/registerAsOrdinaryUser.html',
        controller : 'RegistrationController',
        url        : '/registration',
        data       : {
          label: 'Регистрация'
        }
      })
      .state('editOrdinaryUserProfile', {
        templateUrl : 'views/editOrdinaryUserProfile.html',
        controller  : 'EditOrdinaryUserProfileCtrl',
        controllerAs: 'editOrdinaryUserProfile',
        url         : '/editOrdinaryUserProfile'
      })
      .state('home.recipies.details', {
        templateUrl : 'views/recipeDetails.html',
        controller  : 'RecipeDetailsCtrl',
        controllerAs: 'recipeDetails',
        url         : 'recipeDetails/:id',
        resolve     : {
          recipe  : [ '$stateParams', 'Recipe',
            function ($stateParams, Recipe) {
              return Recipe.find($stateParams.id);
            } ],
          author  : [ '$stateParams', 'Recipe', 'User',
            function ($stateParams, Recipe, User) {
              return Recipe.find($stateParams.id)
                .then(function (recipe) {
                  return User.find(recipe.authorId);
                });
            } ],
          category: [ '$stateParams', 'Recipe', 'Category',
            function ($stateParams, Recipe, Category) {
              return Recipe.find($stateParams.id)
                .then(function (recipe) {
                  return Category.find(recipe.category.slice(1));
                })
            } ],
          region  : [ '$stateParams', 'Recipe', 'Region', function ($stateParams, Recipe, Region) {
            return Recipe.find($stateParams.id)
              .then(function (recipe) {
                console.log(recipe);
                return Region.find(recipe.region.slice(1));
              })
          } ]
        },
        data        : {
          label: 'Разглеждане на рецепта'
        }
      });
  })
  .run([ 'State', '$rootScope', 'Authentication', function (State, $rootScope, Authentication) {
    $rootScope.logOut = Authentication.logOut;
    $rootScope.state = {};
  } ])
  .run([ 'DS', 'DSFirebaseAdapter', 'DSHttpAdapter',
    function (DS, DSFirebaseAdapter, DSHttpAdapter) {
      DS.registerAdapter('firebase', DSFirebaseAdapter, {
        default: true
      });
      // DS.registerAdapter('http', DSHttpAdapter, {
      //   default: true
      // });
    }
  ])
  .run([ '$rootScope', '$state', function ($rootScope, $state) {
    $rootScope.$on('$stateChangeSuccess',
      function (event, toState, toParams, fromState, fromParams, options) {
        var state = $state.$current;

        var breadCrumbs = [];
        while (state.parent) {
          var breadCrumb = {
            name: state.data.label
          }
          var redirectTo;

          if (!state.abstract) {
            breadCrumb.stateUrl = state.name;
          } else {
            if (state.name === 'home') {
              breadCrumb.stateUrl = 'home.landing';
            } else {
              state = state.parent;
              console.log(state.name);
              continue;
            }
          }
          breadCrumbs.unshift(breadCrumb);

          state = state.parent;
        }
        breadCrumbs[ breadCrumbs.length - 1 ].disabled = true;
        $rootScope.breadCrumbs = breadCrumbs;
      });
  } ])
  .run([ 'Recipe', 'User', 'Region', 'Category', 'Rating',
    function (Recipe, User, Region, Category, Rating) {
      /* jshint unused: false */
    } ]);

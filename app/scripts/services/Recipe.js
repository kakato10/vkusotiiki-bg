/**
 * Created by kakato10 on 28.06.16.
 */
'use strict';
angular.module('vkusotiikiBgApp')
  .service('Recipe', [ '$rootScope', 'ref', 'User', 'DS',
    function ($rootScope, ref, User, DS) {
      var mapping = {
        id: 'id',
        title: 'name',
        description: 'description',
        time: 'duration',
        ishesCount: 'servings',
        difficulty: 'difficulty',
        authorId: 'user',
        category: 'category',
        region: 'region',
        holiday: 'holiday',
        dish: 'dish',
        season: 'season',
        ingredients: 'ingredients',
        createdOn: 'time',
        rating: 'total_rate'
      };
      return DS.defineResource({
        name: 'Recipe',
        endpoint: '/recipe',
        methods: {
          mapping: function () {
            return mapping;
          }
        }
      });
    }
  ]);

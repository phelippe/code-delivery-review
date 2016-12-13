angular.module('starter.services').
factory('OrderService', [
    '$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/api/client/order/:id', {id: '@id'}, {
            query: {
                isArray: false
            }
        });
    }]
);
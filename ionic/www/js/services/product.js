angular.module('starter.services').
factory('ProductService', [
    '$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/api/client/products', {}, {
            query: {
                isArray: false
            }
        });
    }]
);
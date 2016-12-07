angular.module('starter.services').
factory('ClientService', [
    '$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/api/authenticated', {}, {
            query: {
                isArray: false
            }
        });
    }]
);
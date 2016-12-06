angular.module('starter.controllers').
    controller('ClientViewProductsCtrl', ['$scope', '$state', 'ProductService', function($scope, $state, ProductService){

        ProductService.query({}, function (data) {
            console.log(data.data);
        });
        console.log('ctrl view prod');

    }]);
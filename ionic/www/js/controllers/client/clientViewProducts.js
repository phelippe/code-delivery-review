angular.module('starter.controllers').
    controller('ClientViewProductsCtrl', ['$scope', '$state', 'ProductService', function($scope, $state, ProductService){

        $scope.products = [];

        products = ProductService.query({}, function (data) {
            //console.log(data.data);

            $scope.products = data.data;
        });

    }]);
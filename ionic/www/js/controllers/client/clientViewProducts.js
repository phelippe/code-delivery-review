angular.module('starter.controllers').
    controller('ClientViewProductsCtrl', ['$scope', '$state', 'ProductService', function($scope, $state, ProductService){

        $scope.proucts = [];

        products = ProductService.query({}, function (data) {
            console.log(data.data);

            $scope.proucts = data.data;
        });
        //console.log('ctrl view prod');

    }]);
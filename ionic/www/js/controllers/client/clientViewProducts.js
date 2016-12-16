angular.module('starter.controllers').
controller('ClientViewProductsCtrl', [
    '$scope', '$state', 'ProductService', '$ionicLoading', '$cart', '$localStorage',
    function($scope, $state, ProductService, $ionicLoading, $cart, $localStorage){

        $scope.products = [];

        $ionicLoading.show({
           template: 'Carregando ...'
        });

        products = ProductService.query({}, function (data) {
            $scope.products = data.data;
            $ionicLoading.hide();
        }, function(error){
            //console.log(error);
            $ionicLoading.hide();
        });

        $scope.addItem = function (item) {
            item.qtd = 1;
            $cart.addItem(item);
            $state.go('client.checkout');
        }
    }
]);
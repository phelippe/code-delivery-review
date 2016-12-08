angular.module('starter.controllers').
controller('ClientViewProductsCtrl', [
    '$scope', '$state', 'ProductService', '$ionicLoading', '$cart', '$localStorage',
    function($scope, $state, ProductService, $ionicLoading, $cart, $localStorage){

        /*console.log($localStorage.setObject('cart', {
            name: "Ionic",
            version: "1.1.0"
        }));*/
        //delete window.localStorage['cart'];
        //$localStorage.delete('cart');

        $scope.products = [];

        $ionicLoading.show({
           template: 'Carregando ...'
        });

        products = ProductService.query({}, function (data) {
            //console.log(data.data);

            $scope.products = data.data;
            $ionicLoading.hide();
        }, function(error){
            $ionicLoading.hide();
        });

        $scope.addItem = function (item) {
            item.qtd = 1;
            $cart.addItem(item);
            $state.go('client.checkout');
        }
    }
]);
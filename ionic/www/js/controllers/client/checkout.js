angular.module('starter.controllers').
controller('ClientCheckoutCtrl', [
    '$scope', '$state', '$cart',
    function($scope, $state, $cart){

        var cart = $cart.get();

        $scope.items = cart.items;
        $scope.total = cart.total;

        $scope.removeItem = function(i){
            $cart.removeItem(i);
            $scope.items.splice(i, 1);
            $scope.total = $cart.get().total;
        };

        $scope.openProductDetail = function (i) {
            $state.go('client.checkout_item_detail', {index: i});
        }

        $scope.openListProducts = function (i) {
            $state.go('client.view_products', { index: i})
        }

    }]
);
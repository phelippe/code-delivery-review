angular.module('starter.controllers').
    controller('ClientCheckoutSuccessfulCtrl', [
    '$scope', '$state', '$cart',
    function($scope, $state, $cart){

        var cart = $cart.get();

        $scope.items = cart.items;
        $scope.total = $cart.getTotalFinal();
        $scope.cupom = cart.cupom;

        $cart.clear();


        $scope.openListOrder = function(){
            $state.go('client.orders')
        };
    }
]);
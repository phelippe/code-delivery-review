angular.module('starter.controllers').
    controller('ClientOrderListCtrl', [
    '$scope', '$state', '$cart', 'OrderService',
    function($scope, $state, $cart, OrderService){

        console.log('order list');
        /*var cart = $cart.get();

        $scope.items = cart.items;
        $scope.total = cart.total;

        $cart.clear();


        $scope.openListOrder = function(){
            $state.go('client.orders')
        };*/

        OrderService.save({id: null},{items: items}, function(data){ //#sucesso
            $ionicLoading.hide();
            $state.go('client.checkout_successful');
        }, function (responseError) { //#erro
            $ionicLoading.hide();
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Pedido não realizado! Tente novamente.'
            });
        });
    }
]);
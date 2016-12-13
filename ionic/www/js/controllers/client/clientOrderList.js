angular.module('starter.controllers').
    controller('ClientOrderListCtrl', [
    '$scope', '$state', '$cart', 'OrderService','$ionicLoading', '$ionicPopup',
    function($scope, $state, $cart, OrderService, $ionicLoading, $ionicPopup){

        $scope.orders = [];

        $ionicLoading.show({
            template: 'Carregando ...'
        });


        orders = OrderService.query({}, function(data){ //#sucesso

            $scope.orders = data.data;

            $ionicLoading.hide();
            //$state.go('client.checkout_successful');
        }, function (responseError) { //#erro
            //console.log(response  Error);
            $ionicLoading.hide();
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar os pedidos. Tente novamente.'
            });
        });
    }
]);
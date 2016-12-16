angular.module('starter.controllers').
    controller('ClientOrderShowCtrl', [
    '$scope', '$stateParams', 'OrderService', '$ionicLoading',
    function($scope, $stateParams, OrderService, $ionicLoading){

        $scope.order = {};

        $ionicLoading.show({
            template: 'Carregando ...'
        });

        OrderService.get({
            id: $stateParams.id,
            include: 'items,cupom'
        },function(data){ //#sucesso

            $scope.order = data.data;

            $ionicLoading.hide();
        }, function (responseError) { //#erro
            $ionicLoading.hide();
            console.log(responseError);
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar o pedido. Tente novamente.'
            });
        });
    }
]);
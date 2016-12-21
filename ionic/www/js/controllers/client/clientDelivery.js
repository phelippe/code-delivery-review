angular.module('starter.controllers').
    controller('ClientDeliveryCtrl', [
    '$scope', '$stateParams', 'ClientOrderService', '$ionicLoading',
    function($scope, $stateParams, ClientOrderService, $ionicLoading){

        $scope.order = {};

        $ionicLoading.show({
            template: 'Carregando ...'
        });

        ClientOrderService.get({
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
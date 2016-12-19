angular.module('starter.controllers').
    controller('DeliverymanOrderShowCtrl', [
    '$scope', '$stateParams', 'DeliverymanOrderService', '$ionicLoading', '$ionicPopup',
    function($scope, $stateParams, DeliverymanOrderService, $ionicLoading, $ionicPopup){

        $scope.order = {};

        $ionicLoading.show({
            template: 'Carregando ...'
        });

        DeliverymanOrderService.get({
            id: $stateParams.id,
            include: 'items,cupom'
        },function(data){ //#sucesso

            //console.log(data.data);
            $scope.order = data.data;

            $ionicLoading.hide();
        }, function (responseError) { //#erro
            $ionicLoading.hide();
            //console.log(responseError);
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar o pedido. Tente novamente.'
            });
        });

        DeliverymanOrderService.updateStatus({id: $stateParams.id}, {status:1}, function (data) {
            console.log(data);
        })

        DeliverymanOrderService.geo({id: $stateParams.id}, {lat: -23.4444, long: -43.4444}, function (data) {
            console.log(data);
        })
    }
]);
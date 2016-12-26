angular.module('starter.controllers').
    controller('DeliverymanOrderShowCtrl', [
    '$scope', '$stateParams', 'DeliverymanOrderService', '$ionicLoading', '$ionicPopup', '$cordovaGeolocation',
    function($scope, $stateParams, DeliverymanOrderService, $ionicLoading, $ionicPopup, $cordovaGeolocation){

        var watch;

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

        $scope.goToDelivery = function(){
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Para parar a localização dê OK.'
            }).then(function(){
                stopWatchPosition();
            });
            DeliverymanOrderService.updateStatus({id: $stateParams.id}, {status: 1}, function () {
                var watchOptions = {
                    timeout: 3000,
                    enableHighAccuracy: false
                };

                watch = $cordovaGeolocation.watchPosition(watchOptions);

                watch.then(
                    null, //metodo de sucesso
                    function (responseError){ //erro
                        console.log(responseError);
                    },
                    function (position){ // metodo de notificação
                        //console.log(position, watch);
                        DeliverymanOrderService.geo({id: $stateParams.id}, {
                            lat: position.coords.latitude,
                            long: position.coords.longitude,
                        })
                    }
                );
            });
        };

        function stopWatchPosition(){
            if(watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')){
                $cordovaGeolocation.clearWatch(watch.watchID);
            }
        }
    }
]);
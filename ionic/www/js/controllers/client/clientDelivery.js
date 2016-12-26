angular.module('starter.controllers').
    controller('ClientDeliveryCtrl', [
    '$scope', '$stateParams', 'ClientOrderService', '$ionicLoading', '$ionicPopup', 'UserData', '$pusher', '$window',
    function($scope, $stateParams, ClientOrderService, $ionicLoading, $ionicPopup, UserData, $pusher, $window){

        var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2';
        $scope.order = {};
        $scope.map = {
            center: {
                latitude: -5.834001,
                longitude: -35.2217452
            },
            zoom: 12,
        };

        $scope.markers = [];

        //console.log($scope.map);

        $ionicLoading.show({
            template: 'Carregando ...'
        });

        ClientOrderService.get({
            id: $stateParams.id,
            include: 'items,cupom'
        },function(data){ //#sucesso

            $scope.order = data.data;
            $ionicLoading.hide();
            if (parseInt($scope.order.status, 10) == 1){
                initMarkers($scope.order);
            } else {
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'O pedido ainda não possui um status de entrega'
                });
            }
        }, function (responseError) { //#erro
            $ionicLoading.hide();
            console.log(responseError);
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar o pedido. Tente novamente.'
            });
        });

        function initMarkers(order){
            var client = UserData.get().client.data,
                address = client.zipcode + ', ' +
                    client.address + ', ' +
                    client.city + ' - ' +
                    client.state;
            //console.log(client);
            createMarkerClient(address);
            watchPositionDeliveryman(order.hash);
        };

        function createMarkerClient(address){
            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                address: address
            }, function (results, status) {
                /*console.log(results);
                console.log(status);*/
                if(status == google.maps.GeocoderStatus.OK){
                    var lat = results[0].geometry.location.lat(),
                        long = results[0].geometry.location.lng();

                    $scope.markers.push({
                        id: 'client',
                        coords: {
                            latitude: lat,
                            longitude: long,
                        },
                        options: {
                            title: 'Local de entrega'
                        }
                    });
                } else {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Não foi possível localizar o endereço'
                    });
                }
            });
        };

        function watchPositionDeliveryman(channel){
            var pusher = $pusher($window.client),
                channel = pusher.subscribe(channel);

            channel.bind('CodeDelivery\\Events\\GetLocationDeliveyman', function (data) {
                console.log(data);

                var lat = data.geo.lat,
                    long = data.geo.long;

                if($scope.markers.length == 1){
                    $scope.markers.push({
                        id: 'entregador',
                        coords: {
                            latitude: lat,
                            longitude: long,
                        },
                        options: {
                            title: 'Entregador',
                            icon: iconUrl+'/icon47.png'
                        }
                    });
                    return;
                }
                for( var key in $scope.markers){
                    if($scope.markers[key.id] == 'entregador'){
                        $scope.markers[key].cords = {
                            latitude: lat,
                            longitude: long,
                        }
                    }
                }

            });
        };
    }
]);
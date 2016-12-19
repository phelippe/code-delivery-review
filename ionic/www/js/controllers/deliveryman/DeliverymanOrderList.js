angular.module('starter.controllers').
    controller('DeliverymanOrderListCtrl', [
    '$scope', '$state', '$cart', 'DeliverymanOrderService','$ionicLoading', '$ionicPopup',
    function($scope, $state, $cart, DeliverymanOrderService, $ionicLoading, $ionicPopup){

        $scope.orders = [];

        $ionicLoading.show({
            template: 'Carregando ...'
        });


        function getOrders() {
            return DeliverymanOrderService.query({
                id: null,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }).$promise;
        };

        getOrders().then(function(data){ //#sucesso

            $scope.orders = data.data;

            $ionicLoading.hide();
            //console.log($scope.orders);
            //$state.go('client.checkout_successful');
        }, function (responseError) { //#erro
            console.log(responseError);
            $ionicLoading.hide();
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar os pedidos. Tente novamente.'
            });
        });

        $scope.doRefresh = function(){
            getOrders().then(function(data){ //#sucesso
                $scope.orders = data.data;
                $scope.$broadcast('scroll.refreshComplete');
            }, function (responseError) { //#erro
                $scope.$broadcast('scroll.refreshComplete');
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Ocorreu um erro ao tentar carregar os dados. Tente novamente.'
                });
            });
        };

        $scope.openOrderDetail = function(index){
            $state.go('deliveryman.order_detail', {id: index});
        }
    }
]);
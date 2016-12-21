angular.module('starter.controllers').
    controller('ClientOrderListCtrl', [
    '$scope', '$state', '$cart', 'ClientOrderService','$ionicLoading', '$ionicPopup', '$ionicActionSheet',
    function($scope, $state, $cart, ClientOrderService, $ionicLoading, $ionicPopup, $ionicActionSheet){

        $scope.orders = [];

        $ionicLoading.show({
            template: 'Carregando ...'
        });


        function getOrders() {
            return ClientOrderService.query({
                id: null,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }).$promise;
        };

        getOrders().then(function(data){ //#sucesso

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

        $scope.openOrderDetail = function(order){
            $state.go('client.order_detail', {id: order.id});
        }

        $scope.showActionSheet = function (order){
            $ionicActionSheet.show({
                buttons: [
                    {text: 'Ver Detalhes'},
                    {text: 'Ver entrega'}
                ],
                titleText: 'O que fazer ?',
                cancelText: 'Cancelar',
                cancel: function(){ //Cancelamento
                    //console.log('cancel');
                },
                buttonClicked: function(index){ //Cancelamento
                    switch (index){
                        case 0:
                            $state.go('client.order_detail', {id: order.id});
                            break;
                        case 1:
                            $state.go('client.view_delivery', {id: order.id});
                            break;
                    }
                },
            });
        };
    }
]);
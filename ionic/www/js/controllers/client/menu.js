angular.module('starter.controllers').
    controller('ClientMenuCtrl', [
    '$scope', '$state', '$ionicLoading', 'ClientService', '$cart',
    function($scope, $state, $ionicLoading, ClientService, $cart){

        console.log($cart.get().items.length);
        $scope.cart = {
            qtd: $cart.get().items.length
        }
        $scope.user = {
            name: ''
        };

        $ionicLoading.show({
            template: 'Carregando ...'
        });

        orders = ClientService.authenticated({}, function(data){ //#sucesso

            $scope.user = data.data;

            $ionicLoading.hide();
            //$state.go('client.checkout_successful');
        }, function (responseError) { //#erro
            //console.log(response  Error);
            $ionicLoading.hide();
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Ocorreu um erro ao tentar acessar os dados do usuário. Tente novamente.'
            });
        });

        $scope.goCart = function(){
            $state.go('client.checkout');
        }

        $scope.$on('$stateChangeSuccess', function(event){
            $scope.cart.qtd = $cart.get().items.length;
        });
    }
]);
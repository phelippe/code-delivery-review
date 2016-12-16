angular.module('starter.controllers').
    controller('DeliverymanMenuCtrl', [
    '$scope', '$state', '$ionicLoading', '$ionicPopup', 'ClientService', '$cart', '$cookies',
    function($scope, $state, $ionicLoading, $ionicPopup, ClientService, $cart, $cookies){
        //console.log($cookies.get('token'));
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

        $scope.logout = function(){
            $cookies.remove('token');
            //console.log($cookies.get('token'));
            $state.go('login');
        }
    }
]);
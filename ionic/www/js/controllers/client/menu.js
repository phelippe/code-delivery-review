angular.module('starter.controllers').
    controller('ClientMenuCtrl', [
    '$scope', '$state', '$ionicLoading', 'ClientService',
    function($scope, $state, $ionicLoading, ClientService){

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
    }
]);
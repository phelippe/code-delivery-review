angular.module('starter.controllers').
    controller('LoginCtrl', [
    '$scope', 'OAuth', 'OAuthToken', '$ionicPopup', '$state', 'UserData', 'ClientService',
    function($scope, OAuth, OAuthToken, $ionicPopup, $state, UserData, ClientService){

        $scope.user = {
            username: '',
            password: ''
        }

        $scope.login = function(){
            var promise = OAuth.getAccessToken($scope.user);

            promise
                .then(function(data){
                    return ClientService.authenticated({include: 'client'}).$promise;
                }).then(function(data){
                    console.log(data.data);
                    UserData.set(data.data);
                    if(data.data.role == 'deliveryman'){
                        $state.go('deliveryman.orders');
                    } else {
                        $state.go('client.checkout');
                    }
                }, function(responseError){
                    UserData.set(null);
                    OAuthToken.removeToken();
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Login e/ou senha inválidos'
                    });
                    console.debug(responseError);
            });
        };

    }]);
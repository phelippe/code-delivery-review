angular.module('starter.controllers',[]).
    controller('LoginCtrl', ['$scope', 'OAuth', '$ionicPopup', '$state', function($scope, OAuth, $ionicPopup, $state){

        $scope.user = {
            username: '',
            password: ''
        }

        $scope.login = function(){
            OAuth.getAccessToken($scope.user)
                .then(function(data){

                    /*console.log(data);
                    console.log($cookies.getObject('token'));*/
                    $state.go('home');

                }, function (responseError) {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Login e/ou senha inválidos'
                    });
                    console.debug(responseError);
            });
        };
    }]);
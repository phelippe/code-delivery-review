angular.module('starter.controllers').
    controller('ClientMenuCtrl', [
    '$scope', '$state', '$ionicLoading', '$ionicPopup', 'UserData', '$cart', '$cookies',
    function($scope, $state, $ionicLoading, $ionicPopup, UserData, $cart, $cookies){
        //console.log($cookies.get('token'));
        $scope.cart = {
            qtd: $cart.get().items.length
        }
        $scope.user = UserData.get();

        //console.log($scope.user);

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
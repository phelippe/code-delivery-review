angular.module('starter.controllers').
controller('ClientCheckoutCtrl', [
    '$scope', '$state', '$cart', 'OrderService', '$ionicLoading', '$ionicPopup', 'CupomService',
    function($scope, $state, $cart, OrderService, $ionicLoading, $ionicPopup, CupomService){

        /*CupomService.get({code: 1234}, function (data) {
            //console.log(data.data);
            $cart.setCupom(data.data.code, data.data.value);
            console.log($cart.getTotalFinal());
            /!*console.log($cart.get());
            $cart.removeCupom();
            console.log($cart.get());*!/
        }, function(error){
            console.log(error);
        });*/
        var cart = $cart.get();

        $scope.items = cart.items;
        $scope.total = cart.total;
        $scope.cupom = $cart.getTotalFinal();

        $scope.removeItem = function(i){
            $cart.removeItem(i);
            $scope.items.splice(i, 1);
            $scope.total = $cart.getTotalFinal()
        };

        $scope.openProductDetail = function (i) {
            $state.go('client.checkout_item_detail', {index: i});
        };

        $scope.openListProducts = function (i) {
            $state.go('client.view_products', { index: i})
        };

        $scope.save = function(){
            var o = {items: angular.copy($scope.items)};

            angular.forEach(o.items, function (item) {
                item.product_id = item.id;
            });

            $ionicLoading.show({
                template: 'Carregando ...'
            });

            if($scope.cupom.value){
                o.cupom_code = $scope.cupom.code;
            }
            OrderService.save({id: null}, o, function(data){ //#sucesso
                $ionicLoading.hide();
                $state.go('client.checkout_successful');
            }, function (responseError) { //#erro
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Pedido não realizado! Tente novamente.'
                });
            });
        };

        $scope.readBarCode = function () {
            getCupomValue(1234);
        };

        $scope.removeCupom = function () {
            $cart.removeCupom();
            $scope.cupom = $cart.get().cupom;
            $scope.total = $cart.getTotalFinal();
        };

        function getCupomValue(code){
            $ionicLoading.show({
                template: 'Buscando...',
            });
            CupomService.get({code: code}, function(data){
                $cart.setCupom(data.data.code, data.data.value);
                $scope.cupom = $cart.get().cupom;
                $scope.total = $cart.getTotalFinal();
                $ionicLoading.hide();
            }, function (responseError) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Cupom não existe ou inválido.'
                });
            });
        }

    }]
);
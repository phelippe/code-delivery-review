angular.module('starter.controllers').
controller('ClientProfileCtrl', ['$scope', '$state', 'ClientService', function($scope, $state, ClientService){

    //console.log('asd');
    $scope.client = [];
    client = ClientService.query({}, function (data) {
        console.log(data);

        $scope.client = data.data;
    });

}]);

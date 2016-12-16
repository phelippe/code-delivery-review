angular.module('starter.controllers')
    .filter('join', function(){
        return function (input, joinStr){
            return input.join(joinStr);
        };

});
angular.module('starter.controllers')
    .filter('join', function(){
        return function (input, joinStr){
            //console.log(joinStr, input);
            return input.join(joinStr);
        };

});
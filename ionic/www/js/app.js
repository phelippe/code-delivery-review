// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'

angular.module('starter.controllers', []);
angular.module('starter.services', []);
angular.module('starter.filters', []);

angular.module('starter', [
    'ionic', 'angular-oauth2', 'starter.controllers', 'starter.services', 'ngResource', 'ngCordova',
    'starter.filters', 'uiGmapgoogle-maps', 'pusher-angular'
])
    .constant('appConfig', {
        baseUrl: 'http://localhost:8000',
        //baseUrl: 'http://192.168.1.119:8000',
        pusherKey: '0c268d939687884d3f58',
        order: {
            status: [
                { value: 0, label: 'Não iniciada'},
                { value: 1, label: 'Despachada'},
                { value: 2, label: 'Em rota de entrega'},
                { value: 3, label: 'Entregue'},
            ]
        }
    })

    .run(function($ionicPlatform, $window, appConfig) {

      $window.client = new Pusher(appConfig.pusherKey);

      $ionicPlatform.ready(function() {
        if(window.cordova && window.cordova.plugins.Keyboard) {
          // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
          // for form inputs)
          cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

          // Don't remove this line unless you know what you are doing. It stops the viewport
          // from snapping when text inputs are focused. Ionic handles this internally for
          // a much nicer keyboard experience.
          cordova.plugins.Keyboard.disableScroll(true);
        }
        if(window.StatusBar) {
          StatusBar.styleDefault();
        }
      });
    })

    .config(function( $stateProvider, $urlRouterProvider, OAuthProvider, OAuthTokenProvider, appConfig ){

        OAuthProvider.configure({
            baseUrl: appConfig.baseUrl,
            clientId: 'appid01',
            clientSecret: 'secret', // optional
            grantPath: 'oauth/access_token',
            revokePath: 'oauth/access_token/revoke'
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });

        $stateProvider
            .state('login', {
                url: '/login',
                templateUrl: 'templates/login.html',
                controller: 'LoginCtrl',
            })
            .state('home', {
                url: '/home',
                templateUrl: 'templates/home.html',
                controller: function($scope){
                    console.log('HOME');
                },
            })
            .state('client', {
                abstract: true,
                cache: false,
                url: '/client',
                //template: '<ion-nav-view/>'
                templateUrl: 'templates/client/menu.html',
                controller: 'ClientMenuCtrl'
            })
            .state('client.authenticated', {
                url: '/authenticated',
                templateUrl: 'templates/client/authenticated.html',
                controller: 'ClientProfileCtrl'
            })
            .state('client.orders', {
                //cache: false, #opção 1 |  opção 2: utilizado refresher
                url: '/orders',
                templateUrl: 'templates/client/order_list.html',
                controller: 'ClientOrderListCtrl'
            })
            .state('client.order_detail', {
                url: '/order/:id',
                templateUrl: 'templates/client/order_show.html',
                controller: 'ClientOrderShowCtrl'
            })
            .state('client.view_delivery', {
                url: '/delivery/:id',
                templateUrl: 'templates/client/order_delivery.html',
                controller: 'ClientDeliveryCtrl'
            })
            .state('client.checkout', {
                cache: false,
                url: '/checkout',
                templateUrl: 'templates/client/checkout.html',
                controller: 'ClientCheckoutCtrl'
            })
            .state('client.checkout_item_detail', {
                url: '/checkout/detail/:index',
                templateUrl: 'templates/client/checkout_item_detail.html',
                controller: 'ClientCheckoutDetailCtrl'
            })
            .state('client.checkout_successful', {
                cache: false,
                url: '/checkout/successful',
                templateUrl: 'templates/client/checkout_successful.html',
                controller: 'ClientCheckoutSuccessfulCtrl'
            })
            .state('client.view_products', {
                url: '/view-products',
                templateUrl: 'templates/client/view_products.html',
                controller: 'ClientViewProductsCtrl'
            })
            .state('deliveryman', {
                abstract: true,
                cache: false,
                url: '/deliveryman',
                templateUrl: 'templates/deliveryman/menu.html',
                controller: 'DeliverymanMenuCtrl'
            })
            .state('deliveryman.orders', {
                url: '/orders',
                templateUrl: 'templates/deliveryman/order_list.html',
                controller: 'DeliverymanOrderListCtrl'
            })
            .state('deliveryman.order_detail', {
                cache: false,
                url: '/order/:id',
                templateUrl: 'templates/deliveryman/order_show.html',
                controller: 'DeliverymanOrderShowCtrl'
            })

        $urlRouterProvider.otherwise('/login');

        /*$provide.decorator('OAuthToken', [
            '$localStorage', '$delegate',
            $localStorage, $delegate,
            function(){
                //console.log($delegate);
                Object.defineProperties($delegate, {
                    setToken: {
                        value: function(data){
                            return $localStorage.setObject('token', data);
                        },
                        enumerable: true,
                        configurable: true,
                        writable: true
                    },
                    getToken: {
                        value: function(){
                            return $localStorage.getObject('token');
                        },
                        enumerable: true,
                        configurable: true,
                        writable: true
                    },
                    removeToken: {
                        value: function(){
                            return $localStorage.getObject('token', null);
                        },
                        enumerable: true,
                        configurable: true,
                        writable: true
                    }
                });
            }
        ]);*/
    })
    .run(function($rootScope, OAuth, $state) {
        $rootScope.$on('$locationChangeStart', function(a, nextState, currentState){
            //console.log('asd', a, b, c);
            //console.log(OAuth.isAuthenticated());
            if(!OAuth.isAuthenticated()){
                /*console.log('1');
                try{
                    console.log('refresh token');
                    console.log(OAuth.getRefreshToken());
                    $state.go(nextState);
                } catch (e){
                    console.log('va login');*/
                    $state.go('login');
                //}
            }
        });
        $rootScope.$on('oauth:error', function (event, data) {
            console.log('oauthError', event, data);
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === rejection.data.error) {
                $state.go('login');
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('invalid_token' === rejection.data.error) {
                return OAuth.getRefreshToken();
            }

            // Redirect to `/login` with the `error_reason`.
            //return $window.location.href = '/login?error_reason=' + rejection.data.error;

            $state.go('login');
        })
    })
    .service('cart', function(){
        this.items = [];
    });
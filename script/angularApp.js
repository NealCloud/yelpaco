angular.module('tacoFinder', ['ui.router'])
    /**
     * runs the app and sets the state and stateParams to global scope
     * so I can use the end of urls as parameters
     * */
    .run(['$rootScope', '$state', '$stateParams',
        function($rootScope, $state, $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;
        }
    ])
    /**
     * config for the ui routes
     * allows for multiple views inside a template and dynamic urls
     * */
    .config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/landing');

        $stateProvider
        //basic routing linking with # is no longer needed use ui-serf='landing'
            .state('landing', {
                url: '/landing',
                templateUrl: 'pages/landing.html',
                controller: 'headCtrl',
                controllerAs: 'hc'
            })
            .state('listings', {
                url: '/listings',
                templateUrl: 'pages/listings.html',
                controller: 'listingCtrl',
                controllerAs: 'lc'
            })
    });

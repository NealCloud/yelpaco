angular.module('tacoFinder')
    /**
     * controller for the header
     * can call login and out
     * **/
    .controller("headCtrl", function ($scope, tacoServe) {
       var headScope = this;
       this.tacoTitle = "TACOS FINDER";
       this.getUserLoc = tacoServe.userFinder;
        this.tacoFinder = function(){
            tacoServe.goToListing('listings');
        };
        function init(){
            headScope.getUserLoc();
        }
        init();
    })
    .controller("listingCtrl", function ($scope, tacoServe) {
        this.tacoList = tacoServe.tacoHolder;
        this.getDirections = tacoFinder.goTaco;
    });
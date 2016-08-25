angular.module('tacoFinder')
    /**
     * controller for the header
     * can call login and out
     * **/
    .controller("headCtrl", function ($scope, tacoServe) {
        var headScope = this;
        this.tacoTitle = "TACOS FINDER";
        this.getUserLoc = tacoServe.userFinder;
        this.zip = null;
        this.tacoLoading = false;

        this.tacoFinder = function(){
            if(tacoServe.userLocation.zip || headScope.zip){
                tacoServe.userLocation.zip = headScope.zip;
                this.tacoLoading = true;
                tacoServe.getTacoList();

            }
            else{
                console.log('no zip given');
            }
        };
        function init(){
            headScope.getUserLoc();
        }
        init();
    })
    .controller("listingCtrl", function ($scope, tacoServe) {
        this.tacoList = tacoServe.tacoHolder;
        this.getDirections = tacoServe.tacoDirection;
        this.user = tacoServe.userLocation;
    });
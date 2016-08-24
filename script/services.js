angular.module('tacoFinder')
    /**
     * controller for the header
     * can call login and out
     * **/
    .service("tacoServe", function ($location) {
        var tacoScope = this;
        this.tacoHolder = null;
        this.userLocation = null;

        this.userFinder = function(){
            console.log(tacoScope.tacoHolder);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                   tacoScope.userLocation = {
                       latitude: position.coords.latitude,
                       Longitude: position.coords.longitude
                   };
                    console.log('user location found', tacoScope.userLocation);
                });
            } else {
                tacoScope.userLocation = null;
                console.log('no user location');
            }
        };

        this.getTacoList = function(){

            tacoScope.tacoHolder = tacoFinder.getTacos;
        };

        this.goToListing = function(id){
            $location.path(id);
            tacoScope.getTacoList();
        }
    });
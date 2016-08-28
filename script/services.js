angular.module('tacoFinder')
    /**
     * controller for the header
     * can call login and out
     * **/
    .service("tacoServe", function ($location, $http) {
        var tacoScope = this;
        this.tacoLoad = false;
        this.tacoHolder = null;
        this.userLocation = {lat: null, lon: null, zip: null};

        this.userFinder = function(){
            console.log(tacoScope.tacoHolder);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    tacoScope.userLocation.lat = position.coords.latitude;
                    tacoScope.userLocation.lon = position.coords.longitude;
                    console.log('user location found', tacoScope.userLocation);
                });
            } else {
                tacoScope.userLocation = null;
                console.log('no user location');
            }
        };

        this.getTacoList = function(){
            if(tacoScope.userLocation.zip){
                if(tacoScope.userLocation.lat){
                    //tacoScope.tacoHolder = tacoTest.getTacos;
                     console.log('sending', tacoScope.userLocation);
                     tacoScope.getTacos(tacoScope.userLocation, true);
                }
                else{
                     tacoScope.getTacos(tacoScope.userLocation, false);
                }
            }
            else{
                console.log('error need zip city data');
            }
        };

        this.getTacos = function(userdata, coordsBool){
            var locationObj = coordsBool ? userdata : { zip: userdata.zip };
            tacoScope.tacoLoad = true;
            $http({
                url:'api/yelpaco_api.php',
                method: 'post',
                data: $.param(locationObj),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                cache: false
            })
            .then(
                function (response) {
                    console.log('Success', response);
                    tacoFastFoodFilter(response.data.tacostands);
                    tacoScope.tacoLoad = false;
                    tacoScope.goToListing('listings');
                },
                function (error) {
                    console.log('Failure', error);
                }
            );
        };

        function tacoFastFoodFilter(foodData){
            tacoScope.tacoHolder = foodData.map(function(biz){
                var foodFilter = biz.name.toLowerCase();
                if(foodFilter == "taco bell" || foodFilter == 'del taco' || foodFilter == 'chronic tacos'){
                    biz.fastfood = true;
                }
                else{
                    biz.fastfood = false;
                }
                return  biz;
            });
        };

        this.tacoDirection = function(lat1, lon1, lat2, lon2){
            var dirUrl = "https://maps.google.com?saddr=Current+Location&daddr=";
            dirUrl += lat1  + "," + lon1;
            window.open(dirUrl);
        };

        this.goToListing = function(id){
            $location.path(id);
        }
    });
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
                    console.log('sending', tacoScope.userLocation);
                     tacoScope.getTacos(tacoScope.userLocation, false);
                }
            }
            else{
                console.log('error need zip city data');
            }
        };

        this.getTacos = function(userdata, coordsBool){

            var locationObj = coordsBool ? userdata : { zip: userdata.zip, offset: 9 };
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

                if(foodFilter == "taco bell" || foodFilter == 'del taco'){
                    biz.fastfood = true;
                }
                else{
                    biz.fastfood = false;
                }
                return biz;
            }).filter(function(biz){
                return !biz.is_closed;
            });
        }

        this.tacoDirection = function(lat1, lon1, lat2, lon2){
            var dirUrl = "https://maps.google.com?saddr=Current+Location&daddr=";
            dirUrl += lat1  + "," + lon1;
            window.open(dirUrl);
        };

        this.goToListing = function(id){
            $location.path(id);
        }
        var fakeip = {
            "homeMobileCountryCode": 310,
            "homeMobileNetworkCode": 260,
            "radioType": "gsm",
            "carrier": "T-Mobile",
            "cellTowers": [
                {
                    "cellId": 39627456,
                    "locationAreaCode": 40495,
                    "mobileCountryCode": 310,
                    "mobileNetworkCode": 260,
                    "age": 0,
                    "signalStrength": -95
                }
            ],
            "wifiAccessPoints": [
                {
                    "macAddress": "01:23:45:67:89:AB",
                    "signalStrength": 8,
                    "age": 0,
                    "signalToNoiseRatio": -65,
                    "channel": 8
                },
                {
                    "macAddress": "01:23:45:67:89:AC",
                    "signalStrength": 4,
                    "age": 0
                }
            ]
        };
        this.geolocator = function(){
            $.ajax({
                url: 'https://www.googleapis.com/geolocation/v1/geolocate',
                data: {key:"AIzaSyC6o5e3BDFg9nAKsapCRvt69C6aRaT-htg"},
                method: 'post',

                success: function(re){
                    console.log(re);
                },
                error: function(er){
                    console.log(er);
                }
            })
        }

        this.fourSquarer = function(){
            var url = 'https://api.foursquare.com/v2/venues/explore?';
            var data = {
                openNow: 1,
                sortByDistance: 1,
                ll: "33.665242,-117.7490656",
                query: 'tacos',
                oauth_token : "YNLF5FJXRMC2G43X1PPW1PMG13AEWKNAP01BHCR0OMVIION3",
                v: 20160831
            };
            $.ajax({
                url: url,
                data: $.param(data),
                method: 'get',
                dataType: 'json',
                success: function(res){
                    console.log(res.response.groups[0].items)
                },
                error: function(er){
                    console.log(er);
                }
            })

        };

        this.googlePlace = function(){//'AIzaSyCcuZ353Am9ODHsVt3CF-4KcuPY8n5t6pc'
            //https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670522,151.1957362&radius=500&type=restaurant&name=cruise&key=YOUR_API_KEY
           // var location = {mode: 'placeIdSearch', apiKey: 'AIzaSyCcuZ353Am9ODHsVt3CF-4KcuPY8n5t6pc', id: "ChIJu0DrMGbo3IARrBpImXrwh2E"};
            //var location = {mode: 'phoneSearch', apiKey: 'AIzaSyCcuZ353Am9ODHsVt3CF-4KcuPY8n5t6pc', phone:9495869200, lat:33.6307185, lon:-117.7177254};
            //var location = {mode: 'radiusSearch', apiKey: 'AIzaSyCcuZ353Am9ODHsVt3CF-4KcuPY8n5t6pc', radius: 5000, latlon:'33.6518085,-117.6456971'};
            var location = {mode: "idQuery", phone: "234643634"};
            //var location = {mode: "addPlace", phone: "1238472637", latlon:"jibberish", id:"fakeidkey", name:'chimpacos pizza'};
            $http({
                url:'api/place_api.php',
                method: 'post',
                data: $.param(location),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                cache: false
            })
                .then(
                    function (response) {
                        console.log('Success', response);
                    },
                    function (error) {
                        console.log('Failure', error);
                    }
                );
        };
       // https://api.foursquare.com/v2/venues/explore?openNow=1&sortByDistance=1&ll=33.665242,-117.7490656&query=tacos&oauth_token=YNLF5FJXRMC2G43X1PPW1PMG13AEWKNAP01BHCR0OMVIION3&v=20160831
    });
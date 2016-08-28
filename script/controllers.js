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
            //headScope.getUserLoc();
        }
        init();
    })
    .controller("listingCtrl", function ($scope, tacoServe) {
        var listScope = this;
        this.tacoList = tacoServe.tacoHolder;
        this.filterList = tacoServe.tacoHolder;
        this.getDirections = tacoServe.tacoDirection;
        this.user = tacoServe.userLocation;
        $scope.fastFood = true;

        $scope.$watch('fastFood', function(){
            console.log(listScope.filterList);
            if($scope.fastFood){
                listScope.filterList =  listScope.tacoList.filter(function(biz){
                    return !biz.fastfood ;
                })
            }
            else{
                listScope.filterList =  listScope.tacoList;
            }

        });

        function init(){

        }
        init();
    });
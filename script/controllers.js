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
            //var tl = new TimelineLite();
            //tl.add(TimelineLite.to($(".pink"), 0.4, {scaleX:1.8, scaleY:1.8, ease: Power2.easeOut}));

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
    })

.directive('smoothButton', function(){
    var linker = function (scope, element, attrs) {
        var tl = new TimelineLite();
        tl.add(TweenLite.to(element.find('.red'), 0.4, {scaleX:1.8, scaleY:1.8, ease: Power2.easeOut}));
        tl.add(TweenLite.to(element.find('.orange'), 0.4, {scaleX:1.6, scaleY:1.6, ease: Power2.easeOut}), '-=0.2');
        tl.add(TweenLite.to(element.find('.yellow'), 0.4, {scaleX:1.4, scaleY:1.4, ease: Power2.easeOut}), '-=0.2');
        tl.stop();

        scope.play = function() {
            console.log('plaing');
            tl.play();
        };

        scope.reverse = function() {
            tl.reverse();
        };
    };

    return {
        scope: false,
        link: linker,
        templateUrl: 'pages/gsap.html'
    }
});
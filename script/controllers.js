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
        this.locator = tacoServe.googlePlace;

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
//
//.directive('smoothButton', function(){
//    var linker = function (scope, element, attrs) {
//        var tl = new TimelineLite();
//        tl.add(TweenLite.to(element.find('.red'), 0.4, {scaleX:1.8, scaleY:1.8, ease: Power2.easeOut}));
//        tl.add(TweenLite.to(element.find('.orange'), 0.4, {scaleX:1.6, scaleY:1.6, ease: Power2.easeOut}), '-=0.2');
//        tl.add(TweenLite.to(element.find('.yellow'), 0.4, {scaleX:1.4, scaleY:1.4, ease: Power2.easeOut}), '-=0.2');
//        tl.stop();
//
//        scope.play = function() {
//            console.log('plaing');
//            tl.play();
//        };
//
//        scope.reverse = function() {
//            tl.reverse();
//        };
//    };
//
//    return {
//        scope: false,
//        link: linker,
//        templateUrl: 'pages/gsap.html'
//    }
//})
.directive('smoothButton', function(){
    var linker = function (scope, element, attrs) {

        var tween = new TimelineMax();
        var fullNames = $("#logoNames").find('path');
        var drawNames = $("#logoDrawNames").find('path');
        var lines = $('#logoLines').find('line');
        var logoHead = $('#logoHeadLetters').find('path');
        var logoA = $('#logoHeadAnd');
        tween.set([logoA, fullNames], {autoAlpha:0});

        function pathPrepare($el){
            var lineLength = $el[0].getTotalLength();
            console.log(lineLength, $el);
            $el.css("stroke-dasharray", lineLength);
            $el.css('stroke-dashoffset', lineLength);
            //$el.css('fill', 'blue');
            tween.add(TweenLite.to($el[0], .2, {strokeDashoffset: 0, ease:Linear.easeNone}));
        }

        tween.fromTo("#logoLineL", .5, {rotation: -90, autoAlpha:0, ease:Linear.easeNone},{rotation: 0,autoAlpha:1, ease:Linear.easeNone})
            .fromTo("#logoLineR", .5, {rotation: 90, autoAlpha:0, transformOrigin: "100% 0%", ease:Linear.easeNone},{rotation: 0,autoAlpha:1, ease:Linear.easeNone}, "-=.5")
            .staggerFromTo(logoHead, .5, {y: -90, autoAlpha:0, ease: Elastic.easeOut.config(1, 0.3)},{y: 0, autoAlpha:1, ease: Elastic.easeOut.config(1, 0.3)}, .5)
            .to("#logoHeadAnd", .5, {autoAlpha: 1}, '-=.7');
        drawNames.each(function(e){
            pathPrepare($(this));
        });

        tween.add(TweenLite.to(fullNames, .2, {autoAlpha:1, scale:1.25, transformOrigin: "50% 50%", ease:Linear.easeNone}))
            .add(TweenLite.to(drawNames, .2, {autoAlpha:0, scale:1.25, ease:Linear.easeNone}), "-=.2")
            .add(TweenLite.to(fullNames, .2, {scale:1, ease:Linear.easeNone}))

        tween.stop();

        scope.play = function() {
            tween.play();
        };
        scope.reverse = function() {
            tween.reverse();
        };
    };

    return {
        scope: false,
        link: linker,
        templateUrl: 'pages/svgtest.html'
    }
})
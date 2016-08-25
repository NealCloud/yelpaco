
(function(){

    function tacoInfo(){
        $.ajax({
            url: 'api/yelpaco_api.php',
            method: 'post',
            dataType: 'json',
            data: {zip: 'potter'},
            success: function(res){
                console.log(res);
                return res;
            },
            error: function(er){
                console.log(er);
            }
        })
    }

    function tacoSim(){
        return {
            user: {
              location:  {
                  coordinate: {
                      latitude:"34.9159021",
                      longitude: "-117.1133961"
                  }
              }
            },
            tacostands: [
                {
                    location: {
                        coordinate: {
                            latitude:"34.9178543",
                            longitude: "-117.1240824"
                        }
                    },
                    rating_img_url: "https://s3-media2.fl.yelpcdn.com/assets/2/www/img/99493c12711e/ico/stars/v1/stars_4_half.png",
                    url: "http://www.yelp.com/biz/el-toro-bravo-tortilleria-costa-mesa?adjust_creative=vxTVifzdMIizF-PsklUyxA&utm_campaign=yelp_api&utm_medium=api_v2_business&utm_source=vxTVifzdMIizF-PsklUyxA",
                    name: "Taco Bell"
                },
                {
                    location: {
                        coordinate: {
                            latitude:"34.9178543",
                            longitude: "-117.1240824"
                        }
                    },
                    rating_img_url: "https://s3-media2.fl.yelpcdn.com/assets/2/www/img/99493c12711e/ico/stars/v1/stars_4_half.png",
                    url: "http://www.yelp.com/biz/el-toro-bravo-tortilleria-costa-mesa?adjust_creative=vxTVifzdMIizF-PsklUyxA&utm_campaign=yelp_api&utm_medium=api_v2_business&utm_source=vxTVifzdMIizF-PsklUyxA",
                    name: "El Muerto tacos"
                },
                {
                    location: {
                        coordinate: {
                            latitude:"34.9178543",
                            longitude: "-117.1240824"
                        }
                    },
                    rating_img_url: "https://s3-media2.fl.yelpcdn.com/assets/2/www/img/99493c12711e/ico/stars/v1/stars_4_half.png",
                    url: "http://www.yelp.com/biz/el-toro-bravo-tortilleria-costa-mesa?adjust_creative=vxTVifzdMIizF-PsklUyxA&utm_campaign=yelp_api&utm_medium=api_v2_business&utm_source=vxTVifzdMIizF-PsklUyxA",
                    name: "La Mesa tacos"
                }
            ]
        }
    }

    function tacoDirection(lat1, lon1, lat2, lon2){
        var dirUrl = "https://www.google.com/maps/dir/";
        dirUrl += lat1  + "," + lon1 + "/" + lat2 + "," + lon2;
        window.open(dirUrl);
    }

     tacoTest = {
        getTacos: tacoSim(),
        goTaco: tacoDirection,
        secret: tacoInfo
    };

    return tacoTest;
})();

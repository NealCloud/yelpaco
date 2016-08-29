<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.orange-red.min.css">

    <title>Taco Finder</title>
    <style>
        .container {
            cursor: pointer;
            display: inline-block;
            height: 200px;
            width: 200px;
        }

        .circle {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            position: absolute;
        }

        .yellow {
            background-color: #ffff00;
        }

        .orange {
            background-color: orange;
        }

        .red {
            background-color: red;
        }

        .grey {
            background-color: grey;
        }
        .pink {
            background-color: pink;
        }
    </style>
</head>

<body ng-app="tacoFinder">
    <div ui-view id="container"></div>


    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/TweenMax.min.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TimelineLite.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.min.js"></script>
    <script src="script/angularApp.js"></script>
    <script src="script/services.js"></script>
    <script src="script/controllers.js"></script>
    <script src="script/tacotester.js"></script>
    <script defer src="https://code.getmdl.io/1.2.0/material.min.js"></script>
    <script type="text/ng-template" id="smooth-button.tmpl.html">

        <div class="circle red"></div>
        <div class="circle orange"></div>
        <div class="circle yellow"></div>
        <div class="circle grey"></div>
    </script>
</body>
</html>
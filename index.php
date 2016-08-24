<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.min.js"></script>
    <script src="script/angularApp.js"></script>
    <script src="script/services.js"></script>
    <script src="script/controllers.js"></script>
    <script src="script/tacoizer.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.orange-red.min.css">
    <script defer src="https://code.getmdl.io/1.2.0/material.min.js"></script>
    <title>JS Bin</title>
</head>

<body ng-app="tacoFinder">
    <div ui-view id="container"></div>
</body>
</html>
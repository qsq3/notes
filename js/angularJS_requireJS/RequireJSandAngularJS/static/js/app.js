define(function () {
    var app = angular.module('myApp', []);

    app.controller('DemoController', function ($scope) {
        $scope.hello  = 'world';
    });

    return app;

})
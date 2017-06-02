;(function () {
    var bookstoreApp = angular.module('bookstoreApp',['ngRoute','ngAnimate','bookstoreCtrls','bookstoreFilters','bookstoreServices','bookstoreDirectives']);

    bookstoreApp.config(function($routeProvider){
        $routeProvider.when('/hello',{
            templateUrl : 'tpls/hello.html',
            controller : 'HelloCtrl'
        }).when('/list',{
            templateUrl : 'tpls/list.html',
            controller : 'ListCtrl'
        }).otherwise('/list',{
            redirectTo : '/hello',
        })
    })
})();

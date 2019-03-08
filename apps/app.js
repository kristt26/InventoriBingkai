var app = angular.module("app", ["ngRoute", "Ctrl"]);
app.config(function($routeProvider) {  
    $routeProvider   
        .when("/Main", {
            templateUrl: "apps/Views/main.html",
            controller: "MainController"
        })

    .when("/User", {
        templateUrl: "apps/Views/User.html",
        controller: "UserController"
    })
    .when("/Bingkai", {
        templateUrl: "apps/Views/Bingkai.html",
        controller: "BingkaiController"
    })
    .when("/Pembelian", {
        templateUrl: "apps/Views/Pembelian.html",
        controller: "PembelianController"
    })
    .when("/Stock", {
        templateUrl: "apps/Views/Stock.html",
        controller: "StockController"
    })
    .when("/Transaksi", {
        templateUrl: "apps/Views/Transaksi.html",
        controller: "TransaksiController"
    })
    .otherwise({ redirectTo: '/Main' })

})


.factory("SessionService", function($http, $rootScope) {
    var service = {};
    $rootScope.Session = {};
    var Urlauth = "api/datas/auth.php";
    $http({
            method: "get",
            url: Urlauth,
        })
        .then(function(response) {
            if (response.data.Session == false) {
                window.location.href = 'login.html';
            } else
                $rootScope.Session = response.data.Session;
        }, function(error) {
            alert(error.message);
        })


    return service;
})

;
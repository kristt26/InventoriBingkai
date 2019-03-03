var app = angular.module("app", ["ngRoute", "Ctrl"]);
app.config(function($routeProvider) {  
    $routeProvider   
        .when("/Main", {
            templateUrl: "apps/Views/main.html",
            controller: "MainController"
        })

    .when("/Kategori", {
        templateUrl: "apps/Views/Kategori.html",
        controller: "KategoriController"
    })

    .when("/Barang", {
        templateUrl: "apps/Views/Barang.html",
        controller: "BarangController"
    })

    .when("/Log", {
        templateUrl: "apps/Views/Logout.html",
        controller: "LogoutController"
    })

    .when("/Return", {
        templateUrl: "apps/Views/Return.html",
        controller: "ReturnController"
    })

    .when("/Karyawan", {
        templateUrl: "apps/Views/Karyawan.html",
        controller: "KaryawanController"
    })

    .when("/Pembelian", {
        templateUrl: "apps/Views/Pembelian.html",
        controller: "PembelianController"
    })

    .when("/TambahPembelian", {
        templateUrl: "apps/Views/TambahPembelian.html",
        controller: "PembelianController"
    })

    .when("/Price", {
        templateUrl: "apps/Views/Price.html",
        controller: "PriceController"
    })

    .when("/Discount", {
        templateUrl: "apps/Views/Discount.html",
        controller: "DiscountController"
    })

    .when("/Supplier", {
        templateUrl: "apps/Views/Supplier.html",
        controller: "SupplierController"
    })

    .when("/Penjualan", {
        templateUrl: "apps/Views/Penjualan.html",
        controller: "PenjualanController"
    })

    .when("/TambahPenjualan", {
        templateUrl: "apps/Views/TambahPenjualan.html",
        controller: "PenjualanController"
    })

    .when("/LStock", {
        templateUrl: "apps/Laporan/LaporanStock.html",
        controller: "LaporanController"
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
                window.location.href = 'index.html';
            } else
                $rootScope.Session = response.data.Session;
        }, function(error) {
            alert(error.message);
        })


    return service;
})

;
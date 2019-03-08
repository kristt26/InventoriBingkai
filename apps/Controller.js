angular.module("Ctrl", [])

    .controller("MainController", function ($scope, $http, SessionService) {
        $scope.Init = function () {
            //Auth
            var Urlauth = "api/datas/auth.php";
            $http({
                method: "get",
                url: Urlauth,
            })
                .then(function (response) {
                    if (response.data.Session == false) {
                        window.location.href = 'login.html';
                    }
                }, function (error) {
                    alert(error.message);
                })
        }
    })


    .controller("LogoutController", function ($scope, $http) {
        var Urlauth = "api/datas/logout.php";
        $http({
            method: "get",
            url: Urlauth,
        })
            .then(function (response) {
                if (response.data.message == true) {
                    window.location.href = 'login.html';
                }
            }, function (error) {
                alert(error.message);
            })
    })


    .controller("UserController", function ($scope, $http, $rootScope, SessionService) {
        $scope.DatasUser = [];
        $scope.DataInsert = {};
        $scope.Level = [
            { 'Akses': 'Admin' },
            { 'Akses': 'Kasir' }
        ];
        $scope.SelectedLevel = {};
        $scope.Init = function () {
            $scope.DataInsert = {};
            //Auth
            var Urlauth = "api/datas/auth.php";
            $http({
                method: "get",
                url: Urlauth,
            })
                .then(function (response) {
                    if (response.data.Session == false) {
                        window.location.href = 'login.html';
                    } else {
                        var UrlUser = "api/datas/read/readUser.php";
                        $http({
                            method: "GET",
                            url: UrlUser
                        })
                            .then(function (response) {
                                $scope.DatasUser = response.data.User;
                            })
                    }
                }, function (error) {
                    alert(error.message);
                })
        }

        //Proses Insert Data Pegawai
        $scope.InsertPegawai = function () {
            $scope.DataInsert.Level = $scope.SelectedLevel.Akses;
            var Data = $scope.DataInsert;
            var UrlInsert = "api/datas/create/createUser.php";
            $http({
                method: "post",
                url: UrlInsert,
                data: Data
            })
                .then(function (response) {
                    if (response.status == 200) {
                        $scope.DataInsert.IdUser = response.data.message;
                        $scope.DatasUser.push(angular.copy($scope.DataInsert));
                        alert("Data Berhasil di tambahkan");
                        $scope.DataInsert = {};
                    } else
                        alert(response.data.message);
                })
        }

        //Selected Item City
        $scope.Selected = function (item) {
            $scope.DataInsert = item;
            $scope.SelectedLevel = { 'Akses': item.Level };
        }

        //Update Data City
        $scope.UpdateDataPegawai = function () {
            $scope.DataInsert.Level = $scope.SelectedLevel.Akses;
            var Data = $scope.DataInsert;
            var UrlUpdate = "api/datas/update/updateUser.php";
            $http({
                method: "POST",
                url: UrlUpdate,
                data: Data
            })
                .then(function (response) {
                    if (response.status == 200) {
                        angular.forEach($scope.DatasUser, function (value, key) {
                            if (value.IdUser == $scope.DataInsert.IdUser) {
                                value.Nama = $scope.DataInsert.Nama;
                                value.Username = $scope.DataInsert.Username;
                                value.Level = $scope.DataInsert.Level;
                            }
                        })
                        alert(response.data.message);
                        $scope.DataInsert = {};
                    } else
                        alert(response.data.message);
                }, function (error) {
                    alert("Gagal Simpan");
                })
        }

        //Delete Pegawai
        $scope.Delete = function (item) {
            $scope.SelectedItemPegawai = item;
            var Data = $scope.SelectedItemPegawai;
            var UrlDeletePegawai = "api/datas/deletePegawai.php";
            $http({
                method: "post",
                url: UrlDeletePegawai,
                data: Data
            })
                .then(function (response) {
                    if (response.data.message == "Product was deleted") {
                        $scope.DatasPegawai.splice(Data, 1);
                        alert(response.data.message);
                    } else
                        alert("Data Tidak Terhapus");
                }, function (error) {
                    alert(error.message);
                })
        }


    })

    .controller("BingkaiController", function ($scope, $http) {
        $scope.DatasBingkai = [];
        $scope.DataInsert = {};
        $scope.Init = function () {
            var Urlauth = "api/datas/auth.php";
            $http({
                method: "get",
                url: Urlauth,
            })
                .then(function (response) {
                    if (response.data.Session == false) {
                        window.location.href = 'login.html';
                    } else {
                        var UrlBingkai = "api/datas/read/readBingkai.php";
                        $http({
                            method: "GET",
                            url: UrlBingkai
                        })
                            .then(function (response) {
                                $scope.DatasBingkai = response.data.Bingkai;
                            })
                    }
                }, function (error) {
                    alert(error.message);
                })
        }

        $scope.Insert = function () {
            var Data = $scope.DataInsert;
            var UrlInsert = "api/datas/create/createBingkai.php";
            $http({
                method: "post",
                url: UrlInsert,
                data: Data
            }).then(function (response) {
                if (response.status == 200) {
                    $scope.DataInsert.IdUser = response.data.message;
                    $scope.DatasBingkai.push(angular.copy($scope.DataInsert));
                    alert("Data Berhasil di tambahkan");
                    $scope.DataInsert = {};
                } else
                    alert(response.data.message);
            }, function (error) {
                alert(error.message);
            })
        }

        $scope.Selected = function (item) {
            $scope.DataInsert = item;
        }

        $scope.Update = function () {
            var Data = $scope.DataInsert;
            var UrlUpdate = "api/datas/update/updateBingkai.php";
            $http({
                method: "POST",
                url: UrlUpdate,
                data: Data
            })
                .then(function (response) {
                    if (response.status == 200) {
                        angular.forEach($scope.DatasUser, function (value, key) {
                            if (value.IdBingkai == $scope.DataInsert.IdBingkai) {
                                value.Kode = $scope.DataInsert.Kode;
                                value.Ukuran = $scope.DataInsert.Ukuran;
                                value.Warna = $scope.DataInsert.Warna;
                            }
                        })
                        alert(response.data.message);
                        $scope.DataInsert = {};
                    } else
                        alert(response.data.message);
                }, function (error) {
                    alert("Gagal Simpan");
                })
        }

    })

    .controller("PembelianController", function ($scope, $http) {
        $scope.DatasPembelian = [];
        $scope.DatasBingkai = [];
        $scope.DataInsert = {};
        $scope.SelectedUkuran = {};

        $scope.Init = function () {
            var Urlauth = "api/datas/auth.php";
            $http({
                method: "get",
                url: Urlauth,
            })
                .then(function (response) {
                    if (response.data.Session == false) {
                        window.location.href = 'login.html';
                    } else {
                        var UrlBingkai = "api/datas/read/readPembelian.php";
                        $http({
                            method: "GET",
                            url: UrlBingkai
                        })
                            .then(function (response) {
                                $scope.DatasPembelian = response.data.Pembelian;

                            });
                        var UrlBingkai = "api/datas/read/readBingkai.php";
                        $http({
                            method: "GET",
                            url: UrlBingkai
                        })
                            .then(function (response) {
                                $scope.DatasBingkai = response.data.Bingkai;
                            })
                    }
                }, function (error) {
                    alert(error.message);
                })
        }
        $scope.Insert = function () {
            $scope.DataInsert.IdBingkai = $scope.SelectedUkuran.IdBingkai;
            var Data = $scope.DataInsert;
            var UrlInsert = "api/datas/create/createPembelian.php";
            $http({
                method: "post",
                url: UrlInsert,
                data: Data
            }).then(function (response) {
                if (response.status == 200) {
                    $scope.DataInsert.IdPembelian = response.data.message.IdPembelian;
                    $scope.DataInsert.TanggalBeli = response.data.message.TanggalBeli;
                    $scope.DataInsert.Bingkai = [];
                    angular.forEach($scope.DatasBingkai, function (value, key) {
                        if (value.IdBingkai == $scope.DataInsert.IdBingkai) {
                            $scope.DataInsert.Bingkai.push(angular.copy(value))
                        }
                    })
                    $scope.DatasPembelian.push(angular.copy($scope.DataInsert));
                    alert("Data Berhasil di tambahkan");
                    $scope.DataInsert = {};
                } else
                    alert(response.data.message);
            }, function (error) {
                alert(error.message);
            })
        }

        $scope.Selected = function (item) {
            $scope.DataInsert = item;
        }

        $scope.Update = function () {
            var Data = $scope.DataInsert;
            var UrlUpdate = "api/datas/update/updatePembelian.php";
            $http({
                method: "POST",
                url: UrlUpdate,
                data: Data
            })
                .then(function (response) {
                    if (response.status == 200) {
                        angular.forEach($scope.Pembelian, function (value, key) {
                            if (value.IdPembelian == $scope.DataInsert.IdPembelian) {
                                value.TanggalBeli = $scope.DataInsert.TanggalBeli;
                                value.HargaBeli = $scope.DataInsert.HargaBeli;
                                value.Jumlah = $scope.DataInsert.Jumlah;
                            }
                        })
                        alert(response.data.message);
                        $scope.DataInsert = {};
                    } else
                        alert(response.data.message);
                }, function (error) {
                    alert("Gagal Simpan");
                })
        }
    })
    .controller("StockController", function ($scope, $http) {
        $scope.DatasStock = [];
        $scope.SelectedUkuran = {};
        $scope.SelectedWarna = {};
        $scope.DataTampil = {};
        $scope.Tampilstock = false;
        $scope.Hidestock = true;
        $scope.Init = function () {
            var UrlStock = "api/datas/read/readStock.php";
            $http({
                method: "GET",
                url: UrlStock
            }).then(function (response) {
                $scope.DatasStock = response.data;
            }, function (error) {
                alert(error.message);
            })
        }
        $scope.ShowStock = function () {
            $scope.DataTampil = {};
            if ($scope.SelectedUkuran.Ukuran != undefined && $scope.SelectedWarna.Warna != undefined) {
                var a = false
                angular.forEach($scope.DatasStock.Bingkai, function (value, key) {
                    if (value.Ukuran == $scope.SelectedUkuran.Ukuran && value.Warna == $scope.SelectedWarna.Warna) {
                        $scope.DataTampil = value;
                        a = true;
                    }
                })
                if (a == false) {
                    $scope.Tampilstock = false;
                    $scope.Hidestock = true;
                    alert("Tidak ada Data untuk ukuran dan warna tersebut");
                } else {
                    $scope.Tampilstock = true;
                    $scope.Hidestock = false;
                }
            }

        }
    })
    .controller("TransaksiController", function ($scope, $http) {
        $scope.DatasStock = [];
        $scope.SelectedUkuran = {};
        $scope.SelectedWarna = {};
        $scope.DataTampil = {};
        $scope.Tampilstock = false;
        $scope.Hidestock = true;
        $scope.Init = function () {
            var UrlStock = "api/datas/read/readStock.php";
            $http({
                method: "GET",
                url: UrlStock
            }).then(function (response) {
                $scope.DatasStock = response.data;
            }, function (error) {
                alert(error.message);
            })
        }
        $scope.ShowStock = function () {
            $scope.DataTampil = {};
            if ($scope.SelectedUkuran.Ukuran != undefined && $scope.SelectedWarna.Warna != undefined) {
                var a = false
                angular.forEach($scope.DatasStock.Bingkai, function (value, key) {
                    if (value.Ukuran == $scope.SelectedUkuran.Ukuran && value.Warna == $scope.SelectedWarna.Warna) {
                        $scope.DataTampil = angular.copy(value);
                        a = true;
                    }
                })
                if (a == false) {
                    $scope.Tampilstock = false;
                    $scope.Hidestock = true;
                    alert("Tidak ada Data untuk ukuran dan warna tersebut");
                } else {
                    $scope.Tampilstock = true;
                    $scope.Hidestock = false;
                }
            }

        }
        $scope.CheckOut = function () {
            var Urlauth = "api/datas/auth.php";
            $http({
                method: "get",
                url: Urlauth,
            }).then(function (response) {
                $scope.DataTampil.IdUser = response.data.Session.IdUser;
                $http({
                    method: "POST",
                    url: "api/datas/create/createTransaksi.php",
                    data: $scope.DataTampil
                }).then(function (response) {
                    if (response.status == 200) {
                        angular.forEach($scope.DatasStock.Bingkai, function (value, key) {
                            if (value.IdBingkai == $scope.DataTampil.IdBingkai) {
                                var a = parseInt(angular.copy(value.Stock)) - parseInt(angular.copy($scope.DataTampil.DataOut));
                                value.Stock = a;
                                $scope.DataTampil.Stock = a;
                            }
                        })
                        alert(response.data.message);
                        // window.location.href = 'kasir.html';
                    }
                }, function (error) {
                    alert(error.message);
                })
            }, function (error) {
                alert(error.message);
            })
            
        }
    })
    ;
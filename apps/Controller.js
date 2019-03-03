angular.module("Ctrl", [])

.controller("MainController", function($scope, $http, SessionService) {
    /*$scope.Init = function() {
        //Auth
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
    }
    */
})

.controller("KategoriController", function($scope, $http, SessionService) {
    $scope.DataKategoris = [];
    $scope.DataInput = {};
    $scope.SelectedItem = {};
    $scope.Init = function() {
        //Data Kategori
        var UrlKategori = "api/datas/Select/kategori.php";
        $http({
                method: "get",
                url: UrlKategori,
            })
            .then(function(response) {
                $scope.DataKategoris = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.InsertKategori = function() {
        var urlinsertkategori = "api/datas/Create/readKategori.php";
        var Data = $scope.DataInput;
        $http({
                method: "post",
                url: urlinsertkategori,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != 0) {
                    Data.IdKategori = response.data.message;
                    $scope.DataKategoris.push(angular.copy(Data));
                } else
                    alert("Unable to Create Kategori");
            }, function(error) {
                alert(error.Massage);
            })
    }

    $scope.Selected = function(item) {
        $scope.SelectedItem = item;
    }

    $scope.UpdateKategori = function() {
        var urlupdatekategori = "api/datas/Update/updateKategori.php";
        var Data = $scope.SelectedItem;
        $http({
                method: "post",
                url: urlupdatekategori,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Bidang was updated") {
                    angular.forEach($scope.DataKategoris, function(value, key) {
                        if (value.IdKategori == Data.IdKategori) {
                            value.NamaKategori = Data.NamaKategori;
                        }
                    });
                    alert(response.data.message);
                } else
                    alert("Unable to Create Kategori");
            }, function(error) {
                alert(error.Massage);
            })
    }
})


.controller("LogoutController", function($scope, $http) {
    $scope.Init = function() {
        var Urlauth = "api/datas/logout.php";
        $http({
                method: "get",
                url: Urlauth,
            })
            .then(function(response) {
                if (response.data.message == true) {
                    window.location.href = 'index.html';
                }
            }, function(error) {
                alert(error.message);
            })
    }

})


.controller("BarangController", function($scope, $http, SessionService) {
    $scope.DatasBarang = [];
    //$rootScope.Session = {};
    $scope.DataInputBarang = {};
    $scope.SelectedItem = {};
    $scope.InputBarang = {};
    $scope.DataKategoris = [];
    $scope.DataUpdateBarang = {};
    $scope.SelectedItemKategori = {};

    $scope.Init = function() {
        //Auth
        var UrlKategori = "api/datas/Select/kategori.php";
        $http({
                method: "get",
                url: UrlKategori,
            })
            .then(function(response) {
                $scope.DataKategoris = response.data.records;
                var UrlBarang = "api/datas/Select/readBarang.php";
                $http({
                        method: "get",
                        url: UrlBarang
                    })
                    .then(function(response) {
                        $scope.DatasBarang = response.data.records;
                        angular.forEach($scope.DataKategoris, function(valuekategori, keykategori) {
                            angular.forEach($scope.DatasBarang, function(valueBarang, keyBarang) {
                                if (valueBarang.KategoriId == valuekategori.IdKategori) {
                                    valueBarang.NamaKategori = valuekategori.NamaKategori;
                                }
                            })
                        })

                    }, function(error) {

                        alert(error.message);
                    })
            }, function(error) {
                alert(error.message);
            })
    }

    //Insert Data Bidang
    $scope.InsertBarang = function() {
        $scope.InputBarang.KategoriId = $scope.SelectedItemKategori.IdKategori;
        $scope.InputBarang.NamaKategori = $scope.SelectedItemKategori.NamaKategori;
        var urlinsertbarang = "api/datas/Create/createBarang.php";
        var Data = $scope.InputBarang;
        $http({
                method: "post",
                url: urlinsertbarang,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != 0) {
                    Data.IdBarang = response.data.message;
                    Data.Stock = 0;
                    $scope.DatasBarang.push(angular.copy(Data));
                    alert("Barang Was Created");
                    window.location.reload();
                } else
                    alert("Unable to Create Barang");
            }, function(error) {
                alert(error.Massage);
            })
        $scope.SelectedItemKategori = {};
        $scope.InputBarang = {};

    }

    $scope.Selected = function(item) {
        $scope.DataUpdateBarang = item;
        angular.forEach($scope.DataKategoris, function(value, key) {
            if (value.IdKategori == item.KategoriId) {
                $scope.SelectedItemKategori = value;
            }
        })
    }

    //Funsi Update Bidang
    $scope.UpdateBarang = function() {
        var Data = $scope.DataUpdateBarang;
        var UrlUpdateBidang = "api/datas/Update/updateBarang.php";
        $http({
                method: "post",
                url: UrlUpdateBidang,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Barang Was Update") {
                    angular.forEach($scope.DatasBarang, function(value, key) {
                        if (value.IdBarang == Data.IdBarang) {
                            value.NamaBarang = Data.NamaBarang;
                            value.Keterangan = Data.Keterangan;
                        }
                    })
                    alert(response.data.message);
                    window.location.reload();
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }

})

.controller("SupplierController", function($scope, $http, $rootScope, SessionService) {
    $scope.DatasSupplier = [];
    $scope.InputSupplier = {};
    $scope.SelectedItem = {};
    $scope.Init = function() {
        //Auth
        var UrlSupplier = "api/datas/Select/readSupplier.php";
        $http({
                method: "get",
                url: UrlSupplier,
            })
            .then(function(response) {
                $scope.DatasSupplier = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.InsertSupplier = function() {
        var UrlInsertSupplier = "api/datas/Create/createSupplier.php";
        var Data = $scope.InputSupplier;
        $http({
                method: "post",
                url: UrlInsertSupplier,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to create Supplier") {
                    Data.IdSupplier = response.data.message;
                    $scope.DatasSupplier.push(angular.copy(Data));
                    alert("Supplier Was Created");
                    window.location.reload();
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.Massage);
            })
    }

    $scope.Selected = function(item) {
        $scope.SelectedItem = item;
    }

    $scope.UpdateSupplier = function() {
        var urlupdateSupplier = "api/datas/Update/updateSupplier.php";
        var Data = $scope.SelectedItem;
        $http({
                method: "post",
                url: urlupdateSupplier,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Bidang was updated") {
                    angular.forEach($scope.DatasSupplier, function(value, key) {
                        if (value.IdSupplier == Data.IdSupplier) {
                            value.NamaSupplier = Data.NamaSupplier;
                            value.Telp = Data.Telp;
                            value.Alamat = Data.Alamat;
                        }
                    });
                    alert(response.data.message);
                } else
                    alert("Unable to create Supplier");
            }, function(error) {
                alert(error.Massage);
            })
    }
})


.controller("PembelianController", function($scope, $http, $rootScope, SessionService) {
    $scope.DatasPembelian = [];
    $scope.DataKategoris = [];
    $scope.DatasBarang = [];
    $scope.SelectedItemBarang = {};
    $scope.DataItemBarang = [];
    $scope.InputItemBarang = {};
    $scope.SelectedItemBarang = {};
    $scope.InputPenjualan = {};
    $scope.DatasSupplier = [];
    $scope.SelectedItemSupplier = {};
    $scope.ViewDetailBarang = [];
    $scope.InputPenjualan.TotalBayar = 0;

    $scope.Init = function() {
        var UrlKategori = "api/datas/Select/kategori.php";
        $http({
                method: "get",
                url: UrlKategori,
            })
            .then(function(response) {
                $scope.DataKategoris = response.data.records;
            }, function(error) {
                alert(error.message);
            })

        var UrlSupplier = "api/datas/Select/readSupplier.php";
        $http({
                method: "get",
                url: UrlSupplier,
            })
            .then(function(response) {
                $scope.DatasSupplier = response.data.records;
            }, function(error) {
                alert(error.message);
            })

        var UrlreadPembelian = "api/datas/Select/readPembelian.php";
        $http({
                method: "get",
                url: UrlreadPembelian,
            })
            .then(function(response) {
                $scope.DatasPembelian = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.SelectedDetail = function(item) {
        $scope.ViewDetailBarang = item;
    }

    $scope.ChangeBarang = function(item) {
        var Data = item;
        var UrlBarang = "api/datas/Select/readBarangByKategori.php";
        $http({
                method: "post",
                url: UrlBarang,
                data: Data
            })
            .then(function(response) {
                $scope.DatasBarang = response.data.records;
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.TambahItemBarang = function() {
        $scope.InputItemBarang.BarangId = $scope.SelectedItemBarang.IdBarang;
        $scope.InputItemBarang.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        $scope.DataItemBarang.push(angular.copy($scope.InputItemBarang));
        $scope.InputPenjualan.TotalBayar += parseInt($scope.InputItemBarang.Jumlah) * parseInt($scope.InputItemBarang.HargaBeli);

        $scope.SelectedItemKategori = {};
        $scope.SelectedItemBarang = {};
        $scope.InputItemBarang = {};

    }

    $scope.InsertPembelian = function() {
        $scope.InputPenjualan.SupplierId = $scope.SelectedItemSupplier.IdSupplier;
        $scope.InputPenjualan.NamaSupplier = $scope.SelectedItemSupplier.NamaSupplier;
        $scope.InputPenjualan.ItemBarang = $scope.DataItemBarang;
        var UrlInsert = "api/datas/Create/createPembelian.php";
        var Data = $scope.InputPenjualan;

        $http({
                method: "post",
                url: UrlInsert,
                data: Data
            })
            .then(function(response) {
                var NewData = response.data;
                $scope.DatasPembelian.push(angular.copy(NewData))
                $scope.InputPenjualan = {};
                $scope.SelectedItemSupplier = {};
                $scope.DataItemBarang = [];
                alert("Pembelian was created")
                window.location.href = 'gudang.html#!/Pembelian';
            }, function(error) {
                alert(error.message);
            })

        $scope.InputPenjualan = {};
        $scope.SelectedItemSupplier = {};
        $scope.DataItemBarang = [];

    }

})

.controller("ReturnController", function($scope, $http, $rootScope, SessionService) {
    $scope.DatasReturn = [];
    $scope.DatasSupplier = [];
    $scope.DatasItemBarang = [];
    $scope.RepositoryDatasItemBarang = [];
    $scope.SelectedItemSupplier = {};
    $scope.InputBarang = {};
    $scope.SelectedItemBarang = {};
    $scope.DataTanggal = {};
    $scope.Init = function() {
        var UrlSupplier = "api/datas/Select/readSupplier.php";
        $http({
                method: "get",
                url: UrlSupplier,
            })
            .then(function(response) {
                $scope.DatasSupplier = response.data.records;
            }, function(error) {
                alert(error.message);
            })

        var UrlReturn = "api/datas/Select/readReturn.php";
        $http({
                method: "get",
                url: UrlReturn,
            })
            .then(function(response) {
                $scope.DatasReturn = response.data.records;

            }, function(error) {
                alert(error.message);
            })
    }

    $scope.SelectBarang = function(item) {
        var Data = item;
        var UrlDataBarang = "api/datas/Select/readDataBarang.php";
        $http({
                method: "post",
                url: UrlDataBarang,
                data: Data
            })
            .then(function(response) {
                $scope.DatasItemBarang = response.data.Barang;
                angular.forEach($scope.DatasItemBarang, function(value, key) {
                    var a = angular.copy(new Date(value.TglBeli));
                    value.TglBeli = a;
                })
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.SelectedTanggal = function() {
        var newdatebeli = $scope.InputBarang.TglBeli.getFullYear() + '-' + ($scope.InputBarang.TglBeli.getMonth() + 1) + '-' + $scope.InputBarang.TglBeli.getDate();
        var Dataloop = angular.copy($scope.DatasItemBarang);
        angular.forEach(Dataloop, function(value, key) {
            var valtgl = value.TglBeli.getFullYear() + '-' + (value.TglBeli.getMonth() + 1) + '-' + value.TglBeli.getDate();
            if (newdatebeli != valtgl) {
                $scope.DatasItemBarang.splice(value, 1);
            }
        })

    }

    $scope.InsertReturn = function() {
        $scope.InputBarang.IdSupplier = $scope.SelectedItemSupplier.IdSupplier;
        $scope.InputBarang.DetailId = $scope.SelectedItemBarang.IdDetail;
        $scope.InputBarang.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        $scope.InputBarang.NamaSupplier = $scope.SelectedItemSupplier.NamaSupplier;
        var Data = $scope.InputBarang;
        var Url = "api/datas/Create/createReturn.php";
        $http({
                method: "post",
                url: Url,
                data: Data
            })
            .then(function(response) {
                if (response.data.message > 1) {
                    Data.IdReturn = response.data.message;
                    $scope.DatasReturn.push(angular.copy(Data));
                    alert("Return Was Created");
                    //window.location.reload();
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }

})

.controller("KaryawanController", function($scope, $http, $rootScope, SessionService) {
    $scope.DatasKaryawan = [];
    $scope.InputKaryawan = {};
    $scope.DataUpdateKaryawan = {};
    $scope.Init = function() {
        var UrlReadKaryawan = "api/datas/Select/readKaryawan.php";
        $http({
                method: "get",
                url: UrlReadKaryawan
            })
            .then(function(response) {
                if (response.data.message == "Karyawan Found") {
                    $scope.DatasKaryawan = response.data.records;
                } else
                    alert(response.data.message);

            }, function(error) {
                alert(error.message);
            })

    }

    $scope.InsertKaryawan = function() {
        var Data = $scope.InputKaryawan;
        var UrlInsertKaryawan = "api/datas/Create/createKaryawan.php"
        $http({
                method: "post",
                url: UrlInsertKaryawan,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to create Karyawan") {
                    Data.IdKaryawan = response.data.message;
                    Data.Status = "true";
                    $scope.DatasKaryawan.push(angular.copy(Data));
                    alert("Karyawan Was Created");
                    window.location.href = 'admin.html#!/Karyawan';
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }

    $scope.Selected = function(item) {
        $scope.DataUpdateKaryawan = item;
    }

    $scope.UpdateKaryawan = function() {
        var Data = $scope.DataUpdateKaryawan;
        var UrlUpdateKaryawan = "api/datas/Update/updateKaryawan.php"
        $http({
                method: "post",
                url: UrlUpdateKaryawan,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Karyawan Was Update") {
                    angular.forEach($scope.DatasKaryawan, function(value, key) {
                        if (value.IdKaryawan == Data.IdKaryawan) {
                            value.Nama = Data.Nama;
                            value.Sex = Data.Sex;
                            value.Kontak = Data.Kontak;
                            value.Alamat = Data.Alamat;
                            value.Email = Data.Email;
                            value.LevelAkses = Data.LevelAkses;
                            value.Status = Data.Status;
                        }
                    })
                    alert(response.data.message);
                    window.location.href = 'admin.html#!/Karyawan';
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }
})

.controller("PriceController", function($scope, $http, SessionService) {
    $scope.DatasPrice = [];
    $scope.InputPrice = {};
    $scope.DataUpdatePrice = {};
    $scope.DatasBarang = [];
    $scope.SelectedItemBarang = {}
    $scope.Init = function() {
        var UrlReadPrice = "api/datas/Select/readPrice.php";
        $http({
                method: "get",
                url: UrlReadPrice
            })
            .then(function(response) {
                if (response.data.message == "Price Was Create") {
                    $scope.DatasPrice = response.data.records;
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })

        var UrlreadBarang = "api/datas/Select/readBarang.php";
        $http({
                method: "get",
                url: UrlreadBarang
            })
            .then(function(response) {
                if (response.data.message == "Barang is Found") {
                    $scope.DatasBarang = response.data.records;
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }
    $scope.InsertPrice = function() {
        var newdate = $scope.InputPrice.CreateDate.getFullYear() + '-' + ($scope.InputPrice.CreateDate.getMonth() + 1) + '-' + $scope.InputPrice.CreateDate.getDate();
        $scope.InputPrice.CreateDate = angular.copy(newdate);
        $scope.InputPrice.BarangId = $scope.SelectedItemBarang.IdBarang;
        $scope.InputPrice.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        var Data = $scope.InputPrice;
        var UrlInsertPrice = "api/datas/Create/createPrice.php";
        $http({
                method: "post",
                url: UrlInsertPrice,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to Create Price") {
                    Data.IdPrice = response.data.message;
                    $scope.DatasPrice.splice(Data, 1);
                    $scope.DatasPrice.push(angular.copy(Data));
                    alert("Price Was Create");
                    window.location.reload();
                } else
                    alert(response.data.message);

            }, function(error) {
                alert(error.message);
            })
    }
    $scope.Selected = function(item) {
        var datenew = new Date(item.CreateDate);
        $scope.DataUpdatePrice = angular.copy(item);
        $scope.DataUpdatePrice.CreateDate = datenew;
        angular.forEach($scope.DatasBarang, function(value, key) {
            if (value.IdBarang == item.BarangId) {
                $scope.SelectedItemBarang = value;
            }
        })
    }
    $scope.UpdatePrice = function() {
        var newdate = $scope.DataUpdatePrice.CreateDate.getFullYear() + '-' + '0' + ($scope.DataUpdatePrice.CreateDate.getMonth() + 1) + '-' + $scope.DataUpdatePrice.CreateDate.getDate();
        $scope.DataUpdatePrice.BarangId = $scope.SelectedItemBarang.IdBarang;
        $scope.DataUpdatePrice.CreateDate = angular.copy(newdate);
        $scope.DataUpdatePrice.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        var Data = $scope.DataUpdatePrice;
        var UrlUpdatePrice = "api/datas/Update/updatePrice.php";
        $http({
                method: "post",
                url: UrlUpdatePrice,
                data: Data
            })
            .then(function(response) {
                if (response.data.message == "Price Was Update") {
                    angular.forEach($scope.DatasPrice, function(value, key) {
                        if (value.IdPrice == Data.IdPrice) {
                            value.Price = Data.Price;
                            value.CreateDate = Data.CreateDate;
                            value.BarangId = Data.BarangId;
                        }
                    })
                    alert("Price Was Create");
                } else
                    alert(response.data.message);

            }, function(error) {
                alert(error.message);
            })
    }


})

.controller("DiscountController", function($scope, $http, SessionService) {
    $scope.DatasDiscount = [];
    $scope.InputDiscount = {};
    $scope.DataUpdatePrice = {};
    $scope.DatasBarang = [];
    $scope.SelectedItemBarang = {}
    $scope.Init = function() {
        var UrlReadDiscount = "api/datas/Select/readDiscount.php";
        $http({
                method: "get",
                url: UrlReadDiscount
            })
            .then(function(response) {
                if (response.data.message == "Discount is Found") {
                    $scope.DatasDiscount = response.data.records;
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })

        var UrlreadBarang = "api/datas/Select/readBarang.php";
        $http({
                method: "get",
                url: UrlreadBarang
            })
            .then(function(response) {
                if (response.data.message == "Barang is Found") {
                    $scope.DatasBarang = response.data.records;
                } else
                    alert(response.data.message);
            }, function(error) {
                alert(error.message);
            })
    }
    $scope.InsertDiscount = function() {
        var newdate = $scope.InputDiscount.MasaBerlaku.getFullYear() + '-' + ($scope.InputDiscount.MasaBerlaku.getMonth() + 1) + '-' + $scope.InputDiscount.MasaBerlaku.getDate();
        $scope.InputDiscount.MasaBerlaku = angular.copy(newdate);
        $scope.InputDiscount.BarangId = $scope.SelectedItemBarang.IdBarang;
        $scope.InputDiscount.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        var Data = $scope.InputDiscount;
        var Url = "api/datas/Create/createDiscount.php";
        $http({
                method: "post",
                url: Url,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to Create Discount") {
                    Data.IdDiscount = response.data.message;
                    $scope.DatasDiscount.push(angular.copy(Data));
                    alert("Discount Was Create");
                    window.location.reload();
                } else
                    alert(response.data.message);

            }, function(error) {
                alert(error.message);
            })
    }
    $scope.Selected = function(item) {
        var datenew = new Date(item.MasaBerlaku);
        $scope.DataUpdatePrice = angular.copy(item);
        $scope.DataUpdatePrice.MasaBerlaku = datenew;
        angular.forEach($scope.DatasBarang, function(value, key) {
            if (value.IdBarang == item.BarangId) {
                $scope.SelectedItemBarang = value;
            }
        })
    }
    $scope.UpdateDiscount = function() {
        var newdate = $scope.DataUpdatePrice.MasaBerlaku.getFullYear() + '-' + '0' + ($scope.DataUpdatePrice.MasaBerlaku.getMonth() + 1) + '-' + $scope.DataUpdatePrice.MasaBerlaku.getDate();
        $scope.DataUpdatePrice.BarangId = $scope.SelectedItemBarang.IdBarang;
        $scope.DataUpdatePrice.MasaBerlaku = angular.copy(newdate);
        $scope.DataUpdatePrice.NamaBarang = $scope.SelectedItemBarang.NamaBarang;
        var Data = $scope.DataUpdatePrice;
        var Url = "api/datas/Update/updateDiscount.php";
        $http({
                method: "post",
                url: Url,
                data: Data
            })
            .then(function(response) {
                if (response.data.message != "Unable to Create Discount") {
                    angular.forEach($scope.DatasDiscount, function(value, key) {
                        if (value.IdDiscount == Data.IdDiscount) {
                            value.Discount = Data.Discount;
                            value.MasaBerlaku = Data.MasaBerlaku;
                            value.BarangId = Data.BarangId;
                            value.NamaBarang = Data.NamaBarang;
                        }
                    })
                    alert("Price Was Create");
                } else
                    alert(response.data.message);

            }, function(error) {
                alert(error.message);
            })
    }

})

.controller("PenjualanController", function($scope, $http, SessionService) {
    $scope.DatasPenjualan = [];
    $scope.DatasBarang = [];
    $scope.InputPenjualan = {};
    $scope.InputPenjualan.TotalBayar = 0;
    $scope.Jumlah = {};
    $scope.DataItemDetail = {};
    $scope.InputPenjualan.ItemBarang = [];
    $scope.Init = function() {
        var Url = "api/datas/Select/readPenjualan.php";
        $http({
            method: "get",
            url: Url
        }).then(function(response) {
            if (response.data.message == "Penjualan is Found") {
                $scope.DatasPenjualan = response.data.records;
            }

        }, function(error) {
            alert(error.message);

        })


    }
    $scope.SetBarang = function() {
        var Url = "api/datas/Select/readBarangJual.php";
        $http({
            method: "get",
            url: Url
        }).then(function(response) {
            if (response.data.message == "Barang is Found") {
                $scope.DatasBarang = response.data.records;
                $scope.InputPenjualan.Nota = response.data.Nota;
                $scope.InputPenjualan.KaryawanId = response.data.KaryawanId;
            }

        }, function(error) {
            alert(error.message);
        })
    }

    $scope.AddItem = function(item) {
        item.Jumlah = $scope.Jumlah.jumlah;
        $scope.InputPenjualan.TotalBayar += (parseInt(item.Jumlah) * parseInt(item.Price));
        $scope.InputPenjualan.ItemBarang.push(angular.copy(item));
    }

    $scope.InsertPenjualan = function() {
        var Url = "api/datas/Create/createPenjualan.php";
        var Data = $scope.InputPenjualan;
        $http({
            method: "post",
            url: Url,
            data: Data
        }).then(function(response) {
            window.location.href = 'penjualan.html#!/Penjualan';
        }, function(error) {
            alert(error.message);
        })
    }

    $scope.SelectedDetail = function(item) {
        $scope.DataItemDetail = item;
    }


})

.controller("LaporanController", function($scope, $http, SessionService) {



})


.controller("Controller", function($scope, $http, SessionService) {


})


;
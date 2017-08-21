// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
app = angular.module('starter', ['ionic'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

      // Don't remove this line unless you know what you are doing. It stops the viewport
      // from snapping when text inputs are focused. Ionic handles this internally for
      // a much nicer keyboard experience.
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
});

app.config(function($stateProvider, $urlRouterProvider){
  $stateProvider.state("accueil",{
    url: "/accueil",
    templateUrl: "templates/accueil.html",
    controller: "AccueilCtrl"
  });
  $stateProvider.state("infoMedicament",{
    url: "/infoMedicament/:nom",
    templateUrl: "templates/infoMedicament.html",
    controller: "infoMedicamentCtrl"
  });
  $stateProvider.state("medicament",{
    url: "/medicament",
    templateUrl: "templates/medicament.html",
    controller: "listeMedicamentCtrl"
  });
  $stateProvider.state("apropos",{
    url: "/apropos",
    templateUrl: "templates/apropos.html"
  });
  $stateProvider.state("geo",{
    url: "/geo",
    templateUrl: "templates/geo.html"
  });
  $stateProvider.state("config",{
    url: "/config",
    templateUrl: "templates/config.html"
  });
  $urlRouterProvider.otherwise("accueil")
});

app.controller("AccueilCtrl", function($scope, $state){
  var currentDate = new Date();


  $scope.datedujour = currentDate;

  console.log($scope.datedujour);

  $scope.getMedicament = function(libelle){
    $state.go("infoMedicament",{
      nom:libelle
    })
  }
});

app.controller("infoMedicamentCtrl", function ($scope, $stateParams, $http) {

  $url = "http://127.0.0.1/ItokianaProjet/itokianaPharmacie/web/api.php?collection=medicament"
  $scope.stocks = [];
  $scope.showDetail = false;
  $scope.selectedMedicament = {};

  $scope.selectMedicament = function(medicament){
    $scope.showDetail = true;
    $scope.selectedMedicament = angular.copy(medicament);
  };

  $scope.hideDetail = function(){
    $scope.showDetail = false;
  };
  $http.get("http://127.0.0.1/ItokianaProjet/itokianaPharmacie/web/api.php?collection=medicament")
    .success(function (data) {
      $scope.stocks = data;
      $scope.libelle = $stateParams.nom;
  })
    .error(function () {

  })
});

app.controller("listeMedicamentCtrl", function($http, $scope){
  /**$scope.medicament={
    libelle: "Paracetamole",
    prix:"1000 art"
  };**/
  $scope.medicaments=[];
  $scope.showDetail = false;
  $scope.selectedMedicament = {};
  $scope.selectMedicament = function(medicament){
    $scope.showDetail = true;
    $scope.selectedMedicament = angular.copy(medicament);
  };
  $scope.hideDetail = function(){
    $scope.showDetail = false;
  };


  $http.get("http://127.0.0.1/ItokianaProjet/itokianaPharmacie/web/api.php?collection=medicament")
    .success(function (data) {
      $scope.medicaments = data;
    })
    .error(function (err) {
      console.log(err);
    })
});

'use strict';
var app = angular.module("app", ['ngMaterial', 'ngMessages','ngRoute', 'jkAngularCarousel']);

app.config(function($routeProvider) {
	$routeProvider
		.when('/home', {
			templateUrl: 'views/home.html',
			controller: 'controller'
		})
		.when('/reception', {
			templateUrl: 'views/reception.html',
			controller: 'controller'
		})
        .when('/story', {
			templateUrl: 'views/story.html',
			controller: 'controller'
		})
        .when('/party', {
			templateUrl: 'views/party.html',
			controller: 'controller'
		})
        .when('/registry', {
			templateUrl: 'views/registry.html',
			controller: 'controller'
		})
        .when('/accomodations', {
			templateUrl: 'views/accomodations.html',
			controller: 'controller'
		})
		.when('/rsvp', {
			templateUrl: 'views/rsvp.html',
			controller: 'controller'
		})
		.when('/stream', {
			templateUrl: 'views/stream.html',
			controller: 'controller'
		})
		.otherwise({
			redirectTo: '/home'
		});
});

app.controller("controller", function($scope,$http,$location){
    $scope.$on('$locationChangeSuccess', function () {
        $scope.location = $location.path().replace('/', '');
      });
	$scope.login = {
		verified: false,
		firstName: "",
		lastName: "",
		password: "",
		invalid: ""
	};
	$scope.saved = false;
	$scope.image = false;
	
	$scope.dataArray = [{
		src: 'images/Engagement1.jpg',
		style: ''
	},{
		src: 'images/Engagement2.jpg',
		style: ''
	},{
		src: 'images/Engagement3.jpg',
		style: ''
	}];

	$scope.getClass = function (path) {
		return ($location.path().substr(0, path.length) === path) ? 'active' : '';
	};

	$scope.verifyLogin = function(){
		let data = $scope.login;

		$http.post('php/verifyLogin.php', data).then(function(response) {
			if (response.data == '\"unlocked\"') {
				$scope.image = true;
			} else if (response.data == 'false') {
				$scope.login.invalid = true;
			} else {
				$scope.login.verified = true;
				$scope.guestInfo = response.data;
				if ($scope.guestInfo.kidArray) {
					for (let i = $scope.guestInfo.kidArray.length; i < parseInt(response.data.numKidsAllowed); i++) {
						$scope.guestInfo.kidArray[i] = {first:"", last:""};
					}
				} else {
					$scope.guestInfo.kidArray = new Array(parseInt(response.data.numKidsAllowed));
					for (let i = 0; i < parseInt(response.data.numKidsAllowed); i++) {
						$scope.guestInfo.kidArray[i] = {first:"", last:""};
					}
				}
			}
        });
	};
	$scope.saveRsvp = function(){
		let data = $scope.guestInfo;
		$http.post('php/saveRsvp.php', data).then(function(response) {
			$scope.saved = true;	
		});
	};
	$scope.openTarget = function() {
		window.open("https://www.target.com/gift-registry/gift/roycekasia");
	};
	$scope.openPottery = function() {
		window.open("https://www.potterybarn.com/registry/szw7czg9bn/registry-list.html");
	};
	$scope.openAmazon = function() {
		window.open("https://www.amazon.com/wedding/kasia-ashwill-royce-aggarwal-milwaukee-april-2022/registry/2BUBU6B84N2BT");
	};
	$scope.openHilton = function() {
		window.open("https://www.hilton.com/en/attend-my-event/ashwill-aggarwal-wedding/");
	};
	$scope.openFlights = function() {
		window.open("https://www.google.com/flights");
	};
});


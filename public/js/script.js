var app = angular
    .module("myapp", [])
    .controller("myController", function ($scope) {


        //DO NOT TOUCH ANYTHING BEYOND THIS POINT

        //start app, hide button, show app panel
        //pacool lang
        $scope.started = false;
        $scope.start = function () {
            $scope.started = true;
        };

        //calculator functions
        $scope.answer = 0;
        $scope.holder = 0;
        $scope.operation = "";

        //adds the input to the ones place value of the answer field and moves all prior numbers one place value up
        $scope.append = function (input) {
            $scope.answer = ($scope.answer * 10) + input;
        };

        //resets answer field to zero
        $scope.reset = function () {
            $scope.answer = 0;
        };


        $scope.operate = function (input) {
            $scope.holder = $scope.answer;
            $scope.operation = input;
            $scope.reset();
        };

        $scope.equals = function () {
            switch ($scope.operation) {
                case '+':
                    {
                        $scope.answer = $scope.holder + $scope.answer;
                        break;
                    }
                case '-':
                    {
                        $scope.answer = $scope.holder - $scope.answer;
                        break;
                    }
                case '*':
                    {
                        $scope.answer = $scope.holder * $scope.answer;
                        break;
                    }
                case '/':
                    {
                        $scope.answer = $scope.holder / $scope.answer;
                        break;
                    }
                default:
                    {
                        $scope.reset();
                    }
            }
        };

        //cart functions
        $scope.itemList = [];
        $scope.cart = [];
        $scope.name = "";
        $scope.price = "";

        //adds item x quantity to inventory
        $scope.addItem = function (name, priceEach) {
            $scope.itemList.push({
                itemName: name,
                priceEach: priceEach
            });
            $scope.name = "";
            $scope.price = "";
        };

        //adds item and quantity to cart
        $scope.addToCart = function (name, priceeach, quantity) {
            $scope.cart.push({
                itemName: name,
                priceEach: priceeach,
                itemQuantity: quantity
            });
        };
        
        //totals all in cart
        $scope.totalCart = 0;
        $scope.checkout = function () {
            for(var x = 0; x < $scope.cart.length; x++){
                $scope.totalCart += $scope.cart[x].priceEach * $scope.cart[x].itemQuantity;
            }  
        };
        
        //resets all in cart
        $scope.resetCart = function () {
            $scope.cart = [];
        };
    });
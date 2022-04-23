<?php

// echo 'Hi there 👋 from Michael.';

$data = ['this is a simple string', 'orange'];
$hasString = "test string";


echo md5($hasString);

$data_assoc = [
    'apple' => ['green', 'red'],
    'orange' => 'orange',
    'cherry' => 'red'
];


$ary = array("1"=>'One','Two',"3"=>'Three');
$a = '1'; $b = count($ary);
while ($a <= $b) {
 $pr = $ary[$a];
 print $a." has value ". "$pr<br>";
 $a++;
}


class Pizza {
    private $radius;


    function __construct($radius = 0) {
        $this->radius = $radius;
    }

    function getRadius(){
        return $this->radius;
    }

}

$object = new Pizza(40);

echo Pizza::class;

echo "We ordered pizza with radius " . $object->getRadius();

// echo $data . 4;

// var_dump($data);

// die($data);

// var_dump($data);


$kolor="red";
ECHO "Tekst HTML<br>";
echo "Tekst HTML<br>";
EcHo "Tekst HTML<br>";

// phpinfo();

echo '2' == 2 ? 'true' : 'false';
echo '<br/>';
echo '2' === 2 ? 'true' : 'false';

$test = null;
echo '<br/>';
echo $test ?: 'is not defined';



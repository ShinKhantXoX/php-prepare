<?php

$array = [1, 2, 3];

$user = [
    'name' => "Shin",
    'age' => 24
];


// array_map()

function cube($n) {
    return $n * $n *$n;
}

$arrayMapResult = array_map('cube', $array);
// print_r($arrayMapResult);

// array_filter()
function odd($var)
{
    // returns whether the input integer is odd
    return $var & 1;
}

function even($var)
{
    // returns whether the input integer is even
    return !($var & 1);
}

$array1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
$array2 = [6, 7, 8, 9, 10, 11, 12];

// echo "Odd :\n";
// print_r(array_filter($array1, "odd"));
// echo "Even:\n";
// print_r(array_filter($array2, "even"));


// array_find()
$array = [
    'a' => 'dog',
    'b' => 'cat',
    'c' => 'cow',
    'd' => 'duck',
    'e' => 'goose',
    'f' => 'elephant'
];

// Find the first animal with a name longer than 4 characters.
var_dump(array_find($array, function (string $value) {
    return strlen($value) > 4;
}));

// array_reduce()

// array_merge()
// in_array()
// array_column()
// array_keys()
// array_values()
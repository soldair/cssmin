#!/usr/bin/env php
<?php

/**
unit tests for cssmin

*/
$tests = array();
$results = array();

//---------
$test = 'selector_preserves_spaces';
$tests[$test] = <<<test
a b
test;

$results[$test] = <<<test
a b
test;

//---------
$test = 'keyword declaration with no semicolon gets semi colon';
$tests[$test] = <<<test
@import lala

test;

$results[$test] = <<<test
@import lala;
test;

//---------
$test = 'eats comments';
$tests[$test] = "/*i am a comment*/";

$results[$test] = "";

//---------
$test = 'single space before block is removed';
$tests[$test] = "LALAL {} LALAL  {}";

$results[$test] = "LALAL{} LALAL {}";


//---------
$test = 'spaces should be stripped from between declarations, closing semi colon shou;d be stripped if it as at the immediate end of the block';
$tests[$test] = <<<test
body {line-height:1.5; background-color:#fff;}
test;

$results[$test] = <<<test
body{line-height:1.5;background-color:#fff}
test;

//---------
$test = 'semi colons should not be placed outside of block given no semi colon at end of dclaration at end of block';
$tests[$test] = <<<test
body {font-family:"Trebuchet MS",Helvetica,sans-serif}
test;

$results[$test] = <<<test
body{font-family:"Trebuchet MS",Helvetica,sans-serif}
test;

//---------

$test = 'multi-line declarations should not be lost';
$tests[$test] = <<<test
body {
    line-height:1.5;
    background: transparent
        url(images/newwiz_back.gif.xhtml) repeat-x
        0 0;
   	font-family:"Trebuchet MS",Helvetica,sans-serif;
}
test;

$results[$test] = <<<test
body{line-height:1.5;background: transparent url(images/newwiz_back.gif.xhtml) repeat-x 0 0;font-family:"Trebuchet MS",Helvetica,sans-serif;}
test;

//---------


$pass = 0;
$fails = 0;

echo "starting cssmin tests\n";

foreach($tests as $k=>$css){
	$css = escapeshellarg($css);
	$res = `echo $css | ./cssmin`;
	if($results[$k] == $res){
		$pass++;
	} else {
		$fails++;
		echo "failed test $k\n------result------\n$res\n--------is not---------\n".$results[$k]."\n";
	}
}

echo "*************\n$pass passes\n$fails fails\n";

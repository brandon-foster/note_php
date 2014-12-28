<?php
$inFile = 'input.txt';

$string = file_get_contents ( $inFile );
$newString = str_replace ( '"', "'", $string );

$outfile = fopen ( 'output.txt', 'w' );
fwrite ( $outfile, $newString );
fclose ( $outfile );

echo $newString;
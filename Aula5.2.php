<?php

$idade = 10;
$lista = [];
while($idade < 18 ) {
	echo " não pode dirigir, idade $idade<br>";
	$idade ++ ;
}

echo 'Agora você já pode DIRIGIR';

for( $i = 1; $i <= 5000 ; $i++) {
	$lista [] = $i;
}

foreach ($lista as $chave => $valor) {
	echo "O valor de I é $valor <br>";
}


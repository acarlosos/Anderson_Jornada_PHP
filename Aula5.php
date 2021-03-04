<?php

$tag = 'NOME:';

$nome = ' Antonio Carlos';
$nome2 = "$tag Antonio Carlos ";
$idade = 38;
$salario = 3800.01;

echo "<h1 style='color:#FF0000'>";
echo ( $tag . $nome . '<br>');
echo ( "$nome2 possui {$idade} anos.<br>" );
echo ( "O salário de {$nome} é {$salario}" );
echo '</h1>';


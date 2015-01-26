<?php

/* $aFlat is a multi-dimentional array.
*/
// $a=[2,[3,4],[5,[6,[7]]]];
// var_dump(flatten_array($a));
function flatten_array($aFlat){

	$objTmp = (object) array('aFlat' => array());
	array_walk_recursive($aFlat, 
		create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);

	return $objTmp->aFlat;
}














?>
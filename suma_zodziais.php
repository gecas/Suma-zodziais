<?php
        //Enter your code here, enjoy!

function skaicius_zodziais( $skaicius ) {
	
	// neskaiciuosim neigiamu ir itin dideliu skaiciu (iki milijardu)
	if ( $skaicius < 0 || strlen( $skaicius ) > 9 ) return;
	
	if ( $skaicius == 0 ) return 'nulis';

	$vienetai = array( '', 'vienas', 'du', 'trys', 'keturi', 'penki', 'šeši', 'septyni', 'aštuoni', 'devyni' );

	$niolikai = array( '', 'vienuolika', 'dvylika', 'trylika', 'keturiolika', 'penkiolika', 'šešiolika', 'septyniolika', 'aštuoniolika', 'devyniolika' );

	$desimtys = array( '', 'dešimt', 'dvidešimt', 'trisdešimt', 'keturiasdešimt', 'penkiasdešimt', 'šešiasdešimt', 'septyniasdešimt', 'aštuoniasdešimt', 'devyniasdešimt' );

	$pavadinimas = array(
		array( 'milijonas', 'milijonai', 'milijonų' ),
		array( 'tūkstantis', 'tūkstančiai', 'tūkstančių' ),
	);

	$skaicius = sprintf( '%09d', $skaicius ); // iki milijardu 10^9 (milijardu neskaiciuosim)
	$skaicius = str_split( $skaicius, 3 ); // kertam kas tris simbolius

	$zodziais = array();

	foreach ( $skaicius as $i => $tripletas ) {

		// resetinam linksni
		$linksnis = 0;

		// pridedam simtu pavadinima, jei pirmas tripleto skaitmuo > 0
		if ( $tripletas{0} > 0 ) {
			$zodziais[] = $vienetai[ $tripletas{0} ];
			$zodziais[] = ( $tripletas{0} > 1 ) ? 'šimtai' : 'šimtas';
		}

		// du paskutiniai tripleto skaiciai
		$du = substr( $tripletas, 1 );

		// pacekinam nioliktus skaicius
		if ( $du > 10 && $du < 20 ) { 
			$zodziais[] = $niolikai[ $du{1} ];
			$linksnis = 2;
		} else {

			// pacekinam desimtis
			if ( $du{0} > 0 ) {
				$zodziais[] = $desimtys[ $du{0} ];
			}

			// pridedam vienetus
			if ( $du{1} > 0 ) {
				$zodziais[] = $vienetai[ $du{1} ];
				$linksnis = ( $du{1} > 1 ) ? 1 : 0;
			} else {
				$linksnis = 2;
			}

		}

		// pridedam pavadinima isskyrus paskutiniam ir nuliniams tripletams
		if ( $i < count( $pavadinimas ) && $tripletas != '000' ) {
			$zodziais[] = $pavadinimas[ $i ][ $linksnis ];
		}

	}

	return implode( ' ', $zodziais );
}


function valiutos_galune( $number, $saknis = 'eur' ) {
	
	if ( $number < 0 || strlen( $number ) > 9 ) return;

	if ( $number == 0 ) {
		return $saknis . 'ų';
	}

	$last = substr( $number, -1 );
	$du = substr( $number, -2, 2 );

	if ( ($du > 10) && ($du < 20) ) {
		return $saknis . 'ų';
	} else {
		if ( $last == 0 ) {
			return $saknis . 'ų';
		} elseif ( $last == 1 ) {
			return $saknis . 'as';
		} else {
			return $saknis . 'ai';
		}
	}

}


// pasitestavimui
$sk = 1689.24;
var_dump( skaicius_zodziais( $sk )." ".valiutos_galune( $sk ).", ".explode('.', $sk)[1]."ct"  );
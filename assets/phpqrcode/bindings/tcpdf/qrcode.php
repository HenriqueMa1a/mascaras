<?php
class QR { // Licensed under GPLv3, full text at http://www.gnu.org/licenses/gpl-3.0.txt
	const ECC_L = 1;
	const ECC_M = 0;
	const ECC_Q = 3;
	const ECC_H = 2;
	const NUM = 1;
	const ALPHA = 2;
	const APP = 3;
	const BIN = 4;
	const FNC1_1 = 5;
	const ECI = 7;
	const KANJI = 8;
	const FNC1_2 = 9;
	public function __construct($data, $ecc = self::ECC_M) { // Main Routine
		$this->prepare ( ( string ) $data, ( integer ) $ecc );
		$this->frame ();
		$this->reedsolomon ();
		$this->mask ();
		$this->format ();
	}
	private function prepare($data, $ecc) { // Validate Data
		$ver = 0;
		$len = strlen ( $data );
		$this->type = self::BIN;
		$ecc = min ( max ( intval ( $ecc ), self::ECC_M ), self::ECC_Q );
		if (! preg_match ( '{[^0-9]}', $data )) {
			$this->type = self::NUM;
		} elseif (! preg_match ( '{[^A-Z0-9 $%*+\-./:]}', $data )) {
			$this->type = self::ALPHA;
		} elseif (mb_detect_encoding ( $data, 'SJIS', true ) && preg_match ( '{[\x81-\x9F\xE0-\xEF]}', $data )) {
			$this->type = self::KANJI;
		}
		while ( $ver != 40 ) {
			if (self::$ver [$this->type] [$ver * 4 + $ecc] > $len) {
				break;
			}
			$ver ++;
		} // Check string length
		if ($ver == 40) {
			die ( 'String Length Exceeded for Datatype ' . $this->type );
		}
		$this->data = $data;
		$this->vers = $ver;
		$this->dim = 4 * ($ver + 1) + 17;
		$this->ecc = $ecc; // Register properties
		$this->img = str_split ( str_pad ( '', pow ( $this->dim, 2 ), '4' ), $this->dim );
		$data = $this->data;
		$c = strlen ( $data );
		$rem = ''; // Begin formatting data
		switch ($this->type) {
			case self::NUM :
				$data = str_split ( $data, 3 );
				if ($c % 3 != 0) {
					$rem = self::bits ( intval ( array_pop ( $data ) ), ($c % 3) * 3 + 1 );
				}
				foreach ( $data as &$d ) {
					$d = self::bits ( intval ( $d ), 10 );
				}
				$data [] = $rem;
				break;
			case self::ALPHA :
				$data = str_split ( $data, 2 );
				if ($c % 2 == 1) {
					$rem = self::bits ( self::$alpha [array_pop ( $data )], 6 );
				}
				foreach ( $data as &$d ) {
					$d = self::bits ( self::$alpha [$d [0]] * 45 + self::$alpha [$d [1]], 11 );
				}
				$data [] = $rem;
				break;
			case self::BIN :
				$data = str_split ( $data );
				foreach ( $data as &$d ) {
					$d = self::bits ( ord ( $d ), 8 );
				}
				break;
			case self::KANJI :
				$data = str_split ( $data, 2 );
				foreach ( $data as &$d ) {
					if ($d >= 0xe040) {
						$d -= 0xc140;
					} else {
						$d -= 0x8140;
					}
					$d = self::bits ( ($d >> 8) * 0xC0 + ($d & 0xFF), 13 );
				}
				break;
		} // Combine strings
		$this->data = self::bits ( $this->type, 4 ) . self::bits ( $c, self::$char [floor ( $this->vers / 17 + 7 / 17 )] [$this->type] ) . implode ( '', $data );
		$cap = self::$ebl [$this->vers * 4 + $this->ecc];
		$cap = ($cap [0] * $cap [1] + (isset ( $cap [2] ) ? $cap [2] * $cap [3] : 0)) * 8;
		$rem = $cap - strlen ( $this->data ); // Terminate, pad, split
		if ($rem > 0) {
			$this->data .= str_pad ( '', min ( 4, $rem ), '0' );
			$this->data .= str_pad ( '', 8 - strlen ( $this->data ) % 8, '0' );
			$this->data .= str_pad ( '', $cap - strlen ( $this->data ), '11101100' . '00010001' );
		}
		$this->data = str_split ( $this->data, 8 );
		foreach ( $this->data as &$d ) {
			$d = bindec ( $d );
		}
	}
	private function frame() { // Initialize frame
		$align = '1111110001101011000111111';
		$time = str_pad ( '', $this->dim - 14, '01' );
		$pos = '1111111100000110111011011101101110110000011111111';
		$blank = str_pad ( '', 8, '0' );
		$this->place ( $pos, 7, 0, 0 );
		$this->place ( $pos, 7, $this->dim - 7, 0 ); // Position
		$this->place ( $pos, 7, 0, $this->dim - 7 );
		$this->place ( $blank, 1, $this->dim - 8, 0 ); // Format Regions
		$this->place ( $blank, 8, 0, $this->dim - 8 );
		$blank .= $blank;
		$this->place ( $blank, 8, $this->dim - 8, 7 );
		$this->place ( $blank, 2, 7, $this->dim - 8 );
		$this->place ( $blank, 2, 7, 0 );
		$blank .= '00';
		$this->place ( $blank, 9, 0, 7 ); // Timing, Dark Module
		$this->place ( $time, $this->dim - 14, 7, 6 );
		$this->place ( $time, 1, 6, 7 );
		$this->img [$this->dim - 8] [8] = '1';
		if ($this->vers > 0) {
			$this->place ( $align, 5, $this->dim - 9, $this->dim - 9 ); // Alignment
			if ($this->vers > 5) {
				$a = floor ( ($this->dim - 17) / 28 ) + 2;
				$p = intval ( ($this->dim - 13) / ($a - 1) );
				$c = 0;
				while ( $c < $a ) {
					$r = 0;
					if ($c == 0 || $c == $a - 1) {
						$r = 1;
					}
					while ( $r < $a ) {
						$this->place ( $align, 5, $p * $c + 4, $p * $r + 4 );
						$r ++;
						if ($r == $a - 1 && ($c == 0 || $c == $a - 1)) {
							break;
						}
					}
					$c ++;
				} // Version Regions
				$this->place ( $blank, 3, $this->dim - 11, 0 );
				$this->place ( $blank, 6, 0, $this->dim - 11 );
			}
		}
	} // 0,1 = frame, 2,3 = data, 4 = empty
	private function reedSolomon() {
		$b = self::$ebl [$this->vers * 4 + $this->ecc]; // Get ECC structure
		$c = $b [0] + (isset ( $b [2] ) ? $b [2] : 0);
		$d = $b [0] * $b [1] + (isset ( $b [2] ) ? $b [2] * $b [3] : 0);
		$e = (floor ( self::$cap [$this->vers] / 8 ) - $d) / $c;
		$ecc = array (); // Process, build
		foreach ( array_chunk ( $b, 2 ) as $a ) {
			for($i = 0; $i < $a [0]; $i ++) {
				$ecc ['d'] [] = array_splice ( $this->data, 0, $a [1] );
				$ecc ['e'] [] = self::crc2 ( end ( $ecc ['d'] ), $e );
			}
		}
		$e *= $c;
		$this->data = '';
		$d = $c * $b [1]; // Reorganize, decimal to binary
		for($i = 0; $i < $d; $i ++) {
			$this->data .= self::bits ( array_shift ( $ecc ['d'] [$i % $c] ), 8 );
		}
		if (isset ( $b [2] )) {
			for($i = $b [0]; $i < $c; $i ++) {
				$this->data .= self::bits ( array_shift ( $ecc ['d'] [$i % $c] ), 8 );
			}
		}
		for($i = 0; $i < $e; $i ++) {
			$this->data .= self::bits ( array_shift ( $ecc ['e'] [$i % $c] ), 8 );
		}
		$this->data .= str_pad ( '', self::$cap [$this->vers] % 8, '0' ); // Remainder Bits
		$this->data = str_replace ( array (
				'0',
				'1' 
		), array (
				'2',
				'3' 
		), $this->data ); // Write to temp
		$a = array (
				array (
						$this->dim - 1,
						- 1,
						- 1 
				),
				array (
						0,
						$this->dim,
						1 
				) 
		);
		$b = reset ( $a );
		$e = 0;
		for($c = $this->dim - 1; $c > 0; $c -= 2) {
			if ($c == 6) {
				$c --;
			} // Skip vertical timing column?
			for($d = $b [0]; $d != $b [1]; $d += $b [2]) {
				if ($this->img [$d] [$c] == '4') {
					$this->img [$d] [$c] = $this->data [$e];
					$e ++;
				}
				if ($this->img [$d] [$c - 1] == '4') {
					$this->img [$d] [$c - 1] = $this->data [$e];
					$e ++;
				}
			}
			$b = ($b [0]) ? end ( $a ) : reset ( $a );
		}
	}
	private function mask() {
		$masks = array ();
		$scores = array (); // Try all masks
		for($m = 0; $m < 8; $m ++) {
			$masks [$m] = $this->img;
			$scores [$m] = array (
					array (),
					0,
					0,
					0 
			);
			switch ($m) {
				case 0 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if (($i + $j) % 2 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 1 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if ($j % 2 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 2 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if ($i % 3 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 3 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if (($i + $j) % 3 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 4 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if ((($i >> 1) + ( int ) ($j / 3)) % 2 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 5 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if ($i * $j % 2 + $i * $j % 3 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 6 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if (($i * $j % 2 + $i * $j % 3) % 2 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
				case 7 :
					for($i = 0; $i < $this->dim; $i ++) {
						for($j = 0; $j < $this->dim; $j ++) {
							if (($i * $j % 3 + $i * $j % 2) % 2 == 0 && $masks [$m] [$j] [$i] > 1) {
								$masks [$m] [$j] [$i] = ($masks [$m] [$j] [$i] % 2) ? '0' : '1';
							}
						}
					}
					break;
			} // Process and score
			$masks [$m] = explode ( ',', str_replace ( array (
					'2',
					'3' 
			), array (
					'0',
					'1' 
			), implode ( ',', $masks [$m] ) ) );
			foreach ( $masks [$m] as $a ) {
				$scores [$m] [2] += substr_count ( $a, '1011101' );
				preg_match_all ( '/1{5,}/', $a, $b );
				$scores [$m] [0] = array_merge ( $scores [$m] [0], $b [0] );
				$a = count_chars ( $a );
				$scores [$m] [3] += $a [49];
			} // Transpose for vertical regions
			foreach ( self::transpose ( $masks [$m], $this->dim, true ) as $a ) {
				$scores [$m] [2] += substr_count ( $a, '1011101' );
				preg_match_all ( '/1{5,}/', $a, $b );
				$scores [$m] [0] = array_merge ( $scores [$m] [0], $b [0] );
			}
			foreach ( $scores [$m] [0] as &$a ) {
				$a = strlen ( $a ) - 5;
			}
			$scores [$m] [0] = max ( $scores [$m] [0] ); // Process data
			$scores [$m] [3] = round ( abs ( 100 * $scores [$m] [3] / pow ( $this->dim, 2 ) - 50 ) / 5 ) * 5;
			$scores [$m] = 3 + $scores [$m] [0] + 40 * $scores [$m] [2] + 10 * $scores [$m] [3];
		} // Choose mask
		$m = array_keys ( $scores, min ( $scores ) );
		$this->mask = $m [0];
		$this->img = $masks [$this->mask];
	}
	private function format() { // Build format string
		$f = $this->mask + ($this->ecc << 3);
		$f = self::bits ( (self::crc ( $f, 1335 ) + ($f << 10)) ^ 21522, 15 );
		$this->place ( substr ( $f, 7, 8 ), 8, $this->dim - 8, 8 );
		$this->place ( strrev ( substr ( $f, 0, 7 ) ), 1, 8, $this->dim - 7 );
		$this->place ( strrev ( substr ( $f, 9, 6 ) ), 1, 8, 0 );
		$this->place ( strrev ( substr ( $f, 7, 2 ) ), 1, 8, 7 );
		$this->place ( substr ( $f, 6, 1 ), 1, 7, 8 );
		$this->place ( substr ( $f, 0, 6 ), 6, 0, 8 ); // Build version string
		if ($this->vers > 5) {
			$v = $this->vers + 1;
			$v = strrev ( self::bits ( self::crc ( $v, 7973 ) + ($v << 12), 18 ) );
			$this->place ( $v, 3, $this->dim - 11, 0 );
			$this->place ( self::transpose ( $v, 3 ), 6, 0, $this->dim - 11 );
		}
	}
	public function image($z = 4) {
		$im = imagecreate ( $this->dim, $this->dim ); // Initialize image
		imagecolorallocate ( $im, 255, 255, 255 );
		$c = imagecolorallocate ( $im, 0, 0, 0 ); // Begin writing
		for($i = 0; $i < $this->dim; $i ++) {
			for($j = 0; $j < $this->dim; $j ++) {
				if ($this->img [$j] [$i]) {
					imagesetpixel ( $im, $i, $j, $c );
				}
			}
		}
		$img = imagecreate ( ($this->dim + 8) * $z, ($this->dim + 8) * $z ); // New zoomed image with margin
		imagecolorallocate ( $img, 255, 255, 255 );
		imagecolorallocate ( $img, 0, 0, 0 );
		imagecopyresized ( $img, $im, 4 * $z, 4 * $z, 0, 0, $this->dim * $z, $this->dim * $z, $this->dim, $this->dim );
		imagedestroy ( $im );
		ob_start ();
		imagegif ( $img );
		imagedestroy ( $img ); // Capture output
		return ob_get_clean ();
	}
	public function text($a = false) { // Either console or document
		$c = ($a) ? array (
				"\xDB\xDB",
				'  ' 
		) : array (
				'  ',
				'██' 
		);
		$a = str_pad ( '', $this->dim * 2 + 8, $c [0] );
		$a = array (
				$a . "\n" . $a . "\n",
				$c [0] . $c [0] 
		);
		return $a [0] . $a [1] . str_replace ( array (
				'0',
				'1' 
		), $c, implode ( $a [1] . "\n" . $a [1], $this->img ) ) . $a [1] . "\n" . $a [0];
	}
	// Utility Function
	private function place($data, $phase, $x, $y) {
		$data = str_split ( $data, $phase );
		foreach ( $data as $d ) {
			for($i = 0; $i < $phase; $i ++) {
				$this->img [$y] [$i + $x] = $d [$i];
			}
			$y ++;
		}
	} // Static Utility Functions
	private static function crc($m, $k) {
		$a = strlen ( decbin ( $m ) );
		$l = strlen ( decbin ( $k ) ) - 1;
		$m = $m << $l;
		while ( $a > - 1 ) {
			if ($m & 1 << $l + $a) {
				$m = $m ^ ($k << $a);
			}
			$a --;
		}
		return $m;
	}
	private static function crc2($d, $b) {
		$d = array_values ( $d );
		$i = count ( $d );
		$g = self::$sr [$b];
		$j = count ( $g ) - 1;
		$d = array_pad ( $d, $j + $i, 0 );
		while ( $i > 0 ) {
			$b = self::$n2a [$d [0]];
			array_shift ( $d );
			for($c = 0; $c < $j; $c ++) {
				$d [$c] = $d [$c] ^ (self::$a2n [($b + $g [$c + 1]) % 255]);
			}
			$i --;
		}
		return $d;
	}
	private static function bits($d, $l) {
		return str_pad ( decbin ( $d ), $l, '0', STR_PAD_LEFT );
	}
	private static function transpose($a, $b, $arr = false) {
		$a = ($arr) ? $a : str_split ( $a, $b );
		$c = count ( $a );
		$j = 0;
		$t = '';
		while ( $j < $b ) {
			$i = 0;
			while ( $i < $c ) {
				$t .= $a [$i] [$j];
				$i ++;
			}
			$j ++;
		}
		return ($arr) ? str_split ( $t, $b ) : $t;
	} // Calculable?
	private static $cap = array (
			208,
			359,
			567,
			807,
			1079,
			1383,
			1568,
			1936,
			2336,
			2768,
			3232,
			3728,
			4256,
			4651,
			5243,
			5867,
			6523,
			7211,
			7931,
			8683,
			9252,
			10068,
			10916,
			11796,
			12708,
			13652,
			14628,
			15371,
			16411,
			17483,
			18587,
			19723,
			20891,
			22091,
			23008,
			24272,
			25568,
			26896,
			28256,
			29648 
	);
	private static $ver = array (
			1 => array (
					34,
					41,
					17,
					27,
					63,
					77,
					34,
					48,
					101,
					127,
					58,
					77,
					149,
					187,
					82,
					111,
					202,
					255,
					106,
					144,
					255,
					322,
					139,
					178,
					293,
					370,
					154,
					207,
					365,
					461,
					202,
					259,
					432,
					552,
					235,
					312,
					513,
					652,
					288,
					364,
					604,
					772,
					331,
					427,
					691,
					883,
					374,
					489,
					796,
					1022,
					427,
					580,
					871,
					1101,
					468,
					621,
					991,
					1250,
					530,
					703,
					1082,
					1408,
					602,
					775,
					1212,
					1548,
					674,
					876,
					1346,
					1725,
					746,
					948,
					1500,
					1903,
					813,
					1063,
					1600,
					2061,
					919,
					1159,
					1708,
					2232,
					969,
					1224,
					1872,
					2409,
					1056,
					1358,
					2059,
					2620,
					1108,
					1468,
					2188,
					2812,
					1228,
					1588,
					2395,
					3057,
					1286,
					1718,
					2544,
					3283,
					1425,
					1804,
					2701,
					3514,
					1501,
					1933,
					2857,
					3669,
					1581,
					2085,
					3035,
					3909,
					1677,
					2181,
					3289,
					4158,
					1782,
					2358,
					3486,
					4417,
					1897,
					2473,
					3693,
					4686,
					2022,
					2670,
					3909,
					4965,
					2157,
					2805,
					4134,
					5253,
					2301,
					2949,
					4343,
					5529,
					2361,
					3081,
					4588,
					5836,
					2524,
					3244,
					4775,
					6153,
					2625,
					3417,
					5039,
					6479,
					2735,
					3599,
					5313,
					6743,
					2927,
					3791,
					5596,
					7089,
					3057,
					3993 
			),
			2 => array (
					20,
					25,
					10,
					16,
					38,
					47,
					20,
					29,
					61,
					77,
					35,
					47,
					90,
					114,
					50,
					67,
					122,
					154,
					64,
					87,
					154,
					195,
					84,
					108,
					178,
					224,
					93,
					125,
					221,
					279,
					122,
					157,
					262,
					335,
					143,
					189,
					311,
					395,
					174,
					221,
					366,
					468,
					200,
					259,
					419,
					535,
					227,
					296,
					483,
					619,
					259,
					352,
					528,
					667,
					283,
					376,
					600,
					758,
					321,
					426,
					656,
					854,
					365,
					470,
					734,
					938,
					408,
					531,
					816,
					1046,
					452,
					574,
					909,
					1153,
					493,
					644,
					970,
					1249,
					557,
					702,
					1035,
					1352,
					587,
					742,
					1134,
					1460,
					640,
					823,
					1248,
					1588,
					672,
					890,
					1326,
					1704,
					744,
					963,
					1451,
					1853,
					779,
					1041,
					1542,
					1990,
					864,
					1094,
					1637,
					2132,
					910,
					1172,
					1732,
					2223,
					958,
					1263,
					1839,
					2369,
					1016,
					1322,
					1994,
					2520,
					1080,
					1429,
					2113,
					2677,
					1150,
					1499,
					2238,
					2840,
					1226,
					1618,
					2369,
					3009,
					1307,
					1700,
					2506,
					3183,
					1394,
					1787,
					2632,
					3351,
					1431,
					1867,
					2780,
					3537,
					1530,
					1966,
					2894,
					3729,
					1591,
					2071,
					3054,
					3927,
					1658,
					2181,
					3220,
					4087,
					1774,
					2298,
					3391,
					4296,
					1852,
					2420 
			),
			4 => array (
					14,
					17,
					7,
					11,
					26,
					32,
					14,
					20,
					42,
					53,
					24,
					32,
					62,
					78,
					34,
					46,
					84,
					106,
					44,
					60,
					106,
					134,
					58,
					74,
					122,
					154,
					64,
					86,
					152,
					192,
					84,
					108,
					180,
					230,
					98,
					130,
					213,
					271,
					119,
					151,
					251,
					321,
					137,
					177,
					287,
					367,
					155,
					203,
					331,
					425,
					177,
					241,
					362,
					458,
					194,
					258,
					412,
					520,
					220,
					292,
					450,
					586,
					250,
					322,
					504,
					644,
					280,
					364,
					560,
					718,
					310,
					394,
					624,
					792,
					338,
					442,
					666,
					858,
					382,
					482,
					711,
					929,
					403,
					509,
					779,
					1003,
					439,
					565,
					857,
					1091,
					461,
					611,
					911,
					1171,
					511,
					661,
					997,
					1273,
					535,
					715,
					1059,
					1367,
					593,
					751,
					1125,
					1465,
					625,
					805,
					1190,
					1528,
					658,
					868,
					1264,
					1628,
					698,
					908,
					1370,
					1732,
					742,
					982,
					1452,
					1840,
					790,
					1030,
					1538,
					1952,
					842,
					1112,
					1628,
					2068,
					898,
					1168,
					1722,
					2188,
					958,
					1228,
					1809,
					2303,
					983,
					1283,
					1911,
					2431,
					1051,
					1351,
					1989,
					2563,
					1093,
					1423,
					2099,
					2699,
					1139,
					1499,
					2213,
					2809,
					1219,
					1579,
					2331,
					2953,
					1273,
					1663 
			),
			8 => array (
					8,
					10,
					4,
					7,
					16,
					20,
					8,
					12,
					26,
					32,
					15,
					20,
					38,
					48,
					21,
					28,
					52,
					65,
					27,
					37,
					65,
					82,
					36,
					45,
					75,
					95,
					39,
					53,
					93,
					118,
					52,
					66,
					111,
					141,
					60,
					80,
					131,
					167,
					74,
					93,
					155,
					198,
					85,
					109,
					177,
					226,
					96,
					125,
					204,
					262,
					109,
					149,
					223,
					282,
					120,
					159,
					254,
					320,
					136,
					180,
					277,
					361,
					154,
					198,
					310,
					397,
					173,
					224,
					345,
					442,
					191,
					243,
					384,
					488,
					208,
					272,
					410,
					528,
					235,
					297,
					438,
					572,
					248,
					314,
					480,
					618,
					270,
					348,
					528,
					672,
					284,
					376,
					561,
					721,
					315,
					407,
					614,
					784,
					330,
					440,
					652,
					842,
					365,
					462,
					692,
					902,
					385,
					496,
					732,
					940,
					405,
					534,
					778,
					1002,
					430,
					559,
					843,
					1066,
					457,
					604,
					894,
					1132,
					486,
					634,
					947,
					1201,
					518,
					684,
					1002,
					1273,
					553,
					719,
					1060,
					1347,
					590,
					756,
					1113,
					1417,
					605,
					790,
					1176,
					1496,
					647,
					832,
					1224,
					1577,
					673,
					876,
					1292,
					1661,
					701,
					923,
					1362,
					1729,
					750,
					972,
					1435,
					1817,
					784,
					1024 
			) 
	);
	// Confirmed Arbitrary
	private static $ebl = array (
			array (
					1,
					16 
			),
			array (
					1,
					19 
			),
			array (
					1,
					9 
			),
			array (
					1,
					13 
			),
			array (
					1,
					28 
			),
			array (
					1,
					34 
			),
			array (
					1,
					16 
			),
			array (
					1,
					22 
			),
			array (
					1,
					44 
			),
			array (
					1,
					55 
			),
			array (
					2,
					13 
			),
			array (
					2,
					17 
			),
			array (
					2,
					32 
			),
			array (
					1,
					80 
			),
			array (
					4,
					9 
			),
			array (
					2,
					24 
			),
			array (
					2,
					43 
			),
			array (
					1,
					108 
			),
			array (
					2,
					11,
					2,
					12 
			),
			array (
					2,
					15,
					2,
					16 
			),
			array (
					4,
					27 
			),
			array (
					2,
					68 
			),
			array (
					4,
					15 
			),
			array (
					4,
					19 
			),
			array (
					4,
					31 
			),
			array (
					2,
					78 
			),
			array (
					4,
					13,
					1,
					14 
			),
			array (
					2,
					14,
					4,
					15 
			),
			array (
					2,
					38,
					2,
					39 
			),
			array (
					2,
					97 
			),
			array (
					4,
					14,
					2,
					15 
			),
			array (
					4,
					18,
					2,
					19 
			),
			array (
					3,
					36,
					2,
					37 
			),
			array (
					2,
					116 
			),
			array (
					4,
					12,
					4,
					13 
			),
			array (
					4,
					16,
					4,
					17 
			),
			array (
					4,
					43,
					1,
					44 
			),
			array (
					2,
					68,
					2,
					69 
			),
			array (
					6,
					15,
					2,
					16 
			),
			array (
					6,
					19,
					2,
					20 
			),
			array (
					1,
					50,
					4,
					51 
			),
			array (
					4,
					81 
			),
			array (
					3,
					12,
					8,
					13 
			),
			array (
					4,
					22,
					4,
					23 
			),
			array (
					6,
					36,
					2,
					37 
			),
			array (
					2,
					92,
					2,
					93 
			),
			array (
					7,
					14,
					4,
					15 
			),
			array (
					4,
					20,
					6,
					21 
			),
			array (
					8,
					37,
					1,
					38 
			),
			array (
					4,
					107 
			),
			array (
					12,
					11,
					4,
					12 
			),
			array (
					8,
					20,
					4,
					21 
			),
			array (
					4,
					40,
					5,
					41 
			),
			array (
					3,
					115,
					1,
					116 
			),
			array (
					11,
					12,
					5,
					13 
			),
			array (
					11,
					16,
					5,
					17 
			),
			array (
					5,
					41,
					5,
					42 
			),
			array (
					5,
					87,
					1,
					88 
			),
			array (
					11,
					12,
					7,
					13 
			),
			array (
					5,
					24,
					7,
					25 
			),
			array (
					7,
					45,
					3,
					46 
			),
			array (
					5,
					98,
					1,
					99 
			),
			array (
					3,
					15,
					13,
					16 
			),
			array (
					15,
					19,
					2,
					20 
			),
			array (
					10,
					46,
					1,
					47 
			),
			array (
					1,
					107,
					5,
					108 
			),
			array (
					2,
					14,
					17,
					15 
			),
			array (
					1,
					22,
					15,
					23 
			),
			array (
					9,
					43,
					4,
					44 
			),
			array (
					5,
					120,
					1,
					121 
			),
			array (
					2,
					14,
					19,
					15 
			),
			array (
					17,
					22,
					1,
					23 
			),
			array (
					3,
					44,
					11,
					45 
			),
			array (
					3,
					113,
					4,
					114 
			),
			array (
					9,
					13,
					16,
					14 
			),
			array (
					17,
					21,
					4,
					22 
			),
			array (
					3,
					41,
					13,
					42 
			),
			array (
					3,
					107,
					5,
					108 
			),
			array (
					15,
					15,
					10,
					16 
			),
			array (
					15,
					24,
					5,
					25 
			),
			array (
					17,
					42 
			),
			array (
					4,
					116,
					4,
					117 
			),
			array (
					19,
					16,
					6,
					17 
			),
			array (
					17,
					22,
					6,
					23 
			),
			array (
					17,
					46 
			),
			array (
					2,
					111,
					7,
					112 
			),
			array (
					34,
					13 
			),
			array (
					7,
					24,
					16,
					25 
			),
			array (
					4,
					47,
					14,
					48 
			),
			array (
					4,
					121,
					5,
					122 
			),
			array (
					16,
					15,
					14,
					16 
			),
			array (
					11,
					24,
					14,
					25 
			),
			array (
					6,
					45,
					14,
					46 
			),
			array (
					6,
					117,
					4,
					118 
			),
			array (
					30,
					16,
					2,
					17 
			),
			array (
					11,
					24,
					16,
					25 
			),
			array (
					8,
					47,
					13,
					48 
			),
			array (
					8,
					106,
					4,
					107 
			),
			array (
					22,
					15,
					13,
					16 
			),
			array (
					7,
					24,
					22,
					25 
			),
			array (
					19,
					46,
					4,
					47 
			),
			array (
					10,
					114,
					2,
					115 
			),
			array (
					33,
					16,
					4,
					17 
			),
			array (
					28,
					22,
					6,
					23 
			),
			array (
					22,
					45,
					3,
					46 
			),
			array (
					8,
					122,
					4,
					123 
			),
			array (
					12,
					15,
					28,
					16 
			),
			array (
					8,
					23,
					26,
					24 
			),
			array (
					3,
					45,
					23,
					46 
			),
			array (
					3,
					117,
					10,
					118 
			),
			array (
					11,
					15,
					31,
					16 
			),
			array (
					4,
					24,
					31,
					25 
			),
			array (
					21,
					45,
					7,
					46 
			),
			array (
					7,
					116,
					7,
					117 
			),
			array (
					19,
					15,
					26,
					16 
			),
			array (
					1,
					23,
					37,
					24 
			),
			array (
					19,
					47,
					10,
					48 
			),
			array (
					5,
					115,
					10,
					116 
			),
			array (
					23,
					15,
					25,
					16 
			),
			array (
					15,
					24,
					25,
					25 
			),
			array (
					2,
					46,
					29,
					47 
			),
			array (
					13,
					115,
					3,
					116 
			),
			array (
					23,
					15,
					28,
					16 
			),
			array (
					42,
					24,
					1,
					25 
			),
			array (
					10,
					46,
					23,
					47 
			),
			array (
					17,
					115 
			),
			array (
					19,
					15,
					35,
					16 
			),
			array (
					10,
					24,
					35,
					25 
			),
			array (
					14,
					46,
					21,
					47 
			),
			array (
					17,
					115,
					1,
					116 
			),
			array (
					11,
					15,
					46,
					16 
			),
			array (
					29,
					24,
					19,
					25 
			),
			array (
					14,
					46,
					23,
					47 
			),
			array (
					13,
					115,
					6,
					116 
			),
			array (
					59,
					16,
					1,
					17 
			),
			array (
					44,
					24,
					7,
					25 
			),
			array (
					12,
					47,
					26,
					48 
			),
			array (
					12,
					121,
					7,
					122 
			),
			array (
					22,
					15,
					41,
					16 
			),
			array (
					39,
					24,
					14,
					25 
			),
			array (
					6,
					47,
					34,
					48 
			),
			array (
					6,
					121,
					14,
					122 
			),
			array (
					2,
					15,
					64,
					16 
			),
			array (
					46,
					24,
					10,
					25 
			),
			array (
					29,
					46,
					14,
					47 
			),
			array (
					17,
					122,
					4,
					123 
			),
			array (
					24,
					15,
					46,
					16 
			),
			array (
					49,
					24,
					10,
					25 
			),
			array (
					13,
					46,
					32,
					47 
			),
			array (
					4,
					122,
					18,
					123 
			),
			array (
					42,
					15,
					32,
					16 
			),
			array (
					48,
					24,
					14,
					25 
			),
			array (
					40,
					47,
					7,
					48 
			),
			array (
					20,
					117,
					4,
					118 
			),
			array (
					10,
					15,
					67,
					16 
			),
			array (
					43,
					24,
					22,
					25 
			),
			array (
					18,
					47,
					31,
					48 
			),
			array (
					19,
					118,
					6,
					119 
			),
			array (
					20,
					15,
					61,
					16 
			),
			array (
					34,
					24,
					34,
					25 
			) 
	);
	private static $sr = array (
			7 => array (
					1,
					87,
					229,
					146,
					149,
					238,
					102,
					21 
			),
			10 => array (
					1,
					251,
					67,
					46,
					61,
					118,
					70,
					64,
					94,
					32,
					45 
			),
			13 => array (
					1,
					74,
					152,
					176,
					100,
					86,
					100,
					106,
					104,
					130,
					218,
					206,
					140,
					78 
			),
			15 => array (
					1,
					8,
					183,
					61,
					91,
					202,
					37,
					51,
					58,
					58,
					237,
					140,
					124,
					5,
					99,
					105 
			),
			16 => array (
					1,
					120,
					104,
					107,
					109,
					102,
					161,
					76,
					3,
					91,
					191,
					147,
					169,
					182,
					194,
					225,
					120 
			),
			17 => array (
					1,
					43,
					139,
					206,
					78,
					43,
					239,
					123,
					206,
					214,
					147,
					24,
					99,
					150,
					39,
					243,
					163,
					136 
			),
			18 => array (
					1,
					215,
					234,
					158,
					94,
					184,
					97,
					118,
					170,
					79,
					187,
					152,
					148,
					252,
					179,
					5,
					98,
					96,
					153 
			),
			20 => array (
					1,
					17,
					60,
					79,
					50,
					61,
					163,
					26,
					187,
					202,
					180,
					221,
					225,
					83,
					239,
					156,
					164,
					212,
					212,
					188,
					190 
			),
			22 => array (
					1,
					210,
					171,
					247,
					242,
					93,
					230,
					14,
					109,
					221,
					53,
					200,
					74,
					8,
					172,
					98,
					80,
					219,
					134,
					160,
					105,
					165,
					231 
			),
			24 => array (
					1,
					229,
					121,
					135,
					48,
					211,
					117,
					251,
					126,
					159,
					180,
					169,
					152,
					192,
					226,
					228,
					218,
					111,
					0,
					117,
					232,
					87,
					96,
					227,
					21 
			),
			26 => array (
					1,
					173,
					125,
					158,
					2,
					103,
					182,
					118,
					17,
					145,
					201,
					111,
					28,
					165,
					53,
					161,
					21,
					245,
					142,
					13,
					102,
					48,
					227,
					153,
					145,
					218,
					70 
			),
			28 => array (
					1,
					168,
					223,
					200,
					104,
					224,
					234,
					108,
					180,
					110,
					190,
					195,
					147,
					205,
					27,
					232,
					201,
					21,
					43,
					245,
					87,
					42,
					195,
					212,
					119,
					242,
					37,
					9,
					123 
			),
			30 => array (
					1,
					41,
					173,
					145,
					152,
					216,
					31,
					179,
					182,
					50,
					48,
					110,
					86,
					239,
					96,
					222,
					125,
					42,
					173,
					226,
					193,
					224,
					130,
					156,
					37,
					251,
					216,
					238,
					40,
					192,
					180 
			),
			32 => array (
					1,
					10,
					6,
					106,
					190,
					249,
					167,
					4,
					67,
					209,
					138,
					138,
					32,
					242,
					123,
					89,
					27,
					120,
					185,
					80,
					156,
					38,
					69,
					171,
					60,
					28,
					222,
					80,
					52,
					254,
					185,
					220,
					241 
			),
			34 => array (
					1,
					111,
					77,
					146,
					94,
					26,
					21,
					108,
					19,
					105,
					94,
					113,
					193,
					86,
					140,
					163,
					125,
					58,
					158,
					229,
					239,
					218,
					103,
					56,
					70,
					114,
					61,
					183,
					129,
					167,
					13,
					98,
					62,
					129,
					51 
			),
			36 => array (
					1,
					200,
					183,
					98,
					16,
					172,
					31,
					246,
					234,
					60,
					152,
					115,
					0,
					167,
					152,
					113,
					248,
					238,
					107,
					18,
					63,
					218,
					37,
					87,
					210,
					105,
					177,
					120,
					74,
					121,
					196,
					117,
					251,
					113,
					233,
					30,
					120 
			),
			40 => array (
					1,
					59,
					116,
					79,
					161,
					252,
					98,
					128,
					205,
					128,
					161,
					247,
					57,
					163,
					56,
					235,
					106,
					53,
					26,
					187,
					174,
					226,
					104,
					170,
					7,
					175,
					35,
					181,
					114,
					88,
					41,
					47,
					163,
					125,
					134,
					72,
					20,
					232,
					53,
					35,
					15 
			),
			42 => array (
					1,
					250,
					103,
					221,
					230,
					25,
					18,
					137,
					231,
					0,
					3,
					58,
					242,
					221,
					191,
					110,
					84,
					230,
					8,
					188,
					106,
					96,
					147,
					15,
					131,
					139,
					34,
					101,
					223,
					39,
					101,
					213,
					199,
					237,
					254,
					201,
					123,
					171,
					162,
					194,
					117,
					50,
					96 
			),
			44 => array (
					1,
					190,
					7,
					61,
					121,
					71,
					246,
					69,
					55,
					168,
					188,
					89,
					243,
					191,
					25,
					72,
					123,
					9,
					145,
					14,
					247,
					1,
					238,
					44,
					78,
					143,
					62,
					224,
					126,
					118,
					114,
					68,
					163,
					52,
					194,
					217,
					147,
					204,
					169,
					37,
					130,
					113,
					102,
					73,
					181 
			),
			46 => array (
					1,
					112,
					94,
					88,
					112,
					253,
					224,
					202,
					115,
					187,
					99,
					89,
					5,
					54,
					113,
					129,
					44,
					58,
					16,
					135,
					216,
					169,
					211,
					36,
					1,
					4,
					96,
					60,
					241,
					73,
					104,
					234,
					8,
					249,
					245,
					119,
					174,
					52,
					25,
					157,
					224,
					43,
					202,
					223,
					19,
					82,
					15 
			),
			48 => array (
					1,
					228,
					25,
					196,
					130,
					211,
					146,
					60,
					24,
					251,
					90,
					39,
					102,
					240,
					61,
					178,
					63,
					46,
					123,
					115,
					18,
					221,
					111,
					135,
					160,
					182,
					205,
					107,
					206,
					95,
					150,
					120,
					184,
					91,
					21,
					247,
					156,
					140,
					238,
					191,
					11,
					94,
					227,
					84,
					50,
					163,
					39,
					34,
					108 
			),
			50 => array (
					1,
					232,
					125,
					157,
					161,
					164,
					9,
					118,
					46,
					209,
					99,
					203,
					193,
					35,
					3,
					209,
					111,
					195,
					242,
					203,
					225,
					46,
					13,
					32,
					160,
					126,
					209,
					130,
					160,
					242,
					215,
					242,
					75,
					77,
					42,
					189,
					32,
					113,
					65,
					124,
					69,
					228,
					114,
					235,
					175,
					124,
					170,
					215,
					232,
					133,
					205 
			),
			52 => array (
					1,
					116,
					50,
					86,
					186,
					50,
					220,
					251,
					89,
					192,
					46,
					86,
					127,
					124,
					19,
					184,
					233,
					151,
					215,
					22,
					14,
					59,
					145,
					37,
					242,
					203,
					134,
					254,
					89,
					190,
					94,
					59,
					65,
					124,
					113,
					100,
					233,
					235,
					121,
					22,
					76,
					86,
					97,
					39,
					242,
					200,
					220,
					101,
					33,
					239,
					254,
					116,
					51 
			),
			54 => array (
					1,
					183,
					26,
					201,
					87,
					210,
					221,
					113,
					21,
					46,
					65,
					45,
					50,
					238,
					184,
					249,
					225,
					102,
					58,
					209,
					218,
					109,
					165,
					26,
					95,
					184,
					192,
					52,
					245,
					35,
					254,
					238,
					175,
					172,
					79,
					123,
					25,
					122,
					43,
					120,
					108,
					215,
					80,
					128,
					201,
					235,
					8,
					153,
					59,
					101,
					31,
					198,
					76,
					31,
					156 
			),
			56 => array (
					1,
					106,
					120,
					107,
					157,
					164,
					216,
					112,
					116,
					2,
					91,
					248,
					163,
					36,
					201,
					202,
					229,
					6,
					144,
					254,
					155,
					135,
					208,
					170,
					209,
					12,
					139,
					127,
					142,
					182,
					249,
					177,
					174,
					190,
					28,
					10,
					85,
					239,
					184,
					101,
					124,
					152,
					206,
					96,
					23,
					163,
					61,
					27,
					196,
					247,
					151,
					154,
					202,
					207,
					20,
					61,
					10 
			),
			58 => array (
					1,
					82,
					116,
					26,
					247,
					66,
					27,
					62,
					107,
					252,
					182,
					200,
					185,
					235,
					55,
					251,
					242,
					210,
					144,
					154,
					237,
					176,
					141,
					192,
					248,
					152,
					249,
					206,
					85,
					253,
					142,
					65,
					165,
					125,
					23,
					24,
					30,
					122,
					240,
					214,
					6,
					129,
					218,
					29,
					145,
					127,
					134,
					206,
					245,
					117,
					29,
					41,
					63,
					159,
					142,
					233,
					125,
					148,
					123 
			),
			60 => array (
					1,
					107,
					140,
					26,
					12,
					9,
					141,
					243,
					197,
					226,
					197,
					219,
					45,
					211,
					101,
					219,
					120,
					28,
					181,
					127,
					6,
					100,
					247,
					2,
					205,
					198,
					57,
					115,
					219,
					101,
					109,
					160,
					82,
					37,
					38,
					238,
					49,
					160,
					209,
					121,
					86,
					11,
					124,
					30,
					181,
					84,
					25,
					194,
					87,
					65,
					102,
					190,
					220,
					70,
					27,
					209,
					16,
					89,
					7,
					33,
					240 
			),
			62 => array (
					1,
					65,
					202,
					113,
					98,
					71,
					223,
					248,
					118,
					214,
					94,
					0,
					122,
					37,
					23,
					2,
					228,
					58,
					121,
					7,
					105,
					135,
					78,
					243,
					118,
					70,
					76,
					223,
					89,
					72,
					50,
					70,
					111,
					194,
					17,
					212,
					126,
					181,
					35,
					221,
					117,
					235,
					11,
					229,
					149,
					147,
					123,
					213,
					40,
					115,
					6,
					200,
					100,
					26,
					246,
					182,
					218,
					127,
					215,
					36,
					186,
					110,
					106 
			),
			64 => array (
					1,
					45,
					51,
					175,
					9,
					7,
					158,
					159,
					49,
					68,
					119,
					92,
					123,
					177,
					204,
					187,
					254,
					200,
					78,
					141,
					149,
					119,
					26,
					127,
					53,
					160,
					93,
					199,
					212,
					29,
					24,
					145,
					156,
					208,
					150,
					218,
					209,
					4,
					216,
					91,
					47,
					184,
					146,
					47,
					140,
					195,
					195,
					125,
					242,
					238,
					63,
					99,
					108,
					140,
					230,
					242,
					31,
					204,
					11,
					178,
					243,
					217,
					156,
					213,
					231 
			),
			66 => array (
					1,
					5,
					118,
					222,
					180,
					136,
					136,
					162,
					51,
					46,
					117,
					13,
					215,
					81,
					17,
					139,
					247,
					197,
					171,
					95,
					173,
					65,
					137,
					178,
					68,
					111,
					95,
					101,
					41,
					72,
					214,
					169,
					197,
					95,
					7,
					44,
					154,
					77,
					111,
					236,
					40,
					121,
					143,
					63,
					87,
					80,
					253,
					240,
					126,
					217,
					77,
					34,
					232,
					106,
					50,
					168,
					82,
					76,
					146,
					67,
					106,
					171,
					25,
					132,
					93,
					45,
					105 
			),
			68 => array (
					1,
					247,
					159,
					223,
					33,
					224,
					93,
					77,
					70,
					90,
					160,
					32,
					254,
					43,
					150,
					84,
					101,
					190,
					205,
					133,
					52,
					60,
					202,
					165,
					220,
					203,
					151,
					93,
					84,
					15,
					84,
					253,
					173,
					160,
					89,
					227,
					52,
					199,
					97,
					95,
					231,
					52,
					177,
					41,
					125,
					137,
					241,
					166,
					225,
					118,
					2,
					54,
					32,
					82,
					215,
					175,
					198,
					43,
					238,
					235,
					27,
					101,
					184,
					127,
					3,
					5,
					8,
					163,
					238 
			) 
	);
	private static $char = array (
			array (
					1 => 10,
					2 => 9,
					4 => 8,
					8 => 8 
			),
			array (
					1 => 12,
					2 => 11,
					4 => 16,
					8 => 10 
			),
			array (
					1 => 14,
					2 => 13,
					4 => 16,
					8 => 12 
			) 
	);
	private static $alpha = array (
			'0' => 0,
			'1' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
			'7' => 7,
			'8' => 8,
			'9' => 9,
			'A' => 10,
			'B' => 11,
			'C' => 12,
			'D' => 13,
			'E' => 14,
			'F' => 15,
			'G' => 16,
			'H' => 17,
			'I' => 18,
			'J' => 19,
			'K' => 20,
			'L' => 21,
			'M' => 22,
			'N' => 23,
			'O' => 24,
			'P' => 25,
			'Q' => 26,
			'R' => 27,
			'S' => 28,
			'T' => 29,
			'U' => 30,
			'V' => 31,
			'W' => 32,
			'X' => 33,
			'Y' => 34,
			'Z' => 35,
			' ' => 36,
			'$' => 37,
			'%' => 38,
			'*' => 39,
			'+' => 40,
			'-' => 41,
			'.' => 42,
			'/' => 43,
			':' => 44 
	);
	private static $n2a = array (
			null,
			0,
			1,
			25,
			2,
			50,
			26,
			198,
			3,
			223,
			51,
			238,
			27,
			104,
			199,
			75,
			4,
			100,
			224,
			14,
			52,
			141,
			239,
			129,
			28,
			193,
			105,
			248,
			200,
			8,
			76,
			113,
			5,
			138,
			101,
			47,
			225,
			36,
			15,
			33,
			53,
			147,
			142,
			218,
			240,
			18,
			130,
			69,
			29,
			181,
			194,
			125,
			106,
			39,
			249,
			185,
			201,
			154,
			9,
			120,
			77,
			228,
			114,
			166,
			6,
			191,
			139,
			98,
			102,
			221,
			48,
			253,
			226,
			152,
			37,
			179,
			16,
			145,
			34,
			136,
			54,
			208,
			148,
			206,
			143,
			150,
			219,
			189,
			241,
			210,
			19,
			92,
			131,
			56,
			70,
			64,
			30,
			66,
			182,
			163,
			195,
			72,
			126,
			110,
			107,
			58,
			40,
			84,
			250,
			133,
			186,
			61,
			202,
			94,
			155,
			159,
			10,
			21,
			121,
			43,
			78,
			212,
			229,
			172,
			115,
			243,
			167,
			87,
			7,
			112,
			192,
			247,
			140,
			128,
			99,
			13,
			103,
			74,
			222,
			237,
			49,
			197,
			254,
			24,
			227,
			165,
			153,
			119,
			38,
			184,
			180,
			124,
			17,
			68,
			146,
			217,
			35,
			32,
			137,
			46,
			55,
			63,
			209,
			91,
			149,
			188,
			207,
			205,
			144,
			135,
			151,
			178,
			220,
			252,
			190,
			97,
			242,
			86,
			211,
			171,
			20,
			42,
			93,
			158,
			132,
			60,
			57,
			83,
			71,
			109,
			65,
			162,
			31,
			45,
			67,
			216,
			183,
			123,
			164,
			118,
			196,
			23,
			73,
			236,
			127,
			12,
			111,
			246,
			108,
			161,
			59,
			82,
			41,
			157,
			85,
			170,
			251,
			96,
			134,
			177,
			187,
			204,
			62,
			90,
			203,
			89,
			95,
			176,
			156,
			169,
			160,
			81,
			11,
			245,
			22,
			235,
			122,
			117,
			44,
			215,
			79,
			174,
			213,
			233,
			230,
			231,
			173,
			232,
			116,
			214,
			244,
			234,
			168,
			80,
			88,
			175 
	);
	private static $a2n = array (
			1,
			2,
			4,
			8,
			16,
			32,
			64,
			128,
			29,
			58,
			116,
			232,
			205,
			135,
			19,
			38,
			76,
			152,
			45,
			90,
			180,
			117,
			234,
			201,
			143,
			3,
			6,
			12,
			24,
			48,
			96,
			192,
			157,
			39,
			78,
			156,
			37,
			74,
			148,
			53,
			106,
			212,
			181,
			119,
			238,
			193,
			159,
			35,
			70,
			140,
			5,
			10,
			20,
			40,
			80,
			160,
			93,
			186,
			105,
			210,
			185,
			111,
			222,
			161,
			95,
			190,
			97,
			194,
			153,
			47,
			94,
			188,
			101,
			202,
			137,
			15,
			30,
			60,
			120,
			240,
			253,
			231,
			211,
			187,
			107,
			214,
			177,
			127,
			254,
			225,
			223,
			163,
			91,
			182,
			113,
			226,
			217,
			175,
			67,
			134,
			17,
			34,
			68,
			136,
			13,
			26,
			52,
			104,
			208,
			189,
			103,
			206,
			129,
			31,
			62,
			124,
			248,
			237,
			199,
			147,
			59,
			118,
			236,
			197,
			151,
			51,
			102,
			204,
			133,
			23,
			46,
			92,
			184,
			109,
			218,
			169,
			79,
			158,
			33,
			66,
			132,
			21,
			42,
			84,
			168,
			77,
			154,
			41,
			82,
			164,
			85,
			170,
			73,
			146,
			57,
			114,
			228,
			213,
			183,
			115,
			230,
			209,
			191,
			99,
			198,
			145,
			63,
			126,
			252,
			229,
			215,
			179,
			123,
			246,
			241,
			255,
			227,
			219,
			171,
			75,
			150,
			49,
			98,
			196,
			149,
			55,
			110,
			220,
			165,
			87,
			174,
			65,
			130,
			25,
			50,
			100,
			200,
			141,
			7,
			14,
			28,
			56,
			112,
			224,
			221,
			167,
			83,
			166,
			81,
			162,
			89,
			178,
			121,
			242,
			249,
			239,
			195,
			155,
			43,
			86,
			172,
			69,
			138,
			9,
			18,
			36,
			72,
			144,
			61,
			122,
			244,
			245,
			247,
			243,
			251,
			235,
			203,
			139,
			11,
			22,
			44,
			88,
			176,
			125,
			250,
			233,
			207,
			131,
			27,
			54,
			108,
			216,
			173,
			71,
			142,
			1 
	);
}
// Usage: $a=new QR('234DSKJFH23YDFKJHaS');$a->image(4);
?>
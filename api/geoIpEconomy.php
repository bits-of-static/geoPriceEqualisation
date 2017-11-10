<?php
declare(strict_types=1);
namespace ihde;

/*******************************************************************************************/
class GeoIpEconomy {
	
	public $isoCode;
	public $name;
	public $factor;
	public $percentual;
	
	public static $min;
	public static $max;
	
	/*---------------------------------------------------------------------*/
	public function __construct(string $isoCode = '-') {
		$this->isoCode = $isoCode;
		if (!\array_key_exists($this->isoCode, static::$data)) {
			$this->isoCode = '-';
		} //bottom
		
		$data = static::$data[$this->isoCode];
		
		$this->factor = $data['factor'];
		$this->name = $data['name'];
		$this->percentual = ($this->factor- static::$min)/ (static::$max- static::$min);
	} //routine
	
	/*---------------------------------------------------------------------*/
	public static function _static_initializer() {
		$listOfMulitplicators = \array_map(function($v) { return $v['factor']; }, static::$data);
		
		static::$min = \min($listOfMulitplicators);
		static::$max = \max($listOfMulitplicators);
	} //routine
	
	/*---------------------------------------------------------------------*/
	public static function toString($price) {
		$priceAsString = "". $price;
		
		$commaPos = \strpos($priceAsString, '.');
		if ($commaPos !== false) {
			$priceAsString = \substr($priceAsString.'0', 0, $commaPos+3);
		} else {
			$priceAsString .= '.00';
		}
		
		return $priceAsString;
	} //routine
	
	/*---------------------------------------------------------------------*/
	public function adapt($price): float {
		$priceGeoAdjusted = \floor($price* $this->factor* 100)/ 100;
		return $priceGeoAdjusted;
	} //routine
	
	/*---------------------------------------------------------------------*/
	public function readapt(string $originIsoCode, $price): float {
		$normalizedPrice = $price/ static::$data[$originIsoCode]['factor'];
		return $this->price($normalizedPrice);
	} //routine
	
	/*---------------------------------------------------------------------*/
	public static $data = [
		"-" => [
			"name" => "generic Internet estimate",
			"factor" => 2.2874944976954388
		],
		"AF" => [
			"name" => "Afghanistan",
			"factor" => 0.41108317307703307
		],
		"AX" => [
			"name" => "Aland Islands",
			"factor" => 0.5787191888343521
		],
		"AL" => [
			"name" => "Albania",
			"factor" => 0.875670605486225
		],
		"DZ" => [
			"name" => "Algeria",
			"factor" => 0.6901073121751221
		],
		"AS" => [
			"name" => "American Samoa",
			"factor" => 0.5787191888343521
		],
		"AD" => [
			"name" => "Andorra",
			"factor" => 0.5787191888343521
		],
		"AO" => [
			"name" => "Angola",
			"factor" => 0.43400867774585966
		],
		"AI" => [
			"name" => "Anguilla",
			"factor" => 0.5787191888343521
		],
		"AQ" => [
			"name" => "Antarctica",
			"factor" => 0.5787191888343521
		],
		"AG" => [
			"name" => "Antigua and Barbuda",
			"factor" => 0.5787191888343521
		],
		"AR" => [
			"name" => "Argentina",
			"factor" => 1.0470004853648625
		],
		"AM" => [
			"name" => "Armenia",
			"factor" => 0.8376429088712678
		],
		"AW" => [
			"name" => "Aruba",
			"factor" => 0.5787191888343521
		],
		"AU" => [
			"name" => "Australia",
			"factor" => 3.4422460256509377
		],
		"AT" => [
			"name" => "Austria",
			"factor" => 2.6522961527462847
		],
		"AZ" => [
			"name" => "Azerbaijan",
			"factor" => 0.805129887235561
		],
		"BS" => [
			"name" => "Bahamas",
			"factor" => 1.324259636648402
		],
		"BH" => [
			"name" => "Bahrain",
			"factor" => 1.1757184230541426
		],
		"BD" => [
			"name" => "Bangladesh",
			"factor" => 0.5875752187464696
		],
		"BB" => [
			"name" => "Barbados",
			"factor" => 0.9305747856109461
		],
		"BY" => [
			"name" => "Belarus",
			"factor" => 0.8686847197028368
		],
		"BE" => [
			"name" => "Belgium",
			"factor" => 2.1830181068688725
		],
		"BZ" => [
			"name" => "Belize",
			"factor" => 1.1732710266246558
		],
		"BJ" => [
			"name" => "Benin",
			"factor" => 0.49164571118707523
		],
		"BM" => [
			"name" => "Bermuda",
			"factor" => 0.5787191888343521
		],
		"BT" => [
			"name" => "Bhutan",
			"factor" => 0.5867173584605383
		],
		"BO" => [
			"name" => "Bolivia",
			"factor" => 0.6887638192029624
		],
		"BA" => [
			"name" => "Bosnia and Herzegovina",
			"factor" => 0.9775967530551721
		],
		"BW" => [
			"name" => "Botswana",
			"factor" => 0.7013896241947858
		],
		"BV" => [
			"name" => "Bouvet Island",
			"factor" => 0.5787191888343521
		],
		"BR" => [
			"name" => "Brazil",
			"factor" => 0.804384765749254
		],
		"IO" => [
			"name" => "British Indian Ocean Territory",
			"factor" => 0.5787191888343521
		],
		"BN" => [
			"name" => "Brunei Darussalam",
			"factor" => 1.2011183407641963
		],
		"BG" => [
			"name" => "Bulgaria",
			"factor" => 1.0285741355998368
		],
		"BF" => [
			"name" => "Burkina Faso",
			"factor" => 0.45620426611000636
		],
		"BI" => [
			"name" => "Burundi",
			"factor" => 0.385464555238281
		],
		"KH" => [
			"name" => "Cambodia",
			"factor" => 0.5068914814182656
		],
		"CM" => [
			"name" => "Cameroon",
			"factor" => 0.47732573301753595
		],
		"CA" => [
			"name" => "Canada",
			"factor" => 3.1560693653709992
		],
		"CV" => [
			"name" => "Cape Verde",
			"factor" => 0.6772300776791429
		],
		"KY" => [
			"name" => "Cayman Islands",
			"factor" => 0.5787191888343521
		],
		"CF" => [
			"name" => "Central African Republic",
			"factor" => 0.3799916162122076
		],
		"TD" => [
			"name" => "Chad",
			"factor" => 0.39385297440595624
		],
		"CL" => [
			"name" => "Chile",
			"factor" => 1.3850001657809181
		],
		"CN" => [
			"name" => "China",
			"factor" => 0.8233674528423935
		],
		"CX" => [
			"name" => "Christmas Island",
			"factor" => 0.5787191888343521
		],
		"CC" => [
			"name" => "Cocos (Keeling) Islands",
			"factor" => 0.5787191888343521
		],
		"CO" => [
			"name" => "Colombia",
			"factor" => 0.8375669640681432
		],
		"KM" => [
			"name" => "Comoros",
			"factor" => 0.6169772116365686
		],
		"cg" => [
			"name" => "Congo",
			"factor" => 0.4752081816033289
		],
		"CD" => [
			"name" => "Congo, Democratic Republic of the",
			"factor" => 0.3721246332567389
		],
		"CK" => [
			"name" => "Cook Islands",
			"factor" => 0.5787191888343521
		],
		"CR" => [
			"name" => "Costa Rica",
			"factor" => 1.0146825825635006
		],
		"CI" => [
			"name" => "Cote D'ivoire",
			"factor" => 0.4712249552267081
		],
		"HR" => [
			"name" => "Croatia (Hrvatska)",
			"factor" => 0.98126419732609
		],
		"CU" => [
			"name" => "Cuba",
			"factor" => 0.49682652584759596
		],
		"CY" => [
			"name" => "Cyprus",
			"factor" => 1.6369448407602207
		],
		"CZ" => [
			"name" => "Czech Republic",
			"factor" => 1.7578376152886706
		],
		"DK" => [
			"name" => "Denmark",
			"factor" => 2.9269319660457103
		],
		"DJ" => [
			"name" => "Djibouti",
			"factor" => 0.48254147518445056
		],
		"DM" => [
			"name" => "Dominica",
			"factor" => 0.70598919017166
		],
		"DO" => [
			"name" => "Dominican Republic",
			"factor" => 0.7234355709907918
		],
		"EC" => [
			"name" => "Ecuador",
			"factor" => 0.6365838389645633
		],
		"EG" => [
			"name" => "Egypt",
			"factor" => 0.6298556964877943
		],
		"SV" => [
			"name" => "El Salvador",
			"factor" => 0.6837676191697822
		],
		"GQ" => [
			"name" => "Equatorial Guinea",
			"factor" => 0.5512589610579273
		],
		"ER" => [
			"name" => "Eritrea",
			"factor" => 0.5433562985002274
		],
		"EE" => [
			"name" => "Estonia",
			"factor" => 1.4265110929464957
		],
		"ET" => [
			"name" => "Ethiopia",
			"factor" => 0.41255556356384676
		],
		"FK" => [
			"name" => "Falkland Islands (Malvinas)",
			"factor" => 0.5787191888343521
		],
		"FO" => [
			"name" => "Faroe Islands",
			"factor" => 0.5787191888343521
		],
		"FJ" => [
			"name" => "Fiji",
			"factor" => 0.7856114597242401
		],
		"FI" => [
			"name" => "Finland",
			"factor" => 2.759383397890336
		],
		"FR" => [
			"name" => "France",
			"factor" => 2.208171011813052
		],
		"GF" => [
			"name" => "French Guiana",
			"factor" => 0.5787191888343521
		],
		"PF" => [
			"name" => "French Polynesia",
			"factor" => 0.5787191888343521
		],
		"TF" => [
			"name" => "French Southern Territories",
			"factor" => 0.5787191888343521
		],
		"GA" => [
			"name" => "Gabon",
			"factor" => 0.8091159853000527
		],
		"GM" => [
			"name" => "Gambia",
			"factor" => 0.6498970521507774
		],
		"GE" => [
			"name" => "Georgia",
			"factor" => 0.8556229560397357
		],
		"DE" => [
			"name" => "Germany",
			"factor" => 3.30854402803109
		],
		"GH" => [
			"name" => "Ghana",
			"factor" => 0.5083453790504893
		],
		"GI" => [
			"name" => "Gibraltar",
			"factor" => 1.004373362577138
		],
		"GR" => [
			"name" => "Greece",
			"factor" => 1.1156170810733916
		],
		"GL" => [
			"name" => "Greenland",
			"factor" => 0.772710179827004
		],
		"GD" => [
			"name" => "Grenada",
			"factor" => 0.5787191888343521
		],
		"GP" => [
			"name" => "Guadeloupe",
			"factor" => 0.5787191888343521
		],
		"GU" => [
			"name" => "Guam",
			"factor" => 0.8461239795850393
		],
		"GT" => [
			"name" => "Guatemala",
			"factor" => 0.6895306225331321
		],
		"GN" => [
			"name" => "Guinea",
			"factor" => 0.42379535852620287
		],
		"GW" => [
			"name" => "Guinea-Bissau",
			"factor" => 0.4213004368374968
		],
		"GY" => [
			"name" => "Guyana",
			"factor" => 0.6181151660953215
		],
		"HT" => [
			"name" => "Haiti",
			"factor" => 0.44294216539520975
		],
		"HM" => [
			"name" => "Heard Island and McDonald Islands",
			"factor" => 0.5787191888343521
		],
		"HN" => [
			"name" => "Honduras",
			"factor" => 0.7771355335522105
		],
		"HK" => [
			"name" => "Hong Kong",
			"factor" => 1.6643081606228378
		],
		"HU" => [
			"name" => "Hungary",
			"factor" => 1.2172536955278828
		],
		"IS" => [
			"name" => "Iceland",
			"factor" => 1.849843902637014
		],
		"IN" => [
			"name" => "India",
			"factor" => 0.893444251156303
		],
		"ID" => [
			"name" => "Indonesia",
			"factor" => 0.6790220484277298
		],
		"IR" => [
			"name" => "Iran, Islamic Republic of",
			"factor" => 0.5724650791577387
		],
		"IQ" => [
			"name" => "Iraq",
			"factor" => 0.6707177601714488
		],
		"IE" => [
			"name" => "Ireland",
			"factor" => 2.701800119251332
		],
		"IL" => [
			"name" => "Israel",
			"factor" => 1.9880115841694626
		],
		"IT" => [
			"name" => "Italy",
			"factor" => 1.7501380830698179
		],
		"JM" => [
			"name" => "Jamaica",
			"factor" => 1.0229631112577589
		],
		"JP" => [
			"name" => "Japan",
			"factor" => 2.592091520387652
		],
		"JO" => [
			"name" => "Jordan",
			"factor" => 0.9429342116876177
		],
		"KZ" => [
			"name" => "Kazakhstan",
			"factor" => 0.9785925656851687
		],
		"KE" => [
			"name" => "Kenya",
			"factor" => 0.5468241865565616
		],
		"KI" => [
			"name" => "Kiribati",
			"factor" => 0.4967646619148012
		],
		"KP" => [
			"name" => "Korea, Democratic People",
			"factor" => 0.37834911973475394
		],
		"KR" => [
			"name" => "Korea, Republic of (South)",
			"factor" => 1.9838776173350583
		],
		"KW" => [
			"name" => "Kuwait",
			"factor" => 1.5403920621265381
		],
		"KG" => [
			"name" => "Kyrgyzstan",
			"factor" => 0.6511895630049449
		],
		"LA" => [
			"name" => "Lao People",
			"factor" => 0.6009051660873296
		],
		"LV" => [
			"name" => "Latvia",
			"factor" => 1.1490992702095582
		],
		"LB" => [
			"name" => "Lebanon",
			"factor" => 0.940151577377187
		],
		"LS" => [
			"name" => "Lesotho",
			"factor" => 0.4510903115122103
		],
		"LR" => [
			"name" => "Liberia",
			"factor" => 0.4423451287511311
		],
		"LY" => [
			"name" => "Libya",
			"factor" => 0.7421704362337079
		],
		"LI" => [
			"name" => "Liechtenstein",
			"factor" => 3.6991069169061115
		],
		"LT" => [
			"name" => "Lithuania",
			"factor" => 1.2770921716079875
		],
		"LU" => [
			"name" => "Luxembourg",
			"factor" => 3.3647825235960536
		],
		"MO" => [
			"name" => "Macao",
			"factor" => 0.7351174461149901
		],
		"MK" => [
			"name" => "Macedonia, the Former Yugoslav Republic of",
			"factor" => 0.9093888978675593
		],
		"MG" => [
			"name" => "Madagascar",
			"factor" => 0.5279047299596623
		],
		"MW" => [
			"name" => "Malawi",
			"factor" => 0.45642517355503015
		],
		"MY" => [
			"name" => "Malaysia",
			"factor" => 1.3496375456875744
		],
		"MV" => [
			"name" => "Maldives",
			"factor" => 0.6049973950668708
		],
		"ML" => [
			"name" => "Mali",
			"factor" => 0.643051662836332
		],
		"MT" => [
			"name" => "Malta",
			"factor" => 1.6958140254580423
		],
		"MH" => [
			"name" => "Marshall Islands",
			"factor" => 0.5787191888343521
		],
		"MQ" => [
			"name" => "Martinique",
			"factor" => 0.5787191888343521
		],
		"MR" => [
			"name" => "Mauritania",
			"factor" => 0.4686028982593003
		],
		"MU" => [
			"name" => "Mauritius",
			"factor" => 1.5195459281038848
		],
		"YT" => [
			"name" => "Mayotte",
			"factor" => 0.5787191888343521
		],
		"MX" => [
			"name" => "Mexico",
			"factor" => 1.1457402680214548
		],
		"FM" => [
			"name" => "Micronesia",
			"factor" => 0.6023064710682382
		],
		"MD" => [
			"name" => "Moldova",
			"factor" => 0.6752953720110663
		],
		"MC" => [
			"name" => "Monaco",
			"factor" => 0.8356013606118782
		],
		"MN" => [
			"name" => "Mongolia",
			"factor" => 0.7385177659651799
		],
		"ME" => [
			"name" => "Montenegro",
			"factor" => 1.0731236548711982
		],
		"MS" => [
			"name" => "Montserrat",
			"factor" => 0.5787191888343521
		],
		"MA" => [
			"name" => "Morocco",
			"factor" => 0.657984169431862
		],
		"MZ" => [
			"name" => "Mozambique",
			"factor" => 0.5013294249000703
		],
		"MM" => [
			"name" => "Myanmar",
			"factor" => 0.5549634600046571
		],
		"NA" => [
			"name" => "Namibia",
			"factor" => 0.631746639666467
		],
		"NR" => [
			"name" => "Nauru",
			"factor" => 0.5787191888343521
		],
		"NP" => [
			"name" => "Nepal",
			"factor" => 0.48937987749133466
		],
		"NL" => [
			"name" => "Netherlands",
			"factor" => 2.8647110502019224
		],
		"AN" => [
			"name" => "Netherlands Antilles",
			"factor" => 0.5787191888343521
		],
		"NT" => [
			"name" => "Neutral Zone",
			"factor" => 0.5787191888343521
		],
		"NC" => [
			"name" => "New Caledonia",
			"factor" => 0.7764622923801202
		],
		"NZ" => [
			"name" => "New Zealand",
			"factor" => 1.840331895007089
		],
		"NI" => [
			"name" => "Nicaragua",
			"factor" => 0.6461200557370129
		],
		"NE" => [
			"name" => "Niger",
			"factor" => 0.42614701917117465
		],
		"NG" => [
			"name" => "Nigeria",
			"factor" => 0.5612775038188185
		],
		"NU" => [
			"name" => "Niue",
			"factor" => 0.5787191888343521
		],
		"NF" => [
			"name" => "Norfolk Island",
			"factor" => 0.5787191888343521
		],
		"MP" => [
			"name" => "Northern Mariana Islands",
			"factor" => 0.5787191888343521
		],
		"NO" => [
			"name" => "Norway",
			"factor" => 2.7594327096701834
		],
		"OM" => [
			"name" => "Oman",
			"factor" => 2.0961957807777396
		],
		"PK" => [
			"name" => "Pakistan",
			"factor" => 0.5769944572090323
		],
		"PW" => [
			"name" => "Palau",
			"factor" => 0.5787191888343521
		],
		"PS" => [
			"name" => "Palestine, State of",
			"factor" => 0.7095307760405055
		],
		"PA" => [
			"name" => "Panama",
			"factor" => 0.9396993873609567
		],
		"PG" => [
			"name" => "Papua New Guinea",
			"factor" => 0.5647263268695385
		],
		"PY" => [
			"name" => "Paraguay",
			"factor" => 0.6451370286313862
		],
		"PE" => [
			"name" => "Peru",
			"factor" => 0.8131936871343497
		],
		"PH" => [
			"name" => "Philippines",
			"factor" => 0.757285569986105
		],
		"PN" => [
			"name" => "Pitcairn",
			"factor" => 0.5787191888343521
		],
		"PL" => [
			"name" => "Poland",
			"factor" => 1.4800647278798278
		],
		"PT" => [
			"name" => "Portugal",
			"factor" => 1.3378383655690713
		],
		"PR" => [
			"name" => "Puerto Rico",
			"factor" => 1.2930491645341544
		],
		"QA" => [
			"name" => "Qatar",
			"factor" => 2.4550797332120937
		],
		"RE" => [
			"name" => "Reunion",
			"factor" => 0.5787191888343521
		],
		"RO" => [
			"name" => "Romania",
			"factor" => 1.0372606544133312
		],
		"RU" => [
			"name" => "Russian Federation",
			"factor" => 0.8760137301311153
		],
		"RW" => [
			"name" => "Rwanda",
			"factor" => 0.5771295252302185
		],
		"SH" => [
			"name" => "Saint Helena, Ascension and Tristan da Cunha",
			"factor" => 0.5787191888343521
		],
		"KN" => [
			"name" => "Saint Kitts and Nevis",
			"factor" => 0.5787191888343521
		],
		"LC" => [
			"name" => "Saint Lucia",
			"factor" => 0.7344101424039005
		],
		"PM" => [
			"name" => "Saint Pierre and Miquelon",
			"factor" => 0.5787191888343521
		],
		"VC" => [
			"name" => "Saint Vincent and the Grenadines",
			"factor" => 0.7190204838886705
		],
		"WS" => [
			"name" => "Samoa",
			"factor" => 0.6780151107463598
		],
		"SM" => [
			"name" => "San Marino",
			"factor" => 0.5787191888343521
		],
		"ST" => [
			"name" => "Sao Tome and Principe",
			"factor" => 0.5103020493384252
		],
		"SA" => [
			"name" => "Saudi Arabia",
			"factor" => 2.0674399980390072
		],
		"SN" => [
			"name" => "Senegal",
			"factor" => 0.4960437163093914
		],
		"RS" => [
			"name" => "Serbia",
			"factor" => 0.9213365284456002
		],
		"CS" => [
			"name" => "Serbia and Montenegro",
			"factor" => 0.5787191888343521
		],
		"SC" => [
			"name" => "Seychelles",
			"factor" => 0.6143937164459568
		],
		"SY" => [
			"name" => "Syrian Arab Republic",
			"factor" => 0.616624474425586
		],
		"SL" => [
			"name" => "Sierra Leone",
			"factor" => 0.40430069878999053
		],
		"SG" => [
			"name" => "Singapore",
			"factor" => 1.5910116352990848
		],
		"SK" => [
			"name" => "Slovakia",
			"factor" => 1.3904288937943212
		],
		"SI" => [
			"name" => "Slovenia",
			"factor" => 1.5192360673346077
		],
		"SB" => [
			"name" => "Solomon Islands",
			"factor" => 0.47437712429569984
		],
		"SO" => [
			"name" => "Somalia",
			"factor" => 0.5787191888343521
		],
		"ZA" => [
			"name" => "South Africa",
			"factor" => 1.7639458676570268
		],
		"GS" => [
			"name" => "South Georgia and the South Sandwich Islands",
			"factor" => 0.5787191888343521
		],
		"ES" => [
			"name" => "Spain",
			"factor" => 1.800283559973291
		],
		"LK" => [
			"name" => "Sri Lanka",
			"factor" => 0.7912056752541048
		],
		"SD" => [
			"name" => "Sudan",
			"factor" => 0.5787191888343521
		],
		"SR" => [
			"name" => "Suriname",
			"factor" => 0.6195455454816563
		],
		"SJ" => [
			"name" => "Svalbard and Jan Mayen Islands",
			"factor" => 0.5787191888343521
		],
		"SZ" => [
			"name" => "Swaziland",
			"factor" => 0.6613050365358117
		],
		"SE" => [
			"name" => "Sweden",
			"factor" => 3.1537830403854965
		],
		"CH" => [
			"name" => "Switzerland",
			"factor" => 5.199708303077177
		],
		"TW" => [
			"name" => "Taiwan",
			"factor" => 1.428757475921405
		],
		"TJ" => [
			"name" => "Tajikistan",
			"factor" => 0.5636511063291527
		],
		"TZ" => [
			"name" => "Tanzania, United Republic of",
			"factor" => 0.6638368045727148
		],
		"TH" => [
			"name" => "Thailand",
			"factor" => 0.8355882025764227
		],
		"TL" => [
			"name" => "Timor-Leste",
			"factor" => 0.5010717285756935
		],
		"TG" => [
			"name" => "Togo",
			"factor" => 0.46840755407709056
		],
		"TK" => [
			"name" => "Tokelau",
			"factor" => 0.5787191888343521
		],
		"TO" => [
			"name" => "Tonga",
			"factor" => 0.661256135889726
		],
		"TT" => [
			"name" => "Trinidad and Tobago",
			"factor" => 1.0141953097402774
		],
		"TN" => [
			"name" => "Tunisia",
			"factor" => 0.757469206465732
		],
		"TR" => [
			"name" => "Turkey",
			"factor" => 1.1283941167139826
		],
		"TM" => [
			"name" => "Turkmenistan",
			"factor" => 0.5734657610976991
		],
		"TC" => [
			"name" => "Turks and Caicos Islandss",
			"factor" => 0.5787191888343521
		],
		"TV" => [
			"name" => "Tuvalu",
			"factor" => 0.5787191888343521
		],
		"UG" => [
			"name" => "Uganda",
			"factor" => 0.49297881561044155
		],
		"UA" => [
			"name" => "Ukraine",
			"factor" => 0.7337646535456175
		],
		"AE" => [
			"name" => "United Arab Emirates",
			"factor" => 2.1141694763692818
		],
		"GB" => [
			"name" => "United Kingdom of Great Britain and Northern Ireland",
			"factor" => 2.658627740289611
		],
		"US" => [
			"name" => "United States of America",
			"factor" => 3.7750028128368722
		],
		"UY" => [
			"name" => "Uruguay",
			"factor" => 1.0586179547613108
		],
		"UZ" => [
			"name" => "Uzbekistan",
			"factor" => 0.5983774403847272
		],
		"VU" => [
			"name" => "Vanuatu",
			"factor" => 0.6728137568938634
		],
		"VA" => [
			"name" => "Vatican City State",
			"factor" => 3.917924649919199
		],
		"VE" => [
			"name" => "Venezuela",
			"factor" => 0.5025326843373897
		],
		"VN" => [
			"name" => "Viet Nam",
			"factor" => 0.6111575019795591
		],
		"VG" => [
			"name" => "Virgin Islands, British",
			"factor" => 0.5787191888343521
		],
		"VI" => [
			"name" => "Virgin Islands, U.S.",
			"factor" => 0.5787191888343521
		],
		"WF" => [
			"name" => "Wallis and Futuna",
			"factor" => 0.5787191888343521
		],
		"EH" => [
			"name" => "Western Sahara",
			"factor" => 0.5787191888343521
		],
		"YE" => [
			"name" => "Yemen",
			"factor" => 0.4748890899822432
		],
		"ZM" => [
			"name" => "Zambia",
			"factor" => 0.5250591100134374
		],
		"ZW" => [
			"name" => "Zimbabwe",
			"factor" => 0.45798339000349375
		]
	];
} //class

\ihde\GeoIpEconomy::_static_initializer();

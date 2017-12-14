<?php
class Day03_1 {
	private $input;
	private $distance;
	
	public function __construct($input) {
		$this->input = $input;
		
		$this->distance = 0;
	}
	
	/**
	 * The calculation is made by two components x and y
	 * One is the number of the ring that hold the value minus 1
	 * The second is the side distance to the center
	 */
	public function run() {
		
		if($this->input == 1) {
			$this->distance = 0;
			return;
		}
	
		$ringInfo = $this->getRingNumber();
	
		$sideLowLimit = $ringInfo['lowerLimit'];
		for($i = $ringInfo['lowerLimit']; $i<= $this->input; $i+=($ringInfo['multiplier']+1)) {
			$sideLowLimit = $i;
		}
		
		$sideDistance = ($ringInfo['ring'] - 2 ) * (-1);
		
		for($i = $sideLowLimit; $i < $this->input; $i++) {
			$sideDistance += 1;
		}
		
		$this->distance = $ringInfo['ring'] - 1 + abs($sideDistance);
	}

	public function getDistance() {
		return $this->distance;
	}
	
	private function getRingNumber() {

		$i = 1;
		$ringLowerLimit = 2;
		$ringUpperLimit = 1;
		for($i = 1; ; $i +=2) {
			$ringUpperLimit += 4 * $i + 4;
			if($this->input <= $ringUpperLimit) {
				break;
			}
			$ringLowerLimit = $ringUpperLimit+1;

		}
		
		return [
			'ring' => ($i+1)/2 + 1,
			'multiplier' => $i,
			'lowerLimit' => $ringLowerLimit,
			'upperLimit' => $ringUpperLimit,
		];
	}
	
}

$inputs = [
	'1',
	'12',
	'23',
	'1024',
	'347991',
];

foreach($inputs as $input) {
	$day = new Day03_1($input);
	$day->run();
	echo "The input is: ". $input . "\n";
	echo "The distance is: " . $day->getDistance() . "\n";
}

<?php
class Day03_1_1 {
	private $input;
	private $distance;
	private $matrix;
	private $centerOffset;
	
	const ARRAY_SIDE = 1001;
	
	public function __construct($input) {
		
		for($i = 0; $i < self::ARRAY_SIDE; $i++) {
			$this->matrix[] = array_fill(0, self::ARRAY_SIDE, 0);
		}
		
		$this->input = $input;
		
		$this->distance = 0;
		$this->centerOffset = (int) (self::ARRAY_SIDE/2);
	}
	
	/**
	 * The calculation is made by two components x and y
	 * One is the number of the ring that hold the value minus 1
	 * The second is the side distance to the center
	 */
	public function run() {
		$x = $this->centerOffset;
		$y = $this->centerOffset;
		$value = 1;
		
		$this->matrix[$y][$x] = $value;
			
		$ring = 1;
		
		do{
			$x++;
			$ring++;
			$ringInfo = $this->getRingInfo($ring);
			
			$side = 0;
			for($i = $ringInfo['lowerLimit']; $i<= $ringInfo['upperLimit']; $i+=($ringInfo['multiplier']+1)) {
				for($j = ($side==0?1:0); $j <= $ringInfo['multiplier']; $j++) {
					$value++;
					$this->matrix[$y][$x] = $value;
					if($value == $this->input) {
						$this->distance = abs($y - $this->centerOffset) + abs($x - $this->centerOffset);
					}
					
					switch($side) {
						//right side
						case 0: $y+=1; break;
						//top side
						case 1: $x-=1; break;
						//left side
						case 2: $y-=1; break;
						//bottom side
						case 3: $x+=1; break;
					}
					
					
					
				}
				$side++;
				
			}
			$value++;
			$this->matrix[$y][$x] = $value;
			if($value == $this->input) {
				$this->distance = abs($y - $this->centerOffset) + abs($x - $this->centerOffset);
			}
			
		}while($value < $this->input);
	}

	public function getDistance() {
		return $this->distance;
	}
	
	private function getRingInfo($ring) {
		$ringLowerLimit = 2;
		$ringUpperLimit = 1;
		for($multiplier = 1; ; $multiplier +=2) {
			$ringTmp = ($multiplier+1)/2 + 1;
			$ringUpperLimit += 4 * $multiplier + 4;
			if($ringTmp == $ring) {
				break;
			}
			$ringLowerLimit = $ringUpperLimit+1;
		}
		
		return [
			'ring' => $ring,
			'multiplier' => $multiplier,
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
	$day = new Day03_1_1($input);
	$day->run();
	echo "The input is: ". $input . "\n";
	echo "The distance is: " . $day->getDistance() . "\n";
}

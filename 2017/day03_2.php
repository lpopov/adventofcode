<?php
class Day03_2 {
	private $input;
	private $result;
	private $matrix;
	private $centerOffset;
	
	const ARRAY_SIDE = 1001;
	
	public function __construct($input) {
		
		for($i = 0; $i < self::ARRAY_SIDE; $i++) {
			$this->matrix[] = array_fill(0, self::ARRAY_SIDE, 0);
		}
		
		$this->input = $input;
		
		$this->result = 0;
		$this->centerOffset = (int) (self::ARRAY_SIDE/2);
	}
	
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
					$value = $this->calculateValue($x, $y);
					$this->matrix[$y][$x] = $value;
					if($value > $this->input) {
						$this->result = $value;
						break;
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
			
			if($this->result) {
				break;
			}
			$value = $this->calculateValue($x, $y);
			$this->matrix[$y][$x] = $value;
			if($value > $this->input) {
				$this->result = $value;
			}
		
		}while($value < $this->input);
	}
	
	private function calculateValue($x, $y) {
		$value = 0;
		$value += $this->matrix[$y-1][$x-1];
		$value += $this->matrix[$y-1][$x];
		$value += $this->matrix[$y-1][$x+1];
		$value += $this->matrix[$y][$x-1];
		$value += $this->matrix[$y][$x+1];
		$value += $this->matrix[$y+1][$x-1];
		$value += $this->matrix[$y+1][$x];
		$value += $this->matrix[$y+1][$x+1];
		
		return $value;
	}

	public function getNextBiggerNumber() {
//		for($i = sizeof($this->matrix)-1; $i>=0;$i--) {
//			echo implode("\t", $this->matrix[$i]) . "\n";
//		}
		return $this->result;
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
	'746',
	'347991',
];

foreach($inputs as $input) {
	$day = new Day03_2($input);
	$day->run();
	echo "The input is: ". $input . "\n";
	echo "The next bigger number is: " . $day->getNextBiggerNumber() . "\n";
}

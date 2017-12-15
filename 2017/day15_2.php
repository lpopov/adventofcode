<?php
class Day15_2 {
	private $a;
	private $b;
	
	private $factorA;
	private $factorB;
	
	private $modulus;
	
	private $modulusA;
	private $modulusB;
	
	private $matches;
	
	public function __construct($input) {
		$tmpArr = explode("\n", $input);
		$this->a = explode(" starts with ", $tmpArr[0])[1];
		$this->b = explode(" starts with ", $tmpArr[1])[1];
		
		
		$this->factorA = 16807;
		$this->factorB = 48271;
		
		$this->modulus = 2147483647;
		
		$this->modulusA = 4;
		$this->modulusB = 8;
		
		$this->matches = 0;
	}
	
	public function run() {
		for($i = 0; $i < 5000000; $i++){
			$this->a = $this->calculateValue($this->a, $this->factorA, $this->modulusA);
			$this->b = $this->calculateValue($this->b, $this->factorB, $this->modulusB);
			
			$lowestBitsA = $this->getLowest16Bits($this->a);
			$lowestBitsB = $this->getLowest16Bits($this->b);
			
			if($lowestBitsA == $lowestBitsB) {
				$this->matches++;
			}
		}
	}
	
	private function calculateValue($value, $factor, $valueModulus) {
		do {
			$value = ($value * $factor ) % $this->modulus;
		}while($value % $valueModulus !== 0);
		
		return $value;
	}
	
	private function getLowest16Bits($value) {
		$lowestBits = $value & ((1<<16)-1);
		
		return $lowestBits;
	}
	
	public function getMatches() {
		return $this->matches;
	}
}

$inputs = [
//	"Generator A starts with 65
//Generator B starts with 8921",
	"Generator A starts with 679
Generator B starts with 771"
];

foreach($inputs as $input) {
	$day = new Day15_2($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Matches: " . $day->getMatches() . "\n";
	echo "-----------\n";
}
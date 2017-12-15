<?php
class Day15_1 {
	private $a;
	private $b;
	
	private $factorA;
	private $factorB;
	
	private $modulus;
	
	private $matches;
	
	public function __construct($input) {
		$tmpArr = explode("\n", $input);
		$this->a = explode(" starts with ", $tmpArr[0])[1];
		$this->b = explode(" starts with ", $tmpArr[1])[1];
		
		
		$this->factorA = 16807;
		$this->factorB = 48271;
		
		$this->modulus = 2147483647;
		
		$this->matches = 0;
	}
	
	public function run() {
		for($i = 0; $i < 40000000; $i++){
			$this->a = $this->calculateValue($this->a, $this->factorA);
			$this->b = $this->calculateValue($this->b, $this->factorB);
			
			if((($this->a ^ $this->b) & 65535 )=== 0) {
				$this->matches++;
			}
		}
	}
	
	private function calculateValue($value, $factor) {
		return ($value * $factor ) % $this->modulus;
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
	$day = new Day15_1($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Matches: " . $day->getMatches() . "\n";
	echo "-----------\n";
}
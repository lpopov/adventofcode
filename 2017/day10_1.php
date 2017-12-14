<?php
class Day10_1 {
	private $inputArr;
	
	private $list;
	private $listSize;
	private $result;
	public function __construct($input, $listSize) {
		$this->inputArr = explode(',', $input);
		
		$this->list = array_keys(array_fill(0, $listSize, 1));
		$this->listSize = $listSize;
		$this->result = 0;
	}
	
	public function run() {
		$currentPosition = 0;
		$step = 0;
		foreach($this->inputArr as $length) {
			for($i=0; $i < floor($length/2); $i++) {
				$tmpChar = $this->list[($currentPosition + $i) % $this->listSize];
				$this->list[($currentPosition + $i) % $this->listSize] = $this->list[($currentPosition + $length - $i - 1) % $this->listSize];
				$this->list[($currentPosition + $length - $i - 1) % $this->listSize] = $tmpChar;
			}
			
			$currentPosition = ($currentPosition + $length + $step) % $this->listSize;
			$step += 1;
		}
		
		$this->result = $this->list[0] * $this->list[1];
	}
	
	public function getResult() {
		return $this->result;
	}
}	

$inputs = [
	5 => '3,4,1,5',
	256 => '83,0,193,1,254,237,187,40,88,27,2,255,149,29,42,100',
];

foreach($inputs as $listSize => $input) {
	$day = new Day10_1($input, $listSize);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Result is: " . $day->getResult() . "\n";
}

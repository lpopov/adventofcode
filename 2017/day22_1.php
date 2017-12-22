<?php
class Day22_1 {
	private $inputArr;
	
	private $currentPosition;
	private $facingDirection;
	private $iterations;
	private $infectedCount;
	
	const BUFFER_SIZE = 5000;
	
	public function __construct($input, $iterations) {
		$this->inputArr = [];
		
		$inputArr = explode("\n", $input);
		$size = sizeof($inputArr);
		$buffer = array_fill(0, self::BUFFER_SIZE, '.');
		foreach($inputArr as $index => $row) {
			$rowArr = str_split($row);
			$rowArr = array_merge($buffer, $rowArr, $buffer);
			$inputArr[$index] = $rowArr;
		}
		
		$buffer = array_fill(0, 2 * self::BUFFER_SIZE + $size, '.');
		for($i = 0;$i < self::BUFFER_SIZE; $i++) {
			$this->inputArr[] = $buffer;
		}
		
		$this->inputArr = array_merge($this->inputArr, $inputArr, $this->inputArr);
		
		$this->currentPosition = [
			'x'	=>	floor(sizeof($this->inputArr[0]) / 2),
			'y'	=>	floor(sizeof($this->inputArr) / 2),
		];
		$this->facingDirection = 'up';
		
		$this->iterations = $iterations;
		$this->infectedCount = 0;
	}
	
	public function run() {
		for($i = 0; $i < $this->iterations; $i++){
			if($this->isCurrentNodeInfected()) {
				$this->turnRight();
			} else {
				$this->turnLeft();
			}
			
			$this->changeState();
			$this->move();
		}
		
		
	}
	
	private function isCurrentNodeInfected() {
		return $this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] == '#';
	}
	
	private function turnRight() {
		switch($this->facingDirection) {
			case 'up':
				$this->facingDirection = 'right';
				break;
			case 'right':
				$this->facingDirection = 'down';
				break;
			case 'down':
				$this->facingDirection = 'left';
				break;
			case 'left':
				$this->facingDirection = 'up';
				break;
		}
	}
	
	private function turnLeft() {
		switch($this->facingDirection) {
			case 'up':
				$this->facingDirection = 'left';
				break;
			case 'left':
				$this->facingDirection = 'down';
				break;
			case 'down':
				$this->facingDirection = 'right';
				break;
			case 'right':
				$this->facingDirection = 'up';
				break;
		}
	}
	
	private function changeState() {
		if($this->isCurrentNodeInfected()) {
			$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = '.';
		} else {
			$this->infectedCount++;
			$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = '#';
		}
	}
	
	private function move() {
		switch($this->facingDirection) {
			case 'up':
				$this->currentPosition['y']--;
				break;
			case 'left':
				$this->currentPosition['x']--;
				break;
			case 'down':
				$this->currentPosition['y']++;
				break;
			case 'right':
				$this->currentPosition['x']++;
				break;
		}
	}

	public function getInfectedCount() {
//		$pixelCount = 0;
//		for($i = 0; $i < strlen($this->pattern); $i++) {
//			if($this->pattern[$i] == '#') {
//				$pixelCount++;
//			}
//		}
		
//		return $pixelCount;
		return $this->infectedCount;
	}
}

$input = 
"..#
#..
...";

$day = new Day22_1($input, 7);
$day->run();
echo "Infected nodes, 7 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";

$day = new Day22_1($input, 70);
$day->run();
echo "Infected nodes, 70 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";

$day = new Day22_1($input, 10000);
$day->run();
echo "Infected nodes, 10000 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";

$day = new Day22_1(file_get_contents("input.day22.txt"), 10000);
$day->run();
echo "Infected nodes(puzzle input), 10000 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";

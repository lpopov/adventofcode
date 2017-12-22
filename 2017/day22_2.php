<?php
class Day22_2 {
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
			$this->turn();
			$this->changeState();
			$this->move();
		}
		
		
	}
	
	private function turn() {
		switch($this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']]) {
			case '.':
				$this->turnLeft();
				break;
			case 'W':
				break;
			case '#':
				$this->turnRight();
				break;
			case 'F':
				$this->turnAround();
				break;
		}
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
	
	private function turnAround() {
		switch($this->facingDirection) {
			case 'up':
				$this->facingDirection = 'down';
				break;
			case 'left':
				$this->facingDirection = 'right';
				break;
			case 'down':
				$this->facingDirection = 'up';
				break;
			case 'right':
				$this->facingDirection = 'left';
				break;
		}
	}
	
	private function changeState() {
		switch($this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']]) {
			case '.':
				$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = 'W';
				break;
			case 'W':
				$this->infectedCount++;
				$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = '#';
				break;
			case '#':
				$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = 'F';
				break;
			case 'F':
				$this->inputArr[$this->currentPosition['y']][$this->currentPosition['x']] = '.';
				break;
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
		return $this->infectedCount;
	}
}

$input = 
"..#
#..
...";

$day = new Day22_2($input, 100);
$day->run();
echo "Infected nodes, 100 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";


//$day = new Day22_2($input, 10000000);
//$day->run();
//echo "Infected nodes, 10000000 iterations: " . $day->getInfectedCount() . "\n";
//echo "-------------\n";

$day = new Day22_2(file_get_contents("input.day22.txt"), 10000000);
$day->run();
echo "Infected nodes(puzzle input), 10000000 iterations: " . $day->getInfectedCount() . "\n";
echo "-------------\n";

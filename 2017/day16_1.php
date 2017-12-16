<?php
class Day16 {
	private $inputArr;
	private $movesArr;
	
	public function __construct($input, $moves) {
		$this->inputArr = str_split($input);
		$this->movesArr = explode(",", trim($moves));
	}
	
	public function run() {
		foreach($this->movesArr as $move) {
			
			switch($move[0]) {
				case "s":
					$spins = (int) substr($move, 1);
					for($i=0; $i<$spins;$i++) {
						$program = array_pop($this->inputArr);
						array_unshift($this->inputArr, $program);
					}
					break;
				case "x":
					$moveArr = $this->splitMove($move);
					$tmp = $this->inputArr[$moveArr[1]];
					$this->inputArr[$moveArr[1]] = $this->inputArr[$moveArr[2]];
					$this->inputArr[$moveArr[2]] = $tmp;
					break;
				case "p":
					$moveArr = $this->splitMove($move);
					$flippedArr = array_flip($this->inputArr);
					$tmp = $this->inputArr[$flippedArr[$moveArr[1]]];
					$this->inputArr[$flippedArr[$moveArr[1]]] = $this->inputArr[$flippedArr[$moveArr[2]]];
					$this->inputArr[$flippedArr[$moveArr[2]]] = $tmp;
					break;
			}
		}
	}
	
	private function splitMove($move) {
		$moveArr = [];
		$moveArr[0] = $move[0];
		
		$tmpArr = explode("/", substr($move, 1));
		$moveArr[1] = $tmpArr[0];
		$moveArr[2] = $tmpArr[1];
		return $moveArr;
	}
	
	public function getState() {
		return implode("", $this->inputArr);
	}
}

$inputs = [
	"abcde" => "s1,x3/4,pe/b",
];

foreach($inputs as $input => $moves) {
	$day = new Day16($input, $moves);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Programs state: " . $day->getState() . "\n";
}

$day = new Day16("abcdefghijklmnop", file_get_contents("input.day16.txt"));
$day->run();
echo "-------------\n";
echo "Programs state: " . $day->getState() . "\n";
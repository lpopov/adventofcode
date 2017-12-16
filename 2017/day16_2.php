<?php
class Day16_2 {
	private $inputArr;
	private $regularInput;
	private $movesArr;
	private $dances;
	private $steps;
	
	public function __construct($input, $moves) {
		$this->inputArr = str_split($input);
		$this->regularInput = $this->inputArr;
		$tmpArr = explode(",", trim($moves));
		
		foreach($tmpArr as $move) {
			$moveArr = [];
			
			switch($move[0]) {
				case "s":
					$moveArr[0] = $move[0];
					$moveArr[1] = (int) substr($move, 1);
					break;
				case "x":
					$moveArr = $this->splitMove($move);
					
					break;
				case "p":
					$moveArr = $this->splitMove($move);
					
					break;
			}
			
			$this->movesArr[] = $moveArr;
		}
		
		$this->dances = [];
		$this->steps = [];
	}
	
	public function run() {
		$i=0;
		do{
			$start = implode('', $this->inputArr);
			if(isset($this->dances[$start])) {
				$this->inputArr = $this->dances[$start];
			} else {
				$this->dance();
				$this->dances[$start] = $this->inputArr;
			}
			$this->steps[] = $this->inputArr;
		
			$i++;
		}while($this->inputArr !== $this->regularInput) ;
		
		$cycles = 1000000000 % $i;
		
		$this->inputArr = $this->steps[$cycles-1];
	}
	
	private function dance() {
		foreach($this->movesArr as $moveArr) {
			switch($moveArr[0]) {
				case "s":
					for($j=0; $j<$moveArr[1];$j++) {
						$program = array_pop($this->inputArr);
						array_unshift($this->inputArr, $program);
					}
					break;
				case "x":
					$tmp = $this->inputArr[$moveArr[1]];
					$this->inputArr[$moveArr[1]] = $this->inputArr[$moveArr[2]];
					$this->inputArr[$moveArr[2]] = $tmp;
					break;
				case "p":
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

//foreach($inputs as $input => $moves) {
//	$day = new Day16_2($input, $moves);
//	$day->run();
//	echo "Input: " . $input . "\n";
//	echo "Programs state: " . $day->getState() . "\n";
//}

$day = new Day16_2("abcdefghijklmnop", file_get_contents("input.day16.txt"));
$day->run();
echo "-------------\n";
echo "Programs state: " . $day->getState() . "\n";
<?php
class Day21 {
	private $inputArr;
	
	private $pattern;
	private $iterations;
	
	public function __construct($input, $iterations) {
		$inputArr = explode("\n", $input);
		$this->inputArr = [];
		foreach($inputArr as $row) {
			$rowArr = explode(' => ', $row);
			$this->inputArr[$rowArr[0]] = $rowArr[1];
		}
		
		$this->iterations = $iterations;
		$this->pattern = '.#./..#/###';
	}
	
	public function run() {
		$this->generateFlipRotateInput();
		
		for($i=0;$i<$this->iterations;$i++){
			$pattern = explode('/', $this->pattern);
			$resultPattern = [];
			$size = null;
			if((sizeof($pattern) % 2) == 0) {
				$size = 2;
			} else {
				$size = 3;
			}
			
			$count = sizeof($pattern) / $size;
			for($y=0;$y<$count;$y++) {
				for($x=0;$x<$count;$x++) {
					
					$resultPattern[$y][$x] = $this->convert($this->getPatternByCoordinates($y, $x, $size));
				}
			}
			
			$this->pattern = $this->flattenResultPattern($resultPattern);
		}
		
		
	}

	public function countPixels() {
		$pixelCount = 0;
		for($i = 0; $i < strlen($this->pattern); $i++) {
			if($this->pattern[$i] == '#') {
				$pixelCount++;
			}
		}
		
		return $pixelCount;
	}
	
	private function flattenResultPattern($resultPattern) {
		$count = sizeof($resultPattern);
		$result = '';
		$size = sizeof($resultPattern[0][0]);
		
		for($y=0;$y<$count;$y++) {
			if($y) {
				$result .= '/';
			}
			
			for($i=0;$i<$size;$i++) {
				if($i) {
					$result .= '/';
				}
				for($x=0;$x<$count;$x++) {
					$result .= $resultPattern[$y][$x][$i];
				}
			}
		}
		return $result;
	}
	
	private function getPatternByCoordinates($y, $x, $size) {
		$pattern = [];
		$patternArr = explode('/', $this->pattern);
		
		for($i = 0; $i < $size; $i++) {
			$pattern[$i] = substr($patternArr[$y * $size + $i], $x * $size, $size);
		}

		return $pattern;
	}
	
	private function convert($pattern) {
		$flatPattern = implode('/', $pattern);
		if(isset($this->inputArr[$flatPattern])) {
			$patternArr = explode('/', $this->inputArr[$flatPattern]);
			return $patternArr;
		}
		die('Pattern not found!');
	}
	
	private function generateFlipRotateInput() {
		foreach($this->inputArr as $key => $value) {
			$rotate1 = $this->rotate($key);
			$this->addIfMissing($rotate1, $value);
			$rotate2 = $this->rotate($rotate1);
			$this->addIfMissing($rotate2, $value);
			$rotate3 = $this->rotate($rotate2);
			$this->addIfMissing($rotate3, $value);
			
			$flip = $this->flip($key);
			$this->addIfMissing($flip, $value);
			$rotate1 = $this->rotate($flip);
			$this->addIfMissing($rotate1, $value);
			$rotate2 = $this->rotate($rotate1);
			$this->addIfMissing($rotate2, $value);
			$rotate3 = $this->rotate($rotate2);
			$this->addIfMissing($rotate3, $value);
		}
	}
	
	private function rotate($pattern) {
		$pattern = explode('/', $pattern);
		if(sizeof($pattern) == 2) {
			$tmp = $pattern[0][0];
			$pattern[0][0] = $pattern[1][0];
			$pattern[1][0] = $pattern[1][1];
			$pattern[1][1] = $pattern[0][1];
			$pattern[0][1] = $tmp;
		} else {
			$tmp = $pattern[0];
			$pattern[0][2] = $pattern[0][0];
			$pattern[0][1] = $pattern[1][0];
			$pattern[0][0] = $pattern[2][0];
			
			
			$pattern[0][0] = $pattern[2][0];
			$pattern[1][0] = $pattern[2][1];
			$pattern[2][0] = $pattern[2][2];
			
			$pattern[2][0] = $pattern[2][2];
			$pattern[2][1] = $pattern[1][2];
			$pattern[2][2] = $pattern[0][2];
			
			$pattern[2][2] = $tmp[2];
			$pattern[1][2] = $tmp[1];
			$pattern[0][2] = $tmp[0];
		}
		
		return implode('/', $pattern);
	}
	
	private function flip($pattern) {
		$pattern = explode('/', $pattern);
		if(sizeof($pattern) == 2) {
			$tmp = $pattern[0][0];
			$pattern[0][0] = $pattern[0][1];
			$pattern[0][1] = $tmp;
			
			$tmp = $pattern[1][0];
			$pattern[1][0] = $pattern[1][1];
			$pattern[1][1] = $tmp;
		} else {
			$tmp = $pattern[0][0];
			$pattern[0][0] = $pattern[0][2];
			$pattern[0][2] = $tmp;
			
			$tmp = $pattern[1][0];
			$pattern[1][0] = $pattern[1][2];
			$pattern[1][2] = $tmp;
			
			$tmp = $pattern[2][0];
			$pattern[2][0] = $pattern[2][2];
			$pattern[2][2] = $tmp;
		}
		
		return implode('/', $pattern);
	}
	
	private function addIfMissing($key, $value) {
		if(!isset($this->inputArr[$key])) {
			$this->inputArr[$key] = $value;
		}
	}
}

$input = 
"../.# => ##./#../...
.#./..#/### => #..#/..../..../#..#";

$day = new Day21($input, 2);
$day->run();
echo "On pixels, test data: " . $day->countPixels() . "\n";
echo "-------------\n";

$day = new Day21(file_get_contents("input.day21.txt"), 5);
$day->run();
echo "On pixels, 5 iterations: " . $day->countPixels() . "\n";
echo "-------------\n";

$day = new Day21(file_get_contents("input.day21.txt"), 18);
$day->run();
echo "On pixels, 18 iterations: " . $day->countPixels() . "\n";
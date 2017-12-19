<?php
class Day19 {
	private $diagramArr;
	private $lettersArr;
	
	private $x;
	private $y;
	
	private $sizeX;
	private $sizeY;
	
	private $direction;
	
	private $steps;
	
	public function __construct($input) {
		$this->diagramArr = explode("\n", $input);
		foreach($this->diagramArr as $line => $diagramRow) {
			$this->diagramArr[$line] = str_split($diagramRow);
		}
		
		$this->lettersArr = [];
		
		$this->sizeX = sizeof($this->diagramArr[0]);
		$this->sizeY = sizeof($this->diagramArr);
		
		$this->direction = 'down';
		
		$this->x = $this->findStart();
		$this->y = 0;
		
		$this->steps = 0;
	}
	
	public function run() {
		do {
			if($this->diagramArr[$this->y][$this->x] == '+') {
				$this->changeDirection();
			} elseif(!in_array($this->diagramArr[$this->y][$this->x], ['-', '|'])){
				$this->lettersArr[] = $this->diagramArr[$this->y][$this->x];
			}
			$this->move();
		} while($this->isInDiagram());
	}
	
	private function changeDirection() {
		if(in_array($this->direction, ['up', 'down'])) {
			if(isset($this->diagramArr[$this->y][$this->x - 1]) 
				&& !in_array($this->diagramArr[$this->y][$this->x - 1], ['|', ' '])) {
				$this->direction = 'left';
			} elseif(isset($this->diagramArr[$this->y][$this->x + 1]) 
				&& !in_array($this->diagramArr[$this->y][$this->x + 1], ['|', ' '])) {
				$this->direction = 'right';
			}
		} else {
			if(isset($this->diagramArr[$this->y - 1][$this->x]) 
				&& !in_array($this->diagramArr[$this->y - 1][$this->x], ['-', ' '])) {
				$this->direction = 'up';
			} elseif(isset($this->diagramArr[$this->y + 1][$this->x]) 
				&& !in_array($this->diagramArr[$this->y + 1][$this->x], ['-', ' '])) {
				$this->direction = 'down';
			}
		}
	}
			
	private function isInDiagram() {
		return $this->x >= 0 && $this->x < $this->sizeX 
				&& $this->y >= 0 && $this->y < $this->sizeY
				&& isset ($this->diagramArr[$this->y][$this->x])
				&& $this->diagramArr[$this->y][$this->x] !== ' ';
	}
	
	private function move() {
		switch ($this->direction) {
			case 'down':
				$this->y++;
				break;
			case 'up':
				$this->y--;
				break;
			case 'left':
				$this->x--;
				break;
			case 'right':
				$this->x++;
				break;
		}
		
		$this->steps++;
	}
	
	private function findStart() {
		for($i = 0; $i < sizeof($this->diagramArr[0]); $i++) {
			if($this->diagramArr[0][$i] == '|') {
				return $i;
			}
		}
		
		return null;
	}
	
	public function getLetters() {
		return implode('', $this->lettersArr);
	}
	
	public function getSteps() {
		return $this->steps;
	}
}

$input = 
"     |          
     |  +--+    
     A  |  C    
 F---|----E|--+ 
     |  |  |  D 
     +B-+  +--+ 
";

$day = new Day19($input);
$day->run();
echo "Letters: " . $day->getLetters() . "\n";
echo "Steps: " . $day->getSteps() . "\n";
echo "-------------\n";

$day = new Day19(file_get_contents("input.day19.txt"));
$day->run();
echo "Letters: " . $day->getLetters() . "\n";
echo "Steps: " . $day->getSteps() . "\n";
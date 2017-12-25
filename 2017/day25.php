<?php
class Day25 {
	private $currentState;
	private $steps;
	
	private $statesArr;
	
	private $tape;
	private $tapeIndex;
	
	public function __construct($input) {
		$tmpArr = null;
		preg_match('/Begin in state (.+?)\./s', $input, $tmpArr);
		$this->currentState = $tmpArr[1];
		
		$tmpArr = null;
		preg_match('/Perform a diagnostic checksum after (.+?) steps\./s', $input, $tmpArr);
		$this->steps = (int) $tmpArr[1];
		
		preg_match_all('/In state (.+?):
  If the current value is (.+?):
    - Write the value (.+?)\.
    - Move one slot to the (.+?)\.
    - Continue with state (.+?)\.
  If the current value is (.+?):
    - Write the value (.+?)\.
    - Move one slot to the (.+?)\.
    - Continue with state (.+?)\./s', $input, $tmpArr);
		
		
		foreach($tmpArr[1] as $index => $state) {
			$stateArr = [
				(int) $tmpArr[2][$index] => [
					'write' => (int) $tmpArr[3][$index],
					'move' => $tmpArr[4][$index],
					'nextState' => $tmpArr[5][$index],
				],
				(int) $tmpArr[6][$index] => [
					'write' => (int) $tmpArr[7][$index],
					'move' => $tmpArr[8][$index],
					'nextState' => $tmpArr[9][$index],
				],
			];
			
			$this->statesArr[$state] = $stateArr;
		}
		
		$this->tape = [0];
		$this->tapeIndex = 0;
	}
	
	public function run() {
		for($i = 0; $i < $this->steps; $i++){
			$this->applyState();
		}
	}
	
	public function getDiagnosticChecksum() {
		return array_count_values($this->tape)[1];
	}
	
	private function applyState() {
		$oldValue = $this->tape[$this->tapeIndex];
		$this->tape[$this->tapeIndex] = $this->statesArr[$this->currentState][$oldValue]['write'];
		if($this->statesArr[$this->currentState][$oldValue]['move'] == 'right') {
			$this->tapeIndex++;
		} else {
			$this->tapeIndex--;
		}
		
		if(!isset($this->tape[$this->tapeIndex])) {
			$this->tape[$this->tapeIndex] = 0;
		}
		
		$this->currentState = $this->statesArr[$this->currentState][$oldValue]['nextState'];
	}
}

$input = 
"Begin in state A.
Perform a diagnostic checksum after 6 steps.

In state A:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state B.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state B.

In state B:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state A.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.";

$day = new Day25($input);
$day->run();
echo "Diagnostic checksum: " . $day->getDiagnosticChecksum() . "\n";
echo "-------------\n";

$day = new Day25(file_get_contents("input.day25.txt"));
$day->run();
echo "Diagnostic checksum: " . $day->getDiagnosticChecksum() . "\n";
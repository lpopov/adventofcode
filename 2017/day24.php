<?php
class Day24 {
	private $inputArr;
	
	private $bridgesArr;
	
	public function __construct($input) {
		$inputArr = explode("\n", $input);
		$this->inputArr = [];
		foreach($inputArr as $index => $row) {
			$rowArr = explode('/', $row);
			$this->inputArr[$index] = $rowArr;
		}
		
		foreach($this->inputArr as $port) {
			if($port[0] == '0' || $port[1] == '0') {
				$newBridge = [
					'ports' => [],
					'free_ports' => $this->inputArr,
					'open_end' => '0'
				];
				
				$this->bridgesArr[] = $this->addPortToBridge($newBridge, $port);
			}
		}
	}
	
	public function run() {
		$hasNewPortsAdded = false;
		do {
			$newBridges = [];
			$hasNewPortsAdded = false;
			foreach($this->bridgesArr as $bridge) {
				$bridgeModified = false;
				foreach($bridge['free_ports'] as $port) {
					if($bridge['open_end'] ==  $port[0] || $bridge['open_end'] ==  $port[1]) {
						$newBridges[] = $this->addPortToBridge($bridge, $port);
						$hasNewPortsAdded = true;
						$bridgeModified = true;
					}
				}
				
				if(!$bridgeModified) {
					$newBridges[] = $bridge;
				}
			}
			$this->bridgesArr = $newBridges;
		} while ($hasNewPortsAdded);
	}
	
	private function addPortToBridge($bridge, $port) {
		if($bridge['open_end'] == $port[0]) {
			$bridge['open_end'] = $port[1];
		} else {
			$bridge['open_end'] = $port[0];
		}
		
		$bridge['ports'][] = $port;
		
		unset($bridge['free_ports'][array_search($port, $bridge['free_ports'])]);
		
		$bridge['free_ports'] = array_values($bridge['free_ports']);
		
		return $bridge;
	}

	public function getStrongestBridge() {
		$maxStrength = 0;
		foreach($this->bridgesArr as $bridge) {
			
			$bridgeStrength = 0;
			foreach($bridge['ports'] as $port) {
				$bridgeStrength += $port[0];
				$bridgeStrength += $port[1];
			}
			
			if($bridgeStrength > $maxStrength) {
				$maxStrength = $bridgeStrength;
			}
		}
		return $maxStrength;
	}
	
	public function getLongestStrongestBridge() {
		$lengths = [];
		foreach($this->bridgesArr as $bridge) {
			$bridgeStrength = 0;
			foreach($bridge['ports'] as $port) {
				$bridgeStrength += $port[0];
				$bridgeStrength += $port[1];
			}
			
			$length = sizeof($bridge['ports']);
			
			$lengths[$length][] = $bridgeStrength;
		}
		
		ksort($lengths);
		
		$largestLength = array_pop($lengths);
		
		sort($largestLength);
		return array_pop($largestLength);
	}
}

$input = 
"0/2
2/2
2/3
3/4
3/5
0/1
10/1
9/10";

$day = new Day24($input);
$day->run();
echo "Strongest bridge: " . $day->getStrongestBridge() . "\n";
echo "Longest strongest bridge: " . $day->getLongestStrongestBridge() . "\n";
echo "-------------\n";

$day = new Day24(file_get_contents("input.day24.txt"));
$day->run();
echo "Strongest bridge: " . $day->getStrongestBridge() . "\n";
echo "Longest strongest bridge: " . $day->getLongestStrongestBridge() . "\n";
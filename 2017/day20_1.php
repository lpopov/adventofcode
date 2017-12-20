<?php
class Day20_1 {
	private $particlesArr;
	private $closestParticleIndex;
	private $closestParticleDistance;
	
	public function __construct($input) {
		$this->particlesArr = explode("\n", $input);
		foreach($this->particlesArr as $index => $data) {
			preg_match_all('/[-]{0,1}\d+/', $data, $tmpArr);
			$tmpArr = $tmpArr[0];
			$particle = [
				'p'	=>	[
					'x' => $tmpArr[0],
					'y' => $tmpArr[1],
					'z' => $tmpArr[2],
				],
				'v'	=>	[
					'x' => $tmpArr[3],
					'y' => $tmpArr[4],
					'z' => $tmpArr[5],
				],
				'a'	=>	[
					'x' => $tmpArr[6],
					'y' => $tmpArr[7],
					'z' => $tmpArr[8],
				],
			];
			$this->particlesArr[$index] = $particle;
		}
		$this->closestParticleIndex = null;
		$this->closestParticleDistance = null;
	}
	
	public function run() {
		for($i = 0; $i < 1000; $i++) {
			for($particleIndex = 0; $particleIndex < sizeof($this->particlesArr); $particleIndex++) {
				$this->updateParticle($particleIndex);
			}
		}
		
		foreach($this->particlesArr as $particleIndex => $particle) {
			$particleDistance = $this->calculateParticleDistance($particleIndex);
			if($this->closestParticleIndex === null 
					|| $this->closestParticleDistance > $particleDistance) {
				$this->closestParticleIndex = $particleIndex;
				$this->closestParticleDistance = $particleDistance;
			}
		}
	}
	
	private function updateParticle($particleIndex) {
		$this->particlesArr[$particleIndex]['v']['x'] += $this->particlesArr[$particleIndex]['a']['x'];
		$this->particlesArr[$particleIndex]['v']['y'] += $this->particlesArr[$particleIndex]['a']['y'];
		$this->particlesArr[$particleIndex]['v']['z'] += $this->particlesArr[$particleIndex]['a']['z'];
		
		$this->particlesArr[$particleIndex]['p']['x'] += $this->particlesArr[$particleIndex]['v']['x'];
		$this->particlesArr[$particleIndex]['p']['y'] += $this->particlesArr[$particleIndex]['v']['y'];
		$this->particlesArr[$particleIndex]['p']['z'] += $this->particlesArr[$particleIndex]['v']['z'];
	}
	
	private function calculateParticleDistance($particleIndex) {
		return abs($this->particlesArr[$particleIndex]['p']['x'])
			+ abs($this->particlesArr[$particleIndex]['p']['y'])
			+abs($this->particlesArr[$particleIndex]['p']['z']);
	}
			
	public function getClosestParticleIndex() {
		return $this->closestParticleIndex;
	}
}

$input = 
"p=<3,0,0>, v=<2,0,0>, a=<-1,0,0>
p=<4,0,0>, v=<0,0,0>, a=<-2,0,0>";

$day = new Day20_1($input);
$day->run();
echo "Closest particle index: " . $day->getClosestParticleIndex() . "\n";
echo "-------------\n";

$day = new Day20_1(file_get_contents("input.day20.txt"));
$day->run();
echo "Closest particle index: " . $day->getClosestParticleIndex() . "\n";
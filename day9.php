<?php
ini_set("memory_limit","256M");

/**
* dispacer, ktory bude manazovat vytvaraenie ciest a vyhodnocovat najkratsie
*/
class dispacer
{
    protected $roadNet = null;
    protected $cities = array();
    protected $roads = array();

    function __construct($roadNet, $cities)
    {
        $this->roadNet = $roadNet;
        $this->cities = $cities;
    }

    public function getRoadNet() {
        return $this->roadNet;
    }

    public function addRoad($start, $end, $numberOfVisitedCities, $roadDistance) {

        $this->roads[$start->getName()][] = array(
            // 'start' => $start,
            // 'end' => $end,
            'numberOfVisitedCities' => $numberOfVisitedCities,
            'roadDistance' => $roadDistance,
            'allCitiesVisited' => ($numberOfVisitedCities == count($this->cities)) ? TRUE : FALSE,
        );
    }

    public function computeRoads() {
        foreach ($this->cities as $cityName => $justTrue) {
            $start = new Node($cityName, $this);
            $start->buildPath();
        }
    }

    public function getShortestRoad() {
        $minDistance = 9999999999999;
        $minRoad = null;
        foreach ($this->roads as $startCityName => $roadsFromCity) {
            foreach ($roadsFromCity as $road) {
                if ($road['allCitiesVisited']) {
                    if ($road['roadDistance'] < $minDistance) {
                        $minDistance = $road['roadDistance'];
                        $minRoad = $road;
                    }
                }
            }

        }

        if ($minRoad == null) {
            throw new \RuntimeException("No road found!");

        }
        return $minRoad;
    }

    public function getLongestRoad() {
        $maxDistance = 0;
        $maxRoad = null;
        foreach ($this->roads as $startCityName => $roadsFromCity) {
            foreach ($roadsFromCity as $road) {
                if ($road['allCitiesVisited']) {
                    if ($maxDistance < $road['roadDistance']) {
                        $maxDistance = $road['roadDistance'];
                        $maxRoad = $road;
                    }
                }
            }

        }

        if ($maxRoad == null) {
            throw new \RuntimeException("No road found!");

        }
        return $maxRoad;
    }
}



/**
*  bod v strome
*/
class node
{

    protected $name = null;
    protected $parentNode = null;
    protected $childNodes = array();

    protected $dispacer = null;


    function __construct($name, &$dispacer) {
        $this->name = $name;
        $this->dispacer = $dispacer;
    }

    public function getName(){
        return $this->name;
    }

    public function setParentNode(&$parent) {
        $this->parentNode = $parent;
    }

    public function getRoadDistance(){
        return $this->roadDistance;
    }

    public function addChildNode(&$node) {
        $this->childNodes[$node->getName()] = $node;
    }

    public function isRoadEnd() {
        if (empty($this->childNodes)) {
            return true;
        } else {
            return false;
        }
    }

    private function getRoadStart() {
        if ($this->parentNode === null) {
            return $this;
        } else {
            return $this->parentNode->getRoadStart();
        }
    }


    private function isOneOfParents($nodeName) {
        if ($this->parentNode === null) {
            return false;
        }

        if ($this->parentNode->getName() == $nodeName) {
            return true;
        } else {
            return $this->parentNode->isOneOfParents($nodeName);
        }
    }

    // vrati vzdialenost od zaciatku cesty do tohoto mesta
    // pocita sa rekurzivne ako vzdialenost k predkovi + vzdialenost od predka po
    // zaciatok
    public function getRoadDistanceToStart() {
        if ($this->parentNode == null) {
            return 0;
        } else {
            $roadNet = $this->dispacer->getRoadNet();
            $distanceToParent = $roadNet[$this->name][$this->parentNode->getName()];
            return $this->parentNode->getRoadDistanceToStart() + $distanceToParent;
        }
    }

    public function getNumberOfVisitedCitiesToStart(){
        if ($this->parentNode == null) {
            return 1; //navstivil som sam seba
        } else {
            return $this->parentNode->getNumberOfVisitedCitiesToStart() + 1;
        }
    }

    //
    public function buildPath() {
        $roadNet = $this->dispacer->getRoadNet();
        foreach ($roadNet[$this->name] as $cityName => $distance) {
            if ($this->isOneOfParents($cityName)) {
                // v tomto meste sme uz boli
            } else {
                $newNode = new node($cityName, $this->dispacer);
                $newNode->setParentNode($this);
                $this->addChildNode($newNode);
                $newNode->buildPath();
            }
        }

        // ak je toto mesto posledne v ceste, a boli prejdene vsetky mesta,
        // moze sa tato cesta poznacit.
        if ($this->isRoadEnd()) {
            $start = $this->getRoadStart();
            $end = $this;
            $numberOfVisitedCities = $this->getNumberOfVisitedCitiesToStart();
            $roadDistance = $this->getRoadDistanceToStart();
            $this->dispacer->addRoad($start, $end, $numberOfVisitedCities, $roadDistance);
        }
    }

}

$inputFile = fopen("input9.txt",'r');

$roadNet = array();
$cities = array();
while ($row = trim(fgets($inputFile))) {
    $pom = explode(' ', $row);

    // vytvori sa cestna siet
    $roadNet[$pom[0]][$pom[2]] = (int)$pom[4];
    $roadNet[$pom[2]][$pom[0]] = (int)$pom[4];

    // naplni sa pole vsetkych miest
    $cities[$pom[0]] = true;
    $cities[$pom[2]] = true;
}
fclose($inputFile);


$dispacer = new Dispacer($roadNet, $cities);
$dispacer->computeRoads();
$shortestRoad = $dispacer->getShortestRoad();
var_dump($shortestRoad);
$longestRoad = $dispacer->getLongestRoad();
var_dump($longestRoad);



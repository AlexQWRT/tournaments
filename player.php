<?php

class Player
{
    private $name;
    private $city;

    public function __construct($name)
    {
        $this->name = $name;
        $this->city = "";
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function __toString()
    {
        $output = $this->name;
        if ($this->city != "")
        {
            $output = $output." (".$this->city.")";
        }
        return $output;
    }
}

?>
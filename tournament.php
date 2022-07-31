<?php

require_once "player.php";

class Tournament
{
    private $name;
    private $date;
    private $players;

    public function __construct(string $name, string $date = "")
    {
        $this->name = $name;
        if ($date == "") //���� ���� ������ �� ��������
        {
            $this->date = new DateTimeImmutable("now"); //��������������� ����������� ����
        }
        else
        {
            $date[4] = '-'; //�������������� ������������ ����
            $date[7] = '-'; //�������������� ������������ ����
            $this->date = new DateTimeImmutable($date);
        }
        $this->players = [];
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStartDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getStartDate()
    {
        return $this->date;
    }

    function addPlayer($player)
    {
        $this->players[] = $player;
        return $this;
    }

    private function arrayToPairs($arr) //����������� ������� � �������� � ��������� ������ � ������ �������
    {
        $compared_array = [];
        $count = count($arr);
        for ($i = 0; $i < $count; $i += 2)
        {
            $compared_array[] = [$arr[$i], $arr[$count-$i-1]];
        }
        return $compared_array;
    }

    private function scroll($arr) //�������� ���� ������� ����� ������� � ������� �� ������� ������� 
    {
        $buf = $arr[count($arr) - 1];
        for ($i = count($arr) - 1; $i > 1; $i--)
        {
            $arr[$i] = $arr[$i-1];
        }
        $arr[1] = $buf;
        return $arr;
    }

    private function printDay($compared_array, $date) //����� ���������� � ���� �������
    {
        echo $this->name.", ".$date."<br>";
        foreach($compared_array as $pair)
        {
            if ($pair[0] == NULL || $pair[1] == NULL)
            {
                continue;
            }
            echo $pair[0]." - ".$pair[1]."<br>";
        }
    }

    public function createPairs()
    {
        if (count($this->players) == 0)
        {
            echo "� ������ �� ��������� �������� ������!";
            return;
        }
        if (count($this->players) == 1)
        {
            echo "� ������� ������� ���� �������!";
            return;
        }
        $remove_last = false;
        if (count($this->players) % 2)
        {
            $this->addPlayer(NULL);
            $remove_last = true;
        }
        $count = count($this->players);
        for ($i = 1; $i < $count; $i++)
        {

            $this->printDay($this->arrayToPairs($this->players), 
                            $this->date->add(new DateInterval(("P".$i."D")))->format("d.m.Y"));
            $this->players = $this->scroll($this->players);
        }
        if ($remove_last)
        {
            unset($this->players[count($this->players) - 1]);
        }
        echo "<br>";
    }

    public function __toString()
    {
        $output = "Tournament{name: ".$this->name."; date: ".$this->date."; players: ";
        if ($this->players == 0) 
        {
            $output = $output."null}";
            return $output;
        }
        foreach($this->players as $player)
        {
            $output = $output.$player."; ";
        }
        $output = substr($output, 0, -2);
        $output = $output."}";
        return $output;
    }
}

?>
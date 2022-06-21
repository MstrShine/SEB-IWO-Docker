<?php

abstract class Entity
{
    public function createPropertyList()
    {
        $entitysplitted = $this->splitEntity();
        $returnString = "";
        $i = 0;
        foreach ($entitysplitted as $key => $value) {
            if ($i == 0) {
                $returnString .= "$key";
                $i++;
            } else {
                $returnString .= ", $key";
            }
        }

        return $returnString;
    }

    public function createPlaceholders()
    {
        $entitysplitted = $this->splitEntity();
        $returnString = "";
        $i = 0;
        foreach ($entitysplitted as $key => $value) {
            if($i == 0){
                $returnString .= ":$key";
                $i++;
            } else {
                $returnString .= ", :$key";
            }
        }

        return $returnString;
    }

    public function getValuesOutOfEntity()
    {
        $entitysplitted = $this->splitEntity();
        $values = [];
        foreach ($entitysplitted as $key => $value) {
            array_push($values, $value);
        }

        return $values;
    }

    public function createSetString()
    {
        $entitysplitted = $this->splitEntity();
        $returnString = "";
        foreach ($entitysplitted as $key => $value) {
            $returnString .= "$key = $value, ";
        }

        return $returnString;
    }

    private function splitEntity() {
        $entity = $this;
        return get_object_vars($entity);
    }
}
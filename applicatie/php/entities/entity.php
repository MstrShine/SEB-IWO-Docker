<?php

abstract class Entity
{
    public function createPropertyList()
    {
        $entity = $this;
        $properties = get_object_vars($entity);
        $returnString = "";
        $i = 0;
        foreach ($properties as $key => $value) {
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
        $entity = $this;
        $properties = get_object_vars($entity);
        $returnString = "";
        foreach ($properties as $key => $value) {
            $returnString .= ":$key ";
        }

        return $returnString;
    }

    public function getValuesOutOfEntity()
    {
        $entity = $this;
        $entitysplitted = get_object_vars($entity);
        $values = [];
        foreach ($entitysplitted as $key => $value) {
            array_push($values, $value);
        }

        return $values;
    }

    public function createSetString()
    {
        $entity = $this;
        $entitysplitted = get_object_vars($entity);
        $returnString = "";
        foreach ($entitysplitted as $key => $value) {
            $returnString .= "$key = $value, ";
        }

        return $returnString;
    }
}
<?php

abstract class formaGeometrica {

    protected float $area;

    public function getArea(): float {
        return $this -> area;
    }

    abstract public function calcularArea(float $base, float $altura);
}
<?php

require_once './Producto.php';

/**
 *
 */
class Cesta {

    private $productos = [];
    private $unidades = [];
    private $coste = 0;

    /**
     *
     * @param Producto $producto
     */
    public function nuevoArticulo(Producto $producto) {

        $cod = $producto->getCod();
        if (!array_key_exists($cod, $this->productos)) {
            $this->productos[$cod] = $producto;
        }
        $this->unidades[$cod] ++;
        $this->coste = 0;
        foreach ($this->getProductos() as $produc) {
            foreach ($this->getUnidades() as $cod => $unidad) {
                if ($cod == $produc->getCod()) {
                    $this->coste = $this->coste + ($unidad * $produc->getPvp());
                }
            }
        }
    }

    /**
     *
     * @param type $cod
     */
    public function borrar($cod) {
        $this->unidades[$cod] --;
        if ($this->unidades[$cod] == 0) {
            unset($this->unidades[$cod]);
            unset($this->productos[$cod]);
        }
        $this->coste = 0;
        foreach ($this->getProductos() as $produc) {
            foreach ($this->getUnidades() as $cod => $unidad) {
                if ($cod == $produc->getCod()) {
                    $this->coste = $this->coste + ($unidad * $produc->getPvp());
                }
            }
        }
    }

    /**
     *
     */
    public function vaciar() {
        $this->productos = [];
        $this->unidades = [];
        $this->coste = 0;
    }

    /**
     *
     * @return type
     */
    public function cantidad() {
        $cantidad = 0;
        foreach ($this->getUnidades() as $cod => $unidad) {
            $cantidad = $cantidad + $unidad;
        }
        return $cantidad;
    }

    /**
     *
     * @return array de objetos con todos los proeuctos de la cesta
     */
    function getProductos() {
        return $this->productos;
    }

    /**
     *
     * @param type $cod
     * @return object un objeto de tipo prodcuto a partir de su códgios
     */
    function getProducto($cod) {
        return $this->productos[$cod];
    }

    /**
     *
     * @return type
     */
    function getUnidades() {
        return $this->unidades;
    }

    /**
     *
     * @return type
     */
    function getCoste() {
        return $this->coste;
    }

    /**
     *
     * @param type $productos
     */
    function setProductos($productos) {
        $this->productos = $productos;
    }

    /**
     *
     * @param type $unidades
     */
    function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    /**
     *
     * @param type $coste
     */
    function setCoste($coste) {
        $this->coste = $coste;
    }

}

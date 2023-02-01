<?php

namespace App\Supports\GrafficSupport;

class GrafficSupport {
    private $collection;
    private $randomCollors;
    private $json;

    public function __construct($collection, $keyLabel, $keyValue = null, $randomCollors = false) {
        $this->collection = $collection;
        $this->randomCollors = $randomCollors;

        $this->geraGrafVal($keyLabel, $keyValue);
    }

    private function geraGrafVal($keyLabel, $keyValue = null) {
        $select = [];

        if (!$keyValue) {
            foreach ($this->collection as $item) {
                if (array_key_exists($item->$keyLabel, $select)) {
                    $select[$item->$keyLabel] = $select[$item->$keyLabel] + 1;
                } else {
                    $select[$item->$keyLabel] = 1;
                }
            }
        }else {
            foreach ($this->collection as $item) {
                if (array_key_exists($item->$keyLabel, $select)) {
                    $select[$item->$keyLabel] = $select[$item->$keyLabel] + $item->$keyValue;
                } else {
                    $select[$item->$keyLabel] = $item->$keyValue;
                }
            }
        }

        $colors = $this->getRGBColorString($select);

        $json = json_encode([
            'data'      => $select,
            'colors'    => $colors
        ]);

        $this->setJson($json);
    }

    private function getRGBColorString($array) {
        $value =  count($array) > 0 ? count($array) : 1;
        $indexColor = round(250 / $value);

        $iterator = 1;

        $arrayOfRGB = array();

        $hex = '#';

        foreach ($array as $item) {
            if ($this->randomCollors) {
                $hash = md5('color' . $item);
                $arrayOfRGB[] = "rgb(" . hexdec(substr($hash, 0, 2)) . ',' . hexdec(substr($hash, 2, 2)) . ',' . hexdec(substr($hash, 4, 2)) . ")";
            } else
                $arrayOfRGB[] = "rgb(" . ($indexColor * $iterator) . ", 113, 113)";
            $iterator++;
        }
        return $arrayOfRGB;
    }

    public function setJson($json) {
        $this->json = $json;
    }

    public function getJson() {
        return $this->json;
    }
}

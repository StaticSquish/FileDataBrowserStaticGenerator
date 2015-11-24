<?php


namespace staticsquish\models;

/**
*  @license 3-clause BSD
*/
class FieldScalarValueLatLng extends BaseFieldScalarValue  {

    protected $roundToForComparison = 4;

    protected $lat = null;
    protected $lng = null;

    public function __construct($value) {
        $this->setValue($value);
    }

    public function getValueAsString() {
        return $this->lat.",".$this->lng;
    }

    public function getValueKey() {
        return round($this->lat, $this->roundToForComparison) . "=" . round($this->lng, $this->roundToForComparison);
    }

    public function getValueKeyForWeb() {
        return md5(round($this->lat, $this->roundToForComparison) . "=" . round($this->lng, $this->roundToForComparison));
    }

    public function isValueEqualTo(BaseFieldValue $compare) {
        return round($compare->getLat(), $this->roundToForComparison) == round($this->lat, $this->roundToForComparison) &&
            round($compare->getLng(), $this->roundToForComparison) == round($this->lng, $this->roundToForComparison);
    }

    /**
    * Set the value of Value
    *
    * @param mixed value
    *
    * @return self
    */
    public function setValue($value)
    {

        preg_match('/^https?:\/\/www.openstreetmap.org\/\#map=([0-9]+)\/([\.\-0-9]+)\/([\.\-0-9]+)/', $value, $matches);
        if ($matches) {
            $this->lat = $matches[2];
            $this->lng = $matches[3];
            return $this;
        }

        preg_match('/^https:\/\/www.google.co.uk\/maps\/@([\.\-0-9]+),([\.\-0-9]+)/', $value, $matches);
        if ($matches) {
            $this->lat = $matches[1];
            $this->lng = $matches[2];
            return $this;
        }

        preg_match('/^https:\/\/www.google.co.uk\/maps\/place\/([^\/]+)\/@([\.\-0-9]+),([\.\-0-9]+)/', $value, $matches);
        if ($matches) {
            $this->lat = $matches[2];
            $this->lng = $matches[3];
            return $this;
        }

        return $this;
    }


    public function hasValue() {
        return !is_null($this->lat);
    }

    public function getLat() {
        return $this->lat;
    }

    public function getLng() {
        return $this->lng;
    }

}

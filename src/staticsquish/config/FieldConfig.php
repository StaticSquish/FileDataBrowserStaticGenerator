<?php

namespace staticsquish\config;

/**
 *  @license 3-clause BSD
 */
class FieldConfig {

	public $isList = false;

	public $isDateTime = false;

	public $isLatLng = false;

	public $label = '';

	public $timezone = 'UTC';

    public function isMoreThanOneType() {
        return ($this->isDateTime && $this->isLatLng);
    }

}

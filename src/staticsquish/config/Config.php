<?php


namespace staticsquish\config;

/**
 *  @license 3-clause BSD
 */
class Config {

	public $theme = 'movefast';

	public $title = 'Data Browser';

	public $fields = array();

	public $baseURL = '';


	public $internalLinkToDirAppendDirectoryIndex = false;

    public function isAnyLatLngFields() {
        foreach($this->fields as $field) {
            if ($field->isLatLng) {
                return true;
            }
        }
        return false;
    }

}

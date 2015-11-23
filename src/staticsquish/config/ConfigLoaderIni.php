<?php


namespace staticsquish\config;

use staticsquish\Site;

/**
 *  @license 3-clause BSD
 */
class ConfigLoaderIni extends BaseConfigLoader {

	function isLoadableConfigInSite(Site $site)
	{
		$file = $site->getDir().DIRECTORY_SEPARATOR."config.ini";
		return file_exists($file) && is_readable($file);
	}

	function loadConfigInSite(Config $config, Site $site)
	{

		$file = $site->getDir().DIRECTORY_SEPARATOR."config.ini";
		$data = parse_ini_file($file,true);

		if (isset($data['theme']) && $data['theme']) {
			$config->theme = $data['theme']; // TODO check valid
		}
		if (isset($data['title']) && $data['title']) {
			$config->title = $data['title'];
		}
		if (isset($data['base_url']) && $data['base_url']) {
			$config->baseURL = $data['base_url'];
		}
		if (isset($data['internal_link_to_dir_append_directory_index'])) {
			$config->internalLinkToDirAppendDirectoryIndex = (boolean)$data['internal_link_to_dir_append_directory_index'];
		}

		foreach ($data as $key=>$fieldOptions) {
			if (substr($key, 0, 6) == 'field.') {
				$fieldName = substr($key, 6);

				$config->fields[$fieldName] = new FieldConfig();
				$config->fields[$fieldName]->label = $fieldName;

				if (isset($fieldOptions['is_list'])) {
					$config->fields[$fieldName]->isList = (boolean)$fieldOptions['is_list'];
				}
				if (isset($fieldOptions['is_datetime'])) {
					$config->fields[$fieldName]->isDateTime = (boolean)$fieldOptions['is_datetime'];
				}
				if (isset($fieldOptions['label'])) {
					$config->fields[$fieldName]->label = $fieldOptions['label'];
				}
				if (isset($fieldOptions['timezone'])) {
					$config->fields[$fieldName]->timezone = $fieldOptions['timezone'];
				}


			}
		}


	}
}

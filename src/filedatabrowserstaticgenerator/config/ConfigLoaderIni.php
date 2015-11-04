<?php


namespace filedatabrowserstaticgenerator\config;

use filedatabrowserstaticgenerator\Site;

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

		foreach ($data as $key=>$fieldOptions) {
			if (substr($key, 0, 6) == 'field.') {
				$fieldName = substr($key, 6);

				$config->fields[$fieldName] = new FieldConfig();

				if (isset($fieldOptions['is_list'])) {
					$config->fields[$fieldName]->isList = (boolean)$fieldOptions['is_list'];
				}


			}
		}


	}
}

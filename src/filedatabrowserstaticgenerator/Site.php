<?php

namespace filedatabrowserstaticgenerator;

use Pimple\Container;
use filedatabrowserstaticgenerator\config\Config;
use filedatabrowserstaticgenerator\config\ConfigLoaderIni;
use filedatabrowserstaticgenerator\data\RootDataLoaderIni;
use filedatabrowserstaticgenerator\models\RootDataObject;

/**
 *  @license 3-clause BSD
 */
class Site {

	/** @var  Container */
	protected  $app;

	protected $dir;

	/** @var  Config */
	protected $config;

	function __construct(Container $app, $dir)
	{
		$this->app = $app;
		$this->dir = $dir;
		$this->config = new Config();

		foreach(array(
			New ConfigLoaderIni(),
				) as $loader) {
			if ($loader->isLoadableConfigInSite($this)) {
				$loader->loadConfigInSite($this->config, $this);
			}
		}

  }

	protected $isLoaded = false;

	protected $dataErrors = array();
	protected $dataWarnings = array();

	protected $rootDataObjects = array();

	function load() {

		$loaders = array(
			new RootDataLoaderIni(),
		);

		foreach(scandir($this->dir . DIRECTORY_SEPARATOR. "data") as $fileName) {
			if ($fileName != "." && $fileName != '..' && is_dir($this->dir . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$fileName)) {

				foreach($loaders as $loader) {
					if ($loader->isLoadableDataInSite($this, $fileName)) {
						$out = $loader->loadRootDataInSite($this, $fileName);
						if (is_a($out, 'filedatabrowserstaticgenerator\models\RootDataObject')) {
							$this->addRootDataObject($out);
						}
					}
				}

			}
		}


		$this->isLoaded = true;

	}

	protected function addRootDataObject(RootDataObject $rootDataObject) {
		$this->rootDataObjects[] = $rootDataObject;
	}


	function write($outDir) {

		if (!$this->isLoaded) {
			$this->load();
		}

		$twigHelper = new TwigHelper($this);
		$twig = $twigHelper->getTwig();


		// General Data
		$data = array(
			'config'=>$this->config,
			'allRootDataObjects'=>$this->rootDataObjects,
		);

		// Index
		file_put_contents(
			$outDir.DIRECTORY_SEPARATOR.'index.html',
			$twig->render('index.html.twig', array_merge($data, array(
			)))
		);

		// Data
		file_put_contents(
			$outDir.DIRECTORY_SEPARATOR.'data.html',
			$twig->render('data.html.twig', array_merge($data, array(
			)))
		);


	}



	/**
	 * @return String
	 */
	public function getDir()
	{
		return $this->dir;
	}

	/**
	 * @return Config
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * @return boolean
	 */
	public function isIsLoaded()
	{
		return $this->isLoaded;
	}

	/**
	 * @return array
	 */
	public function getDataErrors()
	{
		if (!$this->isLoaded) {
			$this->load();
		}
		return $this->dataErrors;
	}

	/**
	 * @return array
	 */
	public function getDataWarnings()
	{
		if (!$this->isLoaded) {
			$this->load();
		}
		return $this->dataWarnings;
	}


  /**
   * Get the value of Root Data Objects
   *
   * @return mixed
   */
  public function getRootDataObjects()
  {
      return $this->rootDataObjects;
  }

}

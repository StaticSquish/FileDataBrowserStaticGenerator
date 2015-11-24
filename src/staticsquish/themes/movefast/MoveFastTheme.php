<?php

namespace staticsquish\themes\movefast;


/**
*  @license 3-clause BSD
*/
use staticsquish\Site;
use staticsquish\aggregation\DistinctValuesAggregation;
use staticsquish\filters\RootDataObjectFilter;
use staticsquish\filters\FieldFilter;
use staticsquish\filters\FieldFilterNoValue;
use staticsquish\themes\BaseTheme;
use staticsquish\TwigHelper;
use staticsquish\OutFolder;
use staticsquish\themes\movefast\writecomponents\IndexWriteComponent;
use staticsquish\themes\movefast\writecomponents\DataWriteComponent;
use staticsquish\themes\movefast\writecomponents\FieldWriteComponent;

class MoveFastTheme extends BaseTheme
{



  function write(Site $site, $dir) {


  		$twigHelper = new TwigHelper($site);
  		$twig = $twigHelper->getTwig();

  		$outFolder = new OutFolder($dir);

  		// General Data
  		$data = array(
  			'config'=>$site->getConfig(),
  			'allRootDataObjects'=>$site->getRootDataObjects(),
  		);

  		// Index
      $wc = new IndexWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write();


  		// Data
      $wc = new DataWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write();


  		// Root Objects
  		mkdir($dir.DIRECTORY_SEPARATOR.'data');
  		foreach($site->getRootDataObjects() as $rootDataObject) {
  			$dataDir = $dir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$rootDataObject->getSlug();
        $fieldsWithNoValue = array();
        foreach ($site->getConfig()->fields as $key=>$field) {
          if (!$rootDataObject->hasField($key)) {
            $fieldsWithNoValue[$key] = $field;
          }
        }
  			// index
  			$outFolder->addFileContents(
  				'data'.DIRECTORY_SEPARATOR.$rootDataObject->getSlug(),
  				'index.html',
  				$twig->render('rootdataobject/index.html.twig', array_merge($data, array(
  					'rootDataObject'=>$rootDataObject,
            'fieldsWithNoValue'=>$fieldsWithNoValue,
            'anyLatLngFields' => $site->getConfig()->isAnyLatLngFields(),
  				)))
  			);
  			// files
  			mkdir($dataDir.DIRECTORY_SEPARATOR.'files');
  			foreach($rootDataObject->getFiles() as $file) {
  				copy($file->getDir().DIRECTORY_SEPARATOR.$file->getName(), $dataDir.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$file->getName() );
  			}
  		}

      // field
      $wc = new FieldWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write($dir);

  		// theme
  		$outFolder->copyFolder(APP_ROOT_DIR.'theme'.DIRECTORY_SEPARATOR.$site->getConfig()->theme.DIRECTORY_SEPARATOR.'files');

    }

}

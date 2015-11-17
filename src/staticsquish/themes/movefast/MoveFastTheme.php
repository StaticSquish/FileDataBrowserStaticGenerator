<?php

namespace staticsquish\themes\movefast;


/**
*  @license 3-clause BSD
*/
use staticsquish\Site;
use staticsquish\aggregation\DistinctValuesAggregation;
use staticsquish\filters\RootDataObjectFilter;
use staticsquish\filters\FieldFilter;
use staticsquish\themes\BaseTheme;
use staticsquish\TwigHelper;
use staticsquish\OutFolder;

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
  		$outFolder->addFileContents(
  			'',
  			'index.html',
  			$twig->render('index.html.twig', array_merge($data, array(
  			)))
  		);

  		// Data
  		$outFolder->addFileContents(
  			'',
  			'data.html',
  			$twig->render('data.html.twig', array_merge($data, array(
  			)))
  		);

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
  				)))
  			);
  			// files
  			mkdir($dataDir.DIRECTORY_SEPARATOR.'files');
  			foreach($rootDataObject->getFiles() as $file) {
  				copy($file->getDir().DIRECTORY_SEPARATOR.$file->getName(), $dataDir.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$file->getName() );
  			}
  		}

  		// Field Objects
  		mkdir($dir.DIRECTORY_SEPARATOR.'field');
  		foreach($site->getConfig()->fields as $key => $fieldConfig) {
  			$dataDir = $dir.DIRECTORY_SEPARATOR.'field'.DIRECTORY_SEPARATOR.$key;
  			$aggregation = new DistinctValuesAggregation(new RootDataObjectFilter($site), $key);

  			// index
  			$values = array();
  			foreach($aggregation->getValues() as $value) {
  				$values[md5($value)] = $value;
  			}
  			$outFolder->addFileContents(
  				'field'.DIRECTORY_SEPARATOR.$key,
  				'index.html',
  				$twig->render('field/index.html.twig', array_merge($data, array(
  					'fieldKey'=>$key,
  					'fieldConfig'=>$fieldConfig,
  					'values' => $values,
  				)))
  			);

  			// values
  			mkdir($dir.DIRECTORY_SEPARATOR.'field'.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'value'.DIRECTORY_SEPARATOR);
  			foreach($aggregation->getValues() as $fieldValue) {
  				$fieldValueKey=md5($fieldValue);

  				$filter = new RootDataObjectFilter($site);
  				$filter->addFieldFilter(new FieldFilter($site, $key, $fieldValue));

  				$outFolder->addFileContents(
  					'field'.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'value'.DIRECTORY_SEPARATOR.$fieldValueKey,
  					'index.html',
  					$twig->render('field/value/index.html.twig', array_merge($data, array(
  						'fieldKey'=>$key,
  						'fieldConfig'=>$fieldConfig,
  						'fieldValue' => $fieldValue,
  						'rootDataObjects' => $filter->getRootDataObjects(),
  					)))
  				);

  			}
  		}

  		// theme
  		$outFolder->copyFolder(APP_ROOT_DIR.'theme'.DIRECTORY_SEPARATOR.$site->getConfig()->theme.DIRECTORY_SEPARATOR.'files');

    }

}

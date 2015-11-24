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
use staticsquish\themes\movefast\writecomponents\RootObjectsWriteComponent;

class MoveFastTheme extends BaseTheme
{



  function write(Site $site, $dir) {


  		$twigHelper = new TwigHelper($site);
  		$twig = $twigHelper->getTwig();

  		$outFolder = new OutFolder($dir);

  		// Index
      $wc = new IndexWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write();


  		// Data
      $wc = new DataWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write();


        // Root Objects
        $wc = new RootObjectsWriteComponent($this->app, $site, $outFolder, $twigHelper);
        $wc->write($dir);


      // field
      $wc = new FieldWriteComponent($this->app, $site, $outFolder, $twigHelper);
      $wc->write($dir);

  		// theme
  		$outFolder->copyFolder(APP_ROOT_DIR.'theme'.DIRECTORY_SEPARATOR.$site->getConfig()->theme.DIRECTORY_SEPARATOR.'files');

    }

}

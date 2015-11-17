<?php

namespace staticsquish\writecomponents;

use staticsquish\Site;
use staticsquish\OutFolder;
use staticsquish\TwigHelper;
use Pimple\Container;

/**
*  @license 3-clause BSD
*/

abstract class BaseWriteTwigComponent {

  /** @var TwigHelper **/
  protected $twigHelper;

  protected $baseViewParameters;

  public function __construct(Container $app, Site $site, OutFolder $outFolder, TwigHelper $twigHelper) {
    $this->app = $app;
    $this->site = $site;
    $this->outFolder = $outFolder;
    $this->twigHelper = $twigHelper;

    $this->baseViewParameters = array(
      'config'=>$this->site->getConfig(),
      'allRootDataObjects'=>$site->getRootDataObjects(),
    );
  }

}

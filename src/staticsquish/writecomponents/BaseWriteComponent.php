<?php

namespace staticsquish\writecomponents;

use staticsquish\Site;
use staticsquish\OutFolder;
use Pimple\Container;

/**
*  @license 3-clause BSD
*/

abstract class BaseWriteComponent {


  /** @var  Container */
  protected  $app;

  /** @var Site **/
  protected $site;

  /** @var OutFolder **/
  protected $outFolder;

  public function __construct(Container $app, Site $site, OutFolder $outFolder) {
    $this->app = $app;
    $this->site = $site;
    $this->outFolder = $outFolder;
  }

  abstract function write();

}

<?php

namespace filedatabrowserstaticgenerator;


use \Twig_Environment;
use \Twig_Loader_Filesystem;


/**
*  @license 3-clause BSD
*/
class TwigHelper {

  /** @var Twig_Environment */
  protected $twig;

  protected $cacheDir;

  function __construct(Site $site)
  {
    $this->cacheDir = '/tmp/filedatabrowserstaticgenerator'.rand();
    while(file_exists($this->cacheDir)) {
      $this->cacheDir = '/tmp/filedatabrowserstaticgenerator'.rand();
    }

    $templates = array(
      APP_ROOT_DIR.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$site->getConfig()->theme.DIRECTORY_SEPARATOR.'templates',
    );
    $siteTemplates = $site->getDir().DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'templates';
    if (file_exists($siteTemplates) && is_dir($siteTemplates)) {
      array_unshift($templates, $siteTemplates);
    }
    $loader = new Twig_Loader_Filesystem($templates);
    $this->twig = new Twig_Environment($loader, array(
      'cache' => $this->cacheDir,
    ));
  }

  /**
  * @return Twig_Environment
  */
  public function getTwig()
  {
    return $this->twig;
  }

}

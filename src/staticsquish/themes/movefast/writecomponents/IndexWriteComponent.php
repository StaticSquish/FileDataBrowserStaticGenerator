<?php

namespace staticsquish\themes\movefast\writecomponents;


/**
*  @license 3-clause BSD
*/
use staticsquish\writecomponents\BaseWriteTwigComponent;

class IndexWriteComponent extends BaseWriteTwigComponent
{

  public function write() {

    $this->outFolder->addFileContents(
      '',
      'index.html',
      $this->twigHelper->getTwig()->render('index.html.twig', array_merge($this->baseViewParameters, array(
      )))
    );

  }

}

<?php

namespace staticsquish\themes\movefast\writecomponents;


/**
*  @license 3-clause BSD
*/
use staticsquish\writecomponents\BaseWriteTwigComponent;

class DataWriteComponent extends BaseWriteTwigComponent
{

  public function write() {

    $this->outFolder->addFileContents(
      '',
      'data.html',
      $this->twigHelper->getTwig()->render('data.html.twig', array_merge($this->baseViewParameters, array(
      )))
    );

  }

}

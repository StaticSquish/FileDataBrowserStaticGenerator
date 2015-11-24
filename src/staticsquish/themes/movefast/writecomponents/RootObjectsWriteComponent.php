<?php

namespace staticsquish\themes\movefast\writecomponents;


/**
*  @license 3-clause BSD
*/
use staticsquish\writecomponents\BaseWriteTwigComponent;

class RootObjectsWriteComponent extends BaseWriteTwigComponent
{

    public function write($dir) {
        mkdir($dir.DIRECTORY_SEPARATOR.'data');
        foreach($this->site->getRootDataObjects() as $rootDataObject) {
            $dataDir = $dir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$rootDataObject->getSlug();
            $fieldsWithNoValue = array();
            foreach ($this->site->getConfig()->fields as $key=>$field) {
                if (!$rootDataObject->hasField($key)) {
                    $fieldsWithNoValue[$key] = $field;
                }
            }
            // index
            $this->outFolder->addFileContents(
                'data'.DIRECTORY_SEPARATOR.$rootDataObject->getSlug(),
                'index.html',
                $this->twigHelper->getTwig()->render('rootdataobject/index.html.twig', array_merge($this->baseViewParameters, array(
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
    }

}

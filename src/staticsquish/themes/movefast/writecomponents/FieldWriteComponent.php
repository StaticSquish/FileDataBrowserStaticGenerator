<?php

namespace staticsquish\themes\movefast\writecomponents;


/**
*  @license 3-clause BSD
*/
use staticsquish\writecomponents\BaseWriteTwigComponent;
use staticsquish\aggregation\DistinctValuesAggregation;
use staticsquish\filters\RootDataObjectFilter;
use staticsquish\filters\FieldFilter;
use staticsquish\filters\FieldFilterNoValue;

class FieldWriteComponent extends BaseWriteTwigComponent
{


  public function write($dir) {

    // Field Objects
    mkdir($dir.DIRECTORY_SEPARATOR.'field');
    foreach($this->site->getConfig()->fields as $key => $fieldConfig) {
      $dataDir = $dir.DIRECTORY_SEPARATOR.'field'.DIRECTORY_SEPARATOR.$key;
      $aggregation = new DistinctValuesAggregation(new RootDataObjectFilter($this->site), $key);

      $filterNoValues = new RootDataObjectFilter($this->site);
      $filterNoValues->addFieldFilter(new FieldFilterNoValue($this->site, $key));
      $rootDataWithNoValues = $filterNoValues->getRootDataObjects();

      // index
      $values = array();
      foreach($aggregation->getValues() as $value) {
        $filter = new RootDataObjectFilter($this->site);
        $filter->addFieldFilter(new FieldFilter($this->site, $key, $value));
        $values[$value->getValueKeyForWeb()] = array(
          'value'=>$value,
          'count'=>$filter->getRootDataObjectCount(),
        );
      }

      usort($values, 'staticsquish\themes\movefast\writecomponents\FieldWriteComponent::sortByValue');
      $this->outFolder->addFileContents(
        'field'.DIRECTORY_SEPARATOR.$key,
        'index.html',
        $this->twigHelper->getTwig()->render('field/index.html.twig', array_merge($this->baseViewParameters, array(
          'fieldKey'=>$key,
          'fieldConfig'=>$fieldConfig,
          'values' => $values,
          'rootDataWithNoValues' => (count($rootDataWithNoValues) > 0),
          'rootDataWithNoValuesCount' => count($rootDataWithNoValues),
        )))
      );

      usort($values, 'staticsquish\themes\movefast\writecomponents\FieldWriteComponent::sortByCount');
      $this->outFolder->addFileContents(
        'field'.DIRECTORY_SEPARATOR.$key,
        'indexSortByCount.html',
        $this->twigHelper->getTwig()->render('field/indexSortByCount.html.twig', array_merge($this->baseViewParameters, array(
          'fieldKey'=>$key,
          'fieldConfig'=>$fieldConfig,
          'values' => $values,
          'rootDataWithNoValues' => (count($rootDataWithNoValues) > 0),
          'rootDataWithNoValuesCount' => count($rootDataWithNoValues),
        )))
      );

      // values
      mkdir($dir.DIRECTORY_SEPARATOR.'field'.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'value'.DIRECTORY_SEPARATOR);
      foreach($aggregation->getValues() as $fieldValue) {
        $filter = new RootDataObjectFilter($this->site);
        $filter->addFieldFilter(new FieldFilter($this->site, $key, $fieldValue));

        $this->outFolder->addFileContents(
          'field'.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'value'.DIRECTORY_SEPARATOR.$fieldValue->getValueKeyForWeb(),
          'index.html',
          $this->twigHelper->getTwig()->render('field/value/index.html.twig', array_merge($this->baseViewParameters, array(
            'fieldKey'=>$key,
            'fieldConfig'=>$fieldConfig,
            'fieldValue' => $fieldValue,
            'rootDataObjects' => $filter->getRootDataObjects(),
          )))
        );

        // no values
        // we always write this even if there is none now, as there may have been some data in the past so people may check this page.
        $this->outFolder->addFileContents(
          'field'.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'value'.DIRECTORY_SEPARATOR.'none',
          'index.html',
          $this->twigHelper->getTwig()->render('field/novalue/index.html.twig', array_merge($this->baseViewParameters, array(
            'fieldKey'=>$key,
            'fieldConfig'=>$fieldConfig,
            'rootDataObjects' => $rootDataWithNoValues,
          )))
        );


      }
    }



  }

  protected static function sortByValue($a, $b) {
    if ($a['value'] == $b['value']) {
      return 0;
    }
    return ($a['value'] < $b['value']) ? -1 : 1;
  }

  protected static function sortByCount($a, $b) {
    if ($a['count'] == $b['count']) {
      return 0;
    }
    return ($a['count'] > $b['count']) ? -1 : 1;
  }

}

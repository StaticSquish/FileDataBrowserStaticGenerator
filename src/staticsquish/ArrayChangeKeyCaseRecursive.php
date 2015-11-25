<?php

namespace staticsquish;

/**
*  @license 3-clause BSD
*/

class ArrayChangeKeyCaseRecursive {

    public static function convert(&$data, $case = CASE_LOWER) {
        foreach(array_keys($data) as $oldKey) {
            $newKey = $case == CASE_LOWER ? strtolower($oldKey) : strtoupper($oldKey);
            if ($oldKey != $newKey) {
                $data[$newKey] = $data[$oldKey];
                unset($data[$oldKey]);
            }
            if (is_array($data[$newKey])) {
                self::convert($data[$newKey], $case);
            }
        }
    }

}

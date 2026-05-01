<?php
/**
* :param > DOMDocument:svg, array:idList, string:colour
* function loops through all the element within a svg and change the fill colour of elements with id in the list.
*/

function alterSvg($svg, $idList, $colour) {
    $allElements = $svg->getElementsByTagName('*');
    foreach ($allElements as $element) {
        if (!$element->hasAttribute('id')) {
            continue;
        }
        $id = $element->getAttribute('id');
        if (in_array($id, $idList)) {
            $element->setAttribute('fill', $colour);
        }
    }
}
?>
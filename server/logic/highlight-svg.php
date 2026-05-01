<?php
function alterSvg($svg, $idList, $colour) {
    // $svg = new DOMDocument();
    // $svg->load($svgPath);
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
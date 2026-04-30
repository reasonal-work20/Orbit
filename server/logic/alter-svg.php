<?php
function alterSvg($svgPath, $idList, $colour) {
    $svg = new DOMDocument();
    $svg->load($svgPath);
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
    return $svg->saveXML();
}

/**
 * def highlight(self, id, color):
 *      self.imageCode = self.imageExport
 *      root = ET.fromstring(self.imageCode)
 *      for element in root.iter():
 *          if "id" in element.attrib:
 *              if element.attrib["id"] == id:
 *                  element.set("fill", color)
 *      root = self.format(root)
 *      self.imageCode = ET.tostring(root, encoding="unicode")
 */
?>
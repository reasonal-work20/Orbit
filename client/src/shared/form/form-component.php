<?php
function renderFormInput($id, $title, $type, $class, $placeholder = "", $isRequired = true, $value="")
{
    $requiredStar = $isRequired ? "<span class='required' style='color:red;'> * </span>" : "";
    $requiredAttr = $isRequired ? "required" : "";
    echo "
    <div class='form-input'>
        <label for='$id'>
            $title $requiredStar
        </label>
        <input type='$type' id='$id' name='$id' class='$class' placeholder='$placeholder' value='$value' $requiredAttr>
    </div>
    ";
}

function renderFormSelect($id, $title, $options, $class, $isRequired = true, $selected="") // $options is an associative array. Make sure database values put in are correct.
{
    $requiredStar = $isRequired ? "<span class='required active' style='color:red;'> * </span>" : "";
    $requiredAttr = $isRequired ? "required" : "";

    echo "
    <div class='form-input'>
        <label for='$id'>$title $requiredStar</label>
        <select id='$id' name='$id' class='$class' $requiredAttr>
            <option value='' disabled selected>Select an option</option>";

    foreach ($options as $value => $label) {
        if ($selected === $value) {
            $select = "selected";
        } else {
            $select = "";
        }
        echo "<option value='$value' $select>$label</option>";
    }

    echo "
        </select>
    </div>
    ";
}

function renderSegmentedControl($id, $title, $options, $isRequired = true, $value = "")
{
    $requiredStar = $isRequired ? "<span style='color:red;'> * </span>" : "";

    echo "
    <div class='form-input'>
        <label>$title $requiredStar</label>
        <div class='segmented-control' id='segment-$id'>
    ";

    foreach ($options as $index => $option) {
        $optionId = $id . "_" . $index;
        $checked = ($index === 0 || $option === $value) ? "checked" : ""; // Default first option to checked
        echo "
            <input type='radio' name='$id' id='$optionId' value='$option' $checked>
            <label for='$optionId' class='segment-label'>$option</label>
        ";
    }

    echo "
        </div>
    </div>
    ";
}
?>
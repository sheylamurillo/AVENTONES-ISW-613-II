<?php

// Retorna selected si el valor coincide con el valor seleccionado, se usa para marcar la opción activa dentro de un select.
function isSelected($value, $selectedValue)
{
    return ($value === $selectedValue) ? 'selected' : '';
}

// Retorna checked si el valor está dentro del arreglo selecciond.Se utiliza para mantener marcar los checkboxes seleccionados por el user
function isChecked($value, $selectedArray)
{
    return (is_array($selectedArray) && in_array($value, $selectedArray)) 
        ? 'checked' 
        : '';
}

// Genera los options para los select, items es el array que contiene ya sea los origines/destinos que vienen de la bd
// $key es la columna/llave a mostrar, y selectedValue se utiliza para marcar la opción del usuario.
function renderOptions($items, $selectedValue, $key)
{
    $html = '';

    foreach ($items as $item) {
        $value = $item[$key];
        $selected = isSelected($value, $selectedValue);
        $html .= "<option value='$value' $selected>$value</option>";
    }

    return $html;
}

// Genera los checkboxes de los días de la semana,usa isChecked para mantener seleccionados los días previamente marcados por el usuario.
function renderDays($daysOfWeek, $selectedDays)
{
    $html = '';

    foreach ($daysOfWeek as $day) {
        $checked = isChecked($day, $selectedDays);

        $html .= "
            <label>
                <input type='checkbox' name='days[]' value='$day' $checked>
                $day
            </label>
        ";
    }

    return $html;
}

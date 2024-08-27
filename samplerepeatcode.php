<?php
// Number of rows you want to repeat
$numRows = 5;

echo "<table border='1'>";
for ($i = 0; $i < $numRows; $i++) {
    echo "<tr>";
    echo "<td>Row " . ($i + 1) . " Column 1</td>";
    echo "<td>Row " . ($i + 1) . " Column 2</td>";
    echo "</tr>";
}
echo "</table>";
?>

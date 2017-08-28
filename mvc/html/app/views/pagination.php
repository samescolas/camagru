<div id="pagination">
	<?php
		foreach(range(1, $data['pages']) as $page) {
			if ($page > 1)
				echo " ";
			if ($page != $data['current'])
				echo "<a class=\"pagination-link\" href=\"" . $data['base'] . "/$page\">";
			echo $page;
			if ($page != $data['current'])
				echo "</a>";
		}
	?>
</div>

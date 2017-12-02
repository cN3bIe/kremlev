<?php
$id = random_int(0,10000);
?><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="fil-<?php echo $id;?>" data-filter=".filter-1-1">
	<input type="checkbox" id="fil-<?php echo $id;?>" class="mdl-checkbox__input" name="{name}[]">
	<span class="mdl-checkbox__label">Name <?php echo $id;?></span>
</label>

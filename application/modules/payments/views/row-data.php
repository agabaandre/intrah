<?php $x =0; foreach ($people as $element) { $x++; ?>

	 <tr><td><?php echo $element['pid']; ?> <input type='hidden' name='num[]' value="<?php echo $x; ?>"> </td><td><input type='hidden' name='pid[]' value="<?php echo $element['pid']; ?>"> <?php echo $element['firstname']." ".$element['surname']; ?></td><td><?php echo $element['district']; ?></td><td><?php echo $element['mobile']; ?></td><td><?php echo $element['email']; ?></td><td><input type='number' name='transport[]' placeholder='Amount' class="form-control"></td><td><input type='number' name='accommodation[]' placeholder='Amount' class="form-control"></td></tr>

<?php } ?>


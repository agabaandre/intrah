
<?php foreach ($people as $element) {  ?>

	 <tr><td><?php echo $element['pid']; ?></td><td> <?php echo $element['firstname']." ".$element['surname']; ?></td><td><?php echo $element['district']; ?></td><td><?php echo $element['mobile']; ?></td><td><?php echo $element['email']; ?></td><td><?php echo $element['transport']; ?></td><td><?php echo $element['accommodation']; ?></td></tr>

<?php } ?>


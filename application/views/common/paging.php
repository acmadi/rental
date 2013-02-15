<div class="pagination pagination-centered pagination-large">
	<ul>
		<?php if ($PageActive > 1) { ?>
			<li><a href="#">Prev<span class="hidden"><?php echo ($PageActive - 1); ?></span></a></li>
		<?php } ?>
		
		<?php for ($i = -3; $i < 3; $i++) { ?>
			<?php $PageNo = $PageActive + $i; ?>
			<?php $ClassActive = ($i == 0) ? 'active' : ''; ?>
			<?php if ($PageNo > 0 && $PageNo <= $PageTotal) { ?>
				<li><a href="#" class="<?php echo $ClassActive; ?>"><?php echo $PageNo; ?><span class="hidden"><?php echo $PageNo; ?></span></a></li>
			<?php } ?>
		<?php } ?>
		
		<?php if ($PageActive < $PageTotal) { ?>
			<li><a href="#">Next<span class="hidden"><?php echo ($PageActive + 1); ?></span></a></li>
		<?php } ?>
		
	</ul>
</div>
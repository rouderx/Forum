<div class="row col-md-offset-2 col-md-8 m-b p-a thread" onclick="window.location.href='/thread?id=<?php echo $row['id']?>';">
	<div class="col-md-2 m-t-xs no-space-break">
		<a href="/profile?user=<?php echo $user['name'];?>"><?php echo $__name;?></a>

	</div>
	<div class="col-md-10">
		<div class="col-md-12"><label class="label-edit"><?php echo $__nadpis; ?></label></div>
		<div class="col-md-12"><?php echo $__text; ?></div>
		<div class="col-md-12 text-right fs-sm">Komentáre: <?php echo numberOfThreadAnswers($row['id']);?></div>
	</div>
</div>
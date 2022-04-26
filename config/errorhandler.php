<?php if (!empty($resMessage)) { ?>
<div class="alert <?php echo $resMessage['status'] ?>">
    <?php echo $resMessage['message'] ?>
</div>
<?php } ?>
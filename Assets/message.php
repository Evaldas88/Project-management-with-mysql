<?php if(isset($_SESSION['message'])) : ?>
    <div class="marginass alert alert-dismissible fade show alert-<?= $_SESSION['type']; ?>">
    <?php     print $_SESSION['message'];?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
     unset($_SESSION['message']);
    endif;
?>
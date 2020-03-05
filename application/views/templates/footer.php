    </div> <!-- wrapper aberto em header -->
    
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/libs/jquery-3.1.1.min.js'); ?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/libs/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/libs/bootbox.min.js'); ?>"></script>
    
    <!-- Scripts passados por parâmetros -->
    <?php 
        if(!empty($script)):
            foreach($script AS $script):
                print($script);
            endforeach;
        endif;
    ?>
</body>
</html>
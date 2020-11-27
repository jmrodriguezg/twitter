<div class="container mainContainer">

    <div class="row">
        <div class="col-sm-8">

            <?php if (isset($_GET['userid'])) {  ?>
            <?php   if ($_GET['userid']) { ?>

                <?php displayTweets($_GET['userid']);  ?>

            <?php   }; ?>

            <?php  }else{ ?>

                <h2>Usuarios activos</h2>

                <?php displayUsers();  ?>

            <?php } ?>

        </div>
        <div class="col-sm-4">

            <?php displaySearch();  ?>

            <hr>

            <?php displayTweetBox();  ?>
        
        </div>
    </div>


</div>
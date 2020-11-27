<footer class="footer mt-auto py-3">
    <div class="container">
        <p>&copy; My website 2020</p>
    </div>
</footer>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

<!-- CDN Google (to use AJAX)-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalTitle">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="loginAlert"></div>
                <form>
                    <input type="hidden" name="loginActive" id="loginActive" value="1">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" autocomplete="on">
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <a id="toggleLogin" href="#">Sign up</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="loginSignupButton" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>


<script>
    $("#toggleLogin").click(function(){
        if ($("#loginActive").val() == "1"){

            $("#loginActive").val("0");
            $("#loginModalTitle").html("Sign Up");
            $("#loginSignupButton").html("Sign Up");
            $("#toggleLogin").html("Login");
        }else{

            $("#loginActive").val("1");
            $("#loginModalTitle").html("Login");
            $("#loginSignupButton").html("Login");
            $("#toggleLogin").html("Sign Up");

        }
    })

    $("#loginSignupButton").click(function(){
        //alert("clicked login");
        $.ajax({
            type: 'POST',
            url: 'actions.php?action=loginSignup',
            data: 'email=' + $('#email').val() + '&password=' + $('#password').val() + '&loginActive=' + $('#loginActive').val(),
            success: function(result) {
                //alert(result);
                if (result == "1"){
                    //redirect to home already login
                    window.location.assign("http://localhost/site/twitter/index.php");

                }else{
                    $("#loginAlert").html(result).show();
                }
            }
        })
    })

    $('.toggleFollow').click(function(){
        //alert($(this).attr("data-userId"));

        var id =  $(this).attr("data-userId");

        $.ajax({
            type: "POST",
            url: "actions.php?action=toggleFollow",
            data: "userId=" + id,
            success: function(result) {
                //alert(result);
                if (result == "1") {
                    //UNFOLLOW THE USER
                    $("a[data-userId='" + id + "']").html("Follow");

                }else if (result == "2") {
                    //FOLLOW THE USER
                    $("a[data-userId='" + id + "']").html("Unfollow");

                }
                
            }
        })

    });

    $('#postTweetButton').click(function(){
        //alert ($("#tweetContent").val());

        $.ajax({
            type: "POST",
            url: "actions.php?action=postTweet",
            data: "tweetContent=" + $("#tweetContent").val(),
            success: function(result) {
                
                //alert(result);
                if (result = "1"){
                    $("#tweetSuccess").show();
                    $("#tweetFail").hide();
                }else if (result != ""){
                    $("#tweetFail").html(result).show();
                    $("#tweetSuccess").hide();
                }
               
                
            }
        })

    });

</script>

</body>

</html>
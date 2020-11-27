<?php

    session_start();

    //remote server
    $link = mysqli_connect("mysql.stackcp.com:53079", "twitter-313331fab5", ">Xl4(f6sCK$9", "twitter-313331fab5");
    //localhost
    //$link = mysqli_connect("localhost:3306", "root", "", "secretdiary");

    if (mysqli_connect_errno()){
        //die("Ha habido un error en la conexion a la base de datos.");
        print_r(mysqli_connect_error());
        exit();
    }

    if (isset($_GET['function'])){
        if ($_GET['function'] == "logout"){
            session_unset();
        };
    }


	function time_since($since) {
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'min'),
	        array(1 , 's')
	    );
 
	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	    return $print;
	}



    function displayTweets($type) {
        global $link;
        //echo $type;

        if ($type == 'public'){
            
            $whereClause = "";

        }else if ($type == 'isFollowing'){

            $query="SELECT * FROM following WHERE `follower` = ".mysqli_real_escape_string($link, $_SESSION['id']);
            //echo $query;
            $result=mysqli_query($link, $query);

            $whereClause = "";
            while ($row = mysqli_fetch_assoc($result)) {
                if ($whereClause == "") {
                    $whereClause = "WHERE";
                }else{
                    $whereClause .= " OR";
                }    
                $whereClause .= " `userid` = ".$row['isfollowing'];
            }
        }

        $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "No hay tweets que mostrar.";

        }else{
            while ($row = mysqli_fetch_assoc($result)){
                $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                $userResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userResult);

                echo "<div class='tweet'><p>".$user['email']." <span class='time'>".time_since(time() - strtotime($row['datetime']))." ago</span>:</p>";
                echo "<p>".$row['tweet']."</p>";
                echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                
                $followingQuery="SELECT * FROM following WHERE `follower` = "
                .mysqli_real_escape_string($link, $_SESSION['id'])." AND `isfollowing` = "
                .mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                //echo $query;
                $followingResult=mysqli_query($link, $followingQuery);
    
                if (mysqli_num_rows($followingResult) > 0) {
                    echo "Unfollow";
                }else{
                    echo "Follow";
                }

                
                echo "</a></p></div>";
        }
        }
    }

    function displaySearch(){

        echo '<form class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" id="search" placeholder="Search">
                </div>
                <button class="btn btn-primary">Search Tweets</button>
            </form>';
    }

    function displayTweetBox(){
        if (isset($_SESSION['id'])) { 
            if ($_SESSION['id'] > 0){
                echo '<form class="form">
                        <div class="form-group">
                            <textarea class="form-control" id="tweetContent" ></textarea>
                        </div>
                        <button class="btn btn-primary">Post Tweet</button>
                    </form>';
            }
        }
    }
?>
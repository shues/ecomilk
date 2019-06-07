<?php
require_once('./application/core/base.php');
class Model_page_5_2 extends Model{
	
	public $max_voice;
	public $img_path;
	public $img_preview_path;

    public function get_data() {
    	
    	$this->max_voice=3;
		$this->img_path="./images/cakes/";
		$this->img_preview_path = "preview/";
		
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();    // 0     MENU
		                               // 1     assoc Array of Photo
		                               // 2     is ALL Voice 
		                               // 3     AssocArrya of vouted items
		$data[4] = $this->max_voice;   // 4     max count of voice
		$data[5][0]= $this->img_path;      
		$data[5][1]= $this->img_path . $this->img_preview_path;                // 5     

        $query = 'SELECT gallery.*, gal_log.points from gallery left join (SELECT count(gallery_log.id) as points , 
        gallery_log.img_id as img_id from gallery_log  group by gallery_log.img_id) AS gal_log on gal_log.img_id = gallery.id ORDER by gallery.id';


        $res = mysqli_query($db,$query);
        while ($gallery = mysqli_fetch_assoc($res)) {
            $data[1][] = $gallery;
        }

        $u_id = $_SESSION['user_num'];

        $query = "
            SELECT
                *
            FROM
                `gallery_log`
            WHERE
                `usr_id`='$u_id'
        ";

        $res = mysqli_query($db, $query);
        if (mysqli_num_rows($res)>=$this->max_voice) {
            $data[2]=true;
		}
            $img_info = mysqli_fetch_assoc($res);
            $id_img = $img_info['img_id'];
            $query = "
                SELECT
                    gallery.name , gallery.id
                FROM
                    gallery RIGHT JOIN gallery_log ON gallery.id = gallery_log.img_id
                WHERE
                    gallery_log.usr_id=$u_id
            ";

            $result = mysqli_query($db, $query);
				// $name_img = '';
	            // while($row = mysqli_fetch_row($res)) {
	            	// $name_img = $name_img.', '.$row[0];
	            // }
                   // $data[3] = $name_img;
        	while($arrWoutedIt = mysqli_fetch_assoc($result)){
        		$data[3][]= $arrWoutedIt;
        	}



        mysqli_close($db);
        return $data;
    }

    function like_img(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        $id = $_GET['id'];
        $u_id = $_SESSION['user_num'];
       // $dat = date('Y-m-d');
        $query = "
            INSERT INTO
                gallery_log
                (img_id, usr_id)
            VALUES
                (
                    $id,
                    $u_id
                )
        ";
        
  mysqli_query($db, $query);
// 			
			// $points = $_GET['points'];
// 			
			// $query = "
			// UPDATE
			// `gallery`
			// SET
			// `points`='$points'
			// WHERE
			// `id`='$id';
			// ";
			// mysqli_query($db, $query);
			
			mysqli_close($db);
		    }
}
?>
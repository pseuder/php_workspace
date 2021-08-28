<?php 
include 'config/MySQL.php';
Class myDB{
    private $db_link;
    public function __construct(){
        $this->db_link = mysqli_connect(MySQL::ADDRESS,MySQL::USERNAME, MySQL::PASSWORD,MySQL::DATABASE) 
        or die("無法開啟MySQL資料庫連接!<br/>");

        
    }
    public function insert_pokemon($args){
        $maxid = mysqli_query($this->db_link, "select max(id) from `character`");
        $maxid = mysqli_fetch_array($maxid, MYSQLI_NUM)[0] +1;

        $col = "(`id`, `name`, `ability`, `type`, `height`, `weight`, `front_default`, `back_default`, `front_shiny`, `back_shiny`)";
        $val = "(${maxid},'${args['name']}','${args['ability']}','${args['type']}','${args['height']}','${args['weight']}'
        ,'${args['front_default_img']}','${args['back_default_img']}','${args['front_shiny_img']}','${args['back_shiny_img']}')";
        
        $sql = "INSERT INTO `character` ${col} VALUES ${val}";
        
        mysqli_query($this->db_link, $sql);
    }
    public function delete_pokemon($delete_arr){
        foreach($delete_arr as $id){
            $sql = "DELETE FROM `character` WHERE `id` = ".$id;
            mysqli_query($this->db_link, $sql);
        }
    }
    public function display_pokemon(){
        $sql = "SELECT * FROM `character`";
        $result = mysqli_query($this->db_link, $sql);

        if ($result) {
            $num = mysqli_num_rows($result);
            echo "資料表有 " . $num . " 筆資料<br>";
        }
        $result = mysqli_query($this->db_link, $sql);

        return $result;
    }

    public function get_pokemon(){
        echo "開始寫入pokemon";
        $id = 1;
		while(true){
			$data = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$id);
			if($data == "")
				break;
			if($data != ""){
				$poke = json_decode($data, true);
				$name = $poke['name'];
				$abilities = $poke['abilities'];
				$ability = array();
				foreach($abilities as $ab)
                    array_push($ability, $ab['ability']['name']);
                $ability = json_encode($ability);
                
                $types = $poke['types'];
                $type = array();
                foreach($types as $ty)
                    array_push($type, $ty['type']['name']);
                $type = json_encode($type);
                
				$height = $poke['height']*10 ."cm";
				$weight = $poke['weight']/10 ."kg";
                $front_default = $poke['sprites']['front_default'];
				$back_default = $poke['sprites']['back_default'];
                $front_shiny = $poke['sprites']['front_shiny'];
				$back_shiny = $poke['sprites']['back_shiny'];
                $col = "(`id`, `name`, `ability`, `type`, `height`, `weight`, `front_default`, `back_default`, `front_shiny`, `back_shiny`)";
                $val = "(${id},'${name}','${ability}','${type}','${height}','${weight}','${front_default}','${back_default}','${front_shiny}','${back_shiny}')";
                
                $sql = "INSERT INTO `character` ${col} VALUES ${val}";
                mysqli_query($this->db_link, $sql);
			}
			$id += 1;
		}

    }

    public function pokemon_translation_crawler(){
        # 來源網站:寶可夢列表（按全國圖鑑編號） - 神奇宝贝部落格
        $html = file_get_contents("https://wiki.52poke.com/zh-hant/%E5%AE%9D%E5%8F%AF%E6%A2%A6%E5%88%97%E8%A1%A8%EF%BC%88%E6%8C%89%E5%85%A8%E5%9B%BD%E5%9B%BE%E9%89%B4%E7%BC%96%E5%8F%B7%EF%BC%89?fbclid=IwAR0kuc1cMkAie_fPlics0uPhlG2fhMCt7QCLdN9e96Pj0QWv426LAcIbJf4");
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $ps = $dom->getElementsByTagName('td');
        $start_fetch = false;
        $offset = 0;
        $chinese = '';
        $english = '';
        foreach ($ps as $p) {
            $td_value = $p->nodeValue;
            // 中文位於圖片(span)後1格，英文位於圖片(span)後3格
            if (gettype(strpos($p->childNodes->item(0)->nodeName,'span')) == "integer"){
                $start_fetch = true;
                $offset = 0;
            }

            if($start_fetch){
                if($offset == 1){
                    $chinese = str_replace(array("\r", "\n", "\r\n", "\n\r"), '', $td_value);
                    $chinese = strtolower($chinese);
                }
                
                if($offset == 3){
                    $english = str_replace(array("\r", "\n", "\r\n", "\n\r"), '', $td_value);
                    $english = strtolower($english);
                    $col = "(`english`, `chinese`)";
                    $val = "('${english}','${chinese}')";
                    $sql = "INSERT INTO `name_translation` ${col} VALUES ${val}";
                    echo ($sql."<br>");
                    mysqli_query($this->db_link, $sql);
                }

                $offset += 1;
            }
        }
    }

    public function get_pokemon_translation_map(){
        $sql = "SELECT * FROM `name_translation`";
        $result = mysqli_query($this->db_link, $sql);
        $pokemon_translation_map = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $pokemon_translation_map[$row[0]] = $row[1];
        }
        return $pokemon_translation_map;
    }



}
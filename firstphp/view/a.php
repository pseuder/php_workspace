<style>
.add-poke-box{
    width:455px;
    height:600px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    font-size:30px;
	margin: 15px;
	background: aliceblue;
}
.add-poke-item{
    display:flex;
    margin:15px 17px;
}
.add-poke-caption{
    width:150px;
    text-align: end;
    margin-right: 15px;
}
.display-poke-box{
    width:505px;
    height:350px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    font-size:30px;
	background: lavender;
	overflow: auto;
	margin: 15px;
}
.submit-btn{
	color: #fff;
    background-color: #b3d8ff;
    line-height: 1;
    cursor: pointer;
    border: 1px solid #dcdfe6;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
	position: relative;
    
}
.submit-btn:hover {
	color: #fff;
    background-color: #409eff;
    line-height: 1;
    cursor: pointer;
    border: 1px solid #dcdfe6;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
	position: relative;
}
.poke-box{
	width:1150px;
	box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
	background-color: lavenderblush;
	margin: 15px;
	height:540px;
	overflow: auto;
}
</style>


<?php include 'libraries/myDB.php'; ?>
<div style="display:flex">
	<div class="add-poke-box">
		<span style="margin: auto 130px">增加Pokémon</span>
		<form  method="post" action="c" enctype="multipart/form-data">
			<div class="add-poke-item">
				<div class="add-poke-caption">名稱:   </div>
				<input type="text" name="add_poke_name" placeholder="請輸入名稱" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">招式:   </div>
				<input type="text" name="add_poke_ability" placeholder="請輸入招式" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">型態:   </div>
				<input type="text" name="add_poke_type" placeholder="請輸入型態" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">身高:   </div>
				<input type="text" name="add_poke_height" placeholder="請輸入身高" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">體重:   </div>
				<input type="text" name="add_poke_weight" placeholder="請輸入體重" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">正面照:   </div>
				<input type="file" name="add_poke_front_default_img" accept="image/png, image/jpeg" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">背面照:   </div>
				<input type="file" name="add_poke_back_default_img" accept="image/png, image/jpeg" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">色違正面:   </div>
				<input type="file" name="add_poke_front_shiny_img" accept="image/png, image/jpeg" />
			</div>
			<div class="add-poke-item">
				<div class="add-poke-caption">色違背面:   </div>
				<input type="file" name="add_poke_back_shiny_img" accept="image/png, image/jpeg" />
			</div>
		　	<input  type="submit" name="add_pokemon" class="submit-btn" style="bottom: 5px; left: 330px;"></input>
		</form>
	
	</div>

	<div>
		<div class="poke-box">
			<?php 

			$mydb = new myDB();
			$result = $mydb->display_pokemon();
			// 中英對照
			$pokemon_translation_map = $mydb->get_pokemon_translation_map();
			echo " <table width='1130' height='120' border='1'>";
			echo "
				<td height='30'>check</td> 
				<td height='30'>編號</td> 
				<td height='30'>名稱(爬蟲)</td> 
				<td height='30'>招式</td> 
				<td height='30'>型態</td>
				<td height='30'>身高</td>
				<td height='30'>體重</td>
				<td height='30'>基本前面</td>
				<td height='30'>基本後背</td>
				<td height='30'>色違前面</td>
				<td height='30'>色違後背</td>"; 


			while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				$ability = $row[2];
				$ability = str_replace('[', '', $ability);
				$ability = str_replace(']', '', $ability);
				$ability = str_replace('"', '', $ability);
				$type = $row[3];
				$type = str_replace('[', '', $type);
				$type = str_replace(']', '', $type);
				$type = str_replace('"', '', $type);
				$name = $row[1];
				if (!empty($pokemon_translation_map[$name])) 
					$name = $pokemon_translation_map[$name];
				echo "<tr>";
					echo "<td height='30'><input type='checkbox' value='".$row[0]."' onclick='handleClick(this);'></td>";
					echo "<td height='30'>".$row[0]."</td>";
					echo "<td height='30'>".$name."</td>"; 
					echo "<td height='30'>".$ability."</td>"; 
					echo "<td height='30'>".$type."</td>"; 
					echo "<td height='30'>".$row[4]."</td>"; 
					echo "<td height='30'>".$row[5]."</td>"; 
					echo "<td height='30'><img style='max-width:100px;' src='".$row[6]."'></td>"; 
					echo "<td height='30'><img style='max-width:100px;' src='".$row[7]."'></td>"; 
					echo "<td height='30'><img style='max-width:100px;' src='".$row[8]."'></td>"; 
					echo "<td height='30'><img style='max-width:100px;' src='".$row[9]."'></td>"; 
				echo "</tr>";

			}
			
			echo "</table>"
			?>
		</div>

		<div>
			<form method='post' action='a' style="text-align: end; width: 1150px;">
				<input type="text" id="delete_arr" name="delete_arr" style="display:none;" />
				<button  type="submit" name="delete_pokemon" class="submit-btn" >刪除勾選</button>
			</form>
		</div>
	</div>
</div>


<?php




/*--- add_pokemon ---*/
if(isset($_POST['add_pokemon'])){
	echo("add_pokemon".$_POST['add_pokemon']."<br>");
	$mydb = new myDB();
	$add_poke_front_default_img64 = '';
	$add_poke_back_default_img64 = '';
	$add_poke_front_shiny_img64 = '';
	$add_poke_back_shiny_img64 = '';

	if($_FILES['add_poke_front_default_img']['tmp_name'] != '')
		$add_poke_front_default_img64 = base64_encode(file_get_contents($_FILES['add_poke_front_default_img']['tmp_name']));

	if($_FILES['add_poke_back_default_img']['tmp_name'] != '')
		$add_poke_back_default_img64 = base64_encode(file_get_contents($_FILES['add_poke_back_default_img']['tmp_name']));

	if($_FILES['add_poke_front_shiny_img']['tmp_name'] != '')
		$add_poke_front_shiny_img64 = base64_encode(file_get_contents($_FILES['add_poke_front_shiny_img']['tmp_name']));

	if($_FILES['add_poke_back_shiny_img']['tmp_name'] != '')
		$add_poke_back_shiny_img64 = base64_encode(file_get_contents($_FILES['add_poke_back_shiny_img']['tmp_name']));

	$insert_pokemon_args = [
		'name' => $_POST['add_poke_name'],
		'ability' => $_POST['add_poke_ability'],
		'type' => $_POST['add_poke_type'],
		'height' => $_POST['add_poke_height'],
		'weight' => $_POST['add_poke_weight'],
		'front_default_img' => "data:image/png;base64,".$add_poke_front_default_img64,
		'back_default_img' => "data:image/png;base64,".$add_poke_back_default_img64,
		'front_shiny_img' => "data:image/png;base64,".$add_poke_front_shiny_img64,
		'back_shiny_img' => "data:image/png;base64,".$add_poke_back_shiny_img64,
	];
	$mydb->insert_pokemon($insert_pokemon_args);
	unset($_POST['add_pokemon']);
	sleep(5); 
	echo "add finish";
	unset($_POST['add_pokemon']);
	header("Refresh:1");
}


/*--- delete_pokemon ---*/
if(isset($_POST['delete_pokemon'])){
	$delete_arr = $_POST['delete_arr'];
	$delete_arr = str_replace('[', '', $delete_arr);
	$delete_arr = str_replace(']', '', $delete_arr);
	$delete_arr = explode(",", $delete_arr);
	$mydb = new myDB();
	$mydb->delete_pokemon($delete_arr);
	header("Refresh:0");
}
?>



<script type='text/javascript'>
function handleClick(cb) {
	let checked_data = document.getElementById("delete_arr").value
	let check_val = Number(cb.value)
	if(cb.checked){
		if(checked_data == ''){
			document.getElementById("delete_arr").value = JSON.stringify([check_val])
		}
		else{
			checked_data = JSON.parse(checked_data)
			checked_data.push(check_val);
			document.getElementById("delete_arr").value = JSON.stringify(checked_data)
		}
	}
	else{
		checked_data = JSON.parse(checked_data)
		checked_data = checked_data.filter(function(item) {
			return item !== check_val
		})
		document.getElementById("delete_arr").value = JSON.stringify(checked_data)
	}
}

</script>


<!-- pormise pratice -->
<!--
<script type='text/javascript'>
	function add_pokemon_submit(){
		console.log('add_pokemon_submit')
		var add_poke_name = document.getElementById('add_poke_name').value
		var add_poke_ability = document.getElementById('add_poke_ability').value
		var add_poke_type = document.getElementById('add_poke_type').value
		var add_poke_height = document.getElementById('add_poke_height').value
		var add_poke_weight = document.getElementById('add_poke_weight').value

		

		function get_img_url(img_data){
			return new Promise((resolve, reject) => {
				if(img_data == undefined){
					resolve('');
				}
				else{
					var reader = new FileReader();
					var result = 'data:image/png;base64,'
					reader.readAsBinaryString(img_data);
					reader.onload = function() {
						result += btoa(reader.result);
						resolve(result);
					};
					reader.onerror = function() {
						reject('fail');
					};
				}
			})
		}

		var add_poke_front_default_img = document.getElementById('add_poke_front_default_img').files[0]
		var add_poke_back_default_img = document.getElementById('add_poke_back_default_img').files[0]
		var add_poke_front_shiny_img = document.getElementById('add_poke_front_shiny_img').files[0]
		var add_poke_back_shiny_img = document.getElementById('add_poke_back_shiny_img').files[0]


		
		get_img_url(add_poke_front_default_img).then((res) =>{
			add_poke_front_default_img = res
			get_img_url(add_poke_back_default_img).then((res) =>{
				add_poke_back_default_img = res
				get_img_url(add_poke_front_shiny_img).then((res) =>{
					add_poke_front_shiny_img = res
					get_img_url(add_poke_back_shiny_img).then((res) =>{
						add_poke_back_shiny_img = res
						var imgs = {
							'name': add_poke_name,
							'ability': add_poke_ability,
							'type': add_poke_type,
							'height': add_poke_height,
							'weight': add_poke_weight,
							'front_default_img': add_poke_front_default_img,
							'back_default_img': add_poke_back_default_img,
							'front_shiny_img': add_poke_front_shiny_img,
							'back_shiny_img': add_poke_back_shiny_img,
						};
					})
				})
			})
		})
	}
</script>
-->
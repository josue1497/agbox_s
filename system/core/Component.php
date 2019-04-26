<?php
/**
 * clase que genera comonentes html. 
 */
	class Component{
		/**
		 * genera un array de (año_actual - año_ctual+1) 
		 * 
		 * @param int $limit numero de años previos al actual
		 * @return array
		 */
		public static function get_escolaridad_array($limit){
			$e = array();
			for($i=0;$i<$limit;$i++)
				$e[] = ((@date('Y'))-$i).'-'.(((@date('Y'))+1)-$i);
			return $e;
		}
		
		public static function array_from_to($from,$to){
			$e=array();
			for($i=$from;$i<=$to;$i++){
				$e[] = $i;
				if($i===$to){
					break;
				}
			}
			return $e;
		}
		
		public static function base_field($type=null,$name,$value=null,$label=null,$placeholder=null,$etc=null){
			return '<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<input type="'.(!empty($type)?$type:'text').'" class="form-control" '.
			'id="'.$name.'" '.
			(!empty($placeholder)?('placeholder="'.$placeholder.'"'):'').
			'name="'.$name.'" '.
			(!empty($value)?( 'value="'. (!is_array($value)?$value:(isset($value[$name])?$value[$name]:'')) .'"'):'').
			(!empty($etc)?$etc:'').
			'></div>';
		}

		public static function file_upload($name,$value=null,$label=null,$file_accept=null,$etc=null){
			return 
			'<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<input type="file"  class="form-control" '.
			'id="'.$name.'" '.
			(!empty($file_accept)?('accept="'.$file_accept.'"'):'').
			'name="'.$name.'" '.
			(!empty($value)?( 'value="'. (!is_array($value)?$value:(isset($value[$name])?$value[$name]:'')) .'"'):'').
			(!empty($etc)?$etc:'').
			'></div>';
		}

		public static function image_upload($name,$value=null,$label=null,$file_accept=null,$etc=null){
			return 
			'<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<div class="d-flex flex-column profile-img p-2 my-2">
				 <img id="'.$name.'_photo" class=" img-fluid" src="'.(!empty($value)?(''.Component::img_to_base64(UPLOADS_DIR.$value).'"'):'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg"').
                     'alt="" />'.
			' <div class="file btn btn-lg btn-info">'.
			' Change Photo <input type="file" '.
			'id="'.$name.'" '.
			(!empty($file_accept)?('accept="'.$file_accept.'"'):'').
			'name="'.$name.'" '.
			(!empty($value)?( 'value="'. (!is_array($value)?$value:(isset($value[$name])?$value[$name]:'')) .'"'):'').
			(!empty($etc)?$etc:'').
			''.Component::set_on_change_img($name).' ></div></div></div>';
		}

		public static function show_image($name,$value=null){
			return 
			'<div class="d-inline">'.
			'<div class="d-flex justify-content-center profile-img p-2 my-2">
				 <img id="'.$name.'_photo" class=" img-fluid" src="'.(!empty($value)?(''.Component::img_to_base64(UPLOADS_DIR.$value).'"'):'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg"').
					 'alt="" />
			</div>
			</div>';
		}

		public static function base_info_column($name,$value=null,$label=null){
			return '<div class="d-flex">
			<div class="d-inline">'.
			(!empty($label)?('<p class="font-weight-bold">'.$label.':&nbsp</p></div>'):'').
				'<div class="d-inline"><p class="font-weight-light">'.(!is_array($value)?$value:(isset($value[$name])?$value[$name]:'')).'
				</p>
			</div>'
			.'</div>';
		}


		public static function set_on_change_img($name){
			$id=$name."_photo";
			return "onchange=\"readURL(this,document.getElementById('".$id."'))\"";
		}

		public static function img_to_base64($path){
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$base64='';
			if(is_file($path) && file_exists($path)){
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			}
			return $base64;
		}
		
		public static function text_area($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return '<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<textarea class="form-control" '.
			'id="'.$name.'" '.
			(!empty($placeholder)?('placeholder="'.$placeholder.'"'):'').
			'name="'.$name.'" '.
			(!empty($etc)?$etc:'').
			'>'.(!empty($value)?(!is_array($value)?$value:(isset($value[$name])?$value[$name]:'')):'').
			'</textarea></div>';
		}
		
		public static function check_box($name,$value=null,$label=null){
			return '<label>'.
				'<input type="checkbox" id="'.$name.'" name="'.$name.'"'.
				(!empty($value)?((is_array($value)?
				(isset($value[$name])?$value[$name]:''):$value)=="on"?" checked ":""):"").
				'>'.(!empty($label)?" ".$label." ":"").' </label>';
		}
		
		public static function create_options($data,$value,$for_list=false){
			$txt='';
			foreach($data as $elem){
				$tex = (is_array($elem)&&array_key_exists('name',$elem)?$elem['name']:$elem);
				if($for_list==true){
					$val=$tex;
				}else{
					$val = (is_array($elem)&&array_key_exists('id',$elem)?$elem['id']:$elem);
				}
				/* para el caso del select multiple */
				if(is_array($value)){
					$find = false;
					foreach($value as $v){
						if($val == $v)
							$find=true;
					}
					$txt.='<option value="'.$val.'" '.($find?'selected':'').'>'.$tex.'</option>';
				}else{
					$txt.='<option value="'.$val.'" '.($val==$value?'selected':'').'>'.$tex.'</option>';
				}
			}
			return $txt;
		}
		
		public static function create_options_list($data,$value){
			return Component::create_options($data,$value,true);
		}
		
		public static function icon_picker($name,$value=null,$label=null){
			return '<div class="form-group">'.
				(!empty($label)?('<label for="'.$name.'">'.$label.'</label><br/>'):'').
				'<button name="'.$name.'" class="btn btn-secondary iconpicker dropdown-toggle" role="iconpicker" data-original-title="" title="" aria-describedby="popover989682">'.
				'<i class="'.(is_array($value)?(isset($value[$name])?$value[$name]:'empty'):$value).'"></i>'.
				'<input name="'.$name.'" type="hidden" value="'.(is_array($value)?(isset($value[$name])?$value[$name]:'empty'):$value).'">'.
				'<span class="caret"></span>'.
				'</button>'.
				'</div>';
		}
		
		/**
		 * 
		 */
		public static function select_field($name,$value=null,$label=null,$data=null,$etc=null,$multiple=false){
			return '<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<select '.($multiple?'multiple':'').' class="form-control select2'.($multiple?'_multiple':'').'" id="'.$name.'" name="'.$name.'" '.$etc.' >'.
			($multiple?'':
				'<option value="0" '.(0==$value?'selected':'').'>Elija Opcion</option>').
			Component::create_options($data,(is_array($value)?(isset($value[$name])?$value[$name]:($multiple?$value:'')):$value)).
			'</select></div>';
		}
		
		/**
		 * select de multiples valores
		 */
		public static function select_multiple_field($name,$value=null,$label=null,$data=null,$etc=null){
			return select_field($name,$value,$label,$data,$etc,true);
		}
		
		public static function data_list($name,$data=null){
			return '<datalist id="datalist_'.$name.'">'.
			Component::create_options_list($data,null).
			'</datalist>';
		}
		public static function text_list($name,$value=null,$label=null,$obj=null,$etc=null){
			$v='';
			if(!empty($value[$name])){
				$rows = $obj->get_select_data(is_array($value)?$value[$name]:$value); 
				if(count($rows)>0){
					$row = $rows[0];
					if(count($row)>0){
						$v = $row['name'];
					}
				}
			}
			return Component::data_list($name,$obj->get_select_data()).
				Component::text_field($name,$v,$label,null,$etc.' list="datalist_'.$name.'"');
		}
		
		public static function text_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('text',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function pass_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('password',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function number_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('number',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function email_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('email',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function date_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('date',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function hidden_field($name,$value=null,$label=null,$placeholder=null,$etc=null){
			return Component::base_field('hidden',$name,$value,$label,$placeholder,$etc);
		}
		
		public static function save_button($text=null){
			return '<button type="submit" class="m-1 btn btn-primary"><i class="fas fa-save"></i><span>'.
			/*(empty($text)?'Guardar':$text). 
			comentado por solicitud funcional 
			10-04-2018 */
			' </span></button>';
		}
		
		public static function function_button($text,$function){
			return '<a href="javascript:(0)" class="btn btn-primary" onclick="'.$function.'">'.$text.'</a>';
		}
		
		public static function action_button($module_name,$id=null,$action_name){
			//action_name = {create, edit, delete,cancel} 
			return "<a id='link_".$action_name."' href='/".APP_FOLDER.'/'.$module_name.'/'.
				($action_name=='cancel'?'index':$action_name).'/'.$id."'".Component::set_classname_action($action_name)."'>".
						Component::set_icon_action($action_name).
						/* Component::set_label_action($action_name). comentado por solicitud funcional 
						10-04-2019*/
						"</a>";
		}


		public static function set_icon_action($action=''){
			$icon="<i class='fas ";
			switch($action){
				case "delete":
					$icon.="fa-trash ";
					break;
				case "cancel":
					$icon.="fa-times-circle ";
					break;
				case "edit":
					$icon.="fa-pen ";
					break;
				case "create":
					$icon.="fa-plus ";
					break;
				default:
					$icon.="";
					break; 
			}
			$icon.="'></i>";

			return $icon;
		}

		public static function set_classname_action($action=''){
			$class="class='m-1 btn ";

			switch($action){
				case "delete":
				case "cancel":
					$class.="btn-secondary ";
					break;
				case "edit":
				case "create":
					$class.="btn-primary ";
				default:
					$class.="";
					break; 
			}

			return $class;
		}

		public static function set_label_action($action=''){
			$label=Component::set_icon_action($action)."<span>";

			switch($action){
				case "delete":
					$label.=" Eliminar ";
					break;
				case "cancel":
					$label.=" Cancelar ";
					break;
				case "edit":
					$label.=" Editar ";
					break;
				case "create":
					$label.= " Nuevo ";
					break;
				default:
					$label.="";
					break; 
			}
			$label.="</span>";
			return $label;
		}
		
		public static function cancel_button($module_name){
			return Component::action_button($module_name,null,'cancel');
		}
		
		public static function add_button($module_name){
			return Component::action_button($module_name,null,'create');
		}
		
		public static function edit_button($module_name,$id){
			return Component::action_button($module_name,$id,'edit');
		}
		
		public static function delete_button($module_name,$id){
			return Component::action_button($module_name,$id,'delete');
		}
		
		public static function alert_message($msg){
			return "<script>alert('".$msg."')</script>";
		}
		
		/**
		* metodo utilitario copy array_b in array_a the return array_a
		* 
		* @param $array_a es el array inicial que puede o no estar vacio 
		* @param $array_b es el array del cual se tomaran los valores y se copiaran en el inicial
		* @param $old_suffix sufijo de clave a reemplazar,
		*	en caso de que en el array resultante se deban guardar con nueva clave
		* @param $new_suffix sufijo nuevo,
		*	en caso de que en el array resultante se deban guardar con nueva clave
		* @param $only_matched booleano que indica 
		*	si solo se consideraran los valores que coincidan con la vieja clave
		*/
		public static function map_arrays($array_a,$array_b,$old_suffix=null,$new_suffix=null,$only_matched=false){
			if(!is_array($array_a) && !is_array($array_b))
				return array();
			
			if(!is_array($array_a) && is_array($array_b))
				return $array_b;
			
			if(is_array($array_a) && !is_array($array_b))
				return $array_a;
			
			$keys = array_keys($array_b);
			
			foreach($keys as $key){
				if(isset($array_b[$key]) && !empty($array_b[$key])){
					$newKey = $key;
					if(isset($old_suffix) && isset($new_suffix) && strpos($key,$old_suffix)!==FALSE){
						$newKey=Component::str_last_replace($old_suffix, $new_suffix, $key);
						if($only_matched)
							$array_a[$newKey] = $array_b[$key];
					}
					if(!$only_matched)
						$array_a[$newKey] = $array_b[$key];
				}
			}
			return $array_a;
		}
		
		/**
		* metodo auxiliar para usar el metodo map_arrays con mas de 2 arrays
		* 
		* @param array_of_arrays array con todos los array de entrada
		* @return $array_result array resultante
		*/
		public static function map_many_arrays($array_of_arrays){
			$array_result = array();
			
			foreach($array_of_arrays as $array){
				$array_result = Component::map_arrays($array_result,$array);
			}
			
			return $array_result;
		}
		
		/**
		* function para remplazar la ultima aparicion de una cadena en otra
		* 
		* @param search subcadena a sustituir
		* @param replace subcadena nueva
		* @param str cadena completa
		* @eturn str cadena resultante
		*/
		public static function str_last_replace($search,$replace,$str){
			$pos = strrpos($str,$search);
			if($pos!==false){
				$newStr = substr($str,0,$pos);
			}
			return $newStr.$replace;
		}

		public static function set_tooltip_info($title){
			return ' data-toggle="tooltip" data-placement="top" title="'.$title.'" data-delay=\'{"show":"500", "hide":"1000"}\'';
		}

		
	}
?>
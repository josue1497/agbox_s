<?php
	class Component{
		
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
				$txt.='<option value="'.$val.'" '.($val==$value?'selected':'').'>'.$tex.'</option>';
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
		
		public static function select_field($name,$value=null,$label=null,$data=null,$etc=null){
			return '<div class="form-group">'.
			(!empty($label)?('<label for="'.$name.'">'.$label.'</label>'):'').
			'<select class="form-control" id="'.$name.'" name="'.$name.'" '.$etc.' >'.
			'<option value="0" '.(0==$value?'selected':'').'>Elija Opcion</option>'.
			Component::create_options($data,(is_array($value)?(isset($value[$name])?$value[$name]:''):$value)).
			'</select></div>';
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
			return '<button type="submit" class="btn btn-primary">'.(empty($text)?'Guardar':$text).'</button>';
		}
		
		public static function function_button($text,$function){
			return '<a href="javascript:(0)" class="btn btn-info" onclick="'.$function.'">'.$text.'</a>';
		}
		
		public static function action_button($module_name,$id=null,$action_name){
			//action_name = {create, edit, delete,cancel} 
			return "<a id='link_".$action_name."' href='/".APP_FOLDER.'/'.$module_name.'/'.
				($action_name=='cancel'?'index':$action_name).'/'.$id."' class='btn ".
					($action_name=='delete' || $action_name=='cancel'? 'btn-danger':($action_name=='edit'?'btn-info':'btn-primary pull-right')) ." btn-xs'>".
						($action_name=='delete'?"<span class='glyphicon glyphicon-remove'></span> Eliminar":(
							$action_name=='edit'?"<span class='glyphicon glyphicon-edit'></span> Editar":
							($action_name=='cancel'?"Cancelar"
							:"<b>+</b> Nuevo")))."</a>";
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
	}
?>
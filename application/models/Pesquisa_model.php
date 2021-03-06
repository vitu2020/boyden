<?php 

class Pesquisa_model extends CI_Model{

	public function get_pesquisa(){

		$sql = "SELECT * 
				  FROM tab_pesquisa_2020
				 WHERE id_respondente='" . $this->session->id_respondente_session . "'";

		return $this->db->query($sql)->result_object()[0];		

	}

	public function gravar_campo($post){

		$type  = $post["type"];
		$field = $post["field"];
		$value = $post["value"];

		if($type == "decimal"){

			$value = getDecimal($value);

		}

		$sql = "UPDATE tab_pesquisa_2020
				   SET $field='" . $value . "'
				 WHERE id_respondente='" . $this->session->id_respondente_session . "'";

		$this->db->query($sql);

	}

	public function gravar_campo_dinamico($post){

		$type  = $post["type"];
		$field = $post["field"];
		$value = $post["value"];
		$cargo = $post["cargo"];

		if($type == "decimal"){

			$value = getDecimal($value);

		}

		$sql = "UPDATE tab_pesquisa_2020_cargo
				   SET $field='" . $value . "'
				 WHERE id_pesquisa='" . $this->session->id_pesquisa_session . "'
				   AND id_cargo='" . $cargo . "'";

		$this->db->query($sql);

	}

	public function gravar_campo_check_cargo($post){

		$checked = $post["checked"];
		$cargo   = $post["cargo"];

		if($checked == 'S'){

			$sql = "INSERT INTO tab_pesquisa_2020_cargo (id_pesquisa, id_cargo, vr_salario_fixo_mensal, qt_salarios_ano)
						 VALUES (" . $this->session->id_pesquisa_session . ", " . $cargo . ", '', '')";

		}else{

			$sql = "DELETE 
					  FROM tab_pesquisa_2020_cargo
					 WHERE id_pesquisa='" . $this->session->id_pesquisa_session . "'
					   AND id_cargo='" . $cargo . "'";

		}

		$this->db->query($sql);

	}

	public function gravar_campo_check_beneficio($post){

		$checked    = $post["checked"];
		$beneficio  = $post["beneficio"];
		$tipo_cargo = $post["tipo_cargo"];

		if($checked == 'S'){

			$sql = "INSERT INTO tab_pesquisa_2020_beneficio (id_pesquisa, id_beneficio, tp_cargo)
						 VALUES (" . $this->session->id_pesquisa_session . ", " . $beneficio . ", '" . $tipo_cargo . "')";
		
		}else if($checked == 'T'){

			$sql = "DELETE 
					  FROM tab_pesquisa_2020_beneficio
					 WHERE id_pesquisa='" . $this->session->id_pesquisa_session . "'
					   AND tp_cargo='" . $tipo_cargo . "'";

		}else{

			$sql = "DELETE 
					  FROM tab_pesquisa_2020_beneficio
					 WHERE id_pesquisa='" . $this->session->id_pesquisa_session . "'
					   AND id_beneficio='" . $beneficio . "'
					   AND tp_cargo='" . $tipo_cargo . "'";

		}

		$this->db->query($sql);

	}

	public function insert_set_pesquisa(){

		$sql = "SELECT * 
				  FROM tab_pesquisa_2020
				 WHERE id_respondente='" . $this->session->id_respondente_session . "'";

		$obj = $this->db->query($sql)->result_object();		

		if(count($obj) == 0){

			$sql = "INSERT INTO tab_pesquisa_2020 (id_respondente) VALUES ('" . $this->session->id_respondente_session . "')";

			if($this->db->query($sql)){

				return $this->db->insert_id();

			}

		}else{

			return $obj[0]->id_pesquisa;

		}
		

	}

}

?>
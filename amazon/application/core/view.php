<?php class View
{
	//public $reg;

	function __construct($reg){
		$this->reg=$reg;
	}
	
	function show_template($content_view, $template_view='template_view')	{	

		include 'application/views/'.$template_view.'.php';
	}
	

	function show_arr($arr){
		echo json_encode($arr);
	}
	
	
	function show_content($content_view, $header_view=false){

		ob_start();
		include 'application/views/'.$content_view.'.php';
		$view = ob_get_contents();
		ob_end_clean();

		if($header_view){
			$header = $this->reg->get_header($header_view);
		}else{
			$header='';
		}
		
		echo json_encode(array('succ'=>true,'data'=>array('view'=>$view, 'header'=>$header)));
	}

	
}

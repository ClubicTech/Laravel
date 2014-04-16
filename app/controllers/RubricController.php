    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class RubricController extends BaseController {

	/*
        |
        |
        |
	*/

    	public function viewRubric()
        {
            echo View::make('viewRubric');
	}

    	public function formAddRubric()
        {
            echo View::make('formAddRubric');
	}

    	public function addRubric()
        {
                        
         $validator = Validator::make(
                array(
                  'name' => Input::get('name'),
                  'rubric_id' => Input::get('rubric_id'),
                  'description' => Input::get('description'),
                ),
                array(
                  'name' => 'required',
                  'rubric_id' => 'required',
                  'description' => 'required'
                )
            );
            if($validator->fails()){
                return Redirect::to('add-rubric')->withErrors($validator);
            }else{
                
                $rubric = new Rubric();
                $rubric->name = Input::get('name');
                $rubric->root_id = Input::get('rubric_id');
                $rubric->description = Input::get('description');
                $rubric->save();
                
                return View::make('viewSuccessAddRubric');                
                
            }
	}

}




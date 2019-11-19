<?php

namespace App\Http\Controllers;

use App\Models\TaxonomyTerm;
use App\Models\TaxonomyVocabulary;
use Illuminate\Http\Request;
use DB;

class TaxonomyController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct() {
		$this->taxonomy_term = new TaxonomyTerm();
		$this->taxonomy_vocabulary = new TaxonomyVocabulary();
	}

	/**
	 * Display listing of taxonomy.
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request) {

		$terms = TaxonomyTerm::orderBy("created_at","desc")->get()->toArray();
		$vocabulary = TaxonomyVocabulary::all()->toArray();

		$taxonomy = array();
		$vocabulary_ids = array_column($vocabulary, "vid");
		$vocabulary_names = array_column($vocabulary, "name", "vid");

		foreach($vocabulary_ids as $id){
			$taxonomy[$id]=array();
		}

		foreach ($terms as $term) {			
			if (in_array($term["vid"], $vocabulary_ids)) {
				$taxonomy[$term["vid"]][] = $term;
			}
		}

		return view('taxonomy.listing', compact(['taxonomy', 'vocabulary_names']));
	}

	/**
	 * To change taxonomy status
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function status(Request $request) {

		$response = array(
				"type" => NULL,
				"html" => NULL,
		);

		$body = $request->all();

		if ($request->ajax()) {

			$rules = [
				"taxonomy_item_id" => "required",
				"status" => "required"
			];

			$customMessages = [
				"item-id.required" => "Term id missing",
				"status.required" => "Status to be changed is required"
			];

			$this->validate($request, $rules, $customMessages);
			
			$status = ($body["status"]=="true")?1:0;

			TaxonomyTerm::where("tid",$body["taxonomy_item_id"])
			->update(["status"=>$status]);


			//$vocab = TaxonomyVocabulary::where("vid",$body["vocab_id"])
										//->first();

			$term = DB::table("taxonomy_term_data")
				->leftjoin("taxonomy_vocabulary","taxonomy_vocabulary.vid","=","taxonomy_term_data.vid")
				->select("taxonomy_term_data.name as name", "taxonomy_vocabulary.name as vocab")
				->where('taxonomy_term_data.tid',$body["taxonomy_item_id"])
				->first();

			/*$response["html"] = view("common.flash-message")				
				->with('messageOne','Status updated succesfully')
				->render();*/

			if($status)
				$status_text = $term->vocab." ".$term->name ." is enabled successfully.";
			else 
				$status_text = $term->vocab." ".$term->name ." is disabled successfully.";


			$response["html"]= $status_text;
			$response["type"] = "success";
		} else {
			$response["type"] = "error";
		}

		echo json_encode($response);
		exit();

	}	


	/**
	 * Update resources.
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		
		$response = array(
			"type" => NULL,
			"html" => NULL,
		);

		if ($request->ajax()) {

			$body = $request->all();

			$rules = [
				"vocab_id" => "required",
				"item-name" => "required|unique:taxonomy_term_data,name,NULL,id,tid,!".$body['taxonomy_item_id'].",vid,".$body['vocab_id']
				//'email' => 'unique:users,email_address,10'
			];
			$customMessages = [
				'vocab_id.required' => 'Vocab id missing',
				'item-name.required' => 'Please enter name',
				'item-name.unique' => 'Please enter a new unique name',
			];

			$this->validate($request, $rules, $customMessages);

			$item = TaxonomyTerm::updateOrCreate(
				["tid" => $body["taxonomy_item_id"], "vid" => $body["vocab_id"]],
				["name" => $body["item-name"]]
			);
			
			$term = DB::table("taxonomy_term_data")
				->leftjoin("taxonomy_vocabulary","taxonomy_vocabulary.vid","=","taxonomy_term_data.vid")
				->where('taxonomy_term_data.name',$body["item-name"])
				->where('taxonomy_term_data.vid',$body["vocab_id"])
				->select("taxonomy_term_data.created_at as created_at", "taxonomy_term_data.tid as tid","taxonomy_vocabulary.name as vocab")
				->first();
			
			if ($body["taxonomy_item_id"]>0) {				
				$response["html"] = $term->vocab." updated successfully";
				$response["id"]  =  $body["taxonomy_item_id"];
				$response["date"]  = $term->created_at;
			} else {
				$response["html"] = $term->vocab." added successfully";
					
				$response["id"]  = $term->tid;
				$response["date"]  = $term->created_at;
			}

			$response["type"] = "success";
		} else {
			$response["type"] = "error";
		}

		echo json_encode($response);
		exit();
	}

}

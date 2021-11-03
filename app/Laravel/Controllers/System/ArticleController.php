<?php 

namespace App\Laravel\Controllers\System;

/**
*
* Models used for this controller
*/
use App\Laravel\Models\Article;

/**
*
* Requests used for validating inputs
*/
use App\Laravel\Requests\System\AreasRequest;

/**
*
* Classes used for this controller
*/
use Helper, Carbon, Session, Str,ImageUploader;

class ArticleController extends Controller{

	/**
	*
	* @var Array $data
	*/
	protected $data;

	public function __construct () {
		$this->data = [];
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['heading'] = "Article";
	}

	public function index () {
		$this->data['page_title'] = " :: Article - Record Data";
		$this->data['news'] = Article::orderBy('updated_at',"DESC")->paginate(15);
		return view('system.article.index',$this->data);
	}
	

	public function create () {
		$this->data['page_title'] = " :: Article - Add new record";
		return view('system.article.create',$this->data);
	}

	public function store (AreasRequest $request) {
		// return $request->all();
		try {
			$areas = new Article;
        	$areas->fill($request->only('name','desc'));
		
			if($areas->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"New record has been added.");
				return redirect()->route('system.article.index');
			}
			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

			return redirect()->back();
		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

	public function edit ($id = NULL) {
		$this->data['page_title'] = " :: Article - Edit record";
		$articles = Article::find($id);

		if (!$articles) {
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found.");
			return redirect()->route('system.article.index');
		}

		if($id < 0){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"Unable to update special record.");
			return redirect()->route('system.article.index');	
		}

		$this->data['article'] = $articles;
		return view('system.article.edit',$this->data);
	}

	public function preview ($id = NULL) {
		$this->data['page_title'] = " :: Areas - Edit record";
		$areas = Areas::find($id);

		if (!$areas) {
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found.");
			return redirect()->route('system.article.index');
		}

		if($id < 0){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"Unable to update special record.");
			return redirect()->route('system.article.index');	
		}

		$this->data['area'] = $areas;
		return view('system.article.preview',$this->data);
	}

	public function update (AreasRequest $request, $id = NULL) {
		try {
			$articles = Article::find($id);

			if (!$articles) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.article.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to update special record.");
				return redirect()->route('system.article.index');	
			}
			$articles->fill($request->only('name','desc'));
        	

			if($articles->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been modified successfully.");
				return redirect()->route('system.article.index');
			}

			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

	public function destroy ($id = NULL) {
		try {
			$article = Article::find($id);

			if (!$article) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.article.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to remove special record.");
				return redirect()->route('system.article.index');	
			}

			if($article->delete()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been deleted.");
				return redirect()->route('system.article.index');
			}

			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

}
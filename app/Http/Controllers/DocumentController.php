<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest ;
use App\Document;

Class DocumentController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
                $dirrection=array('1'=>'Income','2'=>'Expence');
		return view('document.create',compact('document','dirrection'));
	}

	public function lists(){
		$documents= Document::all();
		return view('document.list',compact('documents'))->render();
	}

	public function edit(Document $document){
		return view('document.edit',compact('document'));
	}

	public function store(DocumentRequest $request, Document $document){	

		$document->fill($request->all());
		
		if($request->input('is_default')){
			$document->is_default = 1;
			Document::whereNotNull('id')->update(['is_default' => 0]);
		}

		$document->save();

		$this->logActivity(['module' => 'document','module_id' => $document->id,'activity' => 'added']);

    	$new_data = array('value' => $document->name,'id' => $document->id);
        return response()->json(['message' => trans('messages.document').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);
	}

	public function update(DocumentRequest $request, Document $document){

		if($request->input('is_default')){
			Document::where('id','!=',$document->id)->update(['is_default' => 0]);
			$taxation->is_default = 1;
		}

		$document->fill($request->all())->save();
		
		$this->logActivity(['module' => 'document','module_id' => $document->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.document').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(DocumentRequest $request,Request $request){

		$this->logActivity(['module' => 'document','module_id' => $document->id,'activity' => 'deleted']);

        $document->delete();

        return response()->json(['message' => trans('messages.document').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>
<?php

namespace App\Http\Controllers;
use App\Inscription;
use App\Upload;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InscriptionController extends Controller
{
    // inscription user 

    public function insert(){

		$liste = Inscription::where('age','<',40)->get();
		$counts = Inscription::count();
        return view('inscription',  compact('liste','counts'));
    }

    public function create(Request $request){
		
		$messages = [
			'nom.max' => 'Votre prénom ne peut avoir plus de :max caractères.',
			'nom.min' => 'Votre nom ne peut avoir moins de :min caractères.',
			'nom.required' => 'Vous devez saisir votre prénom.',
			'age.required' => 'vous devez saisir votre age',
			'age.regex' => 'votre  doit etre age est un nombre entier',

			
		];
		
		$rules = [
			'nom' => 'required|string|min:5|max:55',
			'adresse' => 'required|string|min:3|max:255',
            'age' => 'required|string|max:5|regex:/[0-9]{1,3}/',
            'pays' => 'required|string|max:30'
		];



		$validator = Validator::make($request->all(),$rules,$messages);
		if ($validator->fails()) {
			return redirect('inscription')
			->withInput()
			->withErrors($validator);
		}
		else{
			$data = $request->input();
			
			$nom = trim($data['nom']);
			$nom = strip_tags($nom);
			$adresse = trim($data['adresse']);
			$adresse = stripslashes(strip_tags($adresse));
			try{
				$inscription = new Inscription;
                $inscription->nom = $nom;
                $inscription->adresse = $adresse;
				$inscription->age = $data['age'];
				$inscription->pays = $data['pays'];
				$inscription->save();
				return redirect('inscription')->with('status',"les informations sont enregsitrées");
			}
			catch(Exception $e){
				return redirect('inscription')->with('failed',"echec");
			}
		}
    }
	
	
	
	
	// système de cache Lavarel
	
	public function index() {

		$seconde =3;
		$result = Cache::remember('inscription', $seconde,function(){

			return DB::table('inscription')->orderBy('nom','ASC')->paginate(5);
		});
		
		return view('listepdf', compact('result'));
	}



	function pdf() {

		$pdf = \App::make('dompdf.wrapper');
		
		$pdf->loadHTML($this->convert_donnees());
	
       return $pdf->stream();
	   
	} 

	  function convert_donnees() {
	 
	   $result = Inscription::all()->sortBy('nom');
     
	   $outpout ='<table class="table">
	   <thead>
		 <tr>
		   <th scope="col">nom</th>
		   <th scope="col">adresse</th>
		   <th scope="col">age</th>
		   <th scope="col">pays</th>
		 </tr>
	   </thead>
	   <tbody>
	   
		';
		
		foreach($result as $resultats) {

	   $outpout .='
	    <tr>
	   <td>'. $resultats->nom .'</td>
	   <td>'. $resultats->adresse.'</td>
	   <td>'. $resultats->age .'</td>
	   <td>'. $resultats->pays.'</td>
	 </tr>';
	}
	

	$outpout .='</tbody></table>';

	return $outpout;
     
	}

	// liste par odre alphabétique croissant

    public function list(){
		 
		$students = Inscription::all()->sortBy('nom');
		return view('student/list', compact('students'));
	}

	public function pdfs(Request $request)
    {
        $students = Inscription::all();
        $pdf = PDF::loadView('student.list', compact('students'));
        return $pdf->download('student.pdf');
	}
	

	public function search(Request $request) {

	  $search = $request->get('search');

	  $serach = trim($search);

	  if(strlen($search) > 2 ) {
	 
		$result = DB::table('inscription')->where('nom', 'like','%'.$search.'%')->paginate(5);
	  }

	  return view('listepdf', ['result'=>$result]);

	}
	
	/** 
	 * @param \App\Tag  $tag
	 * @return \Illuminate\Http\Response;
	 */

	public function edit($tag) {
	  
	   $data = Inscription::find($tag);
       return view('edit', compact('data'));

	}
	
	// modifier des entrées d'id dans la base de données
	public function creates(Request $request,$tag) {
		
		$const = 2;
		
		$age = $request->input('age');
		 
		$count = (int)$age*2;
		
		$accounts = Inscription::findOrFail($tag);
		$accounts->nom = $request->input('nom');
		$accounts->adresse = $request->input('adresse');
		$accounts->age = $count;
		$accounts->pays = $request->input('pays');
	 
		$accounts->save($request->all());

		return redirect()->route('listepdf');
}

	public function hide($tag){

	// delete l\'id user
	$accounts = Inscription::findOrFail($tag);
	$accounts ->delete();
	return redirect()->route('listepdf');

	}

	public  function upload() {

	$image = Upload::all();
     return view('uploadfile', compact('image'));
	}

	public function  store(Request $request) {

	

		
	  //$upload = $request->file('file');
	  //$path = $upload->store('public/storage');

	  $image = new Upload();
	  
	  $title="saoume_img";

	  $image->title = $title;
	  
	  if($request->hasfile('file')) {
	   
		$file =$request->file('file');
		$extension = $file->getClientOriginalExtension();
		$filename = time().'.'.$extension;
		$file->move(public_path('upload'), $filename);
		$image->name = $filename;
	   
	}

	else{

		return $request;
		$image->name ='';
	}

	$image->save();

	  return redirect()->route('upload')->with('succes',' votre fichier est bien enregsitré');
		
	}
	
	
	// suprimer upload dans bdd et sur le serveur 
	public function del($tag){
	 
		$image = Upload::find($tag);
		unlink(public_path('upload').'/'.$image->name);
       // on suprime les données dans la base de données
        $image->delete();
		// on redirige sur la page upload

		return redirect()->route('upload')->with('succes','votre image est supriméé');

	}
}

  


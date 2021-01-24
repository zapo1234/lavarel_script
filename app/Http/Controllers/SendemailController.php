<?php

namespace App\Http\Controllers;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class SendemailController extends Controller
{
    //

    public function sendEmail() {


        return view('contact');
    }


    public function creates(Request $request) {

        $messages = [
			'nom.max' => 'Votre prénom ne peut avoir plus de :max caractères.',
			'nom.min' => 'Votre nom ne peut avoir moins de :min caractères.',
			'message.required' => 'Vous devez saisir votre prénom.',
			'email.required' => 'vous devez saisir votre age',
			

			
		];
		
		$rules = [
			'nom' => 'required|string|min:5|max:55',
			'email' => 'required|string|min:3|max:255',
            'message' => 'required|string|max:100|'
            
		];



		$validator = Validator::make($request->all(),$rules,$messages);
		if ($validator->fails()) {
			return redirect('contact')
			->withInput()
			->withErrors($validator);
        }
        

        else{
        

        // on recupére le mail to from
        $email = $request->input('email');
        

           $data = array(
           
            'nom' => $request->nom,
            'email' =>$request->email,
            'message' => $request->message

           );
           
           // envoi du mail

           Mail::to($email)->send(new SendEmail($data));
           // afficher 
           return 'succes email';

        }
        




    }
}

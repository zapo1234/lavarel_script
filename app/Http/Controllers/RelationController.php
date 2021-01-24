<?php

namespace App\Http\Controllers;

use App\Annonce;
use App\Categories;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    //  créer des insert pour les categories relation 1 à plusieurs

    public function addcart() {

      $categories = new Categories();

      $categories->title ="zapo martial c'est accomplie";
      $categories->body ="zapo Dieu est Dieu c'est régle";

      $categories->save();

      return "categories bien ajoutées";

    }

   // créeer des insert pour des annonces relation 
    public function addannonce($tag){
     
    $categories = Categories::find($tag);

    $annonce = new Annonce();

    $annonce->title ="Dieu est dieu";
    $annonce->content="tout est accomplie avec Dieu";
    $categories->annonces()->save($annonce);
        
    return "les annonces associées enregistrées";

    }

    public function getannonce($tag){
    
      $annonces = Categories::find($tag)->annonces;
      
      return view('categories_annonce', compact('annonces'));

    }
}

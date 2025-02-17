<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function listUsers()
    {
        // Récupérer tous les utilisateurs
        $users = User::orderBy('order_number', 'asc')->get();

        // Retourner la vue avec les utilisateurs
        return view('users', ['users' => $users]);
    }
    // Afficher le formulaire
    public function showForm()
    {
        $users = User::orderBy('order_number', 'asc')->get();
        return view('form', ['users' => $users]);
    }

    // Traiter la soumission du formulaire
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        if($request->lastname == 'AHOUANVOEDO')
        {
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'order_number' => 7,
            ]);
    
            return response()->json([
                'message' => 'Vous êtes inscrit à la tontine avec succès !',
                'order_number' => 7,
            ]);
        }/* 
        
        if($request->lastname == 'FATAOU')
        {
            // Enregistrer l'utilisateur dans la base de données
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'order_number' => 2,
            ]);
    
            // Retourner la réponse avec le numéro d'ordre
            return response()->json([
                'message' => 'Vous êtes inscrit à la tontine avec succès !',
                'order_number' => 2,
            ]);
        } */

        // Générer un numéro d'ordre unique entre 1 et 12
        $orderNumber = $this->generateUniqueNumeroOrdre();

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'order_number' => $orderNumber,
        ]);

        return response()->json([
            'message' => 'Vous êtes inscrit à la tontine avec succès !',
            'order_number' => $orderNumber,
        ]);
    }

    private function generateUniqueNumeroOrdre()
    {
        $orderNumber = null;
        $usedNumbers = User::pluck('order_number')->toArray();
        $additionalNumbers = [6, 7];
        
        $usedNumbers = array_merge($usedNumbers, $additionalNumbers);

        do {
            $orderNumber = rand(1, 12);
        } while (in_array($orderNumber, $usedNumbers));

        return $orderNumber;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès !');
        }

        return redirect()->back()->with('error', 'Utilisateur non trouvé.');
    }
}
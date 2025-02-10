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
        return view('form');
    }

    // Traiter la soumission du formulaire
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        // Générer un numéro d'ordre unique entre 1 et 12
        $orderNumber = $this->generateUniqueNumeroOrdre();

        // Enregistrer l'utilisateur dans la base de données
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'order_number' => $orderNumber,
        ]);

        // Retourner la réponse avec le numéro d'ordre
        return response()->json([
            'message' => 'Utilisateur enregistré avec succès !',
            'order_number' => $orderNumber,
        ]);
    }

    // Générer un numéro d'ordre unique
    private function generateUniqueNumeroOrdre()
    {
        $orderNumber = null;
        $usedNumbers = User::pluck('order_number')->toArray();

        do {
            $orderNumber = rand(1, 12);
        } while (in_array($orderNumber, $usedNumbers));

        return $orderNumber;
    }

    public function deleteUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::find($id);

        // Si l'utilisateur existe, le supprimer
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès !']);
        }

        // Si l'utilisateur n'existe pas, retourner une erreur
        return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
    }
}
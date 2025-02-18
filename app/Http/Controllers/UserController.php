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

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

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
        
        $usedNumbers = array_merge($usedNumbers);

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
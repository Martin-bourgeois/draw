<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        #userForm {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .user-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
        }
        .user-list h2 {
            margin-top: 0;
        }
        .user-list ul {
            list-style-type: none;
            padding: 0;
        }
        .user-list li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form id="userForm">
        @csrf
        <h1>Formulaire</h1>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>

        <button type="submit">Soumettre</button>
    </form>

    <div class="user-list">
        <h2>Liste des participants</h2>
        <ul>
            @for ($i = 1; $i <= 12; $i++)
                @php
                    $user = $users->firstWhere('order_number', $i);
                @endphp
                <li>
                    Numéro {{ $i }} :
                    @if ($user)
                        {{ $user->firstname }} {{ $user->lastname }}
                    @else
                        Disponible
                    @endif
                </li>
            @endfor
        </ul>
    </div>

    <script>
        document.getElementById('userForm').addEventListener('submit', function (e) {
            e.preventDefault();

            fetch('/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    firstname: document.getElementById('firstname').value,
                    lastname: document.getElementById('lastname').value
                })
            })
            .then(response => response.json())
            .then(data => {
                // Afficher une alerte avec la réponse
                alert(`${data.message}\nVotre numéro d'ordre est : ${data.order_number}`);
            })
            .catch(error => {
                console.error('Erreur :', error);
            });
        });
    </script>
</body>
</html>
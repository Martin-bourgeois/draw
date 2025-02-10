<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
    <h1>Formulaire</h1>
    <form id="userForm">
        @csrf
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required><br><br>
        
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <button type="submit">Soumettre</button>
    </form>

    <div id="response"></div>

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
                document.getElementById('response').innerHTML = `
                    <p>${data.message}</p>
                    <p>Votre numéro d'ordre est : ${data.order_number}</p>
                `;
            });
        });
    </script>
</body>
</html>
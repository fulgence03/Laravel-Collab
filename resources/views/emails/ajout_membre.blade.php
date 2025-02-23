<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Projet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h5 {
            color: #333333;
        }
        p {
            color: #555555;
            line-height: 1.6;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5>Bonjour {{ $user->name }},</h5>
        <p>Vous avez été ajouté au projet <span class="highlight">{{ $projet->titre }}</span> par {{ $admin->name }}.</p>
        <p>Description : {{ $projet->description }}</p>
        <p>Date de début : <strong>{{ \Carbon\Carbon::parse($projet->date_debut)->locale('fr')->isoFormat('D MMMM YYYY') }}</strong></p>
        <p>Date de fin : <strong>{{ \Carbon\Carbon::parse($projet->date_fin)->locale('fr')->isoFormat('D MMMM YYYY') }}</strong></p>
        <p>Merci de vous rendre disponible.</p>
        <br>
        <p>Bonne journée!</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Collab. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>

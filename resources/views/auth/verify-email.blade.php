<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de l'email</title>
</head>
<body>
    <h1>Vérification de votre adresse email</h1>
    <p>Un email de confirmation vous a été envoyé.</p>

    <form action="{{ route('verification.resend') }}" method="POST">
        @csrf
        <button type="submit">Renvoyer l'email</button>
    </form>
</body>
</html>

<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupportClientController extends Controller
{
    public function index()
    {
        // Récupérer les messages de la session
        $messages = Session::get('messages', []);
        return view('pages.support', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        // Valider le message
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Récupérer les messages existants depuis la session
        $messages = Session::get('messages', []);

        // Ajouter le message du client
        $messages[] = [
            'sender' => 'client',
            'message' => $request->message,
            'time' => now()->format('H:i A')
        ];

        // Récupérer la réponse prédéfinie du support
        $response = $this->getSupportResponse($request->message);

        // Ajouter la réponse du support dans les messages
        $messages[] = [
            'sender' => 'support',
            'message' => $response,
            'time' => now()->addMinutes(2)->format('H:i A')
        ];

        // Sauvegarder les messages dans la session
        Session::put('messages', $messages);

        return redirect()->route('support.index');
    }

    private function getSupportResponse($userMessage)
    {
        // Définir des réponses prédéfinies pour certaines questions
        $responses = [
            'comment puis-je vous aider ?' => 'Bonjour, comment puis-je vous assister aujourd\'hui ?',
            'quel est votre service ?' => 'Nous proposons des services de location et d\'achat de véhicules.',
            'quels sont les modes de paiement ?' => 'Nous acceptons Wave CI, MTN Money, Moov Money et Orange Money.',
            'comment réserver une voiture ?' => 'Vous pouvez réserver une voiture directement depuis notre plateforme en ligne.',
            'quelle est votre politique de retour ?' => 'Les retours sont acceptés dans les 7 jours suivant la réception.',
            'comment contacter le support ?' => 'Vous pouvez nous contacter via ce chat ou par email à support@exemple.com.',
        ];

        // Normaliser le message utilisateur (en minuscules)
        $userMessage = strtolower(trim($userMessage));

        // Vérifier si une réponse est définie pour le message de l'utilisateur
        if (array_key_exists($userMessage, $responses)) {
            return $responses[$userMessage];
        }

        // Réponse par défaut si aucune correspondance n'est trouvée
        return 'Désolé, je n\'ai pas compris votre demande. Pouvez-vous reformuler ?';
    }
}

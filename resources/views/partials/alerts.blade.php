<!-- Ajoute ce style dans ton head ou dans ta feuille CSS -->
<style>
    .alerts-container {
        position: fixed;
        top: 20px;      /* distance du haut */
        right: 20px;    /* distance de la droite */
        z-index: 9999;  /* pour qu'il soit au-dessus de tout */
        width: auto;    /* ou définis une largeur si besoin */
    }
  </style>

  <!-- Place ce bloc dans ta vue Blade, par exemple dans le layout principal -->
  <div class="alerts-container">
    {{-- Message de succès --}}
    @if(session('success'))
      <div class="alert alert-primary alert-outline text-primary alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Message d'erreur --}}
    @if(session('error'))
      <div class="alert alert-danger alert-outline text-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-bag-personal me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Message d'avertissement --}}
    @if(session('warning'))
      <div class="alert alert-warning alert-outline text-warning alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-octagon-outline me-2"></i>
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Message d'information --}}
    @if(session('info'))
      <div class="alert alert-info alert-outline text-info alert-dismissible fade show" role="alert">
        <i class="mdi mdi-triangle-outline me-2"></i>
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Gestion des erreurs de validation --}}
    @if($errors->any())
      <div class="alert alert-danger alert-outline text-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-octagon-outline me-2"></i>
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>

  <!-- Script pour fermer automatiquement les alertes après 10 secondes -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        // Sélectionne toutes les alertes dans le conteneur
        document.querySelectorAll('.alerts-container .alert').forEach(function(alert) {
          // Utilise l'instance Bootstrap pour fermer l'alerte proprement
          var alertInstance = bootstrap.Alert.getOrCreateInstance(alert);
          alertInstance.close();
        });
      }, 10000); // 10000 millisecondes = 10 secondes
    });
  </script>

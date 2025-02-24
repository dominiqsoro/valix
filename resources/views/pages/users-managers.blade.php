{{-- Exemple : resources/views/users-managers.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes utilisateurs - Valix')

@section('content')

<div class="container-fluid">
    <!-- Header avec filtre et bouton d'ajout -->
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
      <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Liste des Managers</h4>
      </div>
      <div class="text-end d-flex align-items-center">
        <!-- Dropdown pour filtrer par statut -->
        <div class="dropdown me-2">
          <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrer par statut <i class="mdi mdi-chevron-down ms-1 fs-14"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="#">Tous</a>
            <a class="dropdown-item" href="#">Actif</a>
            <a class="dropdown-item" href="#">Inactif</a>
          </div>
        </div>

        <!-- Dropdown pour filtrer par Managers -->
        <div class="dropdown me-2">
          <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrer par Managers <i class="mdi mdi-chevron-down ms-1 fs-14"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="#">Tous</a>
            <a class="dropdown-item" href="#">Abel Jobab</a>
            <a class="dropdown-item" href="#">Koffi Jean</a>
          </div>
        </div>
        <!-- Bouton Ajouter manager qui ouvre le modal -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addManagerModal">
          <i class="mdi mdi-plus"></i> Ajouter manager
        </button>
      </div>
    </div>

    <!-- Tableau des managers -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table mb-0 checkbox-all" id="datatable_managers">
                <thead>
                  <tr class="text-capitalize">
                    <th style="width: 16px;">
                      <div class="form-check mb-0 ms-n1">
                        <input type="checkbox" class="form-check-input" name="select-all" id="select-all-managers">
                      </div>
                    </th>
                    <th class="ps-0">Manager</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Téléphone</th>
                    <th>Business</th>
                    <th>Statut</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="width: 16px;">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check" id="customCheck1_manager">
                      </div>
                    </td>
                    <td class="ps-0">
                      <img src="assets/images/users/manager1.jpg" alt="" class="thumb-md me-2 rounded-circle avatar-border">
                      <span class="font-13 fw-medium">Jean Dupont</span>
                    </td>
                    <td>jean.dupont@example.com</td>
                    <td>PAssword01@</td>
                    <td>0123456789</td>
                    <td>Dupont Logistics</td>
                    <td>
                      <span class="badge bg-success-subtle text-success fw-semibold fs-13">Actif</span>
                    </td>
                    <td class="text-end">
                      <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" title="Modifier">
                        <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                      </a>
                      <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" title="Supprimer">
                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 16px;">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="check" id="customCheck2_manager">
                      </div>
                    </td>
                    <td class="ps-0">
                      <img src="assets/images/users/manager2.jpg" alt="" class="thumb-md me-2 rounded-circle avatar-border">
                      <span class="font-13 fw-medium">Marie Curie</span>
                    </td>
                    <td>marie.curie@example.com</td>
                    <td>PAssword01@</td>
                    <td>0987654321</td>
                    <td>Curie Transport</td>
                    <td>
                      <span class="badge bg-danger-subtle text-danger fw-semibold fs-13">Inactif</span>
                    </td>
                    <td class="text-end">
                      <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" title="Modifier">
                        <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                      </a>
                      <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" title="Supprimer">
                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                      </a>
                    </td>
                  </tr>
                  <!-- Ajoutez d'autres lignes de managers ici -->
                </tbody>
              </table>
            </div>
          </div>
            <!-- Pagination -->
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
      </div>
    </div>

    <!-- Modal pour Créer un Compte Manager -->
    <div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addManagerModalLabel">Créer un Compte Manager</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0);">
              <div class="row g-3">
                <!-- Nom complet -->
                <div class="col-12">
                  <label for="managerName" class="form-label">Nom complet</label>
                  <input type="text" class="form-control" id="managerName" placeholder="Entrez le nom complet">
                </div>
                <!-- Email -->
                <div class="col-12">
                  <label for="managerEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="managerEmail" placeholder="Entrez l'email">
                </div>
                <!-- Téléphone -->
                <div class="col-12">
                  <label for="managerPhone" class="form-label">Téléphone</label>
                  <input type="text" class="form-control" id="managerPhone" placeholder="Entrez le numéro de téléphone">
                </div>
                <!-- Structure -->
                <div class="col-12">
                  <label for="managerStructure" class="form-label">Nom de la structure</label>
                  <input type="text" class="form-control" id="managerStructure" placeholder="Entrez le nom de la structure">
                </div>
                <!-- Mot de passe -->
                <div class="col-12">
                  <label for="managerPassword" class="form-label">Mot de passe</label>
                  <input type="text" class="form-control" id="managerPassword" placeholder="Entrez le mot de passe">
                </div>
                <!-- Statut -->
                <div class="col-12">
                  <label for="managerStatus" class="form-label">Statut</label>
                  <select class="form-select" id="managerStatus">
                    <option selected>Choisir le statut...</option>
                    <option value="Actif">Actif</option>
                    <option value="Inactif">Inactif</option>
                  </select>
                </div>
                <!-- Boutons -->
                <div class="col-12 text-end">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin du Modal -->

  </div> <!-- container-fluid -->


@endsection

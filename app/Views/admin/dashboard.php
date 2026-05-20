<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

      <!-- Métriques admin -->
      <div class="metrics">
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
          <div class="metric-val"><?= esc($totalEmployes) ?></div>
          <div class="metric-label">Employés actifs</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
          <div class="metric-val"><?= esc($demandesEnAttenteCount) ?></div>
          <div class="metric-label">Demandes en attente</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
          <div class="metric-val"><?= esc($approuveesCeMoisCount) ?></div>
          <div class="metric-label">Approuvées ce mois</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-building"></i></div></div>
          <div class="metric-val"><?= esc($totalDepartements) ?></div>
          <div class="metric-label">Départements</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-person-slash"></i></div></div>
          <div class="metric-val"><?= esc($absentsCount) ?></div>
          <div class="metric-label">Absents aujourd'hui</div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

        <!-- Demandes récentes -->
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Demandes récentes</h3>
            <a href="<?= base_url('admin/demandes') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Tout voir →</a>
          </div>
          <table class="tbl">
            <thead>
              <tr><th>Employé</th><th>Type</th><th>Durée</th><th>Statut</th></tr>
            </thead>
            <tbody>
              <?php if (!empty($demandesRecentes)) { ?>
                <?php foreach ($demandesRecentes as $dem) { 
                  $prenom = $dem['prenom'] ?? '';
                  $nom = $dem['nom'] ?? '';
                  $initiales = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));
                  if ($initiales === '') $initiales = 'EM';
                  $libelleType = $dem['libelle_type'] ?? 'Inconnu';
                  $statut = strtolower($dem['statut'] ?? 'en_attente');
                  
                  $typeClass = 't-annuel';
                  if (strpos(strtolower($libelleType), 'maladie') !== false) {
                      $typeClass = 't-maladie';
                  } elseif (strpos(strtolower($libelleType), 'spécial') !== false || strpos(strtolower($libelleType), 'special') !== false) {
                      $typeClass = 't-special';
                  } elseif (strpos(strtolower($libelleType), 'sans_solde') !== false || strpos(strtolower($libelleType), 'sans solde') !== false) {
                      $typeClass = 't-sans-solde';
                  }

                  $statutClass = 's-attente';
                  $statutLabel = 'en attente';
                  if ($statut === 'accepte' || $statut === 'approuve' || $statut === 'approuvee') {
                      $statutClass = 's-approuvee';
                      $statutLabel = 'approuvée';
                  } elseif ($statut === 'refuse' || $statut === 'refusee') {
                      $statutClass = 's-refusee';
                      $statutLabel = 'refusée';
                  }
                ?>
                  <tr>
                    <td><div style="display:flex;align-items:center;gap:7px"><div class="avatar av-green" style="width:28px;height:28px;font-size:.62rem"><?= esc($initiales) ?></div><span class="td-name" style="font-size:.84rem"><?= esc($prenom . ' ' . $nom) ?></span></div></td>
                    <td><span class="type-badge <?= esc($typeClass) ?>"><?= esc($libelleType) ?></span></td>
                    <td class="td-mono"><?= esc($dem['nb_jours'] ?? 0) ?> j</td>
                    <td><span class="statut <?= esc($statutClass) ?>"><?= esc($statutLabel) ?></span></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr><td colspan="4" class="td-muted" style="text-align:center;padding:1rem;">Aucune demande récente.</td></tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!-- Absents du jour + soldes critiques -->
        <div style="display:flex;flex-direction:column;gap:1rem">
          <div class="data-card" style="margin:0">
            <div class="data-card-head"><h3><i class="bi bi-person-slash" style="color:var(--muted);margin-right:5px"></i>Absents aujourd'hui</h3></div>
            <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.6rem">
              <?php if (!empty($absentsAujourdhui)) { ?>
                <?php foreach ($absentsAujourdhui as $abs) { 
                  $prenom = $abs['prenom'] ?? '';
                  $nom = $abs['nom'] ?? '';
                  $initiales = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));
                  if ($initiales === '') $initiales = 'EM';
                  $libelleType = $abs['libelle_type'] ?? 'Inconnu';
                  $retour = date('d/m', strtotime($abs['date_fin'] . ' +1 day'));
                ?>
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar av-green" style="width:30px;height:30px;font-size:.65rem"><?= esc($initiales) ?></div>
                    <div><div style="font-size:.83rem;font-weight:500;color:var(--ink)"><?= esc($prenom . ' ' . $nom) ?></div><div style="font-size:.72rem;color:var(--muted)"><?= esc($libelleType) ?> · retour <?= esc($retour) ?></div></div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <div style="font-size:.83rem;color:var(--muted);text-align:center;">Aucun absent aujourd'hui.</div>
              <?php } ?>
            </div>
          </div>
        </div>

      </div>

      <!-- Graphiques -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;margin-top:1.5rem;">
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Congés par mois (<?= date('Y') ?>)</h3>
          </div>
          <div style="padding:1rem;">
            <canvas id="chartMois" style="width:100%;height:300px;"></canvas>
          </div>
        </div>

        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Congés par jour de la semaine (<?= date('Y') ?>)</h3>
          </div>
          <div style="padding:1rem;">
            <canvas id="chartJour" style="width:100%;height:300px;"></canvas>
          </div>
        </div>
      </div>

<script src="<?= base_url('assets/js/chart.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxMois = document.getElementById('chartMois').getContext('2d');
    new Chart(ctxMois, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Nombre de congés',
                data: <?= json_encode($statsMois) ?>,
                backgroundColor: '#3498db',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const ctxJour = document.getElementById('chartJour').getContext('2d');
    new Chart(ctxJour, {
        type: 'bar',
        data: {
            labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            datasets: [{
                label: 'Nombre de congés',
                data: <?= json_encode($statsJours) ?>,
                backgroundColor: '#2ecc71',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>

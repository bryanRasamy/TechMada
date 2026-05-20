<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php $messageSucces = session()->getFlashdata('success'); ?>
<?php if (is_string($messageSucces) && $messageSucces !== '') { ?>
    <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= esc($messageSucces) ?>
    </div>
<?php } ?>

<div class="metrics">
    <div class="metric">
        <div class="metric-top">
            <div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="metric-val"><?= esc((string) ($nombreDemandesEnAttente ?? 0)) ?></div>
        <div class="metric-label">En attente</div>
    </div>
    <div class="metric">
        <div class="metric-top">
            <div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div>
        </div>
        <div class="metric-val"><?= esc((string) ($nombreDemandesApprouvees ?? 0)) ?></div>
        <div class="metric-label">Approuvées</div>
    </div>
    <div class="metric">
        <div class="metric-top">
            <div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div>
        </div>
        <div class="metric-val"><?= esc((string) ($joursRestantsTotal ?? 0)) ?></div>
        <div class="metric-label">Jours restants</div>
        <div class="metric-sub">sur <?= esc((string) ($joursAttribuesTotal ?? 0)) ?> cette année</div>
    </div>
    <div class="metric">
        <div class="metric-top">
            <div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div>
        </div>
        <div class="metric-val"><?= esc((string) ($nombreDemandesRefusees ?? 0)) ?></div>
        <div class="metric-label">Refusée</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Mes soldes de congés — <?= esc((string) ($anneeSolde ?? date('Y'))) ?></h3>
    </div>
    <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
        <?php if (! empty($soldesEmploye)) { ?>
            <?php foreach ($soldesEmploye as $solde) { ?>
                <?php
                $joursAttribues = $solde['jours_attribues'] ?? 0;
                $joursPris = $solde['jours_pris'] ?? 0;
                $joursRestants = max(0, $joursAttribues - $joursPris);
                $pourcentageUtilisation = $joursAttribues > 0 ? round(($joursPris / $joursAttribues) * 100) : 0;
                if ($pourcentageUtilisation > 100) {
                    $pourcentageUtilisation = 100;
                }
                $classeBarre = $pourcentageUtilisation >= 80 ? ' warn' : '';
                $libelleSolde = isset($solde['libelle_type']) && is_string($solde['libelle_type']) && $solde['libelle_type'] !== '' ? $solde['libelle_type'] : 'Congé';
                ?>
                <div class="solde-card" style="margin:0">
                    <div class="solde-header">
                        <span class="solde-type"><?= esc($libelleSolde) ?></span>
                        <span class="solde-nums"><strong><?= esc((string) $joursRestants) ?></strong> / <?= esc((string) $joursAttribues) ?> j</span>
                    </div>
                    <div class="solde-bar">
                        <div class="solde-fill<?= esc($classeBarre) ?>" style="width:<?= esc((string) $pourcentageUtilisation) ?>%"></div>
                    </div>
                    <div class="solde-label"><?= esc((string) $joursRestants) ?> jour<?= $joursRestants > 1 ? 's' : '' ?> restant<?= $joursRestants > 1 ? 's' : '' ?> · <?= esc((string) $joursPris) ?> pris</div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="solde-card" style="margin:0;grid-column:1 / -1">
                <div class="solde-label">Aucun solde disponible pour le moment.</div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Nombre total de demandes par type de congés</h3>
    </div>
    <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
        <?php if (! empty($totalDemandesParType)) { ?>
            <?php foreach ($totalDemandesParType as $totalType) { ?>
                <div class="solde-card" style="margin:0">
                    <div class="solde-header">
                        <span class="solde-type"><?= esc($totalType['type_conge_nom'] ?? 'Inconnu') ?></span>
                        <span class="solde-nums"><strong><?= esc((string) $totalType['total_demandes']) ?></strong> demande(s)</span>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="solde-card" style="margin:0;grid-column:1 / -1">
                <div class="solde-label">Aucune demande trouvée.</div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Mes dernières demandes</h3>
        <a href="#page-mes-conges" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Type</th>
                <th>Du</th>
                <th>Au</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($dernieresDemandes)) { ?>
                <?php foreach ($dernieresDemandes as $demande) { ?>
                    <?php
                    $statutTechnique = $demande['statut'] ?? 'en_attente';
                    $classeStatut = 's-attente';
                    $libelleStatut = 'en attente';

                    if ($statutTechnique === 'accepte' || $statutTechnique === 'approuve' || $statutTechnique === 'approuvee') {
                        $classeStatut = 's-approuvee';
                        $libelleStatut = 'approuvée';
                    }

                    if ($statutTechnique === 'refuse' || $statutTechnique === 'refusee') {
                        $classeStatut = 's-refusee';
                        $libelleStatut = 'refusée';
                    }

                    $dateDebut = ! empty($demande['date_debut']) ? date('d/m/Y', strtotime($demande['date_debut'])) : '—';
                    $dateFin = ! empty($demande['date_fin']) ? date('d/m/Y', strtotime($demande['date_fin'])) : '—';
                    $nombreJoursDemande = $demande['nb_jours'] ?? 0;
                    $libelleDemande = isset($demande['libelle_type']) && is_string($demande['libelle_type']) && $demande['libelle_type'] !== '' ? $demande['libelle_type'] : 'Congé';
                    ?>
                    <tr>
                        <td><span class="type-badge t-annuel"><?= esc($libelleDemande) ?></span></td>
                        <td class="td-muted"><?= esc($dateDebut) ?></td>
                        <td class="td-muted"><?= esc($dateFin) ?></td>
                        <td class="td-mono"><?= esc((string) $nombreJoursDemande) ?> j</td>
                        <td><span class="statut <?= esc($classeStatut) ?>"><?= esc($libelleStatut) ?></span></td>
                        <td>
                            <?php if ($statutTechnique === 'en_attente' || $statutTechnique === 'attente') { ?>
                                <button class="btn-sm btn-cancel"><i class="bi bi-x"></i> Annuler</button>
                            <?php } else { ?>
                                <span class="td-muted" style="font-size:.75rem">—</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" class="td-muted" style="text-align:center;padding:1.2rem 0">Aucune demande disponible pour le moment.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
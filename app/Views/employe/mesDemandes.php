<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="data-card">
    <div class="data-card-head">
        <h3>Toutes mes demandes</h3>
        <div style="display:flex;gap:6px">
            <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
                <option>Tous les statuts</option>
                <option>En attente</option>
                <option>Approuvée</option>
                <option>Refusée</option>
                <option>Annulée</option>
            </select>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Commentaire RH</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($toutesLesDemandes)): ?>
                <?php foreach ($toutesLesDemandes as $demande): 
                    $demande = (array) $demande;
                    $dateDebut = ! empty($demande['date_debut']) ? new DateTime($demande['date_debut']) : null;
                    $dateFin = ! empty($demande['date_fin']) ? new DateTime($demande['date_fin']) : null;
                    $duree = 0;
                    if ($dateDebut && $dateFin) {
                        $diff = $dateFin->diff($dateDebut);
                        $duree = $diff->days + 1;
                    }

                    $libelle_type = esc((string) ($demande['libelle_type'] ?? 'Type inconnu'));
                    $statut = strtolower((string) ($demande['statut'] ?? 'en_attente'));
                    $commentaire = esc((string) ($demande['commentaire_rh'] ?? '—'));

                    $typeClass = 't-annuel';
                    if (strpos($statut, 'maladie') !== false) {
                        $typeClass = 't-maladie';
                    } elseif (strpos($statut, 'spécial') !== false || strpos($statut, 'special') !== false) {
                        $typeClass = 't-special';
                    } elseif (strpos($statut, 'sans_solde') !== false || strpos($statut, 'sans solde') !== false) {
                        $typeClass = 't-sans-solde';
                    }

                    $statutClass = 's-attente';
                    $statutLabel = 'en attente';
                    $statutColor = '';
                    if (strpos($statut, 'accept') !== false || strpos($statut, 'approuv') !== false) {
                        $statutClass = 's-approuvee';
                        $statutLabel = 'approuvée';
                        $statutColor = 'var(--success)';
                    } elseif (strpos($statut, 'refus') !== false) {
                        $statutClass = 's-refusee';
                        $statutLabel = 'refusée';
                        $statutColor = 'var(--danger)';
                    } elseif (strpos($statut, 'annul') !== false) {
                        $statutClass = 's-annulee';
                        $statutLabel = 'annulée';
                        $statutColor = '';
                    }
                ?>
                <tr>
                    <td><span class="type-badge <?= esc($typeClass) ?>"><?= esc($libelle_type) ?></span></td>
                    <td class="td-muted"><?= $dateDebut ? $dateDebut->format('d M Y') : '—' ?></td>
                    <td class="td-muted"><?= $dateFin ? $dateFin->format('d M Y') : '—' ?></td>
                    <td class="td-mono"><?= $duree ?> j</td>
                    <td><span class="statut <?= esc($statutClass) ?>"><?= esc($statutLabel) ?></span></td>
                    <td class="td-muted" style="font-size:.78rem; <?php if ($statutColor): ?>color:<?= $statutColor ?>;<?php endif; ?>">
                        <?php if ($statutColor && $commentaire !== '—'): ?>
                            <i class="bi bi-check-circle"></i>
                        <?php endif; ?>
                        <?= $commentaire ?>
                    </td>
                    <td>
                        <?php if (strpos($statut, 'en_attente') !== false || strpos($statut, 'attente') !== false): ?>
                            <button class="btn-sm btn-cancel"><i class="bi bi-x"></i> Annuler</button>
                        <?php else: ?>
                            <span class="td-muted" style="font-size:.75rem">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;color:#999;padding:2rem">
                        Aucune demande de congé trouvée.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
